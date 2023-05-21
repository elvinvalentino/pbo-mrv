@switch($status)
    @case('pending_approval')
        <div class="badge badge-pill badge-warning text-white">
            Pending Approval
        </div>
        @break
    @case('open')
        <div class="badge badge-pill badge-primary">
            Open
        </div>
        @break
    @case('rejected')
        <div class="badge badge-pill badge-danger">
            Rejected
        </div>
        @break
    @default
        <div class="badge badge-pill badge-primary">
            {{$status}}
        </div>
@endswitch

