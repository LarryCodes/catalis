@extends('layouts.app')

@section('title', 'Our People')

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

    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        overflow: visible;
    }

    .search-container {
        flex: 1;
        max-width: 400px;
    }

    .search-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 0.875rem;
        font-family: 'Segoe UI', Helvetica;
    }

    .search-input:focus {
        outline: none;
        border-color: #a3a2a3;
    }

    select.search-input {
        height: 40px;
        line-height: 1.5;
        appearance: auto;
    }

    .button-group {
        margin-left: 20px;
    }

    .add-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: radial-gradient(circle at top left, #e6e3e5, #a3a2a3);
        color: #000;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Segoe UI', Helvetica;
        font-size: 0.875rem;
    }

    .add-btn:hover {
        background: #d1d1d1;
    }

    .add-btn img {
        width: 16px;
        height: 16px;
    }

    .table-container {
        background: white;
        border-radius: 4px;
        overflow: visible;
        min-height: 400px;
    }

    .quotation-table {
        width: 100%;
        border-collapse: collapse;
        overflow: visible;
    }

    .quotation-table th,
    .quotation-table td {
        padding: 12px 16px;
        text-align: left;
        border: none;
    }

    .quotation-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #000;
    }

    .quotation-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .quotation-table tbody tr:last-child {
        border-bottom: none;
    }

    .people-table tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Segoe UI', Helvetica;
    }

    .edit-btn {
        background: #e3f2fd;
        color: #1976d2;
    }

    .edit-btn:hover {
        background: #bbdefb;
    }

    .deactivate-btn {
        background: #ffebee;
        color: #d32f2f;
    }

    .deactivate-btn:hover {
        background: #ffcdd2;
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

    .quotation-table tbody {
        overflow: visible;
    }

    .quotation-table td {
        overflow: visible;
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

    [x-cloak] {
        display: none !important;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state img {
        width: 80px;
        height: 80px;
        margin-bottom: 16px;
        opacity: 0.6;
    }

    .empty-state h3 {
        color: #666;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #888;
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
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        max-height: 80vh;
        overflow-y: auto;
        margin: auto;
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e0e0e0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 800;
        color: #000;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }

    .modal-body {
        padding: 24px;
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

    .btn {
        padding: 10px 16px;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Segoe UI', Helvetica;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: #000;
        color: #fff;
    }

    .btn-primary:hover {
        background: #333;
    }

    .btn-secondary {
        background: #f4f3f3;
        color: #000;
        border: 1px solid #e0e0e0;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }
</style>
@endpush

@section('content')
<section class="content">
  <div class="people-header">
    <h2 class="people_heading">Our People</h2>

    <div class="people-controls">
      <div class="views-selector">
        <button class="view-tab" data-view="client">Partners</button>
        <button class="view-tab" data-view="site">Sites</button>
        <button class="view-tab" data-view="department">Departments</button>
        <button class="view-tab" data-view="employee-type">Tenures</button>
        <button class="view-tab active" data-view="employee">Employees</button>
        <button class="view-tab" data-view="team">Teams</button>
      </div>

      <form action="#" method="get" class="search-form" data-search-form="employee">
        <div class="search-container">
          <input 
            type="search" 
            name="p" 
            placeholder="Search" 
            class="search-input" 
            id="live-search-input"
            data-search-view="employee"
          >
          <img src="{{ asset('images/filter.svg') }}" alt="Filter Icon" class="search-filter-icon" />
        </div>
      </form>
      <form action="#" method="get" class="search-form" data-search-form="client" style="display: none;">
        <div class="search-container">
          <input 
            type="search" 
            name="partner_search" 
            placeholder="Search partners" 
            class="search-input" 
            data-search-view="client"
          >
          <img src="{{ asset('images/filter.svg') }}" alt="Filter Icon" class="search-filter-icon" />
        </div>
      </form>

      <button class="filters-button" id="filters-button">
        <img src="{{ asset('images/funnel.svg') }}" alt="Filters" class="filters-icon" />
        <span class="filters-text">Filters</span>
      </button>

      <div class="people-actions-group">
        <div class="create-new-wrapper" id="create-new-wrapper">
          <button class="create-new-button" id="create-new-button">
            <img src="{{ asset('images/plus.svg') }}" alt="Plus" class="plus-icon" />
            <span class="create-new-text">Add New</span>
          </button>
          <div class="create-new-panel" id="create-new-panel">
            <div class="options-grid">
              <button class="option-item" data-action="client">
                <img src="{{ asset('images/handshake.svg') }}" alt="Client" />
                <p style="font-size: 0.87rem; font-weight: 600;">Partner</p>
              </button>
              <button class="option-item" data-action="site">
                <img src="{{ asset('images/site.svg') }}" alt="Site" />
                <p style="font-size: 0.87rem; font-weight: 600;">Site</p>
              </button>
              <button class="option-item" data-action="department">
                <img src="{{ asset('images/department.svg') }}" alt="Department" />
                <p style="font-size: 0.87rem; font-weight: 600;">Department</p>
              </button>
              <button class="option-item" data-action="employee-type">
                <img src="{{ asset('images/employee_type.svg') }}" alt="Employee Type" />
                <p style="font-size: 0.87rem; font-weight: 600;">Tenure</p>
              </button>
              <button class="option-item" data-action="employee">
                <img src="{{ asset('images/employee_add.svg') }}" alt="Employee" />
                <p style="font-size: 0.87rem; font-weight: 600;">Employee</p>
              </button>
              <button class="option-item" data-action="team">
                <img src="{{ asset('images/team.svg') }}" alt="Team" />
                <p style="font-size: 0.87rem; font-weight: 600;">Team</p>
              </button>
            </div>
          </div>
        </div>
        <div class="people-actions" id="people-actions" style="display: none;">
          <button id="deactivate-selected" title="Deactivate">
            <img src="{{ asset('images/deactivate.svg') }}" alt="Deactivate" />
          </button>
          <button id="delete-selected" title="Delete">
            <img src="{{ asset('images/trash.svg') }}" alt="Delete" />
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="people-table-wrapper" data-view-section="employee" style="position: relative; min-height: 300px; overflow: visible;">
    @if(isset($people) && count($people))
    <table class="people-table" data-table="employee" style="position: relative;">
      <thead>
        <tr>
          <th class="checkbox-cell" style="width: 20px;">
            <input type="checkbox" id="select-all" title="Select All" />
          </th>
          <th style="padding-right: 25px; width: 120px;">Employee #</th>
          <th style="padding-right: 25px; width: 180px;">Full Name</th>
          <th style="padding-right: 25px; width: 70px;">Gender</th>
          <th style="padding-right: 25px; width: 120px;">DOB</th>
          <th style="padding-right: 25px; width: 140px;">Department</th>
          <th style="padding-right: 25px; width: 140px;">Site</th>
          <th style="padding-right: 25px; width: 120px;">Employee Type</th>
          <th style="padding-right: 25px; width: 140px;">Contact</th>
          <th style="padding-right: 25px; width: 160px;">Address</th>
          <th style="padding-right: 25px; width: 110px;">Daily Wage</th>
          <th style="padding-right: 25px; width: 90px;">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($people as $person)
        <tr>
          <td class="checkbox-cell">
            <input type="checkbox" class="quote-checkbox" name="select_person" value="{{ $person->id }}">
          </td>
          <td>{{ $person->employee_number }}</td>
          <td>
            <div class="person-name">{{ $person->full_name }}</div>
            <div class="person-meta">{{ $person->nationality }}</div>
          </td>
          <td>{{ $person->gender }}</td>
          <td>{{ optional($person->date_of_birth)->format('d M Y') ?? '—' }}</td>
          <td>{{ $person->department->name ?? '—' }}</td>
          <td>{{ $person->site->site_name ?? '—' }}</td>
          <td>{{ $person->employeeType->name ?? '—' }}</td>
          <td>
            <div>{{ $person->phone }}</div>
            @if($person->email)
            <div class="person-meta">{{ $person->email }}</div>
            @endif
          </td>
          <td>{{ $person->address }}</td>
          <td>UGX {{ number_format($person->daily_wage, 2) }}</td>
          <td>
            <span class="status-pill {{ $person->is_active ? 'active' : 'inactive' }}">
              {{ $person->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="empty-state">
      <img src="{{ asset('images/empty_state.svg') }}" alt="No employees" />
      <h3>No employees yet</h3>
      <p>Use the "Add New" button to create your first employee record.</p>
    </div>
    @endif
  </div>

  <div class="people-table-wrapper" data-view-section="client" style="position: relative; min-height: 300px; overflow: visible; display:none;">
    <livewire:partners-component />
  </div>

  <div class="people-table-wrapper" data-view-section="site" style="position: relative; min-height: 300px; overflow: visible; display:none;">
    <livewire:sites-component />
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/our_people.js') }}"></script>
<script>
    document.addEventListener('livewire:loaded', () => {
        Livewire.on('closeModal', () => {
            // This is handled by the component itself
        });
    });
</script>
@endpush
