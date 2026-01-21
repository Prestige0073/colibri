<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'status',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Relation avec l'auteur (User)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope pour les articles publiés
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope pour les brouillons
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Générer automatiquement le slug à partir du titre
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                // Générer slug depuis le titre ou utiliser un slug par défaut
                if (!empty($article->title)) {
                    $article->slug = Str::slug($article->title);
                } else {
                    $article->slug = 'article-' . uniqid();
                }

                // Vérifier l'unicité du slug
                $count = 1;
                $originalSlug = $article->slug;
                while (static::where('slug', $article->slug)->exists()) {
                    $article->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($article) {
            // Générer slug s'il est vide
            if (empty($article->slug)) {
                if (!empty($article->title)) {
                    $article->slug = Str::slug($article->title);
                } else {
                    $article->slug = 'article-' . uniqid();
                }

                // Vérifier l'unicité
                $count = 1;
                $originalSlug = $article->slug;
                while (static::where('slug', $article->slug)->where('id', '!=', $article->id)->exists()) {
                    $article->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
            // Regénérer le slug si le titre a changé et qu'il n'est pas vide
            elseif ($article->isDirty('title') && !empty($article->title)) {
                $newSlug = Str::slug($article->title);

                // Vérifier l'unicité du slug
                $count = 1;
                $originalSlug = $newSlug;
                while (static::where('slug', $newSlug)->where('id', '!=', $article->id)->exists()) {
                    $newSlug = $originalSlug . '-' . $count;
                    $count++;
                }

                $article->slug = $newSlug;
            }
        });
    }

    /**
     * Incrémenter le nombre de vues
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Publier l'article
     */
    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Mettre en brouillon
     */
    public function unpublish()
    {
        $this->update([
            'status' => 'draft',
        ]);
    }
}
