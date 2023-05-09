@switch($status)
    @case('pending')
        <div class="badge badge-pill badge-warning text-white">
            Pending
        </div>
        @break
    @case('rejected')
        <div class="badge badge-pill badge-danger">
            Rejected
        </div>
        @break
    @case('approved')
        <div class="badge badge-pill badge-success">
            Approved
        </div>
        @break
    @default
        <div class="badge badge-pill badge-primary">
            {{$status}}
        </div>
@endswitch

