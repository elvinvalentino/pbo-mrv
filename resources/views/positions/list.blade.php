@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Positions</h1>
@stop

@php
$heads = [
    'Level', ['label' => 'Actions', 'no-export' => true, 'width' => 5]
];

function getBtn($data) {
  $btnEdit = '<a href="' . route('positions.edit', ['position' => $data]) . '" class="btn btn-xs btn-default text-primary mx-1" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
$btnDelete = '<form onSubmit="return confirm(\'Apakah kamu yakin ingin menghapus data ini?\')" class="d-inline" method="POST" action= "' . route('positions.destroy', ['position' => $data]) . '">
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
foreach ($positions as $position) {
  array_push($data, [$position->level,  '<nobr>'.getBtn($position).'</nobr>']);
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
      <a href="{{ route('positions.create') }}" class="btn btn-primary mb-3">Create Position</a>
    </div>

    <x-adminlte-datatable id="table1" :heads="$heads">
      @foreach($config['data'] as $row)
          <tr>
              @foreach($row as $cell)
                  <td>{!! $cell !!}</td>
              @endforeach
          </tr>
      @endforeach
    </x-adminlte-datatable>
  </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop