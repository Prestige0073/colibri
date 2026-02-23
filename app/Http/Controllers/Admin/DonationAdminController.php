<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::latest();

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%");
            });
        }

        $donations = $query->paginate(20)->withQueryString();

        // Statistiques
        $totalDonations = Donation::count();
        $totalAmount = Donation::completed()->sum('amount');
        $completedCount = Donation::completed()->count();
        $failedCount = Donation::failed()->count();
        $pendingCount = Donation::pending()->count();
        $monthAmount = Donation::completed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        return view('admin.donations', compact(
            'donations',
            'totalDonations',
            'totalAmount',
            'completedCount',
            'failedCount',
            'pendingCount',
            'monthAmount'
        ));
    }

    public function show($id)
    {
        $donation = Donation::findOrFail($id);
        return response()->json($donation);
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Don supprimé avec succès.');
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
}
