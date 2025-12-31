<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogAdminController extends Controller
{
    /**
     * Afficher la liste des articles
     */
    public function index()
    {
        $articles = Article::with('author')
                          ->latest()
                          ->paginate(20);

        $publishedCount = Article::published()->count();
        $draftCount = Article::draft()->count();

        return view('admin.blog.index', compact('articles', 'publishedCount', 'draftCount'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Enregistrer un nouvel article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Le titre est requis.',
            'content.required' => 'Le contenu est requis.',
            'featured_image.image' => 'Le fichier doit être une image.',
            'featured_image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'featured_image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        // Gérer l'upload de l'image mise en avant
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        // Définir l'auteur
        $validated['author_id'] = Auth::id();

        // Définir la date de publication si publié
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Article créé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.blog.edit', compact('article'));
    }

    /**
     * Mettre à jour l'article
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Le titre est requis.',
            'content.required' => 'Le contenu est requis.',
            'featured_image.image' => 'Le fichier doit être une image.',
            'featured_image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'featured_image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('featured_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        // Mettre à jour la date de publication
        if ($validated['status'] === 'published' && $article->status === 'draft') {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Supprimer l'article
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Supprimer l'image associée
        if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Article supprimé avec succès.');
    }

    /**
     * Publier/dépublier un article
     */
    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);

        if ($article->status === 'published') {
            $article->unpublish();
            $message = 'Article mis en brouillon.';
        } else {
            $article->publish();
            $message = 'Article publié avec succès.';
        }

        return redirect()->back()->with('success', $message);
    }
}
