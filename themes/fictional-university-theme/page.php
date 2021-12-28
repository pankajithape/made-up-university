<?php
 get_header();
 while(have_posts()){
     the_post();
    pageBanner();
          //  pageBanner(array(
          //   'title' => 'Hello this is the title',
          //   // 'subtitle' => 'This is subtitle'
          //   // 'photo' => 'https://i.pinimg.com/originals/a4/96/c2/a496c2b6bc5d7cfe0e0674f6598c38ad.jpg'
          // ));    
    ?>
    <div class="container container--narrow page-section">

    <?php

    $theParent = wp_get_post_parent_ID(get_the_ID());
      if($theParent){ ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php the_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
      <?php }
     ?>

    <?php 
    $testArray = get_pages(array(
         'child_of' => get_the_ID()
     ));

      if($theParent or $testArray)?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php the_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
            <!-- <li class="current_page_item"><a href="#">Our History</a></li>
            <li><a href="#">Our Goals</a></li> -->
            <?php 
            if($theParent){
                $findChildrenOf = $theParent;
            } else{
                $findChildrenOf = get_the_ID();
            }
            
            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'
            )); 
            
            ?>
        </ul>
      </div>

      <div class="generic-content">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
      </div>
    </div>

<?php
}
get_footer();
?>