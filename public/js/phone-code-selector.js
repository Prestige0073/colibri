/**
 * Phone Code Selector - Sélecteur d'indicatif téléphonique avec recherche AJAX
 *
 * Usage:
 *   PhoneCodeSelector.init({
 *       container: '#phone-container',   // conteneur parent
 *       hiddenInput: '#phone_full',       // champ hidden qui reçoit la valeur combinée
 *       defaultCode: '+229',              // indicatif par défaut
 *       defaultNumber: '',                // numéro par défaut
 *       formId: 'myForm'                  // id du formulaire parent
 *   });
 */
const PhoneCodeSelector = (function () {
    const instances = [];

    function create(config) {
        const container = document.querySelector(config.container);
        if (!container) return;

        const hiddenInput = document.querySelector(config.hiddenInput);
        const defaultCode = config.defaultCode || '+229';
        const defaultNumber = config.defaultNumber || '';
        const defaultFlag = config.defaultFlag || '🇧🇯';
        const defaultCountry = config.defaultCountry || 'Bénin';

        let allCountries = [];
        let selectedCode = defaultCode;
        let selectedFlag = defaultFlag;
        let selectedCountry = defaultCountry;
        let isOpen = false;
        let debounceTimer = null;

        // Build HTML
        container.innerHTML = '';
        container.style.position = 'relative';

        // Wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'pcs-wrapper';

        // Selected button
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pcs-selected-btn';
        btn.innerHTML = `<span class="pcs-flag">${defaultFlag}</span><span class="pcs-code">${defaultCode}</span><i class="fas fa-chevron-down pcs-arrow"></i>`;
        wrapper.appendChild(btn);

        // Number input
        const numInput = document.createElement('input');
        numInput.type = 'tel';
        numInput.name = 'phone_number';
        numInput.className = 'pcs-number-input';
        numInput.placeholder = 'XX XX XX XX';
        numInput.value = defaultNumber;
        numInput.autocomplete = 'tel-national';
        wrapper.appendChild(numInput);

        container.appendChild(wrapper);

        // Dropdown
        const dropdown = document.createElement('div');
        dropdown.className = 'pcs-dropdown';
        dropdown.style.display = 'none';

        // Search
        const searchWrap = document.createElement('div');
        searchWrap.className = 'pcs-search-wrap';
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'pcs-search';
        searchInput.placeholder = 'Rechercher un pays, indicatif...';
        searchInput.autocomplete = 'off';
        searchWrap.appendChild(searchInput);
        dropdown.appendChild(searchWrap);

        // List
        const list = document.createElement('div');
        list.className = 'pcs-list';
        dropdown.appendChild(list);

        container.appendChild(dropdown);

        // Functions
        function updateHidden() {
            if (!hiddenInput) return;
            const num = numInput.value.trim();
            hiddenInput.value = num ? selectedCode + ' ' + num : '';
        }

        function renderList(countries) {
            list.innerHTML = '';
            if (countries.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'pcs-empty';
                empty.textContent = 'Aucun résultat';
                list.appendChild(empty);
                return;
            }
            countries.forEach(function (c) {
                const item = document.createElement('div');
                item.className = 'pcs-item' + (c.code === selectedCode && c.iso === (config.selectedIso || '') ? ' pcs-item-active' : '');
                if (c.code === selectedCode) item.classList.add('pcs-item-active');
                item.innerHTML = `<span class="pcs-item-flag">${c.flag}</span><span class="pcs-item-name">${c.name}</span><span class="pcs-item-code">${c.code}</span>`;
                item.addEventListener('click', function () {
                    selectedCode = c.code;
                    selectedFlag = c.flag;
                    selectedCountry = c.name;
                    btn.innerHTML = `<span class="pcs-flag">${c.flag}</span><span class="pcs-code">${c.code}</span><i class="fas fa-chevron-down pcs-arrow"></i>`;
                    updateHidden();
                    closeDropdown();
                });
                list.appendChild(item);
            });
        }

        function fetchCountries(query) {
            const url = '/api/phone-codes' + (query ? '?q=' + encodeURIComponent(query) : '');
            fetch(url)
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    allCountries = data;
                    renderList(data);
                })
                .catch(function () {
                    list.innerHTML = '<div class="pcs-empty">Erreur de chargement</div>';
                });
        }

        function openDropdown() {
            dropdown.style.display = 'block';
            isOpen = true;
            btn.classList.add('pcs-open');
            searchInput.value = '';
            searchInput.focus();
            fetchCountries('');
        }

        function closeDropdown() {
            dropdown.style.display = 'none';
            isOpen = false;
            btn.classList.remove('pcs-open');
        }

        // Events
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (isOpen) {
                closeDropdown();
            } else {
                openDropdown();
            }
        });

        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                fetchCountries(searchInput.value.trim());
            }, 250);
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDropdown();
        });

        numInput.addEventListener('input', updateHidden);

        // Close on click outside
        document.addEventListener('click', function (e) {
            if (isOpen && !container.contains(e.target)) {
                closeDropdown();
            }
        });

        // Combine before form submit
        if (config.formId) {
            const form = document.getElementById(config.formId);
            if (form) {
                form.addEventListener('submit', function () {
                    updateHidden();
                });
            }
        }

        // Initial hidden value
        updateHidden();

        return { updateHidden: updateHidden, getCode: function () { return selectedCode; } };
    }

    // CSS injection (only once)
    let cssInjected = false;
    function injectCSS() {
        if (cssInjected) return;
        cssInjected = true;

        const style = document.createElement('style');
        style.textContent = `
            .pcs-wrapper {
                display: flex;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                overflow: hidden;
                transition: border-color 0.2s;
            }
            .pcs-wrapper:focus-within {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            }
            .pcs-selected-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 8px 10px;
                border: none;
                background: #f8f9fa;
                cursor: pointer;
                font-size: 14px;
                white-space: nowrap;
                border-right: 1px solid #dee2e6;
                transition: background 0.2s;
                min-width: 110px;
            }
            .pcs-selected-btn:hover {
                background: #e9ecef;
            }
            .pcs-selected-btn.pcs-open {
                background: #e9ecef;
            }
            .pcs-flag {
                font-size: 18px;
                line-height: 1;
            }
            .pcs-code {
                font-weight: 600;
                color: #333;
            }
            .pcs-arrow {
                font-size: 10px;
                color: #999;
                margin-left: 2px;
                transition: transform 0.2s;
            }
            .pcs-open .pcs-arrow {
                transform: rotate(180deg);
            }
            .pcs-number-input {
                flex: 1;
                border: none;
                padding: 8px 12px;
                font-size: 14px;
                outline: none;
                min-width: 0;
            }
            .pcs-number-input::placeholder {
                color: #adb5bd;
            }
            .pcs-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1050;
                background: #fff;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
                margin-top: 4px;
                max-height: 320px;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            .pcs-search-wrap {
                padding: 10px;
                border-bottom: 1px solid #eee;
            }
            .pcs-search {
                width: 100%;
                border: 1px solid #dee2e6;
                border-radius: 6px;
                padding: 8px 12px;
                font-size: 13px;
                outline: none;
                transition: border-color 0.2s;
            }
            .pcs-search:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.12);
            }
            .pcs-list {
                overflow-y: auto;
                max-height: 250px;
                padding: 4px 0;
            }
            .pcs-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 8px 14px;
                cursor: pointer;
                transition: background 0.15s;
                font-size: 13px;
            }
            .pcs-item:hover {
                background: #f0f4ff;
            }
            .pcs-item-active {
                background: #e8f0fe;
                font-weight: 600;
            }
            .pcs-item-flag {
                font-size: 18px;
                line-height: 1;
                flex-shrink: 0;
            }
            .pcs-item-name {
                flex: 1;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                color: #333;
            }
            .pcs-item-code {
                font-weight: 600;
                color: #666;
                font-size: 12px;
                flex-shrink: 0;
            }
            .pcs-empty {
                padding: 16px;
                text-align: center;
                color: #999;
                font-size: 13px;
            }
            /* Scrollbar */
            .pcs-list::-webkit-scrollbar { width: 6px; }
            .pcs-list::-webkit-scrollbar-track { background: transparent; }
            .pcs-list::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
            .pcs-list::-webkit-scrollbar-thumb:hover { background: #aaa; }
        `;
        document.head.appendChild(style);
    }

    return {
        init: function (config) {
            injectCSS();
            return create(config);
        }
    };
})();
