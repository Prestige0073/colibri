#!/bin/bash

# Script de migration des images blog de storage vers public
# Projet: Colibri Littéraire
# Date: 21 Janvier 2026

echo "========================================="
echo "Migration des Images Blog"
echo "De: storage/app/public/blog/"
echo "Vers: public/img/blog/"
echo "========================================="
echo ""

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Vérifier si on est dans le bon dossier
if [ ! -f "artisan" ]; then
    echo -e "${RED}Erreur: Ce script doit être exécuté depuis la racine du projet Laravel${NC}"
    exit 1
fi

# Créer le dossier de destination
echo -e "${YELLOW}1. Création du dossier public/img/blog/${NC}"
mkdir -p public/img/blog
if [ $? -eq 0 ]; then
    echo -e "${GREEN}   ✓ Dossier créé${NC}"
else
    echo -e "${RED}   ✗ Erreur création dossier${NC}"
    exit 1
fi

# Vérifier si des images existent dans storage
if [ -d "storage/app/public/blog" ] && [ "$(ls -A storage/app/public/blog 2>/dev/null)" ]; then
    echo -e "${YELLOW}2. Copie des images depuis storage/app/public/blog/${NC}"

    # Compter les fichiers
    count=$(ls -1 storage/app/public/blog | wc -l)
    echo -e "   ${count} fichier(s) trouvé(s)"

    # Copier les images
    cp -v storage/app/public/blog/* public/img/blog/ 2>&1 | while read line; do
        echo "   $line"
    done

    if [ $? -eq 0 ]; then
        echo -e "${GREEN}   ✓ Images copiées avec succès${NC}"
    else
        echo -e "${RED}   ✗ Erreur lors de la copie${NC}"
        exit 1
    fi
else
    echo -e "${YELLOW}2. Aucune image dans storage/app/public/blog/${NC}"
    echo -e "   Étape ignorée"
fi

# Mettre à jour la base de données
echo -e "${YELLOW}3. Mise à jour de la base de données${NC}"
echo -e "   Changement: 'blog/...' -> 'img/blog/...'"

# Utiliser PHP Artisan Tinker pour mettre à jour
php artisan tinker --execute="
\$count = DB::table('articles')
    ->where('featured_image', 'like', 'blog/%')
    ->count();

if (\$count > 0) {
    DB::table('articles')
        ->where('featured_image', 'like', 'blog/%')
        ->update([
            'featured_image' => DB::raw(\"REPLACE(featured_image, 'blog/', 'img/blog/')\")
        ]);
    echo \"   ✓ {$count} article(s) mis à jour\n\";
} else {
    echo \"   Aucun article à mettre à jour\n\";
}
"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}   ✓ Base de données mise à jour${NC}"
else
    echo -e "${RED}   ✗ Erreur mise à jour BDD${NC}"
    echo -e "   ${YELLOW}Vous pouvez le faire manuellement avec:${NC}"
    echo -e "   php artisan tinker"
    echo -e "   >>> DB::table('articles')->where('featured_image', 'like', 'blog/%')->update(['featured_image' => DB::raw(\"REPLACE(featured_image, 'blog/', 'img/blog/')\")]);"
fi

# Définir les permissions
echo -e "${YELLOW}4. Configuration des permissions${NC}"
chmod -R 775 public/img/blog
chown -R www-data:www-data public/img/blog 2>/dev/null || chown -R $USER:$USER public/img/blog
echo -e "${GREEN}   ✓ Permissions configurées${NC}"

# Vérification finale
echo ""
echo -e "${YELLOW}5. Vérification finale${NC}"
blog_count=$(ls -1 public/img/blog 2>/dev/null | wc -l)
echo -e "   Fichiers dans public/img/blog: ${blog_count}"

# Résumé
echo ""
echo "========================================="
echo -e "${GREEN}Migration terminée avec succès!${NC}"
echo "========================================="
echo ""
echo "Prochaines étapes:"
echo "1. Vérifier les images sur la page /blog"
echo "2. Tester l'upload de nouvelles images"
echo "3. Supprimer storage/app/public/blog/ si tout fonctionne:"
echo "   rm -rf storage/app/public/blog"
echo ""
echo "En cas de problème:"
echo "- Vérifier les logs: storage/logs/laravel.log"
echo "- Vérifier les permissions: ls -la public/img/blog"
echo "- Consulter: CORRECTIONS_PROBLEMES_UTILISATEUR.md"
echo ""
