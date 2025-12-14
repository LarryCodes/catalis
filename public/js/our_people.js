document.addEventListener('DOMContentLoaded', () => {
  const selectAll = document.getElementById('select-all');
  const actionBar = document.getElementById('people-actions');
  const deleteBtn = document.getElementById('delete-selected');
  const deactivateBtn = document.getElementById('deactivate-selected');
  const newEmployeeBtn = document.getElementById('new-employee-icon');
  const searchInputs = document.querySelectorAll('.search-input[data-search-view]');
  const employeeSearchInput = document.querySelector('.search-input[data-search-view="employee"]');
  const partnerSearchInput = document.querySelector('.search-input[data-search-view="client"]');

  const getRowCheckboxes = () => Array.from(document.querySelectorAll('.quote-checkbox'));

function toggleActions() {
    const anyChecked = getRowCheckboxes().some(cb => cb.checked);
    if (actionBar) {
      actionBar.style.display = anyChecked ? 'flex' : 'none';
    }
  }

  if (selectAll) {
    selectAll.addEventListener('change', function () {
      getRowCheckboxes().forEach(cb => (cb.checked = selectAll.checked));
    toggleActions();
});
  }

  getRowCheckboxes().forEach(cb => {
    cb.addEventListener('change', () => {
      if (selectAll) selectAll.checked = getRowCheckboxes().every(c => c.checked);
    toggleActions();
    });
});

  if (deleteBtn) {
    deleteBtn.addEventListener('click', () => {
      const selected = getRowCheckboxes().filter(cb => cb.checked);
      if (!selected.length) return alert('No employees selected.');
      selected.forEach(cb => {
        const row = cb.closest('tr');
        if (row) row.remove();
        });
      if (selectAll) selectAll.checked = false;
      toggleActions();
      ensureNoDataRow();
    });
  }

  if (deactivateBtn) {
    deactivateBtn.addEventListener('click', () => {
      const selected = getRowCheckboxes().filter(cb => cb.checked);
      if (!selected.length) return alert('No employees selected.');
      alert(`${selected.length} employee(s) marked for deactivation (placeholder).`);
    });
  }

    const createNewBtn = document.getElementById('create-new-button');
    const createNewPanel = document.getElementById('create-new-panel');
    
    if (createNewBtn && createNewPanel) {
        createNewBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            createNewPanel.classList.toggle('show');
        });

        const optionItems = createNewPanel.querySelectorAll('.option-item');
        optionItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                const action = item.dataset.action;
                console.log(`Opening modal for: ${action}`);
                createNewPanel.classList.remove('show');
            });
        });

        document.addEventListener('click', (e) => {
            if (!createNewBtn.contains(e.target) && !createNewPanel.contains(e.target)) {
                createNewPanel.classList.remove('show');
      }
    });
  }

    const viewTabs = document.querySelectorAll('.view-tab');
    const viewsSelector = document.querySelector('.views-selector');
    const viewSections = document.querySelectorAll('[data-view-section]');
    const searchForms = document.querySelectorAll('[data-search-form]');
    
    function updateSlidingBackground(activeTab) {
        if (!activeTab || !viewsSelector) return;
        
        const selectorRect = viewsSelector.getBoundingClientRect();
        
        const tabRect = activeTab.getBoundingClientRect();
        
        const left = tabRect.left - selectorRect.left;
        const width = tabRect.width;
        const height = tabRect.height;
        const top = tabRect.top - selectorRect.top;
        
        viewsSelector.style.setProperty('--slider-left', `${left}px`);
        viewsSelector.style.setProperty('--slider-width', `${width}px`);
        viewsSelector.style.setProperty('--slider-height', `${height}px`);
        viewsSelector.style.setProperty('--slider-top', `${top}px`);
    }
    
    function toggleViewSections(viewKey) {
        viewSections.forEach(section => {
            const matches = section.dataset.viewSection === viewKey;
            section.style.display = matches ? '' : 'none';
        });
        searchForms.forEach(form => {
            const matches = form.dataset.searchForm === viewKey;
            form.style.display = matches ? '' : 'none';
        });
    }

    viewTabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            
            viewTabs.forEach(t => t.classList.remove('active'));
            
            tab.classList.add('active');
            
            updateSlidingBackground(tab);
            
            const view = tab.dataset.view;
            toggleViewSections(view);
        });
    });
    
    const activeTab = document.querySelector('.view-tab.active');
    if (activeTab) {
        updateSlidingBackground(activeTab);
        toggleViewSections(activeTab.dataset.view);
    }

  if (employeeSearchInput) {
    const handleEmployeeSearch = () => performEmployeeSearch(employeeSearchInput.value);
    employeeSearchInput.addEventListener('input', handleEmployeeSearch);
    employeeSearchInput.addEventListener('keyup', handleEmployeeSearch);
  }

  if (partnerSearchInput) {
    const handlePartnerSearch = () => performPartnerSearch(partnerSearchInput.value);
    partnerSearchInput.addEventListener('input', handlePartnerSearch);
    partnerSearchInput.addEventListener('keyup', handlePartnerSearch);
  }

  function performEmployeeSearch(rawTerm = '') {
    const employeeSection = document.querySelector('[data-view-section="employee"]');
    const tableBody = employeeSection?.querySelector('.people-table tbody');
    if (!tableBody) return;

    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const term = (rawTerm || '').toLowerCase().trim();

    let visibleCount = 0;
    rows.forEach(row => {
      if (row.querySelector('td[colspan]')) return;

      const cells = Array.from(row.querySelectorAll('td:not(.checkbox-cell)'));
      const matches = cells.some(td => td.textContent.toLowerCase().includes(term));
      row.style.display = !term || matches ? '' : 'none';
      if (!term || matches) visibleCount += 1;
    });

    updateNoResultsRow(tableBody, term, visibleCount);
  }

  function performPartnerSearch(rawTerm = '') {
    const partnerSection = document.querySelector('[data-view-section="client"]');
    const tableBody = partnerSection?.querySelector('.partners-table tbody');
    if (!tableBody) return;

    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const term = (rawTerm || '').toLowerCase().trim();

    rows.forEach(row => {
      const cells = Array.from(row.querySelectorAll('td'));
      const matches = cells.some(td => td.textContent.toLowerCase().includes(term));
      row.style.display = !term || matches ? '' : 'none';
    });
  }

  function updateNoResultsRow(tbody, term, visibleCount) {
    const existingNoDataRows = tbody.querySelectorAll('.no-results-row, .no-data-row');
    existingNoDataRows.forEach(row => row.remove());

    if (term && visibleCount === 0) {
      const noResultsRow = document.createElement('tr');
      noResultsRow.className = 'no-results-row';
      noResultsRow.innerHTML = '<td colspan="12" style="text-align: center; color: #666; font-style: italic;">No results found.</td>';
      tbody.appendChild(noResultsRow);
    } else if (!term && visibleCount === 0) {
      const noDataRow = document.createElement('tr');
      noDataRow.className = 'no-data-row';
      noDataRow.innerHTML = '<td colspan="12" style="text-align: center;">No employees available.</td>';
      tbody.appendChild(noDataRow);
    }
  }

  function ensureNoDataRow() {
    const tbody = document.querySelector('.people-table tbody');
    if (!tbody) return;

    const remaining = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.querySelector('td[colspan]'));
    const hasData = remaining.some(r => r.style.display !== 'none');
    const searchTerm = (employeeSearchInput?.value || '').trim();
    
    const existingNoDataRows = tbody.querySelectorAll('.no-results-row, .no-data-row');
    existingNoDataRows.forEach(row => row.remove());
    
    if (!hasData) {
      const message = searchTerm ? 'No results found.' : 'No employees available.';
      const rowClass = searchTerm ? 'no-results-row' : 'no-data-row';
      const style = searchTerm ? 'color: #666; font-style: italic;' : '';
      
      const emptyRow = document.createElement('tr');
      emptyRow.className = rowClass;
      emptyRow.innerHTML = `<td colspan="12" style="text-align: center; ${style}">${message}</td>`;
      tbody.appendChild(emptyRow);
    }
    
    toggleTableAndSearchVisibility();
  }

  function toggleTableAndSearchVisibility() {
    const tableWrapper = document.querySelector('.people-table-wrapper');
    const searchForm = document.querySelector('.search-form');
    const table = document.querySelector('.people-table');
    const hasEmployees = !!table && table.querySelectorAll('tbody tr').length > 0;
    
    if (tableWrapper) {
      tableWrapper.style.display = hasEmployees ? '' : 'none';
    }
    if (searchForm) {
      searchForm.style.display = hasEmployees ? '' : 'none';
    }
  }

  toggleActions();
  ensureNoDataRow();
});