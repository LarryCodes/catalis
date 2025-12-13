@extends('layouts.app')

@section('title', 'Time & Attendance')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/time_attendance.css') }}">
@endpush

@section('content')
<section class="content">
  <div class="ta-header">
    <h2 class="ta-heading">Time & Attendance</h2>

    <div class="ta-controls">
      <div class="views-selector">
        <button class="view-tab" data-view="client">Partners</button>
        <button class="view-tab" data-view="site">Locations</button>
        <button class="view-tab" data-view="department">Departments</button>
        <button class="view-tab active" data-view="shifts">Shifts</button>
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

      <div class="ta-actions-group">
        <div class="create-new-wrapper" id="create-new-wrapper">
          <button class="create-new-button" id="create-new-button">
            <img src="{{ asset('images/plus.svg') }}" alt="Plus" class="plus-icon" />
            <span class="create-new-text">Add New</span>
          </button>
          <div class="create-new-panel" id="create-new-panel">
            <div class="options-grid">
              <button class="option-item" data-action="client">
                <img src="{{ asset('images/file_upload.svg') }}" alt="TA Bulk Upload" />
                <p style="font-size: 0.87rem; font-weight: 600;">TA Bulk Upload</p>
              </button>
              <button class="option-item" data-action="site">
                <img src="{{ asset('images/clock.svg') }}" alt="Shift" />
                <p style="font-size: 0.87rem; font-weight: 600;">Shift</p>
              </button>
            </div>
          </div>
        </div>
        <div class="ta-actions" id="ta-actions" style="display: none;">
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

  <div class="ta-table-wrapper" style="position: relative; min-height: 300px; overflow: visible;">
    @if(isset($shifts) && count($shifts))
    <table class="ta-table" style="position: relative;">
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
        @foreach($shifts as $row)
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
      <img src="{{ asset('images/empty_state.svg') }}" alt="No shifts" />
      <h3>No shifts recorded</h3>
      <p>Use "Add New" to schedule a shift or upload time & attendance logs.</p>
    </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/time_attendance.js') }}"></script>
@endpush
