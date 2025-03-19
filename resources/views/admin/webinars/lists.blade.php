@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.list') }} des Formations</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.classes') }}</div>

                <div class="breadcrumb-item">{{ trans('admin/main.type_' . $classesType . 's') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-file-video"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.total') }} {{ trans('admin/main.type_' . $classesType . 's') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                {{ $totalWebinars }}
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.total_sales') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalSales }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <input type="hidden" name="type" value="{{ request()->get('type') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.search') }}</label>
                                    <input name="title" type="text" class="form-control"
                                        value="{{ request()->get('title') }}">
                                </div>
                            </div>

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


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.filters') }}</label>
                                    <select name="sort" data-plugin-selectTwo class="form-control populate">
                                        <option value="">{{ trans('admin/main.filter_type') }}</option>
                                        <option value="has_discount" @if (request()->get('sort') == 'has_discount') selected @endif>
                                            {{ trans('admin/main.discounted_classes') }}</option>
                                        <option value="sales_asc" @if (request()->get('sort') == 'sales_asc') selected @endif>
                                            {{ trans('admin/main.sales_ascending') }}</option>
                                        <option value="sales_desc" @if (request()->get('sort') == 'sales_desc') selected @endif>
                                            {{ trans('admin/main.sales_descending') }}</option>
                                        <option value="price_asc" @if (request()->get('sort') == 'price_asc') selected @endif>
                                            {{ trans('admin/main.Price_ascending') }}</option>
                                        <option value="price_desc" @if (request()->get('sort') == 'price_desc') selected @endif>
                                            {{ trans('admin/main.Price_descending') }}</option>
                                        <option value="income_asc" @if (request()->get('sort') == 'income_asc') selected @endif>
                                            {{ trans('admin/main.Income_ascending') }}</option>
                                        <option value="income_desc" @if (request()->get('sort') == 'income_desc') selected @endif>
                                            {{ trans('admin/main.Income_descending') }}</option>
                                        <option value="created_at_asc" @if (request()->get('sort') == 'created_at_asc') selected @endif>
                                            {{ trans('admin/main.create_date_ascending') }}</option>
                                        <option value="created_at_desc" @if (request()->get('sort') == 'created_at_desc') selected @endif>
                                            {{ trans('admin/main.create_date_descending') }}</option>
                                        <option value="updated_at_asc" @if (request()->get('sort') == 'updated_at_asc') selected @endif>
                                            {{ trans('admin/main.update_date_ascending') }}</option>
                                        <option value="updated_at_desc" @if (request()->get('sort') == 'updated_at_desc') selected @endif>
                                            {{ trans('admin/main.update_date_descending') }}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.instructor') }}</label>
                                    <select name="teacher_ids[]" multiple="multiple" data-search-option="just_teacher_role"
                                        class="form-control search-user-select2" data-placeholder="Search teachers">

                                        @if (!empty($teachers) and $teachers->count() > 0)
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" selected>{{ $teacher->full_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.status') }}</label>
                                    <select name="status" data-plugin-selectTwo class="form-control populate">
                                        <option value="">{{ trans('admin/main.all_status') }}</option>
                                        <option value="pending" @if (request()->get('status') == 'pending') selected @endif>
                                            {{ trans('admin/main.pending_review') }}</option>
                                        @if ($classesType == 'webinar')
                                            <option value="active_not_conducted"
                                                @if (request()->get('status') == 'active_not_conducted') selected @endif>
                                                {{ trans('admin/main.publish_not_conducted') }}</option>
                                            <option value="active_in_progress"
                                                @if (request()->get('status') == 'active_in_progress') selected @endif>
                                                {{ trans('admin/main.publish_inprogress') }}</option>
                                            <option value="active_finished"
                                                @if (request()->get('status') == 'active_finished') selected @endif>
                                                {{ trans('admin/main.publish_finished') }}</option>
                                        @else
                                            <option value="active" @if (request()->get('status') == 'active') selected @endif>
                                                {{ trans('admin/main.published') }}</option>
                                        @endif
                                        <option value="inactive" @if (request()->get('status') == 'inactive') selected @endif>
                                            {{ trans('admin/main.rejected') }}</option>
                                        <option value="is_draft" @if (request()->get('status') == 'is_draft') selected @endif>
                                            {{ trans('admin/main.draft') }}</option>
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

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                @can('admin_webinars_export_excel')
                                    <div class="text-left mb-3">
                                        <a href="/admin/webinars/excel?{{ http_build_query(request()->all()) }}"
                                            class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                                    </div>
                                @endcan
                                <table class="table table-striped" id="product-dataTable1">
                                    <thead>
                                        <tr>
                                            <th class="text-left">{{ trans('admin/main.course') }}</th>
                                            <th class="text-left">{{ trans('admin/main.instructor') }}</th>
                                            <th>{{ trans('admin/main.price') }}</th>
                                            <th>{{ trans('admin/main.sales_number') }}</th>
                                            <th>{{ trans('admin/main.sales_amount') }}</th>
                                            <th>{{ trans('admin/main.creation_date') }}</th>
                                            <th>{{ trans('admin/main.change_status') }}</th>
                                            <th>{{ trans('admin/main.status') }}</th>
                                            <th width="120">{{ trans('admin/main.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($webinars as $webinar)
                                            <tr class="text-center mb-20" style="margin-bottom: 20px;">
                                                <td width="18%" class="text-left">
                                                    <div class="d-flex align-items-center">
                                                        <div class="col-6">
                                                            <img src="/store/{{ $webinar->image_cover }}"
                                                                alt="{{ $webinar->title }}" class=""
                                                                style="max-width: 100px; max-height: 70px; border-radius: 20px!important;">
                                                        </div>
                                                        <div class="col-6">
                                                            <a class="text-primary mt-0 mb-1 font-weight-bold"
                                                                href="{{ $webinar->getUrl() }}">{{ $webinar->title }}</a>
                                                            <div class="text-small">{{ $webinar->material->name }}</div>
                                                            <div class="text-small">
                                                                {{ $webinar->level->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-left">
                                                    <div class="d-flex align-items-center">
                                                        <figure class="avatar mr-2">
                                                            <img src="@if (!empty($webinar->teacher->avatar)) {{ $webinar->teacher->avatar }}@else{{ $webinar->teacher->getAvatar() }} @endif"
                                                                alt="{{ $webinar->teacher->full_name }}">
                                                        </figure>
                                                        <div class="media-body ml-1">
                                                            <div class="mt-0 mb-1 font-weight-bold">
                                                                {{ $webinar->teacher->full_name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (!empty($webinar->price) and $webinar->price > 0)
                                                        <span style="font-size:16px">{{ $webinar->price }}</span><span
                                                            style="font-size:10px"> {{ $currency }}</span>
                                                </td>
                                            @else
                                                {{ trans('admin/main.free') }}
                                        @endif
                                        </td>

                                        <td>
                                            <span class="text-primary mt-0 mb-1 font-weight-bold">
                                                {{ $webinar->sales->count() }}
                                            </span>


                                        </td>

                                        <td> <span style="font-size:16px">{{ $webinar->sales->sum('amount') }}
                                            </span><span style="font-size:10px">{{ $currency }}</span></td>

                                        <td class="font-12">{{ date('Y-m-j H:i', $webinar->created_at) }}</td>



                                        <td class="font-12">

                                            <form action="/admin/webinars/changestatus/{{ $webinar->id }}"
                                                method="post" id="kl{{ $webinar->id }}" class="fgdfs">
                                                {{ csrf_field() }}
                                                <p id="para" hidden>{{ $webinar->id }}</p>
                                                <input name="id_web" value="{{ $webinar->id }}" hidden />
                                                <input name="fff" value="{{ $webinar->status }}" hidden />

                                                <div
                                                    class="d-flex align-items-center flex-row-reverse flex-md-row justify-content-start justify-content-md-center mt-20 mt-md-0">
                                                    <div class="custom-control custom-switch">
                                                        @if ($webinar->status == 'active')
                                                            <input type="checkbox" name="active_webinar" value="is_draft"
                                                                class="custom-control-input"
                                                                id="activeVoucherSwitch{{ $webinar->id }}" checked>
                                                            <label class="custom-control-label"
                                                                for="activeVoucherSwitch{{ $webinar->id }}"></label>
                                                        @elseif ($webinar->status == 'is_draft')
                                                            <input type="checkbox" name="active_webinar" value="active"
                                                                class="custom-control-input"
                                                                id="activeVoucherSwitch{{ $webinar->id }}">
                                                            <label class="custom-control-label"
                                                                for="activeVoucherSwitch{{ $webinar->id }}"></label>
                                                        @elseif ($webinar->status == 'pending')
                                                            <input type="checkbox" name="active_webinar" value="active"
                                                                class="custom-control-input"
                                                                id="activeVoucherSwitch{{ $webinar->id }}">
                                                            <label class="custom-control-label"
                                                                for="activeVoucherSwitch{{ $webinar->id }}"></label>
                                                        @endif

                                                    </div>
                                                </div>

                                            </form>
                                        </td>
                                        <td>
                                            @switch($webinar->status)
                                                @case(\App\Models\Webinar::$active)
                                                    <div class="text-success font-600-bold">{{ trans('admin/main.published') }}
                                                    </div>
                                                    @if ($webinar->isWebinar())
                                                        @if ($webinar->isProgressing())
                                                            <div class="text-warning text-small">
                                                                ({{ trans('webinars.in_progress') }})
                                                            </div>
                                                        @elseif($webinar->start_date > time())
                                                            <div class="text-danger text-small">
                                                                ({{ trans('admin/main.not_conducted') }})</div>
                                                        @else
                                                            <div class="text-success text-small">({{ trans('public.finished') }})
                                                            </div>
                                                        @endif
                                                    @endif
                                                @break

                                                @case(\App\Models\Webinar::$isDraft)
                                                    <span class="text-dark">{{ trans('admin/main.is_draft') }}</span>
                                                @break

                                                @case(\App\Models\Webinar::$pending)
                                                    <span class="text-warning">{{ trans('admin/main.waiting') }}</span>
                                                @break

                                                @case(\App\Models\Webinar::$inactive)
                                                    <span class="text-danger">{{ trans('public.rejected') }}</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td width="120" class="btn-sm">
                                            <a href="{{ $webinar->getUrl() }}" target="_blank"
                                                class="btn-transparent btn-sm text-primary mt-1" data-toggle="tooltip"
                                                data-placement="top" title="Preview">
                                                <i class="fa fa-eye"></i>

                                            </a>
                                            <a href="/admin/webinars/{{ $webinar->id }}/students" target="_blank"
                                                class="btn-transparent btn-sm text-primary mt-1" data-toggle="tooltip"
                                                data-placement="top" title="{{ trans('admin/main.students') }}">
                                                <i class="fa fa-users"></i>

                                            </a>
                                            @can('admin_webinars_edit')
                                                <a href="/admin/webinars/{{ $webinar->id }}/edit" target="_blank"
                                                    class="btn-transparent btn-sm text-primary mt-1" data-toggle="tooltip"
                                                    data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('admin_webinars_delete')
                                                @include('admin.includes.delete_button', [
                                                    'url' => '/admin/webinars/' . $webinar->id . '/delete',
                                                    'btnClass' => 'btn-sm mt-1',
                                                ])
                                            @endcan
                                        </td>
                                        </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            {{ $webinars->appends(request()->input())->links() }}
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
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#product-dataTable1').DataTable({
                processing: true,
                paging: false,
                ordering: true,
                searching: false,
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

        });
    </script>
    <script>
        (function($) {
            var _f = document.getElementById("para").textContent;
            $('.fgdfs :checkbox').change(function() {
                if (this.checked) {
                    $(this).closest('form').submit();
                } else {
                    $(this).closest('form').submit();
                }
            });
            console.log(_f);
            $('body').on('change', '#activeVoucherSwitch' + _f, function() {
                $('.custom-control-input').on('change', function() {
                    $(this).closest('form').submit();
                });

            })
        })(jQuery)

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
