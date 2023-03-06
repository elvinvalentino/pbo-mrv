@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Departments</h1>
@stop

@php
$heads = [
    'ID', 'Name', ['label' => 'Actions', 'no-export' => true, 'width' => 5]
];

function getBtn($data) {
  $btnEdit = '<a href="' . route('departments.edit', ['department' => $data]) . '" class="btn btn-xs btn-default text-primary mx-1" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
$btnDelete = '<form onSubmit="return confirm(\'Apakah kamu yakin ingin menghapus data ini?\')" class="d-inline" method="POST" action= "' . route('departments.destroy', ['department' => $data]) . '">
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
foreach ($departments as $department) {
  array_push($data, [$department->id, $department->name,  '<nobr>'.getBtn($department).'</nobr>']);
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
      <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Create Department</a>
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