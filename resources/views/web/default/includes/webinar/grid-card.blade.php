<style>
    .truncated-title {
        width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }
</style>
<div class="webinar-card">
    <figure>
        <a href="{{ $webinar->getUrl() }}" target="_blank">
            <div class="image-box">
                <img src="/store/{{ $webinar->image_cover }}" class="img-cover" alt="">
            </div>
            <div class="webinar-card-body w-100 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                    <h3 class="font-16 text-dark-blue font-weight-bold mb-10 truncated-title"
                        title="{{ $webinar->title }}">
                        {{ $webinar->title }}
                    </h3>
                    <span class="stat-value"
                        style="border: 1px solid {{ $materialColors[$webinar->material->name] ?? '#ccc' }};
                               color: {{ $materialColors[$webinar->material->name] ?? '#ccc' }};
                               border-radius: 5px; padding: 5px 10px;">
                        {{ !empty($webinar->matiere_id) ? $webinar->material->name : '' }}
                    </span>
                </div>
        </a>

        <figcaption class="webinar-card-body">
            <div class="user-inline-avatar d-flex align-items-center">
                @if ($authUser && $authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
                    <a href="/users/{{ $webinar->teacher->id }}/profile" class="d-flex align-items-center mr-15">
                        <div class="d-flex align-items-center mr-15">
                            <img src="{{ $webinar->teacher->getAvatar() }}" class="rounded-circle mr-10" width="40"
                                height="40" alt="">
                            <div class="d-flex flex-column">
                                <span class="stat-value">{{ $webinar->teacher->full_name }}</span>
                                <span class="stat-value text-muted">
                                    {{ trans('panel.followers') }} :
                                    {{ $webinar->teacher->followers->count() }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </figcaption>
    </figure>
</div>
