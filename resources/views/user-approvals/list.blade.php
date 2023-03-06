@extends('adminlte::page')
{{-- @section('plugins.Datatables', true) --}}
@section('title', 'Dashboard')

@section('content_header')
    <h1>User Approval List</h1>
@stop

@section('content')

<div class="card">
    <x-adminlte-datatable id="table1" :heads="$heads">
      @for($row = 0; $row < $rowLength; $row++)
        <tr>
          @for($col = 0; $col < count($heads); $col++)
            <td> {{$datas[$col][$row]['name'] ?? '-'}} </td>
          @endfor
        </tr>
      @endfor
    </x-adminlte-datatable>
  </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop