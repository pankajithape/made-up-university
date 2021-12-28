<?php get_header();
while (have_posts()) {
  the_post();
  pageBanner();
?>
<div class="container container--narrow page-section">
  <div class="generic-content">
    <div class="row group">
      <div class="col-4"><?php the_post_thumbnail('professorProtrait'); ?></div>
      <div class="col-8"><?php the_content(); ?></div>
      <?php print_r($pageBaneerImage); ?>
      <?php echo "<pre>";
        print_r($pageBaneerImage);
        echo "</pre>"; ?>
    </div>
  </div>
  <?php $relatedPrograms = get_field('related_programs');
    // print_r($relatedPrograms);
    if ($relatedPrograms) {
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Subject(s) taught</h2>';
      echo '<ul class="link-list min-list">';
      foreach ($relatedPrograms as $program) { ?>
  <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program); ?></a></li>
  <?php }
      echo '</ul>';
    }
    ?>
</div>
<?php
}
get_footer();
?>