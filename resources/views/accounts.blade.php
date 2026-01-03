@extends('layouts.app')

@section('title', 'Accounts & Access')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/our_people.css') }}">
<style>
    .alert {
        padding: 12px 16px;
        margin-bottom: 16px;
        border-radius: 4px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        overflow: auto;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 680px;
        max-height: 85vh;
        overflow-y: auto;
        margin: auto;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 28px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 12px 12px 0 0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #1f2937;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.2s;
    }

    .modal-close:hover {
        color: #374151;
    }

    .modal-body {
        padding: 24px;
    }

    /* Accordion Styles */
    .accordion-section {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .accordion-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 14px 16px;
        background: #f8f9fa;
        border: none;
        cursor: pointer;
        font-family: 'Segoe UI', Helvetica;
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        text-align: left;
    }

    .accordion-header:hover {
        background: #f0f0f0;
    }

    .accordion-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .accordion-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0e0e0;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
    }

    .accordion-status {
        display: flex;
        align-items: center;
    }

    .accordion-status .status-complete {
        color: #059669;
        font-weight: bold;
    }

    .accordion-status .status-incomplete {
        color: #dc2626;
        font-size: 0.75rem;
    }

    .accordion-status .status-optional {
        color: #6b7280;
        font-size: 0.75rem;
    }

    .accordion-content {
        padding: 16px;
        border-top: 1px solid #e0e0e0;
        background: white;
    }

    .btn-cancel {
        padding: 10px 20px;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-cancel:hover {
        background: #e8e8e8;
    }

    .btn-save {
        padding: 10px 20px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-save:hover {
        background: #0056b3;
    }

    /* Form styles */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #000;
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 0.875rem;
        font-family: 'Segoe UI', Helvetica;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #a3a2a3;
    }

    .error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    /* Actions Dropdown */
    .actions-dropdown-wrapper {
        position: relative;
        display: inline-block;
        overflow: visible;
    }

    .actions-dropdown-btn {
        background: radial-gradient(circle at top left, #e6e3e5, #a3a2a3);
        border: none;
        border-radius: 4px;
        padding: 6px 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .actions-dropdown-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .actions-dropdown-btn img {
        width: 16px;
        height: 16px;
    }

    .actions-dropdown-panel {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 4px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 140px;
        z-index: 1000;
        padding: 8px 0;
    }

    .action-item {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px 16px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 0.875rem;
        font-family: 'Segoe UI', Helvetica;
        color: #333;
        text-align: left;
    }

    .action-item:hover {
        background: #f5f5f5;
    }

    .action-item img {
        width: 16px;
        height: 16px;
    }

    .action-item.deactivate {
        color: #d32f2f;
    }

    .action-item.deactivate:hover {
        background: #ffebee;
    }

    .people-table tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<section class="content">
  <div class="people-header">
    <h2 class="people_heading">Accounts & Access</h2>

    <div class="people-controls">
      <div class="views-selector">
        @can('manage-users')
        <button class="view-tab active" data-view="users">Users</button>
        @endcan
        @can('manage-roles')
        <button class="view-tab" data-view="roles">Roles</button>
        @endcan
        <button class="view-tab" data-view="permissions">Permissions</button>
      </div>

      <form action="#" method="get" class="search-form" data-search-form="users">
        <div class="search-container">
          <input 
            type="search" 
            name="search" 
            placeholder="Search users..." 
            class="search-input" 
            id="users-search-input"
            data-search-view="users"
          >
          <img src="{{ asset('images/filter.svg') }}" alt="Filter Icon" class="search-filter-icon" />
        </div>
      </form>
      <form action="#" method="get" class="search-form" data-search-form="roles" style="display: none;">
        <div class="search-container">
          <input 
            type="search" 
            name="search" 
            placeholder="Search roles..." 
            class="search-input" 
            id="roles-search-input"
            data-search-view="roles"
          >
          <img src="{{ asset('images/filter.svg') }}" alt="Filter Icon" class="search-filter-icon" />
        </div>
      </form>

      <div class="people-actions-group">
        @can('manage-users')
        <button class="create-new-button" id="create-user-button" data-create-for="users">
          <img src="{{ asset('images/plus.svg') }}" alt="Plus" class="plus-icon" />
          <span class="create-new-text">Add New</span>
        </button>
        @endcan
        @can('manage-roles')
        <button class="create-new-button" id="create-role-button" data-create-for="roles" style="display: none;">
          <img src="{{ asset('images/plus.svg') }}" alt="Plus" class="plus-icon" />
          <span class="create-new-text">Add New</span>
        </button>
        @endcan
      </div>
    </div>
  </div>

  <div class="people-table-wrapper" data-view-section="users" style="position: relative; min-height: 300px; overflow: visible;">
    <livewire:users-component />
  </div>

  <div class="people-table-wrapper" data-view-section="roles" style="position: relative; min-height: 300px; overflow: visible; display: none;">
    <livewire:roles-component />
  </div>

  <div class="people-table-wrapper" data-view-section="permissions" style="position: relative; min-height: 300px; overflow: visible; display: none;">
    <livewire:permissions-component />
  </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewTabs = document.querySelectorAll('.view-tab');
    const viewSections = document.querySelectorAll('[data-view-section]');
    const createButtons = document.querySelectorAll('.create-new-button[data-create-for]');
    const searchForms = document.querySelectorAll('[data-search-form]');

    function toggleViewSections(viewKey) {
        viewSections.forEach(section => {
            section.style.display = section.dataset.viewSection === viewKey ? '' : 'none';
        });
        createButtons.forEach(btn => {
            btn.style.display = btn.dataset.createFor === viewKey ? '' : 'none';
        });
        searchForms.forEach(form => {
            form.style.display = form.dataset.searchForm === viewKey ? '' : 'none';
        });
    }

    viewTabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            viewTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            toggleViewSections(tab.dataset.view);
        });
    });

    // Create button handlers
    const createUserBtn = document.getElementById('create-user-button');
    const createRoleBtn = document.getElementById('create-role-button');

    if (createUserBtn) {
        createUserBtn.addEventListener('click', () => {
            Livewire.dispatch('openCreateUser');
        });
    }

    if (createRoleBtn) {
        createRoleBtn.addEventListener('click', () => {
            Livewire.dispatch('openCreateRole');
        });
    }

    // Search handlers with debounce
    const usersSearchInput = document.getElementById('users-search-input');
    const rolesSearchInput = document.getElementById('roles-search-input');

    if (usersSearchInput) {
        let debounce;
        usersSearchInput.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                Livewire.dispatch('searchUsers', { search: usersSearchInput.value });
            }, 300);
        });
    }

    if (rolesSearchInput) {
        let debounce;
        rolesSearchInput.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                Livewire.dispatch('searchRoles', { search: rolesSearchInput.value });
            }, 300);
        });
    }
});
</script>
@endpush
