@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <!-- Page Header -->
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.students') }} {{ trans('admin/main.list') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a>{{ trans('admin/main.students') }}</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="#">{{ trans('admin/main.users_list') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Boxes -->
    <div class="section-body">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_students') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalStudents }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parents -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.parents') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalOrganizationsStudents }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students with Subscription -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.students_have_pack') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $WithSubscriptionCount }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students without Subscription -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.students_have_no_pack') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $WithoutSubscriptionCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <section class="card">
            <div class="card-body">
                <form method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="from" class="text-center form-control" name="from"
                                        value="{{ request()->get('from') }}" placeholder="Start Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="to" class="text-center form-control" name="to"
                                        value="{{ request()->get('to') }}" placeholder="End Date">
                                </div>
                            </div>
                        </div>

                        <!-- Subscription Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.filters') }}</label>
                                <select name="sort" data-plugin-selectTwo class="form-control populate">
                                    <option value="">{{ trans('admin/main.filter_type') }}</option>
                                    <option value="subscribed" @if (request()->get('sort') == 'subscribed') selected @endif>
                                        {{ trans('admin/main.has_subscription') }}
                                    </option>
                                    <option value="not_subscribed" @if (request()->get('sort') == 'not_subscribed') selected @endif>
                                        {{ trans('admin/main.no_subscription') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Organization Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.organization') }}</label>
                                <select name="organization_id" data-plugin-selectTwo class="form-control populate">
                                    <option value="">{{ trans('admin/main.select_organization') }}</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}"
                                            @if (request()->get('organization_id') == $organization->id) selected @endif>
                                            {{ $organization->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Level -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.level') }}</label>
                                <select name="child_level_id" id="levelSelect" class="form-control">
                                    <option value="">{{ trans('admin/main.select_level') }}</option>
                                    @foreach ($level as $lvl)
                                        <option value="{{ $lvl->id }}"
                                            @if (request()->get('child_level_id') == $lvl->id) selected @endif>
                                            {{ $lvl->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-2 d-flex align-items-end">
                            <input type="submit" class="text-center btn btn-primary w-100"
                                value="{{ trans('admin/main.show_results') }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary w-100">
                                {{ trans('admin/main.reset_filters') ?? 'Reset Filters' }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Students Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="row mb-3 justify-content-end">
                    <div class="col-md-4">
                        <input type="text" id="searchBox" class="form-control" placeholder="🔍 Search...">
                    </div>
                </div>
                @can('admin_users_export_excel')
                    <a href="/admin/students/excel?{{ http_build_query(request()->all()) }}"
                        class="btn btn-primary mb-3">{{ trans('admin/main.export_xls') }}</a>
                @endcan
                <table class="table table-striped font-14" id="studentsTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('admin/main.child') }}</th>
                            <th>Level</th>
                            <th>{{ trans('admin/main.register_date') }}</th>
                            <th>{{ trans('admin/main.has_subscription') }}</th>
                            <th width="120">{{ trans('admin/main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="text-left">
                                    <div class="d-flex align-items-center">
                                        <figure class="avatar mr-2">
                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                        </figure>
                                        <div class="media-body ml-1">
                                            <div class="mt-0 mb-1 font-weight-bold">{{ $user->full_name }}</div>

                                            @if ($user->mobile)
                                                <div class="text-primary text-small font-600-bold">
                                                    {{ $user->mobile }}
                                                </div>
                                            @endif

                                            @if ($user->email)
                                                <div class="text-primary text-small font-600-bold">
                                                    {{ $user->email }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($user->childLevel)
                                        <span class="badge badge-primary">
                                            {{ $user->childLevel->name }}
                                        </span>
                                    @endif
                                </td>

                                <td>{{ dateTimeFormat($user->created_at, 'j M Y | H:i') }}</td>
                                <td>
                                    @if ($user->subscriptions()->count() > 0)
                                        <span class="badge badge-success">
                                            {{ trans('admin/main.yes') }}
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            {{ trans('admin/main.no') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center mb-2" width="120">
                                    @can('admin_users_impersonate')
                                        <a href="/admin/users/{{ $user->id }}/impersonate" target="_blank"
                                            class="btn-transparent  text-primary" data-toggle="tooltip" data-placement="top"
                                            title="{{ trans('admin/main.login') }}">
                                            <i class="fa fa-user-shield"></i>
                                        </a>
                                    @endcan

                                    @can('admin_users_edit')
                                        <a href="/admin/users/{{ $user->id }}/edit" class="btn-transparent  text-primary"
                                            data-toggle="tooltip" data-placement="top"
                                            title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('admin_users_delete')
                                        @include('admin.includes.delete_button', [
                                            'url' => '/admin/users/' . $user->id . '/delete',
                                            'btnClass' => '',
                                        ])
                                    @endcan
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laravel Pagination -->
        <div class="card-footer text-center">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {

            var table = $('#studentsTable').DataTable({
                processing: true,
                paging: false,
                ordering: true,
                searching: true,
                order: [
                    [2, 'desc']
                ],
                info: true,
                responsive: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'colvis',
                    text: 'Toggle Columns',
                    className: 'btn btn-primary'
                }]
            });

            $('.dataTables_filter').hide();

            $('#searchBox').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('.btn-secondary').on('click', function() {
                $('#searchBox').val('');
                table.search('').draw();
            });

        });
    </script>
@endpush
