/**
 * Système de validation de formulaire avec confirmation pour champs vides
 * Colibri Littéraire - Admin Forms
 */

(function() {
    'use strict';

    // Variable pour stocker le formulaire en cours de soumission
    let formToSubmit = null;

    /**
     * Initialise la validation pour un formulaire
     */
    function initFormValidation(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return;

        form.addEventListener('submit', function(e) {
            // Si le formulaire a déjà été confirmé, laisser passer
            if (form.dataset.confirmed === 'true') {
                form.dataset.confirmed = 'false'; // Reset
                return true;
            }

            // Empêcher la soumission par défaut
            e.preventDefault();

            // Vérifier les champs vides
            const emptyFields = checkEmptyFields(form);

            if (emptyFields.length > 0) {
                // Afficher le modal de confirmation
                showConfirmationModal(form, emptyFields);
            } else {
                // Pas de champs vides, soumettre directement
                form.submit();
            }
        });
    }

    /**
     * Vérifie les champs vides importants dans le formulaire
     */
    function checkEmptyFields(form) {
        const emptyFields = [];

        // Récupérer tous les champs marqués comme "importants"
        const importantFields = form.querySelectorAll('[data-important="true"]');

        importantFields.forEach(field => {
            const value = getFieldValue(field);

            if (!value || value.trim() === '') {
                const label = getFieldLabel(field);
                emptyFields.push({
                    name: field.name,
                    label: label,
                    element: field
                });
            }
        });

        return emptyFields;
    }

    /**
     * Récupère la valeur d'un champ selon son type
     */
    function getFieldValue(field) {
        if (field.type === 'checkbox') {
            return field.checked ? '1' : '';
        } else if (field.type === 'radio') {
            const form = field.form;
            const checkedRadio = form.querySelector(`input[name="${field.name}"]:checked`);
            return checkedRadio ? checkedRadio.value : '';
        } else if (field.tagName === 'SELECT') {
            return field.value;
        } else {
            return field.value;
        }
    }

    /**
     * Récupère le label d'un champ
     */
    function getFieldLabel(field) {
        // Chercher le label associé
        const fieldId = field.id;
        if (fieldId) {
            const label = document.querySelector(`label[for="${fieldId}"]`);
            if (label) {
                // Extraire le texte sans les astérisques et icônes
                return label.textContent.replace(/\*/g, '').replace(/\s+/g, ' ').trim();
            }
        }

        // Sinon, utiliser le nom du champ
        return field.name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    /**
     * Affiche le modal de confirmation
     */
    function showConfirmationModal(form, emptyFields) {
        formToSubmit = form;

        // Remplir la liste des champs vides
        const listElement = document.getElementById('emptyFieldsList');
        listElement.innerHTML = '';

        emptyFields.forEach(field => {
            const li = document.createElement('li');
            li.className = 'mb-2';
            li.innerHTML = `<i class="fas fa-circle text-warning me-2" style="font-size: 8px;"></i><strong>${field.label}</strong>`;
            listElement.appendChild(li);
        });

        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
        modal.show();
    }

    /**
     * Gère la confirmation de soumission
     */
    function handleConfirmSubmit() {
        const confirmBtn = document.getElementById('confirmSubmitBtn');
        if (!confirmBtn) return;

        confirmBtn.addEventListener('click', function() {
            if (formToSubmit) {
                // Marquer le formulaire comme confirmé
                formToSubmit.dataset.confirmed = 'true';

                // Fermer le modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('confirmSubmitModal'));
                modal.hide();

                // Soumettre le formulaire
                formToSubmit.submit();
            }
        });
    }

    /**
     * Initialisation au chargement de la page
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser pour tous les formulaires avec la classe 'needs-validation-confirm'
        const forms = document.querySelectorAll('form.needs-validation-confirm');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // Si le formulaire a déjà été confirmé, laisser passer
                if (form.dataset.confirmed === 'true') {
                    form.dataset.confirmed = 'false'; // Reset
                    return true;
                }

                // Empêcher la soumission par défaut
                e.preventDefault();

                // Vérifier les champs vides
                const emptyFields = checkEmptyFields(form);

                if (emptyFields.length > 0) {
                    // Afficher le modal de confirmation
                    showConfirmationModal(form, emptyFields);
                } else {
                    // Pas de champs vides, soumettre directement
                    form.submit();
                }
            });
        });

        // Gérer le bouton de confirmation
        handleConfirmSubmit();
    });

})();
