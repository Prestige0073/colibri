# Éditeur de texte Quill - Gratuit et Open Source

## Pourquoi Quill ?

**Quill** est un éditeur de texte riche (WYSIWYG) moderne, **100% gratuit** et **open source** :
- ✅ Aucune clé API requise
- ✅ Complètement gratuit (licence BSD 3-Clause)
- ✅ Léger et performant
- ✅ Interface moderne et intuitive
- ✅ Compatible avec tous les navigateurs modernes
- ✅ Formatage HTML propre

## Fonctionnalités disponibles

### Barre d'outils Quill

```
┌────────────────────────────────────────────────────────────────┐
│ [H1▼] [B] [I] [U] [S] [🎨▼] [🖍▼] [≡] [1.] [•] [📐▼]          │
│                                                                 │
│ [🔗] [🖼] [🎥] ["] [</>] [🧹]                                   │
└────────────────────────────────────────────────────────────────┘
```

### Détail des fonctionnalités

**1. Formatage du texte**
- **Titres** : H1, H2, H3, H4, H5, H6
- **Gras** (Bold)
- **Italique** (Italic)
- **Souligné** (Underline)
- **Barré** (Strike)

**2. Couleurs**
- **Couleur du texte** : Palette de couleurs
- **Couleur du fond** : Surlignage

**3. Listes**
- **Liste numérotée** (ordered list)
- **Liste à puces** (bullet list)

**4. Alignement**
- Gauche
- Centre
- Droite
- Justifié

**5. Médias**
- **Liens hypertextes** : Ajouter des liens
- **Images** : Insérer des images (URL)
- **Vidéos** : Intégrer des vidéos (URL YouTube, Vimeo, etc.)

**6. Blocs spéciaux**
- **Citation** (blockquote)
- **Code** (code-block)

**7. Outils**
- **Nettoyer** : Supprimer le formatage

## Implémentation

### Structure HTML

```html
<!-- Zone d'édition visible -->
<div id="editor" style="height: 400px; background: white;"></div>

<!-- Textarea caché pour soumettre au serveur -->
<textarea class="d-none" id="content" name="content"></textarea>
```

### Fichiers inclus

**CSS** (dans @push('styles')) :
```html
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
```

**JavaScript** (dans @push('scripts')) :
```html
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
```

### Configuration JavaScript

```javascript
// Initialiser Quill
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['blockquote', 'code-block'],
            ['clean']
        ]
    },
    placeholder: 'Rédigez le contenu de votre article ici...'
});

// Synchroniser avec le textarea avant soumission
var form = document.querySelector('form');
form.addEventListener('submit', function() {
    var content = document.querySelector('#content');
    content.value = quill.root.innerHTML;
});

// Charger le contenu existant (pour édition)
var existingContent = document.querySelector('#content').value;
if (existingContent) {
    quill.root.innerHTML = existingContent;
}
```

## Utilisation

### Créer un article

1. Accéder à `/admin/blog/create`
2. L'éditeur Quill s'affiche avec une barre d'outils complète
3. Rédiger le contenu avec formatage :
   - Sélectionner du texte et cliquer sur **B** pour mettre en gras
   - Cliquer sur le menu déroulant des titres pour choisir H1, H2, etc.
   - Insérer des images, liens, vidéos via les boutons correspondants
4. Le contenu HTML est automatiquement synchronisé lors de la soumission

### Éditer un article

1. Accéder à `/admin/blog/{id}/edit`
2. Le contenu existant est chargé automatiquement dans l'éditeur
3. Modifier le texte avec tous les outils de formatage
4. Enregistrer les modifications

## Sortie HTML

Quill génère du HTML propre et sémantique :

**Entrée utilisateur** :
```
Titre principal (H1)
Texte en gras avec du texte italique.
- Liste à puces
- Deuxième élément
```

**HTML généré** :
```html
<h1>Titre principal</h1>
<p><strong>Texte en gras</strong> avec du <em>texte italique</em>.</p>
<ul>
  <li>Liste à puces</li>
  <li>Deuxième élément</li>
</ul>
```

## Avantages de Quill

### 1. Gratuit et Open Source
- Aucun frais
- Aucune limite d'utilisation
- Code source disponible sur GitHub

### 2. Léger et Rapide
- Taille réduite (~43 KB minifié)
- Chargement rapide
- Performance optimale

### 3. Interface Moderne
- Design épuré et professionnel
- Thème "Snow" élégant
- Compatible mobile

### 4. HTML Propre
- Génère du HTML sémantique
- Facilite le SEO
- Compatible avec tous les navigateurs

### 5. Extensible
- Modules additionnels disponibles
- Personnalisation facile
- API bien documentée

## Comparaison avec TinyMCE

| Fonctionnalité | Quill | TinyMCE (gratuit) |
|---------------|-------|-------------------|
| **Prix** | 100% gratuit | Gratuit avec limitations |
| **Clé API** | ❌ Non requise | ⚠️ Requise (messages d'avertissement) |
| **Taille** | 43 KB | ~500 KB |
| **Vitesse** | ⚡ Très rapide | Moyenne |
| **Formatage de base** | ✅ | ✅ |
| **Images** | ✅ (URL) | ✅ (Upload) |
| **Tableaux** | ❌ | ✅ |
| **Plein écran** | ❌ | ✅ |
| **Code source** | ✅ (code-block) | ✅ |

## Outils de formatage disponibles

### Texte de base
- ✅ Gras
- ✅ Italique
- ✅ Souligné
- ✅ Barré
- ✅ Couleur du texte
- ✅ Couleur du fond

### Structure
- ✅ Titres (H1 à H6)
- ✅ Paragraphes
- ✅ Citations (blockquote)
- ✅ Code (code-block)

### Listes
- ✅ Liste numérotée
- ✅ Liste à puces

### Alignement
- ✅ Gauche
- ✅ Centre
- ✅ Droite
- ✅ Justifié

### Médias
- ✅ Liens hypertextes
- ✅ Images (via URL)
- ✅ Vidéos (YouTube, Vimeo)

### Outils
- ✅ Nettoyer le formatage
- ✅ Annuler/Rétablir (Ctrl+Z / Ctrl+Y)

## Limitations (par rapport à TinyMCE)

### Ce qui manque :
- ❌ Tableaux
- ❌ Upload d'images direct (uniquement URL)
- ❌ Mode plein écran
- ❌ Rechercher/Remplacer
- ❌ Insertion de médias avancée
- ❌ Vérification orthographique intégrée

### Solutions de contournement :
1. **Tableaux** : Utiliser HTML dans le code-block ou générer ailleurs
2. **Upload images** : Utiliser le champ "Image mise en avant" principal
3. **Plein écran** : L'éditeur est déjà assez grand (400px)

## Personnalisation

### Changer la hauteur
```javascript
var quill = new Quill('#editor', {
    // ...
});
// Dans le HTML :
<div id="editor" style="height: 600px;"></div>
```

### Ajouter/Retirer des outils
```javascript
toolbar: [
    [{ 'header': [1, 2, 3, false] }], // Seulement H1, H2, H3
    ['bold', 'italic'], // Seulement gras et italique
    // Retirer 'underline', 'strike', etc.
]
```

### Thèmes disponibles
- **Snow** : Barre d'outils fixe en haut (utilisé actuellement)
- **Bubble** : Barre d'outils contextuelle (apparaît à la sélection)

## Raccourcis clavier

- **Ctrl+B** : Gras
- **Ctrl+I** : Italique
- **Ctrl+U** : Souligné
- **Ctrl+Z** : Annuler
- **Ctrl+Y** : Rétablir
- **Ctrl+K** : Insérer un lien

## Documentation officielle

- Site web : https://quilljs.com/
- GitHub : https://github.com/quilljs/quill
- Playground : https://quilljs.com/playground/
- Documentation : https://quilljs.com/docs/

## Fichiers modifiés

1. `resources/views/admin/blog/create.blade.php`
   - Remplacé TinyMCE par Quill
   - Ajout div#editor et textarea caché
   - Script de synchronisation

2. `resources/views/admin/blog/edit.blade.php`
   - Remplacé TinyMCE par Quill
   - Chargement du contenu existant
   - Script de synchronisation

## Résultat

✅ **Éditeur 100% gratuit et fonctionnel**
✅ **Outils essentiels disponibles**
✅ **Interface propre et moderne**
✅ **Aucune dépendance à une API tierce**
✅ **Parfait pour un blog**

L'éditeur Quill offre toutes les fonctionnalités essentielles pour rédiger des articles de blog de qualité, sans aucun frais ni limitation ! 🎉
