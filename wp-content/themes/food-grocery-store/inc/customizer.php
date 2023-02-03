<?php
/**
 * Food Grocery Store Theme Customizer
 *
 * @package Food Grocery Store
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function food_grocery_store_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'food_grocery_store_custom_controls' );

function food_grocery_store_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'food_grocery_store_customize_partial_blogname',
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'food_grocery_store_customize_partial_blogdescription',
	));

	//Homepage Settings
	$wp_customize->add_panel( 'food_grocery_store_homepage_panel', array(
		'title' => esc_html__( 'Homepage Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_panel_id',
		'priority' => 20,
	));

	//Top Header
	$wp_customize->add_section( 'food_grocery_store_top_header' , array(
    	'title' => esc_html__( 'Top Header', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_homepage_panel'
	) );

	$wp_customize->add_setting('food_grocery_store_daily_deals_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('food_grocery_store_daily_deals_text',array(
		'label'	=> esc_html__('Daily Deals Text','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Daily Deals', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_daily_deals_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('food_grocery_store_daily_deals_link',array(
		'label'	=> esc_html__('Daily Deals Link','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'https://example.com/page', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_top_header',
		'type'=> 'url'
	));

	$wp_customize->add_setting('food_grocery_store_contact_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('food_grocery_store_contact_text',array(
		'label'	=> esc_html__('Help & Contact Text','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Help & Contact', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_contact_link',array(
		'default'=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('food_grocery_store_contact_link',array(
		'label'	=> esc_html__('Help & Contact Link','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'https://example.com/page', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_top_header',
		'type'=> 'url'
	));

	$wp_customize->add_setting( 'food_grocery_store_order_tracking',array(
		'default' =>  0,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_order_tracking',array(
		'label' => esc_html__( 'Order Tracking','food-grocery-store' ),
		'section' => 'food_grocery_store_top_header'
    )));

    $wp_customize->add_setting( 'food_grocery_store_currency_switcher',array(
		'default' =>  0,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_currency_switcher',array(
		'label' => esc_html__( 'Currency Switcher','food-grocery-store' ),
		'section' => 'food_grocery_store_top_header'
    )));

    $wp_customize->add_setting( 'food_grocery_store_google_translator',array(
		'default' =>  0,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_google_translator',array(
		'label' => esc_html__( 'Language Translator','food-grocery-store' ),
		'section' => 'food_grocery_store_top_header'
    )));

	$wp_customize->add_setting('food_grocery_store_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'food_grocery_store_sanitize_phone_number'
	));	
	$wp_customize->add_control('food_grocery_store_phone_number',array(
		'label'	=> esc_html__('Phone Number','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '+00 123 456 7890', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_top_header',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_navigation_menu_font_weight',array(
        'default' => 'Default',
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','food-grocery-store'),
        'section' => 'food_grocery_store_top_header',
        'choices' => array(
        	'Default' => __('Default','food-grocery-store'),
            'Normal' => __('Normal','food-grocery-store')
        ),
	) );

	$wp_customize->add_setting('food_grocery_store_header_menus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_header_menus_color', array(
		'label'    => __('Menus Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_top_header',
	)));

	$wp_customize->add_setting('food_grocery_store_header_menus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_header_menus_hover_color', array(
		'label'    => __('Menus Hover Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_top_header',
	)));

	$wp_customize->add_setting('food_grocery_store_header_submenus_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_header_submenus_color', array(
		'label'    => __('Sub Menus Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_top_header',
	)));

	$wp_customize->add_setting('food_grocery_store_header_submenus_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_header_submenus_hover_color', array(
		'label'    => __('Sub Menus Hover Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_top_header',
	)));
    
	//Slider
	$wp_customize->add_section( 'food_grocery_store_slidersettings' , array(
    	'title' => esc_html__( 'Slider Settings', 'food-grocery-store' ),
    	'description' => "Free theme has 3 slides options, For unlimited slides and more options </br><a class='go-pro-btn' target='_blank' href='". esc_url(FOOD_GROCERY_STORE_GO_PRO_URL) ." '>GO PRO</a>",
		'panel' => 'food_grocery_store_homepage_panel'
	) );

	$wp_customize->add_setting( 'food_grocery_store_slider_arrows',array(
    	'default' => 0,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_slider_arrows',array(
      	'label' => esc_html__( 'Show / Hide Slider','food-grocery-store' ),
      	'section' => 'food_grocery_store_slidersettings'
    )));

    $wp_customize->add_setting('food_grocery_store_slider_type',array(
        'default' => 'Default slider',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	) );
	$wp_customize->add_control('food_grocery_store_slider_type', array(
        'type' => 'select',
        'label' => __('Slider Type','food-grocery-store'),
        'section' => 'food_grocery_store_slidersettings',
        'choices' => array(
            'Default slider' => __('Default slider','food-grocery-store'),
            'Advance slider' => __('Advance slider','food-grocery-store'),
        ),
	));

	$wp_customize->add_setting('food_grocery_store_advance_slider_shortcode',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_advance_slider_shortcode',array(
		'label'	=> __('Add Slider Shortcode','food-grocery-store'),
		'section'=> 'food_grocery_store_slidersettings',
		'type'=> 'text',
		'active_callback' => 'food_grocery_store_advance_slider'
	));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('food_grocery_store_slider_arrows',array(
		'selector'        => '#slider .carousel-caption h1',
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_slider_arrows',
	));

	for ( $count = 1; $count <= 3; $count++ ) {
		$wp_customize->add_setting( 'food_grocery_store_slider_page' . $count, array(
			'default'  => '',
			'sanitize_callback' => 'food_grocery_store_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'food_grocery_store_slider_page' . $count, array(
			'label'    => esc_html__( 'Select Slider Page', 'food-grocery-store' ),
			'description' => esc_html__('Slider image size (1400 x 550)','food-grocery-store'),
			'section'  => 'food_grocery_store_slidersettings',
			'type'     => 'dropdown-pages',
			'active_callback' => 'food_grocery_store_default_slider'
		) );
	}

	$wp_customize->add_setting( 'food_grocery_store_slider_title_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_slider_title_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Title','food-grocery-store' ),
		'section' => 'food_grocery_store_slidersettings',
		'active_callback' => 'food_grocery_store_default_slider'
    )));

	$wp_customize->add_setting( 'food_grocery_store_slider_content_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_slider_content_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Content','food-grocery-store' ),
		'section' => 'food_grocery_store_slidersettings',
		'active_callback' => 'food_grocery_store_default_slider'
    )));

	//content layout
	$wp_customize->add_setting('food_grocery_store_slider_content_option',array(
        'default' => 'Center',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control(new Food_Grocery_Store_Image_Radio_Control($wp_customize, 'food_grocery_store_slider_content_option', array(
        'type' => 'select',
        'label' => esc_html__('Slider Content Layouts','food-grocery-store'),
        'section' => 'food_grocery_store_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ),
    	'active_callback' => 'food_grocery_store_default_slider'
	)));

    //Slider content padding
    $wp_customize->add_setting('food_grocery_store_slider_content_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_slider_content_padding_top_bottom',array(
		'label'	=> __('Slider Content Padding Top Bottom','food-grocery-store'),
		'description'	=> __('Enter a value in %. Example:20%','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_slidersettings',
		'type'=> 'text',
		'active_callback' => 'food_grocery_store_default_slider'
	));

	$wp_customize->add_setting('food_grocery_store_slider_content_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_slider_content_padding_left_right',array(
		'label'	=> __('Slider Content Padding Left Right','food-grocery-store'),
		'description'	=> __('Enter a value in %. Example:20%','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_slidersettings',
		'type'=> 'text',
		'active_callback' => 'food_grocery_store_default_slider'
	));

    //Slider excerpt
	$wp_customize->add_setting( 'food_grocery_store_slider_excerpt_number', array(
		'default'              => 25,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'food_grocery_store_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'food_grocery_store_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','food-grocery-store' ),
		'section'     => 'food_grocery_store_slidersettings',
		'type'        => 'range',
		'settings'    => 'food_grocery_store_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
		'active_callback' => 'food_grocery_store_default_slider'
	) );

	//Slider height
	$wp_customize->add_setting('food_grocery_store_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_slider_height',array(
		'label'	=> __('Slider Height','food-grocery-store'),
		'description'	=> __('Specify the slider height (px).','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_slidersettings',
		'type'=> 'text',
		'active_callback' => 'food_grocery_store_default_slider'
	));

	$wp_customize->add_setting( 'food_grocery_store_slider_speed', array(
		'default'  => 4000,
		'sanitize_callback'	=> 'food_grocery_store_sanitize_float'
	) );
	$wp_customize->add_control( 'food_grocery_store_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','food-grocery-store'),
		'section' => 'food_grocery_store_slidersettings',
		'type'  => 'number',
		'active_callback' => 'food_grocery_store_default_slider'
	) );

	$wp_customize->add_setting( 'food_grocery_store_slider_image_overlay',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));
    $wp_customize->add_control( new food_grocery_store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_slider_image_overlay',array(
      	'label' => esc_html__( 'Slider Image Overlay','food-grocery-store' ),
      	'section' => 'food_grocery_store_slidersettings',
      	'active_callback' => 'food_grocery_store_default_slider'
    )));

    $wp_customize->add_setting('food_grocery_store_slider_image_overlay_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_slider_image_overlay_color', array(
		'label'    => __('Slider Image Overlay Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_slidersettings',
		'active_callback' => 'food_grocery_store_default_slider'
	)));

	//Categories Section
	$wp_customize->add_section('food_grocery_store_categories', array(
		'title'       => __('Categories Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_categories_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_categories_text',array(
		'description' => __('<p>1. More options for categories section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for categories section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_categories',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_categories_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_categories_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_categories',
		'type'=> 'hidden'
	));

	//top sale banner Section
	$wp_customize->add_section('food_grocery_store_top_sale_banner', array(
		'title'       => __('Top Sale Banner Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_top_sale_banner_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_top_sale_banner_text',array(
		'description' => __('<p>1. More options for top sale banner section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for top sale banner section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_top_sale_banner',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_top_sale_banner_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_top_sale_banner_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_top_sale_banner',
		'type'=> 'hidden'
	));


	//Features Section
	$wp_customize->add_section('food_grocery_store_features', array(
		'title'       => __('Features Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_features_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_features_text',array(
		'description' => __('<p>1. More options for features section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for features section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_features',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_features_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_features_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_features',
		'type'=> 'hidden'
	));
 

 	//deal recommended Section
	$wp_customize->add_section('food_grocery_store_deal_recommended', array(
		'title'       => __('Deal Recommended Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_deal_recommended_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_deal_recommended_text',array(
		'description' => __('<p>1. More options for deal recommended section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for deal recommended section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_deal_recommended',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_deal_recommended_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_deal_recommended_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_deal_recommended',
		'type'=> 'hidden'
	));
 

 	//shop by brand Section
	$wp_customize->add_section('food_grocery_store_shop_by_brand', array(
		'title'       => __('Shop by Brand Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_shop_by_brand_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_shop_by_brand_text',array(
		'description' => __('<p>1. More options for shop by brand section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for shop by brand section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_shop_by_brand',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_shop_by_brand_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_shop_by_brand_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_shop_by_brand',
		'type'=> 'hidden'
	));
 
	//Product Section
	$wp_customize->add_section('food_grocery_store_product_section',array(
		'title'	=> esc_html__('Trending Product Section','food-grocery-store'),
		'description' => "For more options of trending product section </br><a class='go-pro-btn' target='_blank' href='". esc_url(FOOD_GROCERY_STORE_GO_PRO_URL) ." '>GO PRO</a>",
		'panel' => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting( 'food_grocery_store_product_settings' , array(
		'default' => '',
		'sanitize_callback' => 'food_grocery_store_sanitize_dropdown_pages'
	) );
	$wp_customize->add_control( 'food_grocery_store_product_settings' , array(
		'label'    => esc_html__( 'Select Product Page', 'food-grocery-store' ),
		'section'  => 'food_grocery_store_product_section',
		'type'     => 'dropdown-pages'
	) );

 	//banner Section
	$wp_customize->add_section('food_grocery_store_banner', array(
		'title'       => __('Banner Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_banner_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_banner_text',array(
		'description' => __('<p>1. More options for banner section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for banner section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_banner',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_banner_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_banner_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_banner',
		'type'=> 'hidden'
	));

 	//selling categories Section
	$wp_customize->add_section('food_grocery_store_selling_categories', array(
		'title'       => __('Selling Categories Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_selling_categories_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_selling_categories_text',array(
		'description' => __('<p>1. More options for selling categories section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for selling categories section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_selling_categories',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_selling_categories_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_selling_categories_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_selling_categories',
		'type'=> 'hidden'
	));

 	//featured product Section
	$wp_customize->add_section('food_grocery_store_featured_product', array(
		'title'       => __('Featured Product Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_featured_product_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_featured_product_text',array(
		'description' => __('<p>1. More options for featured product section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for featured product section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_featured_product',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_featured_product_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_featured_product_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_featured_product',
		'type'=> 'hidden'
	));
 
 	//sale organic Section
	$wp_customize->add_section('food_grocery_store_sale_organic', array(
		'title'       => __('Sale Organic Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_sale_organic_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_sale_organic_text',array(
		'description' => __('<p>1. More options for sale organic section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for sale organic section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_sale_organic',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_sale_organic_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_sale_organic_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_sale_organic',
		'type'=> 'hidden'
	));

 	//our blog Section
	$wp_customize->add_section('food_grocery_store_our_blog', array(
		'title'       => __('Blog Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_our_blog_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_our_blog_text',array(
		'description' => __('<p>1. More options for blog section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for blog section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_our_blog',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_our_blog_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_our_blog_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_our_blog',
		'type'=> 'hidden'
	));

	//our blog Section
	$wp_customize->add_section('food_grocery_store_order_now', array(
		'title'       => __('Order Now Section', 'food-grocery-store'),
		'description' => __('<p class="premium-opt">Premium Theme Features</p>','food-grocery-store'),
		'priority'    => null,
		'panel'       => 'food_grocery_store_homepage_panel',
	));

	$wp_customize->add_setting('food_grocery_store_order_now_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_order_now_text',array(
		'description' => __('<p>1. More options for order now section.</p>
			<p>2. Unlimited images options.</p>
			<p>3. Color options for order now section.</p>','food-grocery-store'),
		'section'=> 'food_grocery_store_order_now',
		'type'=> 'hidden'
	));

	$wp_customize->add_setting('food_grocery_store_order_now_btn',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_order_now_btn',array(
		'description' => "<a class='go-pro' target='_blank' href='". admin_url(FOOD_GROCERY_STORE_GET_STARTED_URL) ." '>More Info</a>",
		'section'=> 'food_grocery_store_order_now',
		'type'=> 'hidden'
	));

	//Footer Text
	$wp_customize->add_section('food_grocery_store_footer',array(
		'title'	=> esc_html__('Footer Settings','food-grocery-store'),
		'description' => "For more options of footer section </br><a class='go-pro-btn' target='_blank' href='". esc_url(FOOD_GROCERY_STORE_GO_PRO_URL) ." '>GO PRO</a>",
		'panel' => 'food_grocery_store_homepage_panel',
	));	

	$wp_customize->add_setting('food_grocery_store_footer_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_footer_background_color', array(
		'label'    => __('Footer Background Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_footer',
	)));

	$wp_customize->add_setting('food_grocery_store_footer_background_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'food_grocery_store_footer_background_image',array(
        'label' => __('Footer Background Image','food-grocery-store'),
        'section' => 'food_grocery_store_footer'
	)));

	$wp_customize->add_setting('food_grocery_store_footer_widgets_heading',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_footer_widgets_heading',array(
        'type' => 'select',
        'label' => __('Footer Widget Heading','food-grocery-store'),
        'section' => 'food_grocery_store_footer',
        'choices' => array(
        	'Left' => __('Left','food-grocery-store'),
            'Center' => __('Center','food-grocery-store'),
            'Right' => __('Right','food-grocery-store')
        ),
	) );

	$wp_customize->add_setting('food_grocery_store_footer_widgets_content',array(
        'default' => 'Left',
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_footer_widgets_content',array(
        'type' => 'select',
        'label' => __('Footer Widget Content','food-grocery-store'),
        'section' => 'food_grocery_store_footer',
        'choices' => array(
        	'Left' => __('Left','food-grocery-store'),
            'Center' => __('Center','food-grocery-store'),
            'Right' => __('Right','food-grocery-store')
        ),
	) );

	// footer padding
	$wp_customize->add_setting('food_grocery_store_footer_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_footer_padding',array(
		'label'	=> __('Footer Top Bottom Padding','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'food-grocery-store' ),
    ),
		'section'=> 'food_grocery_store_footer',
		'type'=> 'text'
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('food_grocery_store_footer_text', array( 
		'selector' => '.copyright p', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_footer_text', 
	));
	
	$wp_customize->add_setting('food_grocery_store_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('food_grocery_store_footer_text',array(
		'label'	=> esc_html__('Copyright Text','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Copyright 2020, .....', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_copyright_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_copyright_font_size',array(
		'label'	=> __('Copyright Font Size','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_copyright_alignment',array(
        'default' => 'center',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control(new Food_Grocery_Store_Image_Radio_Control($wp_customize, 'food_grocery_store_copyright_alignment', array(
        'type' => 'select',
        'label' => esc_html__('Copyright Alignment','food-grocery-store'),
        'section' => 'food_grocery_store_footer',
        'settings' => 'food_grocery_store_copyright_alignment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

    // footer social icon
  	$wp_customize->add_setting( 'food_grocery_store_footer_icon',array(
		'default' => false,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
  	$wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_footer_icon',array(
		'label' => esc_html__( 'Footer Social Icon','food-grocery-store' ),
		'section' => 'food_grocery_store_footer'
    )));

	$wp_customize->add_setting( 'food_grocery_store_footer_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_footer_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll to Top','food-grocery-store' ),
      	'section' => 'food_grocery_store_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('food_grocery_store_scroll_to_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_scroll_to_top_icon', 
	));

    $wp_customize->add_setting('food_grocery_store_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control(new Food_Grocery_Store_Image_Radio_Control($wp_customize, 'food_grocery_store_scroll_top_alignment', array(
        'type' => 'select',
        'label' => esc_html__('Scroll To Top','food-grocery-store'),
        'section' => 'food_grocery_store_footer',
        'settings' => 'food_grocery_store_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

     //Blog Post

	$BlogPostParentPanel = new Food_Grocery_Store_WP_Customize_Panel( $wp_customize, 'food_grocery_store_blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_panel_id',
		'priority' => 20,
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'food_grocery_store_post_settings', array(
		'title' => esc_html__( 'Post Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('food_grocery_store_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_toggle_postdate', 
	));

	$wp_customize->add_setting( 'food_grocery_store_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','food-grocery-store' ),
        'section' => 'food_grocery_store_post_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_toggle_author',array(
		'label' => esc_html__( 'Author','food-grocery-store' ),
		'section' => 'food_grocery_store_post_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_toggle_comments',array(
		'label' => esc_html__( 'Comments','food-grocery-store' ),
		'section' => 'food_grocery_store_post_settings'
    )));

     $wp_customize->add_setting( 'food_grocery_store_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_toggle_time',array(
		'label' => esc_html__( 'Time','food-grocery-store' ),
		'section' => 'food_grocery_store_post_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
	));
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_featured_image_hide_show', array(
		'label' => esc_html__( 'Featured Image','food-grocery-store' ),
		'section' => 'food_grocery_store_post_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'food_grocery_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'food_grocery_store_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','food-grocery-store' ),
		'section'     => 'food_grocery_store_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'food_grocery_store_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'food_grocery_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'food_grocery_store_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','food-grocery-store' ),
		'section'     => 'food_grocery_store_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting( 'food_grocery_store_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'food_grocery_store_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'food_grocery_store_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','food-grocery-store' ),
		'section'     => 'food_grocery_store_post_settings',
		'type'        => 'range',
		'settings'    => 'food_grocery_store_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('food_grocery_store_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','food-grocery-store'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','food-grocery-store'),
		'section'=> 'food_grocery_store_post_settings',
		'type'=> 'text'
	));

	//Blog layout
    $wp_customize->add_setting('food_grocery_store_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
    ));
    $wp_customize->add_control(new Food_Grocery_Store_Image_Radio_Control($wp_customize, 'food_grocery_store_blog_layout_option', array(
        'type' => 'select',
        'label' => esc_html__('Blog Layouts','food-grocery-store'),
        'section' => 'food_grocery_store_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('food_grocery_store_blog_page_posts_settings',array(
        'default' => 'Into Blocks',
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_blog_page_posts_settings',array(
        'type' => 'select',
        'label' => __('Display Blog Page posts','food-grocery-store'),
        'section' => 'food_grocery_store_post_settings',
        'choices' => array(
        	'Into Blocks' => __('Into Blocks','food-grocery-store'),
            'Without Blocks' => __('Without Blocks','food-grocery-store')
        ),
	) );

    $wp_customize->add_setting('food_grocery_store_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_excerpt_settings',array(
        'type' => 'select',
        'label' => esc_html__('Post Content','food-grocery-store'),
        'section' => 'food_grocery_store_post_settings',
        'choices' => array(
        	'Content' => esc_html__('Content','food-grocery-store'),
            'Excerpt' => esc_html__('Excerpt','food-grocery-store'),
            'No Content' => esc_html__('No Content','food-grocery-store')
        ),
	) );

    // Button Settings
	$wp_customize->add_section( 'food_grocery_store_button_settings', array(
		'title' => esc_html__( 'Button Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_blog_post_parent_panel',
	));

	$wp_customize->add_setting('food_grocery_store_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_button_padding_top_bottom',array(
		'label'	=> esc_html__('Padding Top Bottom','food-grocery-store'),
		'description' => esc_html__('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'food-grocery-store' ),
        ),
		'section' => 'food_grocery_store_button_settings',
		'type' => 'text'
	));

	$wp_customize->add_setting('food_grocery_store_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_button_padding_left_right',array(
		'label'	=> esc_html__('Padding Left Right','food-grocery-store'),
		'description' => esc_html__('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '10px', 'food-grocery-store' ),
        ),
		'section' => 'food_grocery_store_button_settings',
		'type' => 'text'
	));

	$wp_customize->add_setting( 'food_grocery_store_button_border_radius', array(
		'default'              => 5,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'food_grocery_store_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'food_grocery_store_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','food-grocery-store' ),
		'section'     => 'food_grocery_store_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	// font size button
	$wp_customize->add_setting('food_grocery_store_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_button_font_size',array(
		'label'	=> __('Button Font Size','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
      'placeholder' => __( '10px', 'food-grocery-store' ),
    ),
    'type'        => 'text',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
		'section'=> 'food_grocery_store_button_settings',
	));

	// text trasform
	$wp_customize->add_setting('food_grocery_store_button_text_transform',array(
		'default'=> 'Uppercase',
		'sanitize_callback'	=> 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_button_text_transform',array(
		'type' => 'radio',
		'label'	=> __('Button Text Transform','food-grocery-store'),
		'choices' => array(
            'Uppercase' => __('Uppercase','food-grocery-store'),
            'Capitalize' => __('Capitalize','food-grocery-store'),
            'Lowercase' => __('Lowercase','food-grocery-store'),
        ),
		'section'=> 'food_grocery_store_button_settings',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('food_grocery_store_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_button_text', 
	));

    $wp_customize->add_setting('food_grocery_store_button_text',array(
		'default'=> esc_html__('READ MORE','food-grocery-store'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_button_text',array(
		'label'	=> esc_html__('Add Button Text','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'READ MORE', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_button_settings',
		'type'=> 'text'
	));

	// Related Post Settings
	$wp_customize->add_section( 'food_grocery_store_related_posts_settings', array(
		'title' => esc_html__( 'Related Posts Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('food_grocery_store_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_related_post_title', 
	));

    $wp_customize->add_setting( 'food_grocery_store_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_related_post',array(
		'label' => esc_html__( 'Related Post','food-grocery-store' ),
		'section' => 'food_grocery_store_related_posts_settings'
    )));

    $wp_customize->add_setting('food_grocery_store_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_related_post_title',array(
		'label'	=> esc_html__('Add Related Post Title','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( 'Related Post', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('food_grocery_store_related_posts_count',array(
		'default'=> 3,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_related_posts_count',array(
		'label'	=> esc_html__('Add Related Post Count','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => esc_html__( '3', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_related_posts_settings',
		'type'=> 'number'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'food_grocery_store_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_blog_post_parent_panel',
	));

	$wp_customize->add_setting('food_grocery_store_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','food-grocery-store'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','food-grocery-store'),
		'section'=> 'food_grocery_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'food_grocery_store_single_post_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_post_breadcrumb',array(
		'label' => esc_html__( 'Single Post Breadcrumb','food-grocery-store' ),
		'section' => 'food_grocery_store_single_blog_settings'
    )));

    // Single Posts Category
  	$wp_customize->add_setting( 'food_grocery_store_single_post_category',array(
		'default' => true,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
  	$wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_post_category',array(
		'label' => esc_html__( 'Single Post Category','food-grocery-store' ),
		'section' => 'food_grocery_store_single_blog_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_single_postdate',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'food_grocery_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_postdate',array(
	    'label' => esc_html__( 'Date','food-grocery-store' ),
	   'section' => 'food_grocery_store_single_blog_settings'
	)));

    $wp_customize->add_setting( 'food_grocery_store_single_author',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'food_grocery_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_author',array(
	    'label' => esc_html__( 'Author','food-grocery-store' ),
	    'section' => 'food_grocery_store_single_blog_settings'
	)));

	$wp_customize->add_setting( 'food_grocery_store_single_comments',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'food_grocery_store_switch_sanitization'
	) );
	$wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_comments',array(
	    'label' => esc_html__( 'Comments','food-grocery-store' ),
	    'section' => 'food_grocery_store_single_blog_settings'
	)));

	$wp_customize->add_setting( 'food_grocery_store_single_time',array(
	    'default' => 1,
	    'transport' => 'refresh',
	    'sanitize_callback' => 'food_grocery_store_switch_sanitization'
	) );

	$wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_time',array(
	    'label' => esc_html__( 'Time','food-grocery-store' ),
	    'section' => 'food_grocery_store_single_blog_settings'
	)));

	$wp_customize->add_setting( 'food_grocery_store_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
	));
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_toggle_tags', array(
		'label' => esc_html__( 'Tags','food-grocery-store' ),
		'section' => 'food_grocery_store_single_blog_settings'
    )));

    $wp_customize->add_setting('food_grocery_store_single_blog_comment_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('food_grocery_store_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Leave a Reply', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_single_blog_comment_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('food_grocery_store_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','food-grocery-store'),
		'description'	=> __('Enter a value in %. Example:50%','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_single_blog_settings',
		'type'=> 'text'
	));

	// Grid layout setting

	$wp_customize->add_section( 'food_grocery_store_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_blog_post_parent_panel',
	));

	$wp_customize->add_setting( 'food_grocery_store_grid_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_grid_postdate',array(
        'label' => esc_html__( 'Post Date','food-grocery-store' ),
        'section' => 'food_grocery_store_grid_layout_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_grid_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_grid_author',array(
		'label' => esc_html__( 'Author','food-grocery-store' ),
		'section' => 'food_grocery_store_grid_layout_settings'
    )));

    $wp_customize->add_setting( 'food_grocery_store_grid_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_grid_comments',array(
		'label' => esc_html__( 'Comments','food-grocery-store' ),
		'section' => 'food_grocery_store_grid_layout_settings'
    )));

	//Other Settings
	$wp_customize->add_panel( 'food_grocery_store_other_panel', array(
		'title' => esc_html__( 'Other Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_panel_id',
		'priority' => 20,
	));

	// Layout
	$wp_customize->add_section( 'food_grocery_store_left_right', array(
    	'title' => esc_html__( 'General Settings', 'food-grocery-store' ),
		'panel' => 'food_grocery_store_other_panel'
	) );

	$wp_customize->add_setting('food_grocery_store_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control(new Food_Grocery_Store_Image_Radio_Control($wp_customize, 'food_grocery_store_width_option', array(
        'type' => 'select',
        'label' => esc_html__('Width Layouts','food-grocery-store'),
        'description' => esc_html__('Here you can change the width layout of Website.','food-grocery-store'),
        'section' => 'food_grocery_store_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	$wp_customize->add_setting('food_grocery_store_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_theme_options',array(
        'type' => 'select',
        'label' => esc_html__('Post Sidebar Layout','food-grocery-store'),
        'description' => esc_html__('Here you can change the sidebar layout for posts. ','food-grocery-store'),
        'section' => 'food_grocery_store_left_right',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','food-grocery-store'),
            'Right Sidebar' => esc_html__('Right Sidebar','food-grocery-store'),
            'One Column' => esc_html__('One Column','food-grocery-store'),
            'Three Columns' => esc_html__('Three Columns','food-grocery-store'),
            'Four Columns' => esc_html__('Four Columns','food-grocery-store'),
            'Grid Layout' => esc_html__('Grid Layout','food-grocery-store')
        ),
	) );

	$wp_customize->add_setting('food_grocery_store_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_page_layout',array(
        'type' => 'select',
        'label' => esc_html__('Page Sidebar Layout','food-grocery-store'),
        'description' => esc_html__('Here you can change the sidebar layout for pages. ','food-grocery-store'),
        'section' => 'food_grocery_store_left_right',
        'choices' => array(
            'Left Sidebar' => esc_html__('Left Sidebar','food-grocery-store'),
            'Right Sidebar' => esc_html__('Right Sidebar','food-grocery-store'),
            'One Column' => esc_html__('One Column','food-grocery-store')
        ),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('food_grocery_store_responsive_media',array(
		'title'	=> esc_html__('Responsive Media','food-grocery-store'),
		'panel' => 'food_grocery_store_other_panel',
	));

    $wp_customize->add_setting( 'food_grocery_store_resp_slider_hide_show',array(
      	'default' => 0,
     	'transport' => 'refresh',
      	'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_resp_slider_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Slider','food-grocery-store' ),
      	'section' => 'food_grocery_store_responsive_media'
    )));

    $wp_customize->add_setting( 'food_grocery_store_sidebar_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_sidebar_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Sidebar','food-grocery-store' ),
      	'section' => 'food_grocery_store_responsive_media'
    )));

    $wp_customize->add_setting( 'food_grocery_store_resp_scroll_top_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));  
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_resp_scroll_top_hide_show',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','food-grocery-store' ),
      	'section' => 'food_grocery_store_responsive_media'
    )));

    $wp_customize->add_setting('food_grocery_store_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Food_Grocery_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'food_grocery_store_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','food-grocery-store'),
		'transport' => 'refresh',
		'section'	=> 'food_grocery_store_responsive_media',
		'setting'	=> 'food_grocery_store_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('food_grocery_store_res_close_menus_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new Food_Grocery_Store_Fontawesome_Icon_Chooser(
        $wp_customize,'food_grocery_store_res_close_menus_icon',array(
		'label'	=> __('Add Close Menu Icon','food-grocery-store'),
		'transport' => 'refresh',
		'section'	=> 'food_grocery_store_responsive_media',
		'setting'	=> 'food_grocery_store_res_close_menus_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('food_grocery_store_resp_menu_toggle_btn_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_resp_menu_toggle_btn_bg_color', array(
		'label'    => __('Toggle Button Bg Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_responsive_media',
	)));

	//No Result Page Setting
	$wp_customize->add_section('food_grocery_store_no_results_page',array(
		'title'	=> __('No Results Page Settings','food-grocery-store'),
		'panel' => 'food_grocery_store_other_panel',
	));	

	$wp_customize->add_setting('food_grocery_store_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('food_grocery_store_no_results_page_title',array(
		'label'	=> __('Add Title','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('food_grocery_store_no_results_page_content',array(
		'label'	=> __('Add Text','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_no_results_page',
		'type'=> 'text'
	));


	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'food_grocery_store_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_woocommerce_shop_page_sidebar', ) );

    //Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'food_grocery_store_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','food-grocery-store' ),
		'section' => 'food_grocery_store_left_right'
    )));

    $wp_customize->add_setting('food_grocery_store_shop_page_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_shop_page_layout',array(
        'type' => 'select',
        'label' => __('Shop Page Sidebar Layout','food-grocery-store'),
        'section' => 'food_grocery_store_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','food-grocery-store'),
            'Right Sidebar' => __('Right Sidebar','food-grocery-store'),
        ),
	) );

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'food_grocery_store_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'food_grocery_store_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','food-grocery-store' ),
		'section' => 'food_grocery_store_left_right'
    )));

    $wp_customize->add_setting('food_grocery_store_single_product_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_single_product_layout',array(
        'type' => 'select',
        'label' => __('Single Product Sidebar Layout','food-grocery-store'),
        'section' => 'food_grocery_store_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','food-grocery-store'),
            'Right Sidebar' => __('Right Sidebar','food-grocery-store'),
        ),
	) );

    $wp_customize->add_setting( 'food_grocery_store_single_page_breadcrumb',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_single_page_breadcrumb',array(
		'label' => esc_html__( 'Single Page Breadcrumb','food-grocery-store' ),
		'section' => 'food_grocery_store_left_right'
    )));

     //Wow Animation
	$wp_customize->add_setting( 'food_grocery_store_animation',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ));
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_animation',array(
        'label' => esc_html__( 'Animations','food-grocery-store' ),
        'description' => __('Here you can disable overall site animation effect','food-grocery-store'),
        'section' => 'food_grocery_store_left_right'
    )));

    $wp_customize->add_setting('food_grocery_store_reset_all_settings',array(
      'sanitize_callback'	=> 'sanitize_text_field',
   	));
   	$wp_customize->add_control(new Food_Grocery_Store_Reset_Custom_Control($wp_customize, 'food_grocery_store_reset_all_settings',array(
      'type' => 'reset_control',
      'label' => __('Reset All Settings', 'food-grocery-store'),
      'description' => 'food_grocery_store_reset_all_settings',
      'section' => 'food_grocery_store_left_right'
   	)));

    //Pre-Loader
	$wp_customize->add_setting( 'food_grocery_store_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'food_grocery_store_switch_sanitization'
    ) );
    $wp_customize->add_control( new Food_Grocery_Store_Toggle_Switch_Custom_Control( $wp_customize, 'food_grocery_store_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','food-grocery-store' ),
        'section' => 'food_grocery_store_left_right'
    )));

	$wp_customize->add_setting('food_grocery_store_preloader_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_left_right',
	)));

	$wp_customize->add_setting('food_grocery_store_preloader_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'food_grocery_store_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'food-grocery-store'),
		'section'  => 'food_grocery_store_left_right',
	)));

    //Woocommerce settings
	$wp_customize->add_section('food_grocery_store_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'food-grocery-store'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	//Products per page
    $wp_customize->add_setting('food_grocery_store_products_per_page',array(
		'default'=> '9',
		'sanitize_callback'	=> 'food_grocery_store_sanitize_float'
	));
	$wp_customize->add_control('food_grocery_store_products_per_page',array(
		'label'	=> __('Products Per Page','food-grocery-store'),
		'description' => __('Display on shop page','food-grocery-store'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('food_grocery_store_products_per_row',array(
		'default'=> '3',
		'sanitize_callback'	=> 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_products_per_row',array(
		'label'	=> __('Products Per Row','food-grocery-store'),
		'description' => __('Display on shop page','food-grocery-store'),
		'choices' => array(
            '2' => '2',
			'3' => '3',
			'4' => '4',
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'select',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'food_grocery_store_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar', 
		'render_callback' => 'food_grocery_store_customize_partial_food_grocery_store_woocommerce_shop_page_sidebar', ) );

	$wp_customize->add_setting('food_grocery_store_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'text'
	));

	//Products Sale Badge
	$wp_customize->add_setting('food_grocery_store_woocommerce_sale_position',array(
        'default' => 'right',
        'sanitize_callback' => 'food_grocery_store_sanitize_choices'
	));
	$wp_customize->add_control('food_grocery_store_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','food-grocery-store'),
        'section' => 'food_grocery_store_woocommerce_section',
        'choices' => array(
            'left' => __('Left','food-grocery-store'),
            'right' => __('Right','food-grocery-store'),
        ),
	) );

	$wp_customize->add_setting('food_grocery_store_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('food_grocery_store_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('food_grocery_store_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','food-grocery-store'),
		'description'	=> __('Enter a value in pixels. Example:20px','food-grocery-store'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'food-grocery-store' ),
        ),
		'section'=> 'food_grocery_store_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'food_grocery_store_woocommerce_sale_border_radius', array(
		'default'              => '5',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'food_grocery_store_sanitize_number_range'
	) );
	$wp_customize->add_control( 'food_grocery_store_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','food-grocery-store' ),
		'section'     => 'food_grocery_store_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    // Has to be at the top
	$wp_customize->register_panel_type( 'Food_Grocery_Store_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'Food_Grocery_Store_WP_Customize_Section' );
}

add_action( 'customize_register', 'food_grocery_store_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class Food_Grocery_Store_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'food_grocery_store_panel';
	    public function json() {
			$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
			$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content'] = $this->get_content();
			$array['active'] = $this->active();
			$array['instanceNumber'] = $this->instance_number;
			return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class Food_Grocery_Store_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'food_grocery_store_section';
	    public function json() {
			$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
			$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content'] = $this->get_content();
			$array['active'] = $this->active();
			$array['instanceNumber'] = $this->instance_number;

			if ( $this->panel ) {
			$array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
			} else {
			$array['customizeAction'] = 'Customizing';
			}
			return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function food_grocery_store_customize_controls_scripts() {
	wp_enqueue_script( 'food-grocery-store-customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'food_grocery_store_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Food_Grocery_Store_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Food_Grocery_Store_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Food_Grocery_Store_Customize_Section_Pro( $manager,'food_grocery_store_upgrade_pro_link', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Food Grocery Store Pro', 'food-grocery-store' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'food-grocery-store' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/grocery-store-wordpress-theme/'),
		) )	);

		// Register sections.
		$manager->add_section(new Food_Grocery_Store_Customize_Section_Pro($manager,'food_grocery_store_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'Documentation', 'food-grocery-store' ),
			'pro_text' => esc_html__( 'Docs', 'food-grocery-store' ),
			'pro_url'  => esc_url('https://vwthemesdemo.com/docs/free-food-grocery-store/'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'food-grocery-store-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'food-grocery-store-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );

		wp_localize_script(
		'food-grocery-store-customize-controls',
		'food_grocery_store_customizer_params',
		array(
			'ajaxurl' =>	admin_url( 'admin-ajax.php' )
		));
	}
}

// Doing this customizer thang!
Food_Grocery_Store_Customize::get_instance();