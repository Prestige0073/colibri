<!-- Modal de confirmation pour formulaires avec champs vides -->
<div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title" id="confirmSubmitModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Attention - Champs vides détectés
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Les champs suivants sont vides :</p>
                <ul id="emptyFieldsList" class="list-unstyled mb-3">
                    <!-- Les champs vides seront listés ici par JavaScript -->
                </ul>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Voulez-vous vraiment soumettre ce formulaire avec ces champs vides ?
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-primary" id="confirmSubmitBtn">
                    <i class="fas fa-check me-2"></i>Confirmer quand même
                </button>
            </div>
        </div>
    </div>
</div>
