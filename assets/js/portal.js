$(document).ready(function () {
    // Event delegation for reaction triggers
    $(document).on('click', '.reaction-trigger', function () {
        $(this).siblings('.reaction-options').toggle();
    });

    // Event delegation for reactions
    $(document).on('click', '.reaction', function () {
        var reactionType = $(this).data('reaction');
        var postBy = $(this).data('reacted_by');
        var postId = $(this).closest('.reaction-container').find('.reaction-trigger').attr('id').split('-')[2];
        var $reactionTrigger = $(this).closest('.reaction-container').find('.reaction-trigger');

        $.ajax({
            url: 'reaction',
            method: 'POST',
            data: { post_id: postId, reaction: reactionType, reacted_by: postBy },
            success: function (response) {
                $(this).closest('.reaction-container').find('.reaction-options').hide();
                $reactionTrigger.hide();

                var reactionImage;
                switch (reactionType) {
                    case 'like':
                        reactionImage = '<img src="/Portal/assets/reactions/likes.WEBP" class="img-fluid rounded-circle" alt="Like">';
                        break;
                    case 'heart':
                        reactionImage = '<img src="/Portal/assets/reactions/love.WEBP" class="img-fluid rounded-circle" alt="Heart">';
                        break;
                    case 'love':
                        reactionImage = '<img src="https://i.pinimg.com/564x/1e/b9/ab/1eb9abce88c9859c08e70330ef8495dc.jpg" class="img-fluid rounded-circle" alt="Love">';
                        break;
                    case 'cry':
                        reactionImage = '<img src="/Portal/assets/reactions/cry.WEBP" class="img-fluid rounded-circle" alt="Cry">';
                        break;
                    case 'haha':
                        reactionImage = '<img src="/Portal/assets/reactions/lough.WEBP" class="img-fluid rounded-circle" alt="Haha">';
                        break;
                    case 'wow':
                        reactionImage = '<img src="/Portal/assets/reactions/shock.WEBP" class="img-fluid rounded-circle" alt="Money">';
                        break;
                    case 'angry':
                        reactionImage = '<img src="/Portal/assets/reactions/sadness.WEBP" class="img-fluid rounded-circle" alt="Angry">';
                        break;
                    case 'eey':
                        reactionImage = '<img src="https://i.pinimg.com/564x/cc/12/e0/cc12e02e7eed4491de74e05ea8a019a5.jpg" class="img-fluid rounded-circle" alt="Eey">';
                        break;
                    default:
                        reactionImage = '';
                }

                $reactionTrigger.html(reactionImage).show();
            }.bind(this),
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Handle new post creation
    $('#post-btn').click(function (e) {
        e.preventDefault();

        var postedBy = $('input[name="posted-by"]').val();
        var postDesc = $('#post-desc').val();
        var postDesc = $('#post-desc2').val();
        var audience = $('input[name="audience"]:checked').val();
        var postContent = new FormData();

        postContent.append('postedBy', postedBy);
        postContent.append('postDesc', postDesc);
        postContent.append('audience', audience);

        var fileInput = $('#file-input')[0].files[0];
        if (fileInput) {
            postContent.append('file', fileInput);
        }

        $.ajax({
            url: 'postnews',
            type: 'POST',
            data: postContent,
            processData: false,
            contentType: false,
            success: function (response) {
                alert(response);
                $('#default-Modal').modal('hide');
                resetModalForm();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    function resetModalForm() {
        $('#post-desc').val('');
        $('#post-desc2').val('');
        $('input[name="audience"]').prop('checked', false);
        $('#file-input').val('');
        $('#image-video').css('background-image', 'url(assets/img/upload.png)');
        $('.post-btn').prop('disabled', true);
        $('#add-photo-video').addClass('hide-image');
    }

    $('#post-desc').on('input', function () {
        if ($(this).val().trim() !== '') {
            $('.post-btn').prop('disabled', false);
        } else {
            $('.post-btn').prop('disabled', true);
        }
    });
    $('#post-desc2').on('input', function () {
        if ($(this).val().trim() !== '') {
            $('.post-btn').prop('disabled', false);
        } else {
            $('.post-btn').prop('disabled', true);
        }
    });
});

// Save comment function
function saveComment(postId) {
    const commentInput = document.getElementById(`Mycomment-${postId}`);
    const comIdInput = document.querySelector(`input[name="com-id"][value="${postId}"]`);

    if (!commentInput || !comIdInput) {
        alert('Unable to find input fields for this post.');
        return;
    }

    const comment = commentInput.value.trim();
    const comId = comIdInput.value;

    if (comment === '') {
        alert('Comment cannot be empty!');
        return;
    }

    fetch('save_comment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `com_id=${encodeURIComponent(comId)}&Mycomment=${encodeURIComponent(comment)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                commentInput.value = '';
                reloadComments(postId);
            } else {
                alert(data.message || 'An error occurred while saving the comment.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}

// Reload comments
function reloadComments(postId) {
    $.ajax({
        url: 'comment',
        type: 'POST',
        data: { post_id: postId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const comment = response.comment;
                const newCommentHTML = `
                    <div class="cardbox-base-comment">
                        <div class="media m-1">
                            <div class="d-flex mr-1" style="margin-left: 20px;">
                                <a href=""><img class="img-fluid rounded-circle" src="https://teamtngc.com/hris2/pages/empimg/${comment.bi_empno}.JPG" alt="User"></a>
                            </div>
                            <div class="media-body">
                                <p class="m-0">${comment.bi_empfname} ${comment.bi_emplname}</p>
                                <small><span><i class="icon ion-md-pin"></i> ${comment.com_content}</span></small>
                                <div class="comment-reply">
                                    <small><a href="#">just now</a></small>
                                    <small><a style="cursor: pointer;">Reply</a></small>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $(`#prof-${postId} #comment-section`).append(newCommentHTML);
            } else {
                console.error(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching the new comment:', error);
        }
    });
}
