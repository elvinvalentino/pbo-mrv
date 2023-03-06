@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Create User</h1>
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

    <form class="needs-validation" action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ old('username') }}">
      </div>  
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}">
      </div> 
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" id="role" class="form-control select">
          <option selected disabled>Select Role</option>
          <option value="root">Root</option>
          <option value="admin_po">Admin PO</option>
          <option value="admin_approval">Admin Approval</option>
          <option value="admin_mrv">Admin MRV</option>
        </select>
      </div> 
      <div class="mb-3">
        <label for="department_id" class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-control select">
          <option selected disabled>Select Department</option>
          @foreach($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
          @endforeach
        </select>
      </div> 
      <div class="mb-3">
        <label class="form-label">Position</label>
        @foreach($positions as $position)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="position_ids[]" value="{{$position->id}}" id="defaultCheck{{$position->id}}">
            <label class="form-check-label" for="defaultCheck{{$position->id}}">
              Level {{ $position->level }}
            </label>
          </div>
        @endforeach
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="password">
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
      </div> 
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control select">
          <option selected value="1">Active</option>
          <option value="0">Inctive</option>
        </select>
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