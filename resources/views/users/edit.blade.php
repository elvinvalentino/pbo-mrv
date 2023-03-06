@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit User</h1>
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

    <form class="needs-validation" action="{{ route('users.update', ['user' => $user]) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ $user->username ?? old('username') }}">
      </div>  
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $user->name ?? old('name') }}">
      </div> 
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" id="role" class="form-control select">
          <option disabled>Select Role</option>
          <option {{ $user->role == 'root' ? 'selected' : '' }} value="root">Root</option>
          <option {{ $user->role == 'admin_po' ? 'selected' : '' }} value="admin_po">Admin PO</option>
          <option {{ $user->role == 'admin_approval' ? 'selected' : '' }} value="admin_approval">Admin Approval</option>
          <option {{ $user->role == 'admin_mrv' ? 'selected' : '' }} value="admin_mrv">Admin MRV</option>
        </select>
      </div> 
      <div class="mb-3">
        <label for="department_id" class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-control select">
          <option disabled>Select Department</option>
          @foreach($departments as $department)
            <option {{ $department->id == $user->department_id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
          @endforeach
        </select>
      </div> 
      <div class="mb-3">
        <label class="form-label">Position</label>
        @foreach($positions as $position)
          <div class="form-check">
            <input {{ in_array($position->id, $selectedPositionIds) ? 'checked' : '' }} class="form-check-input" type="checkbox" name="position_ids[]" value="{{$position->id}}" id="defaultCheck{{$position->id}}">
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
          <option {{$user->is_active == '1' ? 'selected' : ''}}  value="1">Active</option>
          <option {{$user->is_active == '0' ? 'selected' : ''}}  value="0">Inactive</option>
        </select>
      </div> 
      <div class="d-flex justify-content-end">
        <x-adminlte-button type='submit' label="Update" theme="primary"/>
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