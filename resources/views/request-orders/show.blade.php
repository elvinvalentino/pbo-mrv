@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Request Order Detail</h1>
@stop

@section('content')

<div class="card">
  <div class="card-header">Details</div>
  <div class="card-body">
    <div class="d-flex">
      <div style="margin-right: 5em">
        <h6>Requester</h6>
        <h5>{{$requestOrder->user->name}}</h5>
      </div>
      <div style="margin-right: 5em">
        <h6>Requested At</h6>
        <h5>{{$requestOrder->requested_at}}</h5>
      </div>
      <div style="margin-right: 5em">
        <h6>Total Expected Price</h6>
        <h5>{{$requestOrder->total}}</h5>
      </div>
      <div>
        <h6>Status</h6>
        <x-request-order.status-badge :status='$requestOrder->status' />
      </div>
    </div>
  </div>
</div>

<div x-data='{activeIndex: 0}'  class="card">
  <div class="card-body">
    <ul class="nav nav-tabs mb-3">
      <li @click="activeIndex = 0" class="nav-item">
        <a x-bind:class="activeIndex == 0 ? 'nav-link active' : 'nav-link'">Products</a>
      </li>
      <li @click="activeIndex = 1" class="nav-item">
        <a x-bind:class="activeIndex == 1 ? 'nav-link active' : 'nav-link'">Approval</a>
      </li>
    </ul>

    <div x-show='activeIndex == 0'>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Product</th>
            <th scope="col">Quantity</th>
            <th scope="col">Unit</th>
            <th scope="col">Rate</th>
            <th scope="col">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requestOrder->requestOrderDetails as $requestOrderDetail)
              <tr>
                <td scope="col">{{ $requestOrderDetail->product->name }}</td>
                <td scope="col">{{ $requestOrderDetail->quantity }}</td>
                <td scope="col">{{ $requestOrderDetail->uom }}</td>
                <td scope="col">{{ $requestOrderDetail->rate }}</td>
                <td scope="col">{{ $requestOrderDetail->sub_total }}</td>
              </tr>
          @empty
              <tr>
                <td colspan="5" class="text-center">No Product</td>
              </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div x-show='activeIndex == 1'>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Reviewer</th>
            <th scope="col">Level</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requestOrder->requestOrderApprovals as $requestOrderApproval)
              <tr>
                <td scope="col">{{ $requestOrderApproval->user->name }}</td>
                <td scope="col">{{ $requestOrderApproval->level }}</td>
                <td scope="col"><x-approval.status-badge :status='$requestOrderApproval->status' /></td>
              </tr>
          @empty
              <tr>
                <td colspan="5" class="text-center">No Product</td>
              </tr>
          @endforelse
        </tbody>
      </table>
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