// AJAX cart handling: intercept forms with .js-ajax-add-to-cart and .js-ajax-emprunt
(function(){
  function q(sel, ctx){ return (ctx||document).querySelector(sel); }
  function qa(sel, ctx){ return Array.from((ctx||document).querySelectorAll(sel)); }

  const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

  function notify(message, success=true){
    // small toast using Bootstrap if available
    if (typeof bootstrap !== 'undefined'){
      const toastContainerId = 'ajaxToastContainer';
      let container = document.getElementById(toastContainerId);
      if (!container){
        container = document.createElement('div');
        container.id = toastContainerId;
        container.setAttribute('aria-live','polite');
        container.setAttribute('aria-atomic','true');
        container.style.position = 'fixed';
        container.style.top = '1rem';
        container.style.right = '1rem';
        container.style.zIndex = '10800';
        document.body.appendChild(container);
      }
      const toast = document.createElement('div');
      toast.className = 'toast align-items-center border-0 shadow-lg';
      toast.role = 'alert';
      toast.innerHTML = `<div class=\"d-flex\"><div class=\"toast-body\">${message}</div><button type=\"button\" class=\"btn-close me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Fermer\"></button></div>`;
      container.appendChild(toast);
      const btoast = new bootstrap.Toast(toast, { delay: 3000 });
      btoast.show();
      return;
    }
    // fallback
    alert(message);
  }

  function updateCartBadge(count){
    // update all badges that show the cart count in the navbar
    qa('.badge.badge-cart-count, .badge[data-cart-count], .position-absolute .badge').forEach(el => {
      try { el.textContent = count; } catch(e){}
    });
    // header badge at top-left (session badge)
    try{
      const navBadge = document.querySelector('.nav-bar .badge.rounded-pill');
      if (navBadge) navBadge.textContent = count;
      const navBtnBadge = document.querySelector('.ms-auto .badge.rounded-pill');
      if (navBtnBadge) navBtnBadge.textContent = count;
    }catch(e){}
  }

  function refreshCartModal(){
    // naive: reload modal body via XHR to /paiement partial or just update totals from server
    // For now we only update the total displayed in the modal and count; a more complete implementation could fetch the modal HTML
    fetch('/api/cart/summary', { headers: { 'X-CSRF-TOKEN': csrf } })
      .then(r => r.ok ? r.json() : Promise.reject(r.status))
      .then(json => {
        if (json && typeof json.count !== 'undefined'){
          updateCartBadge(json.count);
        }
        if (json && typeof json.total !== 'undefined'){
          const t = document.querySelector('#cartModal .text-primary');
          if (t) t.textContent = json.total + ' FCFA';
        }
      }).catch(()=>{});
  }

  // intercept add-to-cart forms
  qa('form.js-ajax-add-to-cart, form[data-ajax="panier"], form[action*="/panier/ajouter"]').forEach(form => {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const btn = form.querySelector('button[type="submit"]');
      if (btn) { btn.disabled = true; }
      const formData = new FormData(form);
      const payload = {};
      formData.forEach((v,k) => { payload[k] = v; });
      fetch(form.action, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf,
        },
        body: formData
      }).then(r => r.ok ? r.json() : r.text().then(t => { throw new Error(t||'Erreur'); }))
      .then(json => {
        if (json && json.success){
          notify(json.message || 'Ajouté au panier');
          if (typeof json.cart_count !== 'undefined') updateCartBadge(json.cart_count);
          // try refresh cart modal totals
          refreshCartModal();
        } else {
          notify(json.message || 'Impossible d\'ajouter le livre au panier', false);
        }
      })
      .catch(err => {
        console.error('AJAX add to cart error', err);
        notify('Erreur réseau. Réessayez.', false);
      })
      .finally(()=>{ if (btn) btn.disabled = false; });
    });
  });

  // intercept emprunt forms
  qa('form.js-ajax-emprunt, form[action*="/bibliotheque/emprunter"]').forEach(form => {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      const btn = form.querySelector('button[type="submit"]');
      if (btn) btn.disabled = true;
      const formData = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
        body: formData
      }).then(r => r.ok ? r.json() : r.text().then(t => { throw new Error(t||'Erreur'); }))
      .then(json => {
        if (json && json.success){
          notify(json.message || 'Emprunt enregistré');
        } else {
          notify(json.message || 'Impossible d\'enregistrer l\'emprunt', false);
        }
      })
      .catch(err => { console.error('AJAX emprunt error', err); notify('Erreur réseau. Réessayez.', false); })
      .finally(()=>{ if (btn) btn.disabled = false; });
    });
  });

})();
