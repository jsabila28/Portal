<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<div class="page-wrapper">
    <div class="page-body">
            <div class="mood-title" align="center">
                <h4>Hi! Every feeling is valid—what’s on your mind?</h4>
            </div>
        <div class="row">
            <div id="moods" class="moods">
                <div class="mood-content">
                   <div class="mood-list">
                       <a href="#" class="mood-option" data-mood="happy"><img src="/zen/assets/reactions/happy.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="nuh"><img src="/zen/assets/reactions/hahaha.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="inlove"><img src="/zen/assets/reactions/inlove.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="crying"><img src="/zen/assets/reactions/crying.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="anger"><img src="/zen/assets/reactions/anger.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="eyeroll"><img src="/zen/assets/reactions/eyeroll.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="sleepy"><img src="/zen/assets/reactions/sleepy.GIF"/></a>
                       <a href="#" class="mood-option" data-mood="tired"><img src="/zen/assets/reactions/tired.GIF"/></a>
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
                window.location.href = '/zen/dashboard';
            },
            error: function () {
                alert('Failed to save mood.');
            }
        });
    });
});
</script>