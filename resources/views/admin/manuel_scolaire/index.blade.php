@extends('admin.layouts.app')

@push('styles_top')
    <style>
        .toggle-icon {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.school_manuals_list') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.school_manuals_list') }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_quizzes') }}</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.active_quizzes') }}</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_students') }}</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_passed_students') }}</h4>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <section class="card">
                <div class="card-body">
                    <form action="{{ route('admin.manuel_scolaire.index') }}" method="GET">
                        <div class="row">
                            <!-- Search Title -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ request()->get('title') }}">
                                </div>
                            </div>

                            <!-- Filter by Level -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.level') }}</label>
                                    <select name="level_id" class="form-control">
                                        <option value="">{{ trans('admin/main.select_level') }}</option>
                                        @foreach ($level as $lvl)
                                            <option value="{{ $lvl->id }}"
                                                {{ request()->get('level_id') == $lvl->id ? 'selected' : '' }}>
                                                {{ $lvl->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Filter by Subject -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.material') }}</label>
                                    <select name="matiere_name" class="form-control">
                                        <option value="">{{ trans('admin/main.select_matiere') }}</option>
                                        @foreach ($matieres as $matiere)
                                            <option value="{{ $matiere->name }}"
                                                {{ request()->get('matiere_name') == $matiere->name ? 'selected' : '' }}>
                                                {{ $matiere->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Filter by Teacher -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.instructor') }}</label>
                                    <select name="teacher_ids[]" multiple class="form-control search-user-select2">
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                {{ in_array($teacher->id, request()->get('teacher_ids', [])) ? 'selected' : '' }}>
                                                {{ $teacher->full_name }}
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
                                <a href="{{ route('admin.manuel_scolaire.index') }}" class="btn btn-secondary w-100">
                                    {{ trans('admin/main.reset_filters') ?? 'Reset Filters' }}
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </section>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        @can('admin_quizzes_lists_excel')
                            <div class="text-left m-3">
                                <a href="/admin/quizzes/excel?{{ http_build_query(request()->all()) }}"
                                    class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                            </div>
                        @endcan
                        <div cla9ss="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th class="text-left">{{ trans('admin/main.book') }}</th>
                                            <th class="text-center">{{ trans('admin/main.teacher_count') }}</th>
                                            <th class="text-center">{{ trans('admin/main.videos_count') }}</th>
                                            <th class="text-center">% {{ trans('admin/main.videos_insertion') }}</th>
                                            <th>{{ trans('admin/main.details') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($manuels as $item)
                                            @php
                                                $totalPages = DB::table('documents')
                                                    ->where('manuel_id', $item->id)
                                                    ->sum('nombre_page');

                                                $uniqueIconsPerPage = $item->videos
                                                    ->map(fn($v) => $v->page . '-' . $v->numero)
                                                    ->unique()
                                                    ->count();

                                                $percentageCompleted =
                                                    $totalPages > 0
                                                        ? number_format(($uniqueIconsPerPage / $totalPages) * 100, 1)
                                                        : 0;
                                                $uniqueTeachers = $item->videos->pluck('user_id')->unique();
                                                $teacher_count = $uniqueTeachers->count();
                                            @endphp
                                            <tr onclick="toggleDetails(this)">
                                                <td class="text-center mt-10">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/{{ $item->logo }}"
                                                            style="width: 110px;margin: 19px;border-radius: 10px;">
                                                        <div class="media-body ml-1">
                                                            <div class="mt-0 mb-1 font-weight-bold">{{ $item->name }}
                                                            </div>
                                                            <div class="text-primary text-small font-600-bold">
                                                                {{ $item->matiere->name }}</div>
                                                            <div class="text-primary text-small font-600-bold">
                                                                {{ $item->matiere->section->level->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $teacher_count }}</td>
                                                <td class="text-center">{{ $uniqueIconsPerPage }}</td>
                                                <td class="text-center">{{ $percentageCompleted }} %</td>
                                                <td>
                                                    <i class="toggle-icon fas fa-chevron-down"></i>
                                                </td>
                                            </tr>

                                            {{-- Teacher details inside the collapsible section --}}
                                            <tr class="user-details" style="display: none;">
                                                <td colspan="5">
                                                    <table class="table table-striped font-14">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ trans('admin/main.teachers') }}</th>
                                                                <th class="text-center">
                                                                    {{ trans('admin/main.videos_count') }}</th>
                                                                <th class="text-center">%
                                                                    {{ trans('admin/main.videos_insertion') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($item->videos->isEmpty())
                                                                <tr>
                                                                    <td colspan="3">
                                                                        {{ trans('admin/main.no_teacher') }}</td>
                                                                </tr>
                                                            @else
                                                                @php $uniqueUsers = collect(); @endphp
                                                                @foreach ($item->videos as $video)
                                                                    @if (!$uniqueUsers->contains($video->user->id))
                                                                        @php
                                                                            $uniqueUsers->push($video->user->id);

                                                                            // Get unique videos per teacher (page, numero pairs)
                                                                            $teacherUniqueVideos = $item->videos
                                                                                ->where('user_id', $video->user->id)
                                                                                ->map(
                                                                                    fn($v) => $v->page .
                                                                                        '-' .
                                                                                        $v->numero,
                                                                                )
                                                                                ->unique()
                                                                                ->count();

                                                                            // Calculate teacher's percentage
                                                                            $teacherPercentage =
                                                                                $totalPages > 0
                                                                                    ? number_format(
                                                                                        ($teacherUniqueVideos /
                                                                                            $totalPages) *
                                                                                            100,
                                                                                        1,
                                                                                    )
                                                                                    : 0;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <figure class="avatar mr-2">
                                                                                        <img src="{{ $video->user->getAvatar() }}"
                                                                                            alt="{{ $video->user->full_name }}">
                                                                                    </figure>
                                                                                    <div class="media-body ml-1">
                                                                                        <div
                                                                                            class="mt-0 mb-1 font-weight-bold">
                                                                                            {{ $video->user->full_name }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                {{ $teacherUniqueVideos }}</td>
                                                                            <td class="text-center">
                                                                                {{ $teacherPercentage }} %</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $manuels->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script>
        function toggleDetails(row) {
            const detailsRow = row.nextElementSibling;
            const icon = row.querySelector('.toggle-icon');
            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                detailsRow.style.display = 'table-row';
                icon.classList.add('rotate-180');
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                detailsRow.style.display = 'none';
                icon.classList.remove('rotate-180');
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
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
    </script>
@endpush
