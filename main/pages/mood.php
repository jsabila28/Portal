<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
            <div class="mood-title" align="center">
                <h4>Share how you feel today!</h4>
            </div>
        <div class="row">
            <div id="moods" class="moods">
                <div class="mood-content">
                   <div class="mood-list">
                       <a href="#" class="mood-option" data-mood="crying"><img src="/Portal/assets/reactions/crying.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="anger"><img src="/Portal/assets/reactions/anger.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="eyeroll"><img src="/Portal/assets/reactions/eyeroll.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="inlove"><img src="/Portal/assets/reactions/inlove.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="sleepy"><img src="/Portal/assets/reactions/sleepy.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="tired"><img src="/Portal/assets/reactions/tired.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="nuh"><img src="/Portal/assets/reactions/hahaha.GIF"/></a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    $('.mood-option').on('click', function (e) {
        e.preventDefault();
        
        const mood = $(this).data('mood');
        $.ajax({
            url: 'save_mood',
            type: 'POST',
            data: { mood: mood },
            success: function (response) {
                // alert('Mood saved successfully: ' + mood);
                window.location.href = '/Portal/dashboard';
            },
            error: function () {
                alert('Failed to save mood.');
            }
        });
    });
});
</script>