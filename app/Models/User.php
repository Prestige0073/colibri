<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'role',
        'blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'blocked' => 'boolean',
        ];
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function emprunts()
    {
        return $this->hasMany(\App\Models\Emprunt::class);
    }

    public function commandes()
    {
        return $this->hasMany(\App\Models\Commande::class);
    }

    /**
     * Retourne les inscriptions aux formations de l'utilisateur
     */
    public function inscriptions()
    {
        return $this->hasMany(\App\Models\FormationInscription::class);
    }

    /**
     * Retourne les tentatives de quiz de l'utilisateur
     */
    public function quizAttempts()
    {
        return $this->hasMany(\App\Models\UserQuizAttempt::class);
    }

    /**
     * Retourne les certificats de l'utilisateur
     */
    public function certificats()
    {
        return $this->hasMany(\App\Models\Certificat::class);
    }

    /**
     * Vérifie si l'utilisateur est administrateur
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est bloqué
     */
    public function isBlocked()
    {
        return $this->blocked === true;
    }

    /**
     * Retourne tous les livres achetés par l'utilisateur (commandes validées)
     */
    public function purchasedBooks()
    {
        return Catalogue::whereIn('id', function($query) {
            $query->select('catalogue_id')
                ->from('commande_items')
                ->whereIn('commande_id', function($subQuery) {
                    $subQuery->select('id')
                        ->from('commandes')
                        ->where('user_id', $this->id)
                        ->where('paiement_valide', true);
                });
        })->distinct();
    }

    /**
     * Vérifie si l'utilisateur a déjà acheté un livre spécifique
     */
    public function hasPurchasedBook($catalogueId)
    {
        return $this->commandes()
            ->where('paiement_valide', true)
            ->whereHas('items', function($query) use ($catalogueId) {
                $query->where('catalogue_id', $catalogueId);
            })
            ->exists();
    }
}
