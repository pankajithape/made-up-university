<?php

if (!is_user_logged_in()) {
  wp_redirect(esc_url(site_url('/')));
  exit;
}

get_header();
while (have_posts()) {
  the_post();
  pageBanner();
  //  pageBanner(array(
  //   'title' => 'Hello this is the title',
  //   // 'subtitle' => 'This is subtitle'
  //   // 'photo' => 'https://i.pinimg.com/originals/a4/96/c2/a496c2b6bc5d7cfe0e0674f6598c38ad.jpg'
  // ));    
?>
<div class="container container--narrow page-section">
</div>

<?php
}
get_footer();
?>