<div class="d-flex align-items-center" style="gap:5px">
    @if ($res->status === 'waiting')
        <button class="btn btn-sm btn-primary change-status" data-id="{{ $res->id }}" data-status="in_delivery">
            Delivery
        </button>
        <button class="btn btn-sm btn-danger change-status" data-id="{{ $res->id }}" data-status="rejected">
            Reject
        </button>
    @elseif ($res->status === 'in_delivery')
        <button class="btn btn-sm btn-success change-status" data-id="{{ $res->id }}" data-status="delivered">
            Delivered
        </button>
        <button class="btn btn-sm btn-danger change-status" data-id="{{ $res->id }}" data-status="rejected">
            Reject
        </button>
    @elseif ($res->status === 'rejected')
        <button class="btn btn-sm btn-warning change-status" data-id="{{ $res->id }}" data-status="waiting">
            Reconsider
        </button>
    @endif

    {{-- Delete Button --}}
    <button class="btn btn-sm btn-danger delete-reservation" data-id="{{ $res->id }}" data-bs-target="#deleteModal"
        data-bs-toggle="modal">
        Delete
    </button>
</div>
