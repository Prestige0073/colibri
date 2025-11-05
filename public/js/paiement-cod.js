/* paiement-cod.js
   Externalized JS for Pay on Delivery flow.
   - Reads cart data from <script id="cart-data" type="application/json"> in the page
   - Reads endpoint route from #codSection data-route attribute
   - Handles preview -> confirm -> send -> show contact actions
*/
(function(){
  function q(sel, ctx){ return (ctx||document).querySelector(sel); }
  function qa(sel, ctx){ return Array.from((ctx||document).querySelectorAll(sel)); }

  const cartDataEl = q('#cart-data');
  if (!cartDataEl) return; // nothing to do

  let payload;
  try { payload = JSON.parse(cartDataEl.textContent); } catch (e) { console.error('Invalid cart-data JSON', e); return; }

  const cartItems = payload.items || [];
  const total = payload.total || 0;
  const userId = payload.userId || null;

  const codSection = q('#codSection');
  if (!codSection) return;
  const endpoint = codSection.dataset.route || '';

  // helper uuid
  function uuidv4(){ return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c){var r=Math.random()*16|0,v=c=='x'?r:(r&0x3|0x8);return v.toString(16);}); }

  function buildItemsHtml(items){
    let html = '<ul class="list-group mb-2">';
    items.forEach(i => {
      html += `<li class="list-group-item d-flex justify-content-between align-items-center">${i.titre} <span class="badge bg-secondary">x${i.quantite}</span> <small class="text-muted ms-3">${i.prix} FCFA</small></li>`;
    });
    html += '</ul>';
    return html;
  }

  // initial render contains a single button; keep original HTML to restore
  const originalHtml = codSection.innerHTML;

  // prevent double submissions
  let inProgress = false;

  function computeSum(items){
    return items.reduce((s,i) => s + (Number(i.prix||0) * Number(i.quantite||0)), 0);
  }

  function showPreview(){
    const itemsHtml = buildItemsHtml(cartItems);
    codSection.innerHTML = `
      <div class="preview">
        <h6>Aperçu de la commande</h6>
        ${itemsHtml}
        <p class="fw-bold">Total: ${total} FCFA</p>
        ${userId ? `<p class="small text-muted">Utilisateur ID: ${userId}</p>` : `<p class="small text-muted">Utilisateur invité</p>`}
        <div class="d-flex gap-2 justify-content-center mt-3">
          <button id="codConfirm" class="btn btn-success">Confirmer et enregistrer</button>
          <button id="codCancel" class="btn btn-outline-secondary">Annuler</button>
        </div>
      </div>
    `;

    const codConfirm = q('#codConfirm');
    const codCancel = q('#codCancel');

    codCancel.addEventListener('click', () => {
      codSection.innerHTML = originalHtml;
      bindInitial();
    });

    codConfirm.addEventListener('click', () => {
      if (inProgress) return;

      // basic checks
      if (!Array.isArray(cartItems) || cartItems.length === 0) {
        alert('Votre panier est vide. Ajoutez des articles avant de confirmer.');
        return;
      }
      const clientSum = computeSum(cartItems);
      if (Number(clientSum) !== Number(total)) {
        alert('Le panier a changé. Rechargez la page et vérifiez votre panier avant de confirmer.');
        return;
      }

      inProgress = true;
      codConfirm.disabled = true;
      const idempotency_key = uuidv4();
      fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ items: cartItems, total: total, idempotency_key: idempotency_key })
      }).then(r=>r.json()).then(data=>{
        inProgress = false;
        if (data && data.success) {
          codSection.innerHTML = `
            <div class="text-center">
              <p class="fw-bold text-success">${data.message || 'Commande enregistrée avec succès.'}</p>
              <p><i class="fa fa-receipt text-primary me-1"></i>Commande ${data.commande_id}</p>
              <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 cod-actions mt-3">
                <a href="https://wa.me/${encodeURIComponent(data.contact_phone || '')}?text=${encodeURIComponent('Bonjour, j\'ai passé une commande (ID: '+(data.commande_id||'')+').') }" target="_blank" class="btn btn-success"> <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp</a>
                <a href="tel:${encodeURIComponent(data.contact_phone || '')}" class="btn btn-outline-primary"> <i class="fa fa-phone"></i> Appeler</a>
                <a href="mailto:${encodeURIComponent(data.contact_email || '')}?subject=${encodeURIComponent('Commande ID: '+(data.commande_id||''))}&body=${encodeURIComponent('Bonjour,%0AJe confirme ma commande. ID: '+(data.commande_id||'')) }" class="btn btn-outline-secondary"> <i class="fa fa-envelope"></i> Email</a>
              </div>
            </div>
          `;
        } else {
          console.error('Unexpected response', data);
          alert(data.message || 'Erreur lors de l\'enregistrement de la commande.');
          codSection.innerHTML = originalHtml;
          bindInitial();
        }
      }).catch(err=>{
        inProgress = false;
        console.error(err);
        alert('Impossible d\'enregistrer la commande pour le moment (problème réseau ou serveur). Réessayez dans un instant.');
        codSection.innerHTML = originalHtml;
        bindInitial();
      });
    });
  }

  function bindInitial(){
    const btn = q('#codValidate');
    if (!btn) return;
    btn.addEventListener('click', showPreview);
  }

  // start
  bindInitial();

})();
