@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Approvals</h1>
@stop

@php
function getBtn($data) {
$btnShow = '<a href="' . route('approval.show', ['requestOrderApproval' => $data]) . '" class="btn btn-xs btn-default text-primary mx-1" title="Edit">
                <i class="fa fa-lg fa-fw fa-eye"></i>
            </a>
              ';
              
return $btnShow;
}

$heads = [
    'Status', 'Requested At', 'Requested By', 'Total Items', ['label' => 'Actions', 'no-export' => true, 'width' => 5]
];

$pendingData = array();
foreach ($pendingApprovals as $pendingApproval) {
  array_push($pendingData, [view('components.approval.status-badge', ['status' => $pendingApproval->status]), $pendingApproval->requestOrder->requested_at, $pendingApproval->requestOrder->user->name, $pendingApproval->requestOrder->requestOrderDetails->count(),  '<nobr>'.getBtn($pendingApproval).'</nobr>']);
}

$pendingConfig = [
    'data' => $pendingData,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];

$completedData = array();
foreach ($completedApprovals as $completedApproval) {
  array_push($completedData, [ view('components.approval.status-badge', ['status' => $completedApproval->status]), $completedApproval->requestOrder->requested_at, $completedApproval->requestOrder->user->name, $completedApproval->requestOrder->requestOrderDetails->count(),  '<nobr>'.getBtn($completedApproval).'</nobr>']);
}

$completedConfig = [
    'data' => $completedData,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];
@endphp

@section('content')
<div x-data='{activeIndex: 0}' class="card">
  <div class="card-body"> 
    <ul class="nav nav-tabs mb-3">
      <li @click="activeIndex = 0" class="nav-item">
        <a x-bind:class="activeIndex == 0 ? 'nav-link active' : 'nav-link'">Pending</a>
      </li>
      <li @click="activeIndex = 1" class="nav-item">
        <a x-bind:class="activeIndex == 1 ? 'nav-link active' : 'nav-link'">Completed</a>
      </li>
    </ul>

    <div x-show='activeIndex == 0'>
      <x-adminlte-datatable id="table1" :heads="$heads">
        @forelse($pendingConfig['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @empty
            <tr>
              <td colspan="5" class="text-center">No pending approval</td>
            </tr>
        @endforelse
      </x-adminlte-datatable>
    </div>

    <div x-show='activeIndex == 1'>
      <x-adminlte-datatable id="table2" :heads="$heads">
        @forelse($completedConfig['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @empty
            <tr>
              <td colspan="5" class="text-center">No completed approval</td>
            </tr>
        @endforelse
      </x-adminlte-datatable>
    </div>
  </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stop