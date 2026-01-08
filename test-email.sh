#!/bin/bash
# Script de test d'envoi d'email

echo "🧪 Test d'envoi d'email de bienvenue"
echo "===================================="
echo ""

if [ -z "$1" ]; then
    echo "Usage: ./test-email.sh <email>"
    echo "Exemple: ./test-email.sh test@example.com"
    exit 1
fi

EMAIL=$1

echo "📧 Recherche de l'utilisateur avec l'email: $EMAIL"
php artisan tinker --execute="
\$user = \App\Models\User::where('email', '$EMAIL')->first();
if (\$user) {
    echo '✅ Utilisateur trouvé: ' . \$user->name . PHP_EOL;
    echo '📧 Envoi de l\'email...' . PHP_EOL;
    try {
        \Illuminate\Support\Facades\Mail::to(\$user->email)->send(new \App\Mail\User\WelcomeEmail(\$user));
        echo '✅ Email envoyé avec succès à: ' . \$user->email . PHP_EOL;
    } catch (\Exception \$e) {
        echo '❌ Erreur: ' . \$e->getMessage() . PHP_EOL;
    }
} else {
    echo '❌ Aucun utilisateur trouvé avec cet email' . PHP_EOL;
}
"
