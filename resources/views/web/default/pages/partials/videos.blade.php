@foreach ($videos as $video)
    <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
        <div class="card custom-card" style="border-radius: 40px 0 0 0;" data-toggle="modal"
            data-target="#videoModal{{ $video->id }}">
            <div class="position-relative">
                <img style="border-radius: 40px 0 0 0;" src="{{ $video->thumbnail }}" class="card-img-top"
                    alt="{{ $video->titre }}">
                <div class="play-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $video->titre }}</h5>

                <div class="d-flex justify-content-between align-items-center">
                    <!-- Manual Section -->
                    <div class="d-flex align-items-center">
                        <img src="{{ $video->manuel->logo }}" alt="{{ $video->manuel->name }}"
                            style="width: 40px; height: 40px; border-radius: 50%">
                        <h5 class="card-title ml-1 mr-1 font-16">{{ $video->manuel->name }}</h5>

                    </div>

                    <!-- User Section -->
                    <div class="d-flex align-items-center">
                        @if (!empty($video->teacher->avatar))
                            <img src="{{ $video->teacher->getAvatar(100) }}" alt="{{ $video->teacher->full_name }}"
                                style="width: 40px; height: 40px; border-radius: 50%">
                        @else
                            <img src="{{ $video->teacher->getAvatar(100) }}" alt="{{ $video->teacher->full_name }}"
                                style="width: 40px; height: 40px; border-radius: 50%">
                        @endif
                        <h6 class="card-title ml-1 mr-1 font-16">{{ $video->teacher->full_name }}</h6>
                    </div>
                </div>

            </div>

        </div>

        <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1"
            aria-labelledby="videoModal{{ $video->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoModal{{ $video->id }}Label">{{ $video->titre }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 500px">
                        <video controls style="width: 100%;height:100%">
                            <source src="{{ $video->video }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@push('scripts_bottom')
    <script>
        $(document).on('click', '.tab-link', function(e) {
            e.preventDefault();

            var level = $(this).attr('data-level');

            var levelTranslations = {
                6: '{{ trans('home.first_level') }}',
                7: '{{ trans('home.second_level') }}',
                8: '{{ trans('home.third_level') }}',
                9: '{{ trans('home.fourth_level') }}',
                10: '{{ trans('home.fifth_level') }}',
                11: '{{ trans('home.sixth_level') }}'
            };

            var newTitle = '{{ trans('home.example_title_with_level', ['level' => ':level']) }}';
            newTitle = newTitle.replace(':level', levelTranslations[level]);

            $('#dynamicTitle').text(newTitle);

            $.ajax({
                url: '{{ route('manuels') }}',
                method: 'GET',
                data: {
                    level: level
                },
                success: function(response) {
                    $('#videos-container').html(
                        response);
                },
                error: function(xhr) {
                    console.error("Failed to load videos.");
                }
            });
        });
    </script>
@endpush
