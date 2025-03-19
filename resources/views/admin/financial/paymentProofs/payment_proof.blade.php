@extends('admin.layouts.app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.payment_proofs') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.payment_proofs') }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="section-filters">
            <section class="card">
                <div class="card-body">
                    <form action="/admin/financial/payment-proofs" method="get" class="row">
                        <!-- Start Date -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="from" autocomplete="off" class="form-control datefilter"
                                        value="{{ request()->get('from', null) }}" />
                                </div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="to" autocomplete="off" class="form-control datefilter"
                                        value="{{ request()->get('to', null) }}" />
                                </div>
                            </div>
                        </div>

                        <!-- User Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('/admin/main.user') }}</label>
                                <select name="user[]" multiple class="form-control search-user-select2"
                                    data-placeholder="{{ trans('/admin/main.search_user') }}">
                                    @if (request()->get('user'))
                                        @foreach (request()->get('user') as $userId)
                                            <option value="{{ $userId }}" selected>
                                                {{ $users[$userId]->full_name ?? 'Unknown User' }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ trans('admin/main.all') }}</option>
                                    <option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>
                                        {{ trans('admin/main.pending') }}
                                    </option>
                                    <option value="approved"
                                        {{ request()->get('status') == 'approved' ? 'selected' : '' }}>
                                        {{ trans('admin/main.approved') }}
                                    </option>
                                    <option value="rejected"
                                        {{ request()->get('status') == 'rejected' ? 'selected' : '' }}>
                                        {{ trans('admin/main.rejected') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> {{ trans('admin/main.show_results') }}
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <!-- Table -->
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="/admin/payment-proofs/excel"
                                class="btn btn-primary mb-3">{{ trans('admin/main.export_xls') }}</a>
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('admin/main.proof') }}</th>
                                            <th>{{ trans('admin/main.user') }}</th>
                                            <th class="text-center">{{ trans('admin/main.user_level') }}</th>
                                            <th class="text-center">{{ trans('admin/main.status') }}</th>
                                            <th>{{ trans('admin/main.note') }}</th>
                                            <th class="text-center">{{ trans('admin/main.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proofs as $proof)
                                            <tr>
                                                <td>
                                                    <a href="/store/{{ $proof->image }}" target="_blank">
                                                        <img src="/store/{{ $proof->image }}" alt="Payment Proof"
                                                            width="90" height="90"
                                                            style="border-radius: 8px;padding:5px">
                                                    </a>
                                                </td>
                                                <td class="text-left">
                                                    <div class="d-flex align-items-center">
                                                        <figure class="avatar mr-2">
                                                            <img src="{{ $proof->user->getAvatar() }}"
                                                                alt="{{ $proof->user->full_name }}">
                                                        </figure>
                                                        <div class="media-body ml-1">
                                                            <div class="mt-0 mb-1 font-weight-bold">
                                                                {{ $proof->user->full_name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $proof->level->name ?? '-' }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge 
                                                        @if ($proof->status == 'pending') badge-warning
                                                        @elseif($proof->status == 'approved') badge-success
                                                        @else badge-danger @endif">
                                                        {{ ucfirst($proof->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $proof->note ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($proof->status === 'pending')
                                                        <button class="btn btn-success btn-sm"
                                                            onclick="confirmStatusUpdate({{ $proof->id }}, 'approved')">
                                                            <i class="fas fa-check"></i> {{ trans('admin/main.approve') }}
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                            id="rejectButton" data-target="#rejectModal"
                                                            data-proof-id="{{ $proof->id }}">
                                                            <i class="fas fa-times"></i> {{ trans('admin/main.reject') }}
                                                        </button>
                                                    @else
                                                        <span
                                                            class="text-muted">{{ trans('admin/main.no_action_needed') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $proofs->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('admin/main.reject_payment_proof') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    <input type="hidden" id="proofId" name="proof_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="note">{{ trans('admin/main.rejection_note') }}</label>
                            <textarea class="form-control" name="note" id="note" rows="3"
                                placeholder="{{ trans('admin/main.optional_note') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{ trans('admin/main.reject') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts_bottom')
    <script>
        document.getElementById("rejectForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let proofId = document.querySelector("#rejectButton").getAttribute("data-proof-id");
            let note = document.getElementById("note").value;

            fetch(`/admin/financial/payment-proofs/${proofId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: "rejected",
                        note: note
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ trans('admin/main.success') }}",
                            text: "{{ trans('admin/main.status_updated_successfully') }}",
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ trans('admin/main.error') }}",
                            text: data.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trans('admin/main.error') }}",
                        text: "{{ trans('admin/main.error_updating_status') }}",
                        confirmButtonColor: '#dc3545'
                    });
                });
        });
    </script>
    <script>
        function confirmStatusUpdate(proofId, status) {
            Swal.fire({
                title: "{{ trans('admin/main.are_you_sure') }}",
                text: status === 'approved' ? "{{ trans('admin/main.approve_confirm_text') }}" :
                    "{{ trans('admin/main.reject_confirm_text') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: status === 'approved' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: status === 'approved' ? "{{ trans('admin/main.yes_approve') }}" :
                    "{{ trans('admin/main.yes_reject') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(proofId, status);
                }
            });
        }

        function updateStatus(proofId, status) {
            fetch(`/admin/financial/payment-proofs/${proofId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ trans('admin/main.success') }}",
                            text: "{{ trans('admin/main.status_updated_successfully') }}",
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ trans('admin/main.error') }}",
                            text: data.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trans('admin/main.error') }}",
                        text: error.message,
                        confirmButtonColor: '#dc3545'
                    });
                });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.min.js"></script>
@endpush
