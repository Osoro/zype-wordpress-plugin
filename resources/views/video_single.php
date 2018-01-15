<?php
  $guests = zype_video_zobjects('guest');
  
  $hours = floor($video->duration / 3600);
  $minutes = floor(($video->duration / 60) % 60);
  $seconds = $video->duration % 60;

  $duration = '';
  if ($hours) {
    $duration = "{$minutes}h, {$minutes}m";
  } else {
    if (!$minutes) {
      $duration = "{$seconds}s";
    } else {
      $duration = "{$minutes}m";
    }
  }
?>
<div class="zype_video">
  <div class="zype_video__wrapper">
    <div class="zype_video__heading">
      <h1><?php echo $video->title; ?></h1>
      <div class="zype_play_sample">
        <?php if (zype_audio_only()): ?>
          <a href="<?php echo get_permalink() ?>?zype_wp=true&zype_type=video_single&zype_video_id=<?php echo $video->_id ?>" class="btn btn-lg btn-primary">Watch Video</a>
        <?php else: ?>
          <a href="<?php echo get_permalink() ?>?zype_wp=true&zype_type=video_single&audio=true&zype_video_id=<?php echo $video->_id ?>" class="btn btn-lg btn-primary">Listen to Audio</a>
        <?php endif ?>
      </div>
    </div>
    <?php if (zype_audio_only()): ?>
        <?php zype_player_embed($video, ['auth' => $video->subscription_required, 'auto_play' => false, 'audio_only' => true]); ?>
    <?php else: ?>
        <?php zype_player_embed($video, ['auth' => $video->subscription_required, 'auto_play' => false, 'audio_only' => false]); ?>
    <?php endif ?>
  </div>
  <?php if ($view == 'full'): ?>
    <section class="episode-main">
      <div class="head">
        <h2><?php echo $video->title; ?></h2>
      </div>
      <div class="head">
        <h5 class="duration-title">Duration <?php echo $duration ?></h5>
      </div>
      
      <div class="summary">
          <p><?php echo $video->description; ?></p>
      </div>
    </section>
    <div class="zype_play_sample">
      <?php if(zype_audio_only()){ ?>
        <a href="<?php echo get_permalink() ?>?zype_wp=true&zype_type=video_single&zype_video_id=<?php echo $video->_id ?>" class="btn btn-lg btn-primary">Watch Video</a>
      <?php } else { ?>
        <a href="<?php echo get_permalink() ?>?zype_wp=true&zype_type=video_single&audio=true&zype_video_id=<?php echo $video->_id ?>" class="btn btn-lg btn-primary">Listen to Audio</a>
      <?php } ?>
    </div>
    <section class="timeline">
      <?php if(isset($video->segments)){ ?>
        <strong class="title">Timeline</strong>
        <ul class="list">
          <?php foreach($video->segments as $segment){ ?> 
            <li>
              <span class="meta"><?php zype_ms2hms($segment->start); ?></span>
              <span class="text"><?php echo $segment->description; ?></span>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>
    </section>
  <?php endif ?>
</div>
<script type="text/javascript">
(function($){
  $(document).on('click', function(e){
    if ($(e.target).is('.player-auth-required')) {
      var modal = $('.player-auth-required');
      modal.removeClass('zype_modal_open');
      $('body').css('overflow-y', 'auto');
      zype_wp.zypeAuthMarkupRequest('login');
      setTimeout(function(){
        modal.find('.player-auth-required-content').css('top', '-50%');
      },10);
    }
  });
  
  $(document).on('click', '#zype_video__auth-close', function(e){
    e.preventDefault();
    var modal = $(this).closest('.player-auth-required');
    modal.removeClass('zype_modal_open');
    $('body').css('overflow-y', 'auto');
    zype_wp.zypeAuthMarkupRequest('login');
    setTimeout(function(){
      modal.find('.player-auth-required-content').css('top', '-50%');
    },10);
  });
  
  $(document).on('click', '.zype_player_container > img.placeholder, .zype_player_container > img.play-placeholder', function(e) {
    e.preventDefault();
    if ($(this).closest('.zype_player_container').find('.player-auth-required').length != 0) {
      var modal = $(this).closest('.zype_player_container').find('.player-auth-required');
      modal.addClass('zype_modal_open');
      $('body').css('overflow-y', 'hidden');
      setTimeout(function(){
        modal.find('.player-auth-required-content').css('top', '20px');
      },10);
    }
  })
})(jQuery); 
</script>


