@extends('adminlte::page')
{{-- @section('plugins.Datatables', true) --}}
@section('title', 'Dashboard')

@section('content_header')
    <h1>My Request Order</h1>
@stop

@php
$heads = [
    'ID', 'Total Items', 'Total Price', 'Requested At', 'Status', ['label' => 'Actions', 'no-export' => true, 'width' => 5]
];

function getBtn($data) {
  $btnEdit = '<a href="' . route('products.edit', ['product' => $data]) . '" class="btn btn-xs btn-default text-primary mx-1" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
$btnDelete = '<form onSubmit="return confirm(\'Apakah kamu yakin ingin menghapus data ini?\')" class="d-inline" method="POST" action= "' . route('products.destroy', ['product' => $data]) . '">
              '. csrf_field() .'
              '. method_field("DELETE") .'
                <button type="submit" class="btn btn-xs btn-default text-danger mx-1" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
              </form>
              ';
              
return $btnEdit . $btnDelete;
}


$data = array();
foreach ($requestOrders as $requestOrder) {
  array_push($data, [$requestOrder->id, $requstOrder->requestOrderDetails->count(), $requestOrder->total, $requestOrder->status]);
}

$config = [
    'data' => $data,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];
@endphp

@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-end">
      <a href="{{ route('request-order.create') }}" class="btn btn-primary mb-3">Create Request Order</a>
    </div>

    <x-adminlte-datatable id="table1" :heads="$heads">
      @forelse($config['data'] as $row)
          <tr>
              @foreach($row as $cell)
                  <td>{!! $cell !!}</td>
              @endforeach
          </tr>
      @empty
          <tr>
            <td colspan="6" class="text-center">No request order</td>
          </tr>
      @endforelse
    </x-adminlte-datatable>
  </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop