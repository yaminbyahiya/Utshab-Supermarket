<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">  
  <?php do_action( 'food_grocery_store_before_slider' ); ?>

  <?php if( get_theme_mod( 'food_grocery_store_slider_arrows', false) == 1 || get_theme_mod( 'food_grocery_store_resp_slider_hide_show', false) == 1) { ?>
    <section id="slider">
      <?php if(get_theme_mod('food_grocery_store_slider_type', 'Default slider') == 'Default slider' ){ ?>
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="<?php echo esc_attr(get_theme_mod( 'food_grocery_store_slider_speed',4000)) ?>"> 
        <?php $food_grocery_store_pages = array();
          for ( $count = 1; $count <= 3; $count++ ) {
            $mod = intval( get_theme_mod( 'food_grocery_store_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $food_grocery_store_pages[] = $mod;
            }
          }
          if( !empty($food_grocery_store_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $food_grocery_store_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $i = 1;
        ?>
        <div class="carousel-inner" role="listbox">
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php if(has_post_thumbnail()){
                the_post_thumbnail();
              } else{?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/block-patterns/images/banner.png" alt="" />
              <?php } ?>
              <div class="carousel-caption pt-0">
                <div class="inner_carousel">
                  <?php if( get_theme_mod('food_grocery_store_slider_title_hide_show',true) == 1){ ?>
                    <h1 class="mb-0 pt-0 wow slideInRight" data-wow-duration="2s"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                  <?php } ?>
                  <?php if( get_theme_mod('food_grocery_store_slider_content_hide_show',true) == 1){ ?>
                    <p class="wow zoomInUp" data-wow-duration="2s"><?php $food_grocery_store_excerpt = get_the_excerpt(); echo esc_html( food_grocery_store_string_limit_words( $food_grocery_store_excerpt, esc_attr(get_theme_mod('food_grocery_store_slider_excerpt_number','25')))); ?></p>
                  <?php } ?>
                  <div class="more-btn mt-4 mb-4 wow slideInRight" data-wow-duration="2s">
                    <a class="p-3 p-lg-3 p-md-3" href="<?php the_permalink(); ?>"><?php esc_html_e('Shop Now','food-grocery-store');?><span class="screen-reader-text"><?php esc_html_e('Shop Now','food-grocery-store'); ?></span></a>
                  </div>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <a class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" role="button">
          <span class="carousel-control-prev-icon w-auto h-auto" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Previous','food-grocery-store' );?></span>
        </a>
        <a class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" role="button">
          <span class="carousel-control-next-icon w-auto h-auto" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Next','food-grocery-store' );?></span>
        </a>
      </div>
      <div class="clearfix"></div>
      <?php } else if(get_theme_mod('food_grocery_store_slider_type', 'Advance slider') == 'Advance slider'){?>
        <?php echo do_shortcode(get_theme_mod('food_grocery_store_advance_slider_shortcode')); ?>
      <?php } ?>
    </section>
  <?php }?>

  <?php do_action( 'food_grocery_store_after_slider' ); ?>

  <section id="product-sec" class="pt-5 pb-5 wow slideInLeft delay-1000">
    <div class="container">
      <?php $food_grocery_store_product_page = array();
        $mod = absint( get_theme_mod( 'food_grocery_store_product_settings','food-grocery-store'));
        if ( 'page-none-selected' != $mod ) {
          $food_grocery_store_product_page[] = $mod;
        }
        if( !empty($food_grocery_store_product_page) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $food_grocery_store_product_page,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $count = 0;
            while ( $query->have_posts() ) : $query->the_post(); ?>
              <div class="heading-txt mb-4 text-left">
                <h2><?php the_title(); ?></h2>
                <hr class="mb-0 mt-0">
              </div>
              <?php the_content(); ?>
            <?php $count++; endwhile; ?>
          <?php else : ?>
            <div class="no-postfound"></div>
          <?php endif;
        endif;
        wp_reset_postdata()
      ?>
    </div>
  </section>

  <?php do_action( 'food_grocery_store_after_service' ); ?>

  <div id="content-vw">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>