<?php

/*
  Plugin Name: Quiz plugin
*/

if (!defined('ABSPATH')) exit;

class Quiz
{
  function __construct()
  {
    add_action('init', array($this, 'adminAssets'));
  }
  function adminAssets()
  {
    wp_register_style('quizeditcss', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_register_script('ourNewBlockType', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    register_block_type("ourplugin/quiz", array(
      "editor_script" => "ourNewBlockType",
      "editor_style" => "quizeditcss",
      "render_callback" => array($this, 'theHTML')
    ));
  }

  function theHTML($attributes)
  {
    if (!is_admin()) {
      wp_enqueue_script('quizFrontend', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
      wp_enqueue_style('quizFrontendStyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
    }
    ob_start(); ?>
<div class="paying-attention-update-me">
  <pre style="display: none;"> <?php echo wp_json_encode($attributes); ?></pre>
</div>
<?php return ob_get_clean();
  }
}

$quiz = new Quiz();