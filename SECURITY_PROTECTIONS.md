# Protections de Sécurité - Visualiseur PDF

## Vue d'ensemble
Ce document décrit les protections multi-couches implémentées pour empêcher la capture d'écran, l'enregistrement d'écran et le piratage du contenu PDF.

---

## 🛡️ Protections Implémentées

### 1. **Protection contre la Capture d'Écran (Screenshot)**

#### 1.1 Détection des raccourcis clavier
- **PrintScreen** (Windows)
- **Cmd+Shift+3** (Mac - capture d'écran complète)
- **Cmd+Shift+4** (Mac - capture d'écran partielle)
- **Win+Shift+S** (Windows - outil de capture)

**Action:** Lorsqu'un de ces raccourcis est détecté, le canvas est immédiatement noirci et un message d'alerte s'affiche.

#### 1.2 Détection de perte de focus
- Lorsque la fenêtre perd le focus (`blur`), le contenu est masqué après 50ms
- Message affiché: "⛔ SESSION SUSPENDUE"
- Le contenu est restauré uniquement après que l'utilisateur clique sur la fenêtre

#### 1.3 Détection de visibilité
- Utilise l'API `visibilitychange`
- Lorsque l'onglet devient caché (changement d'onglet, minimisation), le canvas est noirci
- Message: "⛔ CONTENU PROTÉGÉ"
- Restauration automatique au retour sur l'onglet

### 2. **Protection contre l'Enregistrement d'Écran**

#### 2.1 Blocage de l'API Screen Capture
```javascript
navigator.mediaDevices.getDisplayMedia = function() {
    alert('⛔ ACCÈS REFUSÉ - La capture d\'écran est interdite');
    throw new Error('Screen capture blocked');
};
```

#### 2.2 Blocage de MediaRecorder
- Détecte toute tentative d'enregistrement vidéo
- Bloque les flux vidéo avant leur création
- Message: "⛔ ENREGISTREMENT BLOQUÉ"

#### 2.3 Surveillance des dimensions de fenêtre
- Détecte les redimensionnements suspects (> 100px)
- Peut indiquer l'ouverture d'outils de capture
- Noircit temporairement le contenu

### 3. **Protection du Canvas**

#### 3.1 Blocage des méthodes d'extraction
```javascript
// Rend ces méthodes inutilisables
canvas.toDataURL = function() { return ''; }
canvas.toBlob = function() { return null; }
```

#### 3.2 Watermark intégré au canvas
- Watermark invisible ajouté directement dans le rendu
- Impossible à retirer même avec les DevTools
- Inclut un timestamp et l'ID utilisateur (traçabilité)

#### 3.3 Propriétés CSS anti-capture
```css
#pdf-canvas {
    transform: translateZ(0);
    backface-visibility: hidden;
    will-change: transform, opacity;
}
```

### 4. **Protection contre les Outils de Développement**

#### 4.1 Détection DevTools
- Détecte l'ouverture des DevTools par dimensions de fenêtre
- Affiche un écran d'avertissement complet
- Utilise `console.log` avec un objet piège

#### 4.2 Debugger infini
```javascript
setInterval(function() { debugger; }, 100);
```
- Empêche l'utilisation normale du debugger
- Ralentit considérablement le reverse engineering

#### 4.3 Désactivation de la console
- Toutes les méthodes `console.*` sont remplacées par des fonctions vides
- Empêche les logs de débogage

### 5. **Protections CSS**

#### 5.1 Impression bloquée
```css
@media print {
    body { display: none !important; }
    * { display: none !important; }
}
```

#### 5.2 Sélection désactivée
```css
* {
    user-select: none !important;
    -webkit-user-select: none !important;
}
```

#### 5.3 Isolation du contenu
```css
.viewer-container {
    isolation: isolate;
    contain: layout style paint;
}
```

### 6. **Headers de Sécurité HTTP**

#### 6.1 Permissions-Policy
```
display-capture=()
screen-wake-lock=()
camera=()
microphone=()
```
- Bloque explicitement les permissions de capture au niveau du navigateur

#### 6.2 Content-Security-Policy
```
frame-src 'none'
object-src 'none'
media-src 'none'
```
- Empêche l'embedding et l'accès aux médias

#### 6.3 Cache-Control
```
no-cache, no-store, must-revalidate, max-age=0
```
- Aucune mise en cache possible
- Le PDF n'est jamais stocké localement

### 7. **Protections JavaScript**

#### 7.1 Blocage des raccourcis clavier
- F12 (DevTools)
- Ctrl+Shift+I/J/C (Inspecteur)
- Ctrl+U (Code source)
- Ctrl+S (Sauvegarde)
- Ctrl+P (Impression)

#### 7.2 Blocage du menu contextuel
```javascript
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    return false;
});
```

#### 7.3 Blocage du copier-coller
```javascript
document.addEventListener('copy', function(e) {
    e.preventDefault();
    e.clipboardData.setData('text/plain', '');
});
```

#### 7.4 Blocage du drag & drop
```javascript
document.addEventListener('dragstart', function(e) {
    e.preventDefault();
});
```

### 8. **Watermarks Multi-couches**

#### 8.1 Watermarks HTML
- 3 couches de watermark HTML semi-transparents
- Positionnement fixe avec rotation -45°
- Texte: "COLIBRI - PROTÉGÉ"

#### 8.2 Watermark Canvas
- Intégré directement dans le rendu du PDF
- Opacité très faible (0.1)
- Impossible à retirer

#### 8.3 Overlay dynamique
- Change toutes les 2 secondes
- Angle et opacité aléatoires
- Perturbe les outils de capture automatiques

### 9. **Protection Mobile**

#### 9.1 iOS
- Détection des screenshots natifs
- Blocage de `user-select` pour Safari
- Meta tags spécifiques Apple

#### 9.2 Android
- Désactivation du menu contextuel long-press
- Blocage des screenshots via `FLAG_SECURE` (nécessite app native)
- Protection web maximale

---

## 🎯 Niveaux de Protection

| Type de Menace | Protection | Efficacité |
|----------------|-----------|------------|
| Screenshot (PrintScreen) | Détection + Noircissement | ⭐⭐⭐⭐⭐ |
| Enregistrement d'écran | Blocage API | ⭐⭐⭐⭐⭐ |
| DevTools | Détection + Debugger | ⭐⭐⭐⭐ |
| Extraction Canvas | Blocage méthodes | ⭐⭐⭐⭐⭐ |
| Impression | CSS + JS | ⭐⭐⭐⭐⭐ |
| Copier-coller | Blocage événements | ⭐⭐⭐⭐⭐ |
| Screenshot mobile | Détection visibilité | ⭐⭐⭐ |
| Caméra externe | Watermarks | ⭐⭐ |

---

## ⚠️ Limitations

### Protections impossibles au niveau Web
1. **Caméra externe** - Un utilisateur peut toujours photographier l'écran avec un appareil photo externe
   - **Mitigation:** Watermarks visibles + ID utilisateur tracé

2. **Machine virtuelle** - Capture au niveau hyperviseur
   - **Mitigation:** Détection de VM (complexe), watermarks

3. **HDMI Capture** - Enregistrement du signal vidéo
   - **Mitigation:** Watermarks dynamiques, DRM matériel (non web)

### Note importante
Ces protections sont **maximales pour une application web**. Pour une protection absolue, il faudrait:
- Application native avec DRM matériel
- Trusted Execution Environment (TEE)
- Hardware-based DRM (Widevine L1, PlayReady, FairPlay)

---

## 🔍 Comment tester

### Test 1: Screenshot
1. Ouvrir le visualiseur PDF
2. Appuyer sur `PrintScreen` ou `Cmd+Shift+3`
3. **Résultat attendu:** Écran noir + alerte

### Test 2: Enregistrement
1. Essayer d'utiliser un outil de capture d'écran (OBS, ShareX, etc.)
2. **Résultat attendu:** Erreur ou écran noir

### Test 3: DevTools
1. Ouvrir DevTools (F12)
2. **Résultat attendu:** Avertissement plein écran

### Test 4: Copie
1. Essayer de sélectionner du texte
2. Essayer Ctrl+C
3. **Résultat attendu:** Impossible + alerte

---

## 📊 Traçabilité

Chaque visualisation est tracée avec:
- **ID utilisateur** (dans watermark invisible)
- **Timestamp** de visualisation
- **Token de session** unique
- **Durée d'accès** limitée (6 heures)

En cas de fuite, ces informations permettent d'identifier la source.

---

## 🚀 Améliorations futures possibles

1. **Fingerprinting navigateur** - Tracer le navigateur exact
2. **Géolocalisation** - Enregistrer la position (avec consentement)
3. **Historique d'accès** - Log de toutes les consultations
4. **Machine Learning** - Détecter les comportements suspects
5. **DRM Natif** - Migration vers app native avec DRM matériel

---

## 📝 Conformité légale

Ces protections respectent:
- ✅ RGPD (pas de collecte excessive de données)
- ✅ Droits d'auteur
- ✅ Conditions d'utilisation transparentes
- ✅ Avertissements clairs aux utilisateurs

---

**Version:** 1.0
**Dernière mise à jour:** 2025-12-20
**Auteur:** Colibri Littéraire - Équipe Sécurité
