@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Users</h1>
@stop

@php
$heads = [
    'ID', 'Name', 'Email', ['label' => 'Actions', 'no-export' => true, 'width' => 5]
];

function getBtn($user) {
  $btnEdit = '<a href="' . route('users.edit', ['user' => $user]) . '" class="btn btn-xs btn-default text-primary mx-1" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
$btnDelete = '<form action= "' . route('users.destroy', ['user' => $user]) . '">
              '. @csrf .'
              '. @method('DELETE') .'
                <a class="btn btn-xs btn-default text-danger mx-1" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </a>
              </form>
              ';
              
return $btnEdit . $btnDelete;
}


$data = array();
foreach ($users as $user) {
  array_push($data, [$user->id, $user->name, $user->email,  '<nobr>'.getBtn($user).'</nobr>']);
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
      <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create User</a>
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
    <script> console.log('Hi!'); </script>
@stop