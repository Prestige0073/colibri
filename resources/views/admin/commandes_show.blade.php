@extends('admin.layout')

@section('title','Commande #'.$commande->id)

@section('content')
<div class="container py-5">
    <a href="{{ route('admin.commandes.index') }}" class="btn btn-sm btn-secondary mb-3">
        <i class="fa fa-arrow-left me-1"></i>
        <span class="d-none d-sm-inline">Retour aux commandes</span>
    </a>

    <div class="card">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h5 class="mb-0"><i class="fa fa-truck me-2"></i>Commande {{ $commande->id }}</h5>
                <small class="text-muted d-block d-md-inline"><i class="fa fa-calendar-alt me-1"></i>Le {{ $commande->created_at->format('d/m/Y H:i') }}</small>
            </div>
            <div>
                <form method="POST" action="{{ route('admin.commandes.updateStatus', $commande->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="input-group">
                            <select id="statutSelect" name="statut" class="form-select">
                                <option value="pending" {{ $commande->statut=='pending'?'selected':'' }}>En préparation</option>
                                <option value="en_livraison" {{ $commande->statut=='en_livraison'?'selected':'' }}>En livraison</option>
                                <option value="livre" {{ $commande->statut=='livre'?'selected':'' }}>Livré</option>
                            </select>
                            <input type="hidden" name="delivered_at" id="delivered_at_input" value="">
                            <input type="hidden" name="confirmation_token" id="confirmation_token_input" value="">
                            <button id="statusUpdateBtn" class="btn btn-primary">
                                <i class="fa fa-save" aria-hidden="true"></i>
                                <span class="d-none d-sm-inline ms-1">Mettre à jour</span>
                            </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <h6><i class="fa fa-user me-1"></i>Client</h6>
            <p class="mb-1">{{ $commande->nom ?? '—' }}</p>

            <div class="mb-3">
                @php
                    // Normalisation: essayer plusieurs champs possibles (telephone, tel)
                    $tel = $commande->telephone ?? $commande->tel ?? '';
                    $whatsapp = $tel ? 'https://wa.me/'.preg_replace('/[^0-9+]/','',$tel) : '#';
                    $mailto = $commande->email ?? $commande->mail ?? '';
                @endphp
                <a href="{{ $tel ? 'tel:'.$tel : '#' }}" class="btn btn-outline-success btn-sm me-2">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline ms-1">Appeler</span>
                </a>
                <a href="{{ $tel ? $whatsapp : '#' }}" target="_blank" class="btn btn-outline-success btn-sm me-2">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline ms-1">WhatsApp</span>
                </a>
                @if(!empty($mailto))
                    <a href="mailto:{{ $mailto }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline ms-1">Email</span>
                    </a>
                @endif

                {{-- Afficher les coordonnées en petit texte derrière les boutons --}}
                <div class="small text-muted mt-2">
                    @if(!empty($tel))
                        <span>Téléphone : <a href="tel:{{ $tel }}">{{ $tel }}</a></span>
                    @endif
                    @if(!empty($mailto))
                        <span class="ms-3">Email : <a href="mailto:{{ $mailto }}">{{ $mailto }}</a></span>
                    @endif
                </div>
            </div>

            <h6><i class="fa fa-map-marker-alt me-1"></i>Adresse</h6>
            <p>{{ $commande->adresse ?? '—' }}</p>

            <h6><i class="fa fa-boxes me-1"></i>Articles</h6>
            <ul class="list-unstyled">
                @foreach($commande->items as $it)
                    <li class="mb-2">
                        <i class="fa fa-book me-2"></i>
                        {{ $it->titre }} — x{{ $it->quantite }} — {{ number_format($it->prix,0,',',' ') }} FCFA
                    </li>
                @endforeach
            </ul>

                <div class="mt-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <div>
                    <span class="badge bg-info text-dark">Statut: {{ $commande->statut_label }}</span>
                </div>
                <div class="fw-bold"><i class="fa fa-coins me-1"></i><span class="d-none d-sm-inline">Total: </span>{{ number_format($commande->total,0,',',' ') }} FCFA</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form[action="{{ route('admin.commandes.updateStatus', $commande->id) }}"]');
        if (!form) return;
        var statutSelect = document.getElementById('statutSelect');
        var deliveredAtInput = document.getElementById('delivered_at_input');
        var confirmationInput = document.getElementById('confirmation_token_input');

        // Create modal HTML and append to body
        var modalHtml = `
        <div class="modal fade" id="confirmDeliverModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmer la livraison</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Vous êtes sur le point de marquer la commande <strong>#{{ $commande->id }}</strong> comme <strong>Livré</strong>.</p>
                        <p>Pour confirmer, veuillez saisir l'ID de la commande ci-dessous et indiquer la date/heure de livraison effective. Vous pouvez copier l'ID avec le bouton "Copier" puis coller ici.</p>
                        <div class="mb-3">
                            <label class="form-label">Date / heure de livraison</label>
                            <input type="datetime-local" id="modal_delivered_at" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ID de la commande (copiable)</label>
                            <div class="d-flex gap-2 align-items-center">
                                <code id="modal_order_id" class="p-2 border rounded">#{{ $commande->id }}</code>
                                <button type="button" id="modal_copy_btn" class="btn btn-sm btn-outline-secondary">Copier</button>
                            </div>
                            <div class="mt-2">
                                <label class="form-label">Collez ou saisissez l'ID ici pour confirmer</label>
                                <input type="text" id="modal_confirm_input" class="form-control" placeholder="Ex: {{ $commande->id }} ou #{{ $commande->id }}">
                                <div class="form-text">Collez exactement <code>{{ $commande->id }}</code> ou <code>#{{ $commande->id }}</code> pour confirmer.</div>
                            </div>
                        </div>
                        <div id="modal_error" class="text-danger small" style="display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" id="modal_confirm_btn" class="btn btn-primary">Confirmer la livraison</button>
                    </div>
                </div>
            </div>
        </div>`;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        var confirmModalEl = document.getElementById('confirmDeliverModal');
        var confirmModal = new bootstrap.Modal(confirmModalEl);

        form.addEventListener('submit', function(e){
                var selected = statutSelect.value;
                if (selected === 'livre') {
                        e.preventDefault();
                        // open modal
                        document.getElementById('modal_delivered_at').value = new Date().toISOString().slice(0,16);
                        document.getElementById('modal_confirm_input').value = '';
                        document.getElementById('modal_error').style.display = 'none';
                        confirmModal.show();
                }
                // otherwise let the form submit normally
        });

        // copy button
        document.getElementById('modal_copy_btn').addEventListener('click', function(){
            var txt = document.getElementById('modal_order_id').textContent.trim();
            var btn = document.getElementById('modal_copy_btn');
            // Try modern clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(txt).then(function(){
                    btn.textContent = 'Copié';
                    setTimeout(()=> btn.textContent = 'Copier', 1500);
                }).catch(function(){
                    fallbackCopyText(txt, btn);
                });
            } else {
                fallbackCopyText(txt, btn);
            }
        });

        function fallbackCopyText(text, btn) {
            try {
                var ta = document.createElement('textarea');
                ta.value = text;
                // avoid visible focus
                ta.style.position = 'fixed';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.select();
                ta.setSelectionRange(0, ta.value.length);
                var ok = false;
                try { ok = document.execCommand('copy'); } catch (e) { ok = false; }
                document.body.removeChild(ta);
                if (ok) {
                    btn.textContent = 'Copié';
                    setTimeout(()=> btn.textContent = 'Copier', 1500);
                } else {
                    // final fallback: select the code element so user can press Ctrl+C
                    var codeEl = document.getElementById('modal_order_id');
                    var range = document.createRange();
                    range.selectNode(codeEl);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    btn.textContent = 'Sélectionné';
                    setTimeout(()=> btn.textContent = 'Copier', 1500);
                }
            } catch (e) {
                btn.textContent = 'Erreur';
                setTimeout(()=> btn.textContent = 'Copier', 1500);
            }
        }

        document.getElementById('modal_confirm_btn').addEventListener('click', function(){
            var val = document.getElementById('modal_confirm_input').value.trim();
            var dt = document.getElementById('modal_delivered_at').value;
            var errEl = document.getElementById('modal_error');
            if (!dt) {
                errEl.textContent = 'Veuillez indiquer la date et l\'heure de livraison.';
                errEl.style.display = 'block';
                return;
            }
            // Accept either '6' or '#6'
            var expected = String({{ $commande->id }});
            var alt = '#' + expected;
            if (val !== expected && val !== alt) {
                errEl.textContent = 'Valeur de confirmation incorrecte. Collez ou tapez exactement l\'ID (ex: ' + expected + ').';
                errEl.style.display = 'block';
                return;
            }

            // normalize to plain id
            var token = (val.charAt(0) === '#') ? val.slice(1) : val;

            // set hidden inputs and submit form
            deliveredAtInput.value = dt;
            confirmationInput.value = token;
            confirmModal.hide();
            form.submit();
        });
});
</script>
@endpush
