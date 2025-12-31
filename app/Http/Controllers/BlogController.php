<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Afficher la liste des articles publiés
     */
    public function index()
    {
        $articles = Article::published()
                          ->with('author')
                          ->latest('published_at')
                          ->paginate(12);

        return view('blog.index', compact('articles'));
    }

    /**
     * Afficher un article spécifique
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
                         ->published()
                         ->with('author')
                         ->firstOrFail();

        // Incrémenter le nombre de vues
        $article->incrementViews();

        // Récupérer les articles similaires (3 derniers articles publiés, sauf celui-ci)
        $relatedArticles = Article::published()
                                 ->where('id', '!=', $article->id)
                                 ->latest('published_at')
                                 ->take(3)
                                 ->get();

        return view('blog.show', compact('article', 'relatedArticles'));
    }
}
