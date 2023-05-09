@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Request Order Detail</h1>
@stop

@section('content')
@if (count($errors) > 0)
<x-adminlte-alert theme='danger' title="Validation errors">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</x-adminlte-alert>
@endif

<div class="card">
  <div class="card-header">Details</div>
  <div class="card-body">
    <div class="d-flex">
      <div style="margin-right: 5em">
        <h6>Requester</h6>
        <h5>{{$requestOrderApproval->requestOrder->user->name}}</h5>
      </div>
      <div style="margin-right: 5em">
        <h6>Requested At</h6>
        <h5>{{$requestOrderApproval->requestOrder->requested_at}}</h5>
      </div>
      <div style="margin-right: 5em">
        <h6>Total Expected Price</h6>
        <h5>{{$requestOrderApproval->requestOrder->total}}</h5>
      </div>
      <div>
        <h6>Status</h6>
        <x-request-order.status-badge :status='$requestOrderApproval->requestOrder->status' />
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
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
        @forelse($requestOrderApproval->requestOrder->requestOrderDetails as $requestOrderDetail)
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
</div>

@if($requestOrderApproval == 'pending')
  <div class="d-flex justify-content-end">
    <button class="btn btn-danger mr-2" data-toggle="modal" data-target="#rejectModal">Reject</button>
    <button class="btn btn-success"  data-toggle="modal" data-target="{{$isMaxLevel == 1 ? '#approveModal' : '#approveModalUser'}}">Approve</button>
  </div>
@endif

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Reject Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure want to reject this request order?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <form action="{{ route('approval.reject', ['requestOrderApproval' => $requestOrderApproval]) }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger">Reject</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Approve Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure want to Approve this request order?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <form action="{{ route('approval.approve', ['requestOrderApproval' => $requestOrderApproval]) }}" method="POST">
          @csrf
          <input type="hidden" name="is_max_level" value="{{ $isMaxLevel }}">
          <button type="submit" class="btn btn-success">Approve</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Approve Modal User -->
<div class="modal fade" id="approveModalUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('approval.approve', ['requestOrderApproval' => $requestOrderApproval]) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Approve Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="user_id" class="form-label">Select User to Review</label>
          <select name="user_id" id="user_id" class="form-control select">
            <option selected disabled>Select User</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <input type="hidden" name="is_max_level" value="{{ $isMaxLevel }}">
          <button type="submit" class="btn btn-success">Approve</button>
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
  @stop