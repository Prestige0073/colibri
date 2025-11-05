<?php
namespace App\Http\Controllers\Admin;

use App\Models\Certification;
use App\Models\User;
use App\Models\Formation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::with(['user', 'formation'])->get();
        return view('admin.certifications.index', compact('certifications'));
    }

    public function create()
    {
        $users = User::all();
        $formations = Formation::all();
        return view('admin.certifications.create', compact('users', 'formations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'date_obtention' => 'required|date',
            'code_certificat' => 'required|string|unique:certifications,code_certificat',
            'validite' => 'nullable|date',
        ]);
        Certification::create($validated);
        return redirect()->route('admin.certifications.index')->with('success', 'Certification créée avec succès.');
    }

    public function show(Certification $certification)
    {
        return view('admin.certifications.show', compact('certification'));
    }

    public function edit(Certification $certification)
    {
        $users = User::all();
        $formations = Formation::all();
        return view('admin.certifications.edit', compact('certification', 'users', 'formations'));
    }

    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id',
            'date_obtention' => 'required|date',
            'code_certificat' => 'required|string|unique:certifications,code_certificat,' . $certification->id,
            'validite' => 'nullable|date',
        ]);
        $certification->update($validated);
        return redirect()->route('admin.certifications.index')->with('success', 'Certification modifiée avec succès.');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();
        return redirect()->route('admin.certifications.index')->with('success', 'Certification supprimée avec succès.');
    }
}
