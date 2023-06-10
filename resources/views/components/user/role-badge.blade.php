@switch($role)
    @case('admin_mrv')
        <div class="badge badge-pill badge-warning text-white">
            Admin MRV
        </div>
        @break
    @case('root')
        <div class="badge badge-pill badge-primary">
            Root
        </div>
        @break
    @case('admin_approval')
        <div class="badge badge-pill badge-danger">
            Admin Approval
        </div>
        @break
    @case('admin_po')
        <div class="badge badge-pill badge-success">
            Admin PO
        </div>
        @break
    @default
        <div class="badge badge-pill badge-primary">
            {{$role}}
        </div>
@endswitch

