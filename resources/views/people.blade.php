@extends('layouts.app')

@section('title', 'Our People')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/our_people.css') }}">
@endpush

@section('content')
<section class="content">
  <div class="people-header">
    <h2 class="people_heading">Our People</h2>

    <div class="people-controls">
      <div class="views-selector">
        <button class="view-tab" data-view="client">Partners</button>
        <button class="view-tab" data-view="site">Locations</button>
        <button class="view-tab" data-view="department">Departments</button>
        <button class="view-tab" data-view="employee-type">Tenures</button>
        <button class="view-tab active" data-view="employee">Employees</button>
        <button class="view-tab" data-view="team">Teams</button>
      </div>

      <form action="#" method="get" class="search-form">
        <div class="search-container">
          <input type="search" name="p" placeholder="Search" class="search-input" id="live-search-input">
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
                <p style="font-size: 0.87rem; font-weight: 600;">Location</p>
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

  <div class="people-table-wrapper" style="position: relative; min-height: 300px; overflow: visible;">
    @if(isset($people) && count($people))
    <table class="people-table" style="position: relative;">
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
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/our_people.js') }}"></script>
@endpush
