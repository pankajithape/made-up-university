<?php
get_header();
pageBanner();
while (have_posts()) {
  the_post(); ?>
<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo site_url('/events') ?>"><i class="fa fa-home"
          aria-hidden="true"></i> Program Home </a> <span class="metabox__main"><?php the_title(); ?></span>
    </p>
  </div>
  <div class="generic-content"><?php the_content(); ?></div>
  <?php
    // Related Professors
    $today = date('Ymd');
    $relatedProfessors = new WP_Query(array(
      'post_type' => 'professor',
      'posts_per_page' => -1,
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"'
        )
      )
    ));
    if ($relatedProfessors->have_posts()) {
      // $homepageEvents->the_posts()
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
      echo '<ul class="professor-cards">';
      while ($relatedProfessors->have_posts()) {
        $relatedProfessors->the_post(); ?>
  <li class="professor-card__list-item">
    <a class="professor-card" href="<?php the_permalink(); ?>">
      <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
      <span class="professor-card__name"><?php the_title(); ?></span>
    </a>
  </li>
  <?php }
      echo '</ul>';
    }
    wp_reset_postdata();
    // Related Events
    $today = date('Ymd');
    $homepageEvents = new WP_Query(array(
      'post_type' => 'event',
      'posts_per_page' => -1,
      'meta_key' => 'event_date',
      'orderby' => 'meta_value',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        ),
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"'
        )
      )
    ));
    if ($homepageEvents->have_posts()) {
      // $homepageEvents->the_posts()
      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
      while ($homepageEvents->have_posts()) {
        $homepageEvents->the_post();
        get_template_part('template-parts/content-event');
      }
    }
    ?>
</div>
<?php
}
get_footer();
?>