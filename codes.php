<?php

# Edit search posts per page

function pd_search_posts_per_page($query) {
    if ( $query->is_search ) {
        $query->set( 'posts_per_page', '25' );
    }
    return $query;
}

add_filter( 'pre_get_posts','pd_search_posts_per_page' );


# Remove Taxonomies from archive
add_filter( 'get_the_archive_title', 'my_theme_archive_title' );

/**
 * Remove archive labels.
 * 
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
 
function my_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
}

# Add custom image size
add_image_size( 'name_of_image_size', 800, 600, true ); // widthpx x heightpx, hard crop mode

# Register the three useful image sizes for use in Add Media modal
add_filter( 'image_size_names_choose', 'wpshout_custom_sizes' );
function wpshout_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        '1440p' => __( '1440p' ),
        '1800p' => __( '1800p' ),
        '4k' => __( '4k' ),
    ) );
}

# Remove "Category" from archives
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}

add_filter( 'get_the_archive_title', 'prefix_category_title' );

# Add custom contact method
add_filter('user_contactmethods', 'custom_user_contactmethods');

function custom_user_contactmethods($user_contact) {
    $user_contact['ext_phone'] = 'Phone number';
    
    return $user_contact;
    
}

# SK Google Tag Manager for Oxygen
add_action( 'wp_head', 'sk_google_tag_manager1', 1 );

// Adds Google Tag Manager code in <head> below the <title>.

function sk_google_tag_manager1() { ?>

	<!-- Google Tag Manager -->
	<!-- Insert Google Tag Manager Code here -->
	<!-- End Google Tag Manager -->

<?php }

add_action( 'ct_before_builder', 'sk_google_tag_manager2' );

// Adds Google Tag Manager code immediately after the opening <body> tag.

function sk_google_tag_manager2() { ?>

	<!-- Google Tag Manager (noscript) -->
	<!-- Insert Google Tag Manager Code here -->
	<!-- End Google Tag Manager (noscript) -->

<?php }

# Change excerpt length
add_filter( 'excerpt_length', function($length) {
    return 18;
} );

# Allow all file type upload
define('ALLOW_UNFILTERED_UPLOADS', true);

# Redirect specific user role to a page
if( current_user_can('Role Function') || current_user_can('subscriber') ) {
    add_action('wp_logout','redirect_to_logged_off');
    function redirect_to_page(){
        wp_redirect( '/page-you-lead-them' );
        exit();
    }
}

# Add or remove role
add_role( 'Role', 'Role');
remove_role( 'Role', 'Role');

?>
