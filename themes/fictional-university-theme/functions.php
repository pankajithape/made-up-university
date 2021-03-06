<?php

require get_theme_file_path('inc/search-route.php');
require get_theme_file_path('inc/like-route.php');


function university_custom_rest()
{
  register_rest_field('post', 'authorName', array(
    'get_callback' => function () {
      return get_the_author();
    }
  ));
  register_rest_field('note', 'userNoteCount', array(
    'get_callback' => function () {
      return count_user_posts(get_current_user_id(), 'note');
    }
  ));
}
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL)
{
  // php logic lives here
  if (!$args['title']) {
    $args['title'] = get_the_title();
  }
  if (!$args['subtitle']) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  // if(!$args['photo']){
  //   if(get_field('page_banner_background_image')){
  //     $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
  //   } else {
  //     $args['photo'] = get_theme_file_uri('images/ocean.jpg');
  //   }
  // }
  if (!$args['photo']) {
    if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/css/images/ocean.jpg');
    }
  }
?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
    <div class="page-banner__intro">
      <p><?php echo $args['subtitle']; ?></p>
    </div>
  </div>
</div>
<?php }

function university_files()
{
  wp_enqueue_script('university_main_scripts', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  wp_enqueue_script('api-custom-js', get_stylesheet_directory_uri() . '/js/custom-api.js', NULL, '1.0', true);
  wp_localize_script('api-custom-js', 'additionalData', array('nonce' => wp_create_nonce('wp_rest')));
  wp_enqueue_style('font', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('font1', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_files', get_theme_file_uri('/build/index.css'));

  wp_localize_script('university_main_scripts', 'universityData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
  register_nav_menu('headerMenuLocation', 'Header Menu Location ');
  register_nav_menu('footerLocation1', 'Footer Location 1');
  register_nav_menu('footerLocation2', 'Footer Location 2');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorProtrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
  // add_image_size('professorProtrait1', 480, 650, false);
  // add_image_size('professorProtrait', 635, 492, true);
  // add_image_size('professorProtrait', 635, 492, false);
  // add_image_size('professorProtrait3', 1686, 650, true);
  // add_image_size('professorProtrait3', 1686, 650, false);
}
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
  if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
  if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set(
      'meta_query',
      array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        )
      )
    );
  }
}
add_action('pre_get_posts', 'university_adjust_queries');
university_features();

// Redirect subscriber account out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend()
{
  $ourCurrentUser = wp_get_current_user();
  if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}
// add_action('wp_loaded', 'noSubsAdminBar');

// function noSubsAdminBar()
// {
//   $ourCurrentUser = wp_get_current_user();
//   if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
//     show_admin_bar(false);
//     exit;
//   }
// }

// show admin bar only for admins
if (!current_user_can('manage_options')) {
  add_filter('show_admin_bar', '__return_false');
}
// show admin bar only for admins and editors
if (!current_user_can('edit_posts')) {
  add_filter('show_admin_bar', '__return_false');
}

// Customize login screen

function ourHeaderUrl()
{
  if (is_admin() or !is_admin()) {

    return site_url('/');
  }
}
add_filter('login_headerurl', 'ourHeaderUrl');

add_action('login_enqueue_scripts', 'ourLoginCss');

function ourLoginCss()
{
  wp_enqueue_style('font', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('font1', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_files', get_theme_file_uri('/build/index.css'));
}
add_action('login_headertitle', 'ourLoginTitle');

function ourLoginTitle()
{
  return get_bloginfo('name');
}

// Force note post to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr)
{
  if ($data['post_type'] == 'note') {
    if (count_user_posts(get_current_user_id(), 'note') > 4 and !$postarr['ID']) {
      die("You have reached your note limit");
    }
    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }
  if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
    $data['post_status'] = "private";
  }
  return $data;
}


add_filter('ai1wm_exclude_content_from_export', 'ignoreCertainFiles');
function ignoreCertainFiles()
{
  $exclude_filters[] = "themes/fictional-university-theme/node_modules";
  return $exclude_filters;
}