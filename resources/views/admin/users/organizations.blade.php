@extends('admin.layouts.app')

@push('styles_top')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style>
        table.dataTable tr.shown td.dt-control::before {
            content: "-";
        }

        table.dataTable tr td.dt-control::before {
            content: "+";
            cursor: pointer;
            padding: 5px;
            text-align: center;
            font-weight: bold;
            color: white;
        }

        .d-none {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.organizations_list') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="#">{{ trans('admin/main.organizations_list') }}</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="#">{{ trans('admin/main.users_list') }}</a>
                </div>
            </div>
        </div>
    </section>

    <div class="section-body">
        <div class="row">
            <!-- Stats Cards -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.organizations') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalOrganizations }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Children -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.children') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalOrganizationsStudents }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="from" class="text-center form-control" name="from"
                                        value="{{ request()->get('from') }}" placeholder="Start Date">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="to" class="text-center form-control" name="to"
                                        value="{{ request()->get('to') }}" placeholder="End Date">
                                </div>
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

    <!-- DataTable Card -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-3 justify-content-end">
                <div class="col-md-4">
                    <input type="text" id="searchBox" class="form-control" placeholder="🔍 Search...">
                </div>
            </div>

            @can('admin_users_export_excel')
                <a href="/admin/organizations/excel?{{ http_build_query(request()->all()) }}" class="btn btn-primary mb-3">
                    {{ trans('admin/main.export_xls') }}
                </a>
            @endcan

            <div class="table-responsive">
                <table id="organizationsTable" class="table table-striped font-14">
                    <thead>
                        <tr>
                            <th>Details</th>
                            <th>User ID</th>
                            <th>{{ trans('admin/main.name') }}</th>
                            <th>{{ trans('admin/main.students') }}</th>
                            <th>{{ trans('admin/main.online_offline') }}</th>
                            <th>{{ trans('admin/main.online_time') }}</th>
                            <th>{{ trans('admin/main.minutes_to_open_account') }}</th>
                            <th>{{ trans('admin/main.device_type') }}</th>
                            <th>{{ trans('admin/main.last_seen') }}</th>
                            <th>{{ trans('admin/main.register_date') }}</th>
                            <th width="120">{{ trans('admin/main.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="dt-control"></td>
                                <td>{{ $user->id }}</td>
                                <td class="text-left">
                                    <div class="d-flex align-items-center">
                                        @can('admin_users_impersonate')
                                            <a href="/admin/users/{{ $user->id }}/impersonate" target="_blank"
                                                class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top"
                                                title="{{ trans('admin/main.login') }}">
                                                <figure class="avatar mr-2">
                                                    <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                                </figure>
                                            </a>
                                        @endcan
                                        <div class="media-body ml-1">
                                            <div class="mt-0 mb-1 font-weight-bold">
                                                {{ $user->full_name }}
                                            </div>
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

                                <!-- (4) Students Count -->
                                <td class="text-primary font-weight-bold">
                                    {{ $user->getOrganizationStudents()->count() }}
                                </td>

                                <!-- (5) Online/Offline -->
                                <td id="user-status-{{ $user->id }}">
                                    @if ($user->isOnline())
                                        <span class="text-success">🟢 Online</span>
                                    @else
                                        <span class="text-danger">🔴 Offline</span>
                                    @endif
                                </td>

                                <!-- (6) Online Time (calculated in Blade) -->
                                <td>
                                    @php
                                        $onlineTime = 0;
                                        if (!empty($user->last_seen_at) && !empty($user->first_login_at)) {
                                            $onlineRec = DB::table('users')
                                                ->select(
                                                    DB::raw(
                                                        'TIMESTAMPDIFF(MINUTE, first_login_at, last_seen_at) AS online_time',
                                                    ),
                                                )
                                                ->where('id', $user->id)
                                                ->first();
                                            $onlineTime = $onlineRec->online_time ?? 0;
                                            $hours = floor($onlineTime / 60);
                                            $minutes = $onlineTime % 60;
                                        } else {
                                            $hours = 0;
                                            $minutes = 0;
                                        }
                                    @endphp
                                    {{ $hours }} hours {{ $minutes }} minutes
                                </td>

                                <!-- (7) Minutes to Open Account -->
                                <td>
                                    total OnlineTime: {{ $averageOnlineTime ?? 0 }} minutes
                                    <br>
                                    Average Minutes to Open Account: {{ $averageMinutesToOpen ?? 0 }} minutes
                                </td>

                                <!-- (8) Device Type -->
                                <td>
                                    @foreach ($deviceStats as $device => $count)
                                        @if ($device == 'computer')
                                            <i class="fas fa-desktop"></i> Computer
                                        @elseif($device == 'ios')
                                            <i class="fas fa-mobile-alt"></i> iPhone
                                        @elseif($device == 'android')
                                            <i class="fas fa-mobile-alt"></i> Android
                                        @endif
                                    @endforeach
                                </td>

                                <!-- (9) Last Seen -->
                                <td>
                                    {{ $user->last_seen_at ?: '--' }}
                                </td>

                                <!-- (10) Register Date -->
                                <td>
                                    {{ dateTimeFormat($user->created_at, 'Y/m/j - H:i') }}
                                </td>

                                <!-- (11) Actions -->
                                <td class="text-center" width="120">
                                    @can('admin_users_edit')
                                        <a href="/admin/users/{{ $user->id }}/edit" class="btn-transparent text-primary"
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
            </div><!-- .table-responsive -->
        </div><!-- .card-body -->

        <!-- Pagination -->
        <div class="card-footer text-center">
            {{ $users->links() }}
        </div>
    </div><!-- .card -->

    <!-- Hints Section -->
    <section class="card">
        <div class="card-body">
            <div class="section-title ml-0 mt-0 mb-3">
                <h4>{{ trans('admin/main.hints') }}</h4>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.organizations_hint_title_1') }}
                        </div>
                        <div class="text-small font-600-bold">
                            {{ trans('admin/main.organizations_hint_description_1') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.organizations_hint_title_2') }}
                        </div>
                        <div class="text-small font-600-bold">
                            {{ trans('admin/main.organizations_hint_description_1') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.organizations_hint_title_3') }}
                        </div>
                        <div class="text-small font-600-bold">
                            {{ trans('admin/main.organizations_hint_description_1') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <!-- Required Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

    <script>
        var userDetails = {
            @foreach ($users as $user)
                "{{ $user->id }}": [
                    @foreach ($user->students as $student)
                        {
                            "id": "{{ $student->id }}",
                            "avatar": "{{ $student->getAvatar() }}",
                            "name": "{{ $student->full_name }}",
                            "level": (function() {
                                @php
                                    $levelName = DB::table('school_levels')->where('id', $student->level_id)->pluck('name');
                                    $studentLevel = $levelName[0] ?? '--';
                                @endphp
                                return "{{ $studentLevel }}";
                            })(),
                            "subscribe": "{{ $student->subscribe ? 'Yes' : 'No' }}",
                            "classesSalesSum": "{{ number_format($student->classesSalesSum, 2, '.', '') }}",
                            "meetingsSalesSum": "{{ number_format($student->meetingsSalesSum, 2, '.', '') }}",
                            "created_at": "{{ dateTimeFormat($student->created_at, 'Y/m/j - H:i') }}",
                            "isOnline": "{{ $student->isOnline() ? 'Online' : 'Offline' }}",
                            "online_time": "{{ $student->online_time ?? '--' }}"
                        },
                    @endforeach
                ],
            @endforeach
        };

        function formatChildRow(rowData) {
            var userId = rowData[1];
            var students = userDetails[userId] || [];
            if (students.length === 0) {
                return `<div style="padding:15px;"><em>No students found.</em></div>`;
            }
            var html = `
                <table class="table table-striped font-14">
                    <thead>
                        <tr>
                            <th>{{ trans('admin/main.students') }}</th>
                            <th>Level</th>
                            <th>{{ trans('admin/main.subscribe') }}</th>
                            <th>{{ trans('admin/main.classes_sales') }}</th>
                            <th>{{ trans('admin/main.appointments_sales') }}</th>
                            <th>{{ trans('admin/main.register_date') }}</th>
                            <th>{{ trans('admin/main.online_offline') }}</th>
                            <th>{{ trans('admin/main.online_time') }}</th>
                            <th width="120">{{ trans('admin/main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            students.forEach(function(s) {
                html += `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <figure class="avatar mr-2">
                                    <img src="${s.avatar}" alt="${s.name}" style="width:40px; height:40px; border-radius:50%;" />
                                </figure>
                                <div class="media-body ml-1">
                                    <div class="mt-0 mb-1 font-weight-bold">${s.name}</div>
                                </div>
                            </div>
                        </td>
                        <td>${s.level}</td>
                        <td>${s.subscribe}</td>
                        <td>
                            <div class="media-body">
                                <div class="text-primary mt-0 mb-1 font-weight-bold">0</div>
                                <div class="text-small font-600-bold">${s.classesSalesSum}</div>
                            </div>
                        </td>
                        <td>
                            <div class="media-body">
                                <div class="text-primary mt-0 mb-1 font-weight-bold">0</div>
                                <div class="text-small font-600-bold">${s.meetingsSalesSum}</div>
                            </div>
                        </td>
                        <td>${s.created_at}</td>
                        <td>
                            ${ s.isOnline === 'Online'
                                ? '<span class="text-success">🟢 Online</span>'
                                : '<span class="text-danger">🔴 Offline</span>'
                            }
                        </td>
                        <td>${s.online_time}</td>
                        <td class="text-center">
                            <a href="/admin/users/${s.id}/edit" class="btn-transparent text-primary" data-toggle="tooltip"
                               title="{{ trans('admin/main.edit') }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="/admin/users/${s.id}/delete" class="btn-transparent text-danger" data-toggle="tooltip"
                               title="{{ trans('admin/main.delete') }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
            });
            html += `</tbody></table>`;
            return html;
        }
        $(document).ready(function() {
            var table = $('#organizationsTable').DataTable({
                processing: true,
                paging: false,
                ordering: true,
                searching: true,
                order: [
                    [2, 'asc']
                ],
                info: true,
                responsive: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'colvis',
                    text: 'Toggle Columns',
                    className: 'btn btn-primary'
                }],
                columnDefs: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        targets: 0,
                        defaultContent: ''
                    },
                    {
                        targets: 1,
                        visible: false
                    }
                ]
            });
            $('.dataTables_filter').hide();
            $('#searchBox').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('#organizationsTable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(formatChildRow(row.data())).show();
                    tr.addClass('shown');
                }
            });

            function updateUserStatus() {
                fetch('/admin/users/online-status')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(user => {
                            let statusElement = document.getElementById('user-status-' + user.id);
                            if (statusElement) {
                                statusElement.innerHTML = user.is_online ?
                                    '<span class="text-success">🟢 Online</span>' :
                                    '<span class="text-danger">🔴 Offline</span>';
                            }
                        });
                    });
            }
            setInterval(updateUserStatus, 5000);
        });
    </script>
@endpush
