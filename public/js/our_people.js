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
    
    if (createNewBtn) {
        createNewBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Get the active tab
            const activeTab = document.querySelector('.view-tab.active');
            if (!activeTab) return;
            
            const activeView = activeTab.dataset.view;
            
            // Dispatch event based on active tab
            switch(activeView) {
                case 'client':
                    Livewire.dispatch('openCreatePartner');
                    break;
                case 'site':
                    Livewire.dispatch('openCreateSite');
                    break;
                case 'department':
                    Livewire.dispatch('openCreateDepartment');
                    break;
                case 'employee-type':
                    Livewire.dispatch('openCreateTenure');
                    break;
                case 'employee':
                    Livewire.dispatch('openCreateEmployee');
                    break;
                case 'team':
                    // TODO: Implement teams
                    console.log('Teams not yet implemented');
                    break;
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

  // Search inputs for other views
  const siteSearchInput = document.querySelector('.search-input[data-search-view="site"]');
  const departmentSearchInput = document.querySelector('.search-input[data-search-view="department"]');
  const tenureSearchInput = document.querySelector('.search-input[data-search-view="employee-type"]');

  // Dispatch Livewire events for search - debounced
  if (employeeSearchInput) {
    let employeeDebounce;
    employeeSearchInput.addEventListener('input', () => {
      clearTimeout(employeeDebounce);
      employeeDebounce = setTimeout(() => {
        Livewire.dispatch('searchEmployees', { search: employeeSearchInput.value });
      }, 300);
    });
  }

  if (partnerSearchInput) {
    let partnerDebounce;
    partnerSearchInput.addEventListener('input', () => {
      clearTimeout(partnerDebounce);
      partnerDebounce = setTimeout(() => {
        Livewire.dispatch('searchPartners', { search: partnerSearchInput.value });
      }, 300);
    });
  }

  if (siteSearchInput) {
    let siteDebounce;
    siteSearchInput.addEventListener('input', () => {
      clearTimeout(siteDebounce);
      siteDebounce = setTimeout(() => {
        Livewire.dispatch('searchSites', { search: siteSearchInput.value });
      }, 300);
    });
  }

  if (departmentSearchInput) {
    let deptDebounce;
    departmentSearchInput.addEventListener('input', () => {
      clearTimeout(deptDebounce);
      deptDebounce = setTimeout(() => {
        Livewire.dispatch('searchDepartments', { search: departmentSearchInput.value });
      }, 300);
    });
  }

  if (tenureSearchInput) {
    let tenureDebounce;
    tenureSearchInput.addEventListener('input', () => {
      clearTimeout(tenureDebounce);
      tenureDebounce = setTimeout(() => {
        Livewire.dispatch('searchTenures', { search: tenureSearchInput.value });
      }, 300);
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