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
      <form method="POST" >
          @csrf
  
          <div>
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" required>
          </div>
  
          <div>
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" required>
          </div>
  
          <table>
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
                            <select :name="'products[' + index + '][id]'" x-model="product.id" required>
                              <option value="" disabled>Select a product</option>
                              <template x-for="availableProduct in availableProducts" :key="availableProduct.id">
                                  <option :value="availableProduct.id" x-show="!products.filter(p => p.id == availableProduct.id).length > 0" x-text="availableProduct.name">
                                  </option>
                              </template>
                          </select>
                          </td>
                          <td>
                              <input type="number" :name="'products[' + index + '][quantity]'" :min="1" x-model.number="product.quantity" required>
                          </td>
                          <td>
                              <button type="button" x-on:click="products.splice(index, 1)">Remove</button>
                          </td>
                      </tr>
                  </template>
              </tbody>
          </table>
  
          <div>
              <button type="button" x-on:click="products.push({ id: '', quantity: 1 })">Add Product</button>
          </div>
  
          <div>
              <button type="submit">Submit Request Order</button>
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