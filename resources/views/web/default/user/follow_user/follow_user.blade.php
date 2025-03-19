@auth
    @if (!auth()->user()->isteacher())
        @if (!empty($authUserIsFollower) && $authUserIsFollower)
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="followDropdown"
                    data-toggle="dropdown" aria-expanded="false">
                    {{ trans('panel.followed') }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="followDropdown">
                    <li>
                        <button class="dropdown-item text-danger openUnfollowModal" data-toggle="modal"
                            data-target="#confirmUnfollowModal" data-user-id="{{ $user_id }}">
                            {{ trans('panel.unfollow') }}
                        </button>
                    </li>
                </ul>
            </div>
        @else
            <button type="button" class="btn btn-primary follow-button" data-user-id="{{ $user_id }}">
                {{ trans('panel.follow') }}
            </button>
        @endif
    @endif
@else
    <button type="button" onclick="window.location.href='/login';" class="btn btn-primary btn-sm">
        {{ trans('panel.follow') }}
    </button>
@endauth

<!-- Unfollow Modal -->
<div class="modal fade" id="confirmUnfollowModal" tabindex="-1" aria-labelledby="confirmUnfollowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title p-5" id="confirmUnfollowModalLabel">{{ trans('panel.confirm_unfollow') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ trans('panel.confirm_unfollow_desc') }}
            </div>
            <div class="modal-footer">
                <form method="POST" id="unfollowForm">
                    @csrf
                    <input type="hidden" id="unfollowUserId" name="user_id">
                    <button type="submit" class="btn btn-danger">{{ trans('panel.unfollow') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts_bottom')
    <script>
        $(function() {
            let followRequestInProgress = {};

            // 1) FOLLOW BUTTON CLICK
            // -----------------------
            // Listen for clicks on any .follow-button (works even after UI replacements)
            $(document).on('click', '.follow-button', function(event) {
                event.preventDefault();
                const userId = $(this).data('user-id');
                if (!userId) {
                    console.error("User ID is missing in follow request.");
                    return;
                }
                handleFollow(userId);
            });

            // 2) UNFOLLOW MODAL OPEN
            // ----------------------
            // Set the user ID in the hidden field before showing modal
            $(document).on('click', '.openUnfollowModal', function() {
                const userId = $(this).data('user-id');
                $('#unfollowUserId').val(userId);
            });

            // 3) UNFOLLOW FORM SUBMISSION
            // ---------------------------
            // Process the unfollow request via AJAX
            $('#unfollowForm').on('submit', function(event) {
                event.preventDefault();
                const userId = $('#unfollowUserId').val();
                handleUnfollow(userId);
                $('#confirmUnfollowModal').modal('hide');
            });


            // -- AJAX: FOLLOW user --
            function handleFollow(userId) {
                if (followRequestInProgress[userId]) return;
                followRequestInProgress[userId] = true;

                $.ajax({
                    url: `/panel/add`,
                    method: "POST",
                    data: {
                        _token: $("meta[name='csrf-token']").attr("content"),
                        teacher_id: userId
                    },
                    success: function(response) {
                        updateFollowUI(userId, true, response.newFollowerCount, response
                            .newFollowingCount);
                        followRequestInProgress[userId] = false;
                    },
                    error: function(xhr) {
                        console.error("Follow error:", xhr.responseJSON);
                        alert(xhr.responseJSON?.message || "Error following user.");
                        followRequestInProgress[userId] = false;
                    }
                });
            }

            // -- AJAX: UNFOLLOW user --
            function handleUnfollow(userId) {
                if (followRequestInProgress[userId]) return;
                followRequestInProgress[userId] = true;

                $.ajax({
                    url: `/panel/unfollow/${userId}`,
                    method: "POST",
                    data: {
                        _token: $("meta[name='csrf-token']").attr("content"),
                        user_id: userId
                    },
                    success: function(response) {
                        updateFollowUI(userId, false, response.newFollowerCount, response
                            .newFollowingCount);
                        followRequestInProgress[userId] = false;
                    },
                    error: function() {
                        alert("Error unfollowing user.");
                        followRequestInProgress[userId] = false;
                    }
                });
            }

            function updateFollowUI(userId, isSubscribed, newFollowerCount, newFollowingCount) {
                let followButtonContainer = $(".dropdown");

                if (isSubscribed) {
                    $(".follow-button").replaceWith(`
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="followDropdown"
                                data-toggle="dropdown" aria-expanded="false">
                            {{ trans('panel.followed') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="followDropdown">
                            <li>
                                <button class="dropdown-item text-danger openUnfollowModal" data-toggle="modal"
                                        data-target="#confirmUnfollowModal" data-user-id="${userId}">
                                    {{ trans('panel.unfollow') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                `);
                } else {
                    followButtonContainer.replaceWith(`
                    <button type="button"
                            class="btn btn-primary follow-button"
                            data-user-id="${userId}">
                        {{ trans('panel.follow') }}
                    </button>
                `);
                }

                $("#followerCount_" + userId).text(newFollowerCount);
                $("#followingCount").text(newFollowingCount);
            }
        });
    </script>
@endpush
