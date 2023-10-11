<?php

function load_css()
{
	wp_register_style("bootstrap", get_template_directory_uri() . "/css/bootstrap.min.css", array(), false, "all");
	wp_enqueue_style("bootstrap");
}
add_action("wp_enqueue_scripts", "load_css");

function load_js()
{
	wp_enqueue_script("jquery");
	wp_register_script("bootstrap", get_template_directory_uri() . "/js/bootstrap.min.js", "jquery", false, true);
	wp_enqueue_script("bootstrap");
}

add_action("wp_enqueue_scripts", "load_js");


function register_my_menus() {
  register_nav_menus(
    array(
      'footer-menu' => __( 'Footer Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );


class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth );
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'nav-item';
    $classes[] = 'nav-item-' . $item->ID;
    if ( $depth && $args->has_children ) {
      $classes[] = 'dropdown';
    }
    if ( in_array( 'current-menu-item', $classes ) ) {
      $classes[] = 'active';
    }
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
    $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
    $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
    $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
    $attributes .= $depth == 0 ? ' class="nav-link"' : ' class="dropdown-item"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth );
    $output .= "$indent</ul>\n";
  }
}


//add the customizer setting for the logo image

function affsquare_customize_register( $wp_customize ) {
    // Add a customizer setting for the logo image
    $wp_customize->add_setting( 'affsquare_logo' );

    // Add a control for the logo image
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'affsquare_logo', array(
        'label' => __( 'Logo Image', 'affsquare' ),
        'section' => 'title_tagline',
        'settings' => 'affsquare_logo',
    ) ) );
}
add_action( 'customize_register', 'affsquare_customize_register' );


//add a new post type in WordPress to manage team members

function affsquare_register_team_member_post_type() {
    $labels = array(
        'name' => __( 'Team Members', 'affsquare' ),
        'singular_name' => __( 'Team Member', 'affsquare' ),
        'add_new' => __( 'Add New', 'affsquare' ),
        'add_new_item' => __( 'Add New Team Member', 'affsquare' ),
        'edit_item' => __( 'Edit Team Member', 'affsquare' ),
        'new_item' => __( 'New Team Member', 'affsquare' ),
        'view_item' => __( 'View Team Member', 'affsquare' ),
        'search_items' => __( 'Search Team Members', 'affsquare' ),
        'not_found' => __( 'No team members found', 'affsquare' ),
        'not_found_in_trash' => __( 'No team members found in trash', 'affsquare' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'affsquare' ),
        'menu_name' => __( 'Team Members', 'affsquare' ),
    );

    $args = array(
        'labels' => $labels,
        'description' => __( 'A custom post type for managing team members', 'affsquare' ),
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'team-members' ),
    );

    register_post_type( 'team_member', $args );
}
add_action( 'init', 'affsquare_register_team_member_post_type' );

// Add custom meta box for team member image
function affsquare_add_team_member_image_meta_box() {
    add_meta_box(
        'affsquare_team_member_image',
        __( 'Team Member Image', 'affsquare' ),
        'affsquare_team_member_image_meta_box_callback',
        'team_member',
        'side'
    );
}
add_action( 'add_meta_boxes', 'affsquare_add_team_member_image_meta_box' );

// Callback function for team member image meta box
function affsquare_team_member_image_meta_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'affsquare_team_member_image_nonce' );
    $team_member_image = get_post_meta( $post->ID, 'team_member_image', true );
    ?>
    <p>
        <label for="team_member_image"><?php _e( 'Upload an image for the team member:', 'affsquare' ); ?></label><br>
        <input type="text" name="team_member_image" id="team_member_image" value="<?php echo esc_attr( $team_member_image ); ?>" class="widefat">
        <button class="button button-secondary" id="team_member_image_button"><?php _e( 'Choose Image', 'affsquare' ); ?></button>
    </p>
    <script>
        jQuery(document).ready(function($){
            var mediaUploader;
            $('#team_member_image_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: '<?php _e( "Choose Image", "affsquare" ); ?>',
                    button: {
                        text: '<?php _e( "Choose Image", "affsquare" ); ?>'
                    },
                    multiple: false
                });
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#team_member_image').val(attachment.url);
                });
                mediaUploader.open();
            });
        });
    </script>
    <?php
}

// Save team member image meta box data
function affsquare_save_team_member_image_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['affsquare_team_member_image_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['affsquare_team_member_image_nonce'], basename( __FILE__ ) ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['post_type'] ) && 'team_member' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    if ( ! isset( $_POST['team_member_image'] ) ) {
        return;
    }
    $team_member_image = sanitize_text_field( $_POST['team_member_image'] );
    update_post_meta( $post_id, 'team_member_image', $team_member_image );
}
add_action( 'save_post', 'affsquare_save_team_member_image_meta_box_data' );
