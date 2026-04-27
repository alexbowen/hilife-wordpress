<?php
/**
 * Plugin Name: Hi-Life Core
 * Description: Core functionality for Hi-Life Entertainment
 * Version: 1.0
 */

add_action( 'init', function() {
    $occasions = get_terms([
        'taxonomy'   => 'occasion',
        'hide_empty' => false,
        'fields'     => 'slugs',
    ]);

    if ( empty( $occasions ) || is_wp_error( $occasions ) ) return;

    foreach ( $occasions as $slug ) {
        add_rewrite_rule(
            '^' . preg_quote( $slug ) . '/([^/]+)/?$',
            'index.php?occasion_slug=' . $slug . '&location_slug=$matches[1]',
            'top'
        );
    }
}, 99 );

add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'occasion_slug';
    $vars[] = 'location_slug';
    return $vars;
});

add_filter( 'query_loop_block_query_vars', function( $query, $block, $page ) {
    if ( is_tax( 'location' ) ) {
        $term = get_queried_object();
        $query['tax_query'] = [[
            'taxonomy' => 'location',
            'field'    => 'slug',
            'terms'    => $term->slug,
        ]];
        $query['post_type'] = 'event';
    }
    if ( is_tax( 'occasion' ) ) {
        $term = get_queried_object();
        $query['tax_query'] = [[
            'taxonomy' => 'occasion',
            'field'    => 'slug',
            'terms'    => $term->slug,
        ]];
        $query['post_type'] = 'event';
    }
    if ( is_tax( 'service' ) ) {
        $term = get_queried_object();
        $query['tax_query'] = [[
            'taxonomy' => 'service',
            'field'    => 'slug',
            'terms'    => $term->slug,
        ]];
        $query['post_type'] = 'event';
    }
    return $query;
}, 10, 3 );

add_action( 'template_redirect', function() {
    $parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    
    if ( count($parts) !== 2 ) return;
    
    $occasion_slug = $parts[0];
    $location_slug = $parts[1];

    $occasion = get_term_by( 'slug', $occasion_slug, 'occasion' );
    $location = get_term_by( 'slug', $location_slug, 'location' );

    if ( ! $occasion || ! $location ) return;

    add_filter( 'template_include', function() {
        return get_template_directory() . '/templates/occasion-location.php';
    });
});

add_filter( 'template_include', function( $template ) {
    if ( is_tax( 'location' ) ) {
        $custom = get_template_directory() . '/templates/taxonomy-location.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    if ( is_tax( 'occasion' ) ) {
        $custom = get_template_directory() . '/templates/taxonomy-occasion.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    if ( is_tax( 'service' ) ) {
        $custom = get_template_directory() . '/templates/taxonomy-service.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    if ( is_post_type_archive( 'djs' ) ) {
    $custom = get_template_directory() . '/templates/archive-dj.php';
    if ( file_exists( $custom ) ) return $custom;
}
if ( is_singular( 'music-theme' ) ) {
    $custom = get_template_directory() . '/templates/single-music-theme.php';
    if ( file_exists( $custom ) ) return $custom;
}
if ( is_post_type_archive( 'music-theme' ) ) {
    $custom = get_template_directory() . '/templates/archive-music.php';
    if ( file_exists( $custom ) ) return $custom;
}
if ( is_singular( 'djs' ) ) {
    $custom = get_template_directory() . '/templates/single-dj.php';
    if ( file_exists( $custom ) ) return $custom;
}
if ( is_front_page() ) {
    $custom = get_template_directory() . '/templates/front-page.php';
    if ( file_exists( $custom ) ) return $custom;
}
    return $template;
});

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'hilife-fonts',
        'https://fonts.googleapis.com/css2?family=Lekton:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'hilife',
        get_template_directory_uri() . '/hilife.css',
        ['hilife-fonts'],
        '1.0.0'
    );
});

add_action( 'init', function() {
    register_nav_menus([
        'primary' => 'Primary Navigation',
    ]);
}, 10 );