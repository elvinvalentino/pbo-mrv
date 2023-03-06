@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Position</h1>
@stop

@section('content')

<div class="card">
  <div class="card-body">
    @if (count($errors) > 0)
      <x-adminlte-alert theme='danger' title="Validation errors">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </x-adminlte-alert>
    @endif

    <form class="needs-validation" action="{{ route('positions.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="level" class="form-label">Level</label>
        <input type="number" class="form-control" name="level" id="level" placeholder="Level" value="{{ old('level') }}">
      </div> 
      <div class="d-flex justify-content-end">
        <x-adminlte-button type='submit' label="Create" theme="primary"/>
      </div>
    </div>
    </form>
  </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop