@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.instructors') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ trans('admin/main.instructors') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.users') }}</div>
            </div>
        </div>
    </section>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_instructors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $users->total() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.video_instructors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalVideos }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_instructors') }}</h4>
                            <h4>{{ trans('admin/main.instructors_with_videos') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $videoAllInstructorsCount }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_instructors_without_videos') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalInstructorsWithoutVideos }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

                        <!-- Level -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.level') }}</label>
                                <select name="level_id" id="levelSelect" class="form-control">
                                    <option value="">{{ trans('admin/main.select_level') }}</option>
                                    @foreach ($level as $lvl)
                                        <option value="{{ $lvl->id }}"
                                            @if (request()->get('level_id') == $lvl->id) selected @endif>
                                            {{ $lvl->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Matiere -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.material') }}</label>
                                <select name="matiere_name" id="matiereSelect" class="form-control">
                                    <option value="">{{ trans('admin/main.select_matiere') }}</option>
                                    @if (request()->get('level_id'))
                                        @foreach ($matieres->where('section.level_id', request()->get('level_id')) as $matiere)
                                            <option value="{{ $matiere->name }}"
                                                @if (request()->get('matiere_name') == $matiere->name) selected @endif>
                                                {{ $matiere->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ trans('admin/main.show_results') }}
                            </button>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <a href="{{ route('admin.instructors') }}" class="btn btn-secondary w-100">
                                {{ trans('admin/main.reset_filters') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Box -->
            <div class="table-responsive">
                <div class="row mb-3 justify-content-end">
                    <div class="col-md-4">
                        <input type="text" id="searchBox" class="form-control" placeholder="🔍 Search...">
                    </div>
                </div>

                <!-- DataTable -->
                <table class="table table-striped font-14" id="instructorsTable">
                    @can('admin_users_export_excel')
                        <a href="/admin/instructors/excel?{{ http_build_query(request()->all()) }}"
                            class="btn btn-primary mb-3">{{ trans('admin/main.export_xls') }}</a>
                    @endcan
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('admin/main.name') }}</th>
                            <th>Number Videos</th>
                            <th>Levels Count</th>
                            <th>Materials Count</th>
                            <th>Number Courses</th>
                            <th>Total Video Views</th>
                            <th>Total Video Minutes</th>
                            <th>Total Likes</th>
                            <th>Total Followers</th>
                            <th>{{ trans('admin/main.register_date') }}</th>
                            <th width="140">{{ trans('admin/main.actions') }}</th>
                            <th width="140">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @php
                                $numVideos = $videoInstructorscount[$user->id] ?? 0;
                                $numCourses = $user->courses_count ?? 0;
                                $totalViews = $user->videos_views_sum ?? 0;
                                $totalMinutes = $user->videos_minutes_sum ?? 0;
                                $totalLikes = $user->videos_likes_sum ?? 0;
                                $totalFollowers = $user->followers_count ?? 0;
                                $levels = $user->levels->unique('id')->values();
                                $materials = $user->materials;
                                $groupedMaterialsByLevel = [];
                                foreach ($user->materials as $mat) {
                                    if ($mat->section && $mat->section->level) {
                                        $levelId = $mat->section->level->id;
                                        $groupedMaterialsByLevel[$levelId]['level'] = $mat->section->level->name;
                                        $groupedMaterialsByLevel[$levelId]['materials'][] = $mat->name;
                                    }
                                }
                            @endphp

                            <tr data-user-id="{{ $user->id }}" data-user-full_name="{{ $user->full_name }}"
                                data-grouped-materials='@json($groupedMaterialsByLevel)'
                                data-levels='@json($levels)'>
                                <td>{{ $user->id }}</td>
                                <td class="text-left">
                                    <div class="d-flex align-items-center">
                                        @can('admin_users_impersonate')
                                            <a href="/admin/users/{{ $user->id }}/impersonate" target="_blank"
                                                class="btn-transparent  text-primary" data-toggle="tooltip"
                                                style="text-decoration: none" data-placement="top"
                                                title="{{ trans('admin/main.login') }}">
                                                <figure class="avatar mr-2">
                                                    <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                                </figure>

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
                                            </a>
                                        @endcan
                                    </div>
            </div>
            </td>
            <td>{{ $user->videos->count() }}</td>
            <td>{{ $levels->count() }}</td>
            <td>{{ $materials->count() }}</td>
            <td>{{ $user->webinars->count() }}</td>
            <td>{{ $user->videos->sum('vues') }}</td>
            <td>{{ $user->videos->sum('total_minutes_watched') }}</td>
            <td>{{ $user->videos->sum('likes') }}</td>
            <td>{{ $user->followers->count() }}</td>
            <td>{{ dateTimeFormat($user->created_at, 'j M Y | H:i') }}</td>
            <td class="text-center" width="140">
                @can('admin_users_edit')
                    <a href="/admin/users/{{ $user->id }}/edit" class="btn-transparent text-primary"
                        data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
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
            <td class="text-center" width="140">
                <button class="btn btn-sm btn-outline-info toggle-details">
                    <i class="fa fa-plus"></i> Details
                </button>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="card-footer text-center">
        {{ $users->appends(request()->input())->links() }}
    </div>
    </div>

    <section class="card">
        <div class="card-body">
            <div class="section-title ml-0 mt-0 mb-3">
                <h4>{{ trans('admin/main.hints') }}</h4>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.instructors_hint_title_1') }}
                        </div>
                        <div class="text-small font-600-bold mb-2">
                            {{ trans('admin/main.instructors_hint_description_1') }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.instructors_hint_title_2') }}
                        </div>
                        <div class="text-small font-600-bold mb-2">
                            {{ trans('admin/main.instructors_hint_description_2') }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.instructors_hint_title_3') }}
                        </div>
                        <div class="text-small font-600-bold mb-2">
                            {{ trans('admin/main.instructors_hint_description_3') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#instructorsTable').DataTable({
                processing: true,
                paging: false,
                ordering: true,
                searching: true,
                order: [
                    [10, 'desc']
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

            $('#instructorsTable tbody').on('click', 'button.toggle-details', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).html('<i class="fa fa-plus"></i> Details'); // revert icon
                } else {
                    row.child(formatChildRow(tr)).show();
                    tr.addClass('shown');
                    $(this).html('<i class="fa fa-minus"></i> Details'); // change icon
                }
            });

            function formatChildRow(tr) {
                let userFullName = tr.data('user-full_name');
                let groupedMaterials = tr.data('grouped-materials');

                let tableHtml = `
                    <div class="p-3 bg-light">
                        <h6 class="font-weight-bold mb-3">Levels & Materials for ${userFullName}</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>Materials</th>
                                    </tr>
                                </thead>
                                <tbody>
                `;

                if (groupedMaterials && Object.keys(groupedMaterials).length > 0) {
                    Object.keys(groupedMaterials).forEach(levelId => {
                        let level = groupedMaterials[levelId].level;
                        let materials = groupedMaterials[levelId].materials;

                        let materialsHtml = materials.length ?
                            materials.map(m => `<span class="badge bg-primary text-white mx-1">${m}</span>`)
                            .join('') :
                            `<span class="text-muted">No materials</span>`;

                        tableHtml += `
                <tr>
                    <td width="30%">${level}</td>
                    <td>${materialsHtml}</td>
                </tr>
                `;
                    });
                } else {
                    tableHtml += `
                    <tr>
                        <td colspan="2"><em>No levels found for this user.</em></td>
                    </tr>
                `;
                }

                tableHtml += `
                    </tbody>
                </table>
            </div>
        </div>
    `;

                return tableHtml;
            }


            $('#levelSelect').on('change', function() {
                const levelId = $(this).val();
                const matiereSelect = $('#matiereSelect');
                const selectedMatiere = '{{ request()->get('matiere_name') }}';
                matiereSelect.html('<option value="">{{ trans('admin/main.select_matiere') }}</option>');

                if (levelId) {
                    $.ajax({
                        url: `/get-materials-by-level/${levelId}`,
                        method: 'GET',
                        success: function(response) {
                            response.forEach(function(material) {
                                const option = new Option(material.name, material.name);
                                if (material.name === selectedMatiere) {
                                    option.selected = true;
                                }
                                matiereSelect.append(option);
                            });
                        },
                        error: function(err) {
                            console.error('Failed to fetch materials:', err);
                        }
                    });
                }
            });

            @if (request()->get('level_id'))
                $('#levelSelect').trigger('change');
            @endif
        });
    </script>
@endpush
