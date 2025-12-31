<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialAdminController extends Controller
{
    /**
     * Afficher la liste des témoignages
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')
                                   ->latest()
                                   ->paginate(20);

        $pendingCount = Testimonial::pending()->count();
        $approvedCount = Testimonial::approved()->count();
        $rejectedCount = Testimonial::rejected()->count();

        return view('admin.testimonials', compact(
            'testimonials',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Approuver un témoignage
     */
    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->approve();

        return redirect()->back()->with('success', 'Témoignage approuvé avec succès.');
    }

    /**
     * Rejeter un témoignage
     */
    public function reject($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->reject();

        return redirect()->back()->with('success', 'Témoignage rejeté.');
    }

    /**
     * Mettre en attente un témoignage
     */
    public function pending($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->setPending();

        return redirect()->back()->with('success', 'Témoignage mis en attente.');
    }

    /**
     * Supprimer un témoignage
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Supprimer la photo si elle existe
        if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
                        ->with('success', 'Témoignage supprimé avec succès.');
    }
}
