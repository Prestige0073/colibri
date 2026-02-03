<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index(Request $request)
    {
        $query = Admin::with('role', 'creator')->semiAdmins();

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtrer par rôle
        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('module');

        return view('admin.admins.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'nullable|exists:roles,id',
            'role_type' => 'required|in:predefined,custom',
            'permissions' => 'required_if:role_type,custom|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Créer le rôle personnalisé si nécessaire
        if ($request->role_type === 'custom') {
            $role = Role::create([
                'name' => 'Personnalisé - ' . $request->name,
                'description' => 'Rôle personnalisé pour ' . $request->name,
                'is_predefined' => false,
            ]);

            $role->permissions()->sync($request->permissions);
            $roleId = $role->id;
        } else {
            $roleId = $request->role_id;
        }

        // Créer l'admin
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role_id' => $roleId,
            'status' => 'active',
            'created_by' => auth('admin')->id(),
        ]);

        // Log d'audit
        AuditLog::log('admin_created', $admin, null, $admin->toArray());

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrateur créé avec succès.');
    }

    /**
     * Display the specified admin.
     */
    public function show(Admin $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Impossible de consulter un super administrateur.');
        }

        $admin->load('role.permissions', 'creator', 'auditLogs');

        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(Admin $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Impossible de modifier un super administrateur.');
        }

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('module');
        $admin->load('role.permissions');

        return view('admin.admins.edit', compact('admin', 'roles', 'permissions'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Impossible de modifier un super administrateur.');
        }

        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier vos propres permissions.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'nullable|exists:roles,id',
            'role_type' => 'required|in:predefined,custom',
            'permissions' => 'required_if:role_type,custom|array',
            'permissions.*' => 'exists:permissions,id',
            'status' => 'required|in:active,suspended,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $oldValues = $admin->toArray();

        // Gérer le rôle
        if ($request->role_type === 'custom') {
            // Si l'admin avait déjà un rôle custom non prédéfini, le mettre à jour
            if ($admin->role && !$admin->role->is_predefined) {
                $admin->role->permissions()->sync($request->permissions);
                $roleId = $admin->role_id;
            } else {
                // Créer un nouveau rôle custom
                $role = Role::create([
                    'name' => 'Personnalisé - ' . $request->name,
                    'description' => 'Rôle personnalisé pour ' . $request->name,
                    'is_predefined' => false,
                ]);
                $role->permissions()->sync($request->permissions);
                $roleId = $role->id;
            }
        } else {
            $roleId = $request->role_id;

            // Supprimer l'ancien rôle custom si existant
            if ($admin->role && !$admin->role->is_predefined) {
                $admin->role->delete();
            }
        }

        // Mettre à jour l'admin
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $roleId,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $admin->update(['password' => $request->password]);
        }

        // Log d'audit
        AuditLog::log('admin_updated', $admin, $oldValues, $admin->fresh()->toArray());

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrateur mis à jour avec succès.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Impossible de supprimer un super administrateur.');
        }

        if ($admin->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }

        $oldValues = $admin->toArray();

        // Supprimer le rôle custom associé
        if ($admin->role && !$admin->role->is_predefined) {
            $admin->role->delete();
        }

        $admin->delete();

        // Log d'audit
        AuditLog::log('admin_deleted', null, $oldValues, null);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrateur supprimé avec succès.');
    }

    /**
     * Change admin status (suspend/activate)
     */
    public function changeStatus(Request $request, Admin $admin)
    {
        if ($admin->is_super_admin) {
            abort(403, 'Impossible de modifier le statut d\'un super administrateur.');
        }

        if ($admin->id === auth('admin')->id()) {
            return response()->json(['error' => 'Vous ne pouvez pas modifier votre propre statut.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,suspended,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $oldStatus = $admin->status;
        $admin->update(['status' => $request->status]);

        // Log d'audit
        AuditLog::log('admin_status_changed', $admin, ['status' => $oldStatus], ['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Statut modifié avec succès.',
            'status' => $admin->status,
        ]);
    }

    /**
     * Get permissions for a role (AJAX)
     */
    public function getRolePermissions(Role $role)
    {
        return response()->json([
            'permissions' => $role->permissions->pluck('id')->toArray(),
        ]);
    }
}
