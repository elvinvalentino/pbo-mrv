@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit Product</h1>
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

    <form class="needs-validation" action="{{ route('products.update', ['product' => $product]) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') ?? $product->name }}">
      </div> 
      <div class="mb-3">
        <label for="uom" class="form-label">Unit of Measurement</label>
        <input type="text" class="form-control" name="uom" id="uom" placeholder="Unit of Measurement" value="{{ old('uom') ?? $product->uom  }}">
      </div> 
      <div class="mb-3">
        <label for="unit_price" class="form-label">Unit Price</label>
        <input type="number" class="form-control" name="unit_price" id="unit_price" placeholder="Unit Price" value="{{ old('unit_price') ?? $product->unit_price  }}">
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