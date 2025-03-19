@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Reservation Cards Management</h1>
        </div>

        <form method="GET" action="{{ route('admin.reservations.index') }}">
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="dateRangePicker">Date Range</label>
                        <input type="text" id="dateRangePicker" name="date_range" class="form-control"
                            placeholder="Select date range" value="{{ request('date_range') }}">
                        <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="levelFilter">Level</label>
                        <select class="form-control" id="levelFilter" name="level">
                            <option value="">-- All Levels --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ request('level') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="statusFilter">Status</label>
                        <select class="form-control" id="statusFilter" name="status">
                            <option value="">-- All Statuses --</option>
                            @foreach (\App\Models\CardReservation::getStatuses() as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary btn-block">Reset</a>
                    </div>
                </div>
            </div>
        </form>


        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3 justify-content-end">
                            <div class="col-md-4">
                                <input type="text" id="searchBox" class="form-control" placeholder="🔍 Search...">
                            </div>
                        </div>
                        <table class="table table-striped font-14">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                    <th>Level</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cardreserve as $res)
                                    <tr>
                                        <td>{{ $res->id }}</td>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ $res->phone_number }}</td>
                                        <td>{{ $res->city }}</td>
                                        <td>{{ $res->address }}</td>
                                        <td>{{ ucfirst($res->status) }}</td>
                                        <td>{{ $res->rejection_note ?? '-----' }}</td>
                                        <td>{{ $res->level->name ?? '-----' }}</td>
                                        <td>{{ $res->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center" style="gap:5px">
                                                @if ($res->status === 'waiting')
                                                    <button class="btn btn-sm btn-primary change-status"
                                                        data-id="{{ $res->id }}" data-status="in_delivery">
                                                        Delivery
                                                    </button>
                                                    <button class="btn btn-sm btn-danger change-status"
                                                        data-id="{{ $res->id }}" data-status="rejected">
                                                        Reject
                                                    </button>
                                                @elseif ($res->status === 'in_delivery')
                                                    <button class="btn btn-sm btn-success change-status"
                                                        data-id="{{ $res->id }}" data-status="delivered">
                                                        Delivered
                                                    </button>
                                                    <button class="btn btn-sm btn-danger change-status"
                                                        data-id="{{ $res->id }}" data-status="rejected">
                                                        Reject
                                                    </button>
                                                @elseif ($res->status === 'rejected')
                                                    <button class="btn btn-sm btn-warning change-status"
                                                        data-id="{{ $res->id }}" data-status="waiting">
                                                        Reconsider
                                                    </button>
                                                @endif

                                                {{-- Delete Button --}}
                                                <button class="btn btn-sm btn-danger delete-reservation"
                                                    data-id="{{ $res->id }}" data-bs-target="#deleteModal"
                                                    data-bs-toggle="modal">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="card-footer text-center">
                            {{ $cardreserve->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- REJECTION MODAL --}}
    <div class="modal fade" id="rejectionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="rejectionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectionModalLabel">Rejection Reason</h5>
                        <button type="button" class="close" aria-label="Close" data-bs-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="reservation_id" id="reservation_id">
                        <input type="hidden" name="status" id="target_status">
                        <div class="form-group">
                            <label for="rejection_note">Please provide the reason for rejection:</label>
                            <textarea name="rejection_note" id="rejection_note" class="form-control" rows="3" required></textarea>
                        </div>
                        <p class="text-danger" id="error-message" style="display: none;">You must provide a reason before
                            rejecting.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="deleteForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="reservation_id" id="delete_reservation_id">
                        <p class="text-danger">Are you sure you want to delete this reservation?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('.table').DataTable({
                processing: true,
                paging: false,
                ordering: true,
                searching: true,
                order: [
                    [8, "desc"]
                ],
                info: true,
                responsive: true,
                dom: "Bfrtip",
                buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'colvis',
                        text: 'Toggle Columns',
                        className: 'btn btn-primary'
                    }
                ]
            });
            $(".dataTables_filter").hide();

            $('#searchBox').on('keyup', function() {
                table.search(this.value).draw();
            });

            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');

                if (status === "rejected") {
                    $('#reservation_id').val(id);
                    $('#target_status').val(status);
                    var rejectionModal = new bootstrap.Modal(document.getElementById('rejectionModal'));
                    rejectionModal.show();
                } else {
                    updateStatusAJAX(id, status, '');
                }
            });

            $('#rejectionForm').on('submit', function(e) {
                e.preventDefault();
                var reservationId = $('#reservation_id').val();
                var reason = $('#rejection_note').val().trim();

                if (!reservationId) {
                    console.error('Reservation ID not found');
                    return;
                }

                updateStatusAJAX(reservationId, 'rejected', reason);
                $('#rejectionModal').modal('hide');
                $('#rejection_note').val('');
            });

            function updateStatusAJAX(id, status, rejectionNote) {
                $.ajax({
                    url: "{{ route('admin.reservations.updateStatus') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: String(status),
                        rejection_note: rejectionNote
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message || 'Something went wrong');
                        }
                    },
                    error: function(err) {
                        alert('Error updating status');
                    }
                });
            }

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var reservationId = button.data('id');
                $('#delete_reservation_id').val(reservationId);
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();
                var reservationId = $('#delete_reservation_id').val();

                $.ajax({
                    url: "/admin/reservations/" + reservationId,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || 'Error while deleting');
                        }
                    },
                    error: function(err) {
                        alert('Error while deleting the reservation');
                    }
                });
            });

            $('#dateRangePicker').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                    'YYYY-MM-DD'));
            });

            $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endpush
