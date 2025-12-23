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
