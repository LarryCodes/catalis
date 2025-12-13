@extends('layouts.app')

@section('title', 'Payroll Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payroll.css') }}">
@endpush

@section('content')
<section class="content">
  <div class="payroll-header">
    <h2 class="payroll-heading">Payroll Management</h2>

    <div class="payroll-controls">
      <div class="views-selector">
        <button class="view-tab active" data-view="all">All</button>
        <button class="view-tab" data-view="client">Partners</button>
        <button class="view-tab" data-view="site">Locations</button>
        <button class="view-tab" data-view="department">Departments</button>
      </div>

      <form action="#" method="get" class="search-form">
        <div class="search-container">
          <input type="search" name="p" placeholder="Search" class="search-input" id="live-search-input">
          <img src="{{ asset('images/filter.svg') }}" alt="Filter Icon" class="search-filter-icon" />
        </div>
      </form>

      <div class="payroll-actions-group">
        <div class="create-new-wrapper" id="create-new-wrapper">
          <button class="create-new-button" id="create-new-button">
            <img src="{{ asset('images/plus.svg') }}" alt="Plus" class="plus-icon" />
            <span class="create-new-text">Run Payroll</span>
          </button>
        </div>
        <div class="payroll-actions" id="payroll-actions" style="display: none;">
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

  <div class="payroll-table-wrapper" style="position: relative; min-height: 300px; overflow: visible;">
    @if(isset($payrolls) && count($payrolls))
    <table class="payroll-table" style="position: relative;">
      <thead>
        <tr>
          <th class="checkbox-cell" style="width: 20px;">
            <input type="checkbox" id="select-all" title="Select All" />
          </th>
          <th style="padding-right: 25px; width: 110px;">Employee ID</th>
          <th style="padding-right: 25px; width: 150px;">Full Name</th>
          <th style="padding-right: 25px; width: 60px;">Gender</th>
          <th style="padding-right: 25px; width: 87px;">DOB</th>
          <th style="padding-right: 25px; width: 110px;">Nationality</th>
          <th style="padding-right: 25px; width: 100px;">Contact</th>
          <th style="padding-right: 25px; width: 160px;">Address</th>
          <th style="padding-right: 25px; width: 100px;">Site</th>
          <th style="padding-right: 25px; width: 120px;">Tenure</th>
          <th style="padding-right: 25px; width: 120px;">Department</th>
          <th style="padding-right: 25px; width: 150px;">Position</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payrolls as $row)
        <tr>
          <td class="checkbox-cell">
            <input type="checkbox" class="quote-checkbox" name="select_person" value="{{ $row->employee_id }}">
          </td>
          <td>{{ $row->employee_id }}</td>
          <td>{{ $row->full_name }}</td>
          <td>{{ $row->gender }}</td>
          <td>{{ optional($row->date_of_birth)->format('d M Y') ?? '—' }}</td>
          <td>{{ $row->nationality ?? '—' }}</td>
          <td>
            <div>{{ $row->phone }}</div>
            @if($row->email)
            <div class="person-meta">{{ $row->email }}</div>
            @endif
          </td>
          <td>{{ $row->address ?? '—' }}</td>
          <td>{{ $row->site->site_name ?? '—' }}</td>
          <td>{{ $row->tenure ?? '—' }}</td>
          <td>{{ $row->department->name ?? '—' }}</td>
          <td>{{ $row->position ?? '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="empty-state">
      <img src="{{ asset('images/empty_state.svg') }}" alt="No payroll runs" />
      <h3>No payroll runs yet</h3>
      <p>Use "Run Payroll" to create the first payroll cycle.</p>
    </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/payroll.js') }}"></script>
@endpush
