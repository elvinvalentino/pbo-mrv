@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Request Order</h1>
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

    <div x-data="{ products: [{id: '', quantity: 1}], availableProducts: [] }" x-init="availableProducts = JSON.parse('{{ json_encode($products) }}')">
      <form method="POST" action="{{ route('request-order.store') }}" >
          @csrf
  
          <div class="mb-4">
            <label for="user_id" class="form-label">Select User to Review</label>
            <select name="user_id" id="user_id" class="form-control select">
              <option selected disabled>Select User</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div> 

          <div class="d-flex justify-content-end">
            <button class="btn btn-primary mb-3" type="button" x-on:click="products.push({ id: '', quantity: 1 })">Add Product</button>
        </div>
  
          <table class="table mb-4">
              <thead>
                  <tr>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Remove</th>
                  </tr>
              </thead>
              <tbody>
                  <template x-for="(product, index) in products" :key="index">
                      <tr>
                          <td>
                            <select class="select form-control" :name="'products[' + index + '][id]'" x-model="product.id" required>
                              <option value="" disabled>Select a product</option>
                              <template x-for="availableProduct in availableProducts" :key="availableProduct.id">
                                  <option :value="availableProduct.id" x-show="!products.filter(p => p.id == availableProduct.id).length > 0" x-text="availableProduct.name">
                                  </option>
                              </template>
                          </select>
                          </td>
                          <td>
                              <input class="form-control" type="number" :name="'products[' + index + '][quantity]'" :min="1" x-model.number="product.quantity" required>
                          </td>
                          <td style="width: 5%">
                              <button class="btn btn-danger" type="button" x-on:click="products.splice(index, 1)">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                              </button>
                          </td>
                      </tr>
                  </template>
              </tbody>
          </table>
  
          <div class="d-flex justify-content-end">
              <button class="btn btn-primary" type="submit">Submit Request Order</button>
          </div>
      </form>
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