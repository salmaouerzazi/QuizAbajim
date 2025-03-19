<style>
    .manuel-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-gap: 15px;
        padding: 20px;
    }


    @media (max-width: 992px) {
        .manuel-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 15px;
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .manuel-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 15px;
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .manuel-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 15px;
            padding: 20px;
        }
    }

    .manuel-grid-item {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        height: 310px
    }

    .manuel-content img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;

    }

    .manuel-details {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px 0;
    }

    .manuel-details span:first-child {
        font-weight: bold;
        font-size: 18px;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
        position: relative;
        text-align: center;
    }

    .manuel-details span:first-child::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 2px;
        background-color: #3498db;
        border-radius: 2px;
    }

    .manuel-details span:last-child {
        font-size: 14px;
        color: #7f8c8d;
        font-weight: 500;
        display: flex;
        align-items: center;
        margin-top: 5px;
    }

    .manuel-details span:last-child::before {
        content: '🎥';
        margin-right: 5px;
        font-size: 16px;
    }
</style>

@if (!empty($matiere1))
    <div class="row" id="manuelsList">
        <div class="manuel-grid">    
            @foreach ($matiere1 as $material)
                @foreach ($material->manuels as $manuel)
                    @php
                        $videoCount = \Illuminate\Support\Facades\DB::table('videos')
                            ->where('manuel_id', $manuel->id)
                            ->where('user_id', $user->id)
                            ->count();
                    @endphp
                    
                    @if(auth()->check() && auth()->user()->isEnfant())  
                        <div class="manuel-grid-item">
                            <a    onclick="return handleNavigation('{{ auth()->user()->level_id }}', '{{ $material->section->level->id }}', '/panel/scolaire/{{ $manuel->id }}?teacher_id={{ $user->id }}')">

                            <div class="manuel-content">
                                    <img src="/{{ $manuel->logo }}" alt="{{ $manuel->name }}">
                                    <div class="manuel-details">
                                        <span>
                                            {{ $manuel->matiere->section->level->name }}
                                        </span>
                                        <span>{{ $videoCount }} فيديوهات</span>
                                    </div>
                                </div>
                            </a>
                           
                        </div>
                    @else
                            <div class="manuel-grid-item">
                                <a href="/panel/scolaire/{{ $manuel->id }}?teacher_id={{ $user->id }}">
                                <div class="manuel-content">
                                    <img src="/{{ $manuel->logo }}" alt="{{ $manuel->name }}">
                                    <div class="manuel-details">
                                        <span>
                                            {{ $manuel->matiere->section->level->name }}
                                        </span>
                                        <span>{{ $videoCount }} فيديوهات</span>
                                    </div>
                                </div>
                            </a>
                           
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
    <!-- Modal HTML -->
<div class="modal fade" id="levelModal" tabindex="-1" aria-labelledby="levelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="levelModalLabel">ليس لديك إذن</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                هذا المستوى غير متاح لحسابك لفتح هذا الكتاب.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>




@else
    @include(getTemplate() . '.includes.no-result', [
        'file_name' => 'webinar.png',
        'title' => trans('update.instructor_not_have_posts'),
        'hint' => '',
    ])
@endif
<script>
    function handleNavigation(userLevelId, materialLevelId, url) {
        if (userLevelId == materialLevelId) {
            // Redirect to the URL if the level IDs match
            window.location.href = url;
            return false; // Prevent default link behavior
        } else {
            // Show modal if the level IDs don't match
            var modal = new bootstrap.Modal(document.getElementById('levelModal'));
            modal.show();
            return false;
        }
    }
</script>
