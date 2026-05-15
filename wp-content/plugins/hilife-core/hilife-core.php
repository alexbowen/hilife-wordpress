<?php
/**
 * Plugin Name: Hi-Life Core
 * Description: Core functionality for Hi-Life Entertainment
 * Version: 1.0
 */

// ── INIT — CPT/Taxonomy registration + rewrite rules + nav menus ──
add_action( 'init', function() {

    register_nav_menus([
        'primary' => 'Primary Navigation',
    ]);

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

// ── QUERY VARS ──
add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'occasion_slug';
    $vars[] = 'location_slug';
    return $vars;
});

// ── QUERY LOOP BLOCK ──
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

// ── TEMPLATE REDIRECT — Intersection pages ──
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

// ── TEMPLATE INCLUDE — Custom templates ──
add_filter( 'template_include', function( $template ) {
    if ( is_page() && !is_page('contact') ) {
        $custom = get_template_directory() . '/templates/page.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    if ( is_home() ) {
        $custom = get_template_directory() . '/templates/archive-blog.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    if ( is_singular('post') ) {
        $custom = get_template_directory() . '/templates/single-blog.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    if ( is_page('contact') ) {
        $custom = get_template_directory() . '/templates/contact.php';
        if ( file_exists( $custom ) ) return $custom;
    }
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

// ── ENQUEUE SCRIPTS ──
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

// ── REST API — Header endpoint ──
add_action('rest_api_init', function() {
    register_rest_route('hilife/v1', '/header', [
        'methods'  => 'GET',
        'callback' => function($request) {
            define('HILIFE_HEADER_FETCH', true);

            $GLOBALS['hilife_header_auth'] = [
                'authenticated' => $request->get_param('authenticated') === 'true',
                'is_admin'      => $request->get_param('is_admin') === 'true',
                'is_internal'   => $request->get_param('is_internal') === 'true',
                'is_customer'   => $request->get_param('is_customer') === 'true',
            ];

            error_log('HILIFE HEADER AUTH: ' . print_r($GLOBALS['hilife_header_auth'], true));

            ob_start();
            include get_template_directory() . '/header-hilife.php';
            $html = ob_get_clean();
            return new WP_REST_Response(['html' => $html], 200);
        },
        'permission_callback' => '__return_true',
        'args' => [
            'authenticated' => ['type' => 'string', 'default' => 'false'],
            'is_admin'      => ['type' => 'string', 'default' => 'false'],
            'is_internal'   => ['type' => 'string', 'default' => 'false'],
            'is_customer'   => ['type' => 'string', 'default' => 'false'],
        ],
    ]);
});

add_action('rest_api_init', function() {
    register_rest_route('hilife/v1', '/footer', [
        'methods'  => 'GET',
        'callback' => function() {
            ob_start();
            include get_template_directory() . '/footer-hilife.php';
            $html = ob_get_clean();
            return new WP_REST_Response(['html' => $html], 200);
        },
        'permission_callback' => '__return_true',
    ]);
});

// ── NAV MENU — Hide Sign In when authenticated ──
add_filter('wp_nav_menu_objects', function($items, $args) {
    if ($args->theme_location !== 'primary') return $items;

    if ( defined('HILIFE_HEADER_FETCH') ) {
        $auth = $GLOBALS['hilife_header_auth'] ?? [];
        $is_authenticated = $auth['authenticated'] ?? false;
    } else {
        $session_id = $_COOKIE['PHPSESSID'] ?? '';
        $context = stream_context_create([
            'http' => [
                'header' => "Cookie: PHPSESSID=" . $session_id . "\r\n",
            ]
        ]);
        $auth_status = @json_decode(file_get_contents(home_url('/auth/status'), false, $context), true);
        $is_authenticated = $auth_status['authenticated'] ?? false;
    }

    if ($is_authenticated) {
        $items = array_filter($items, function($item) {
            return strpos($item->url, '/account/sign-in') === false;
        });
    }

    return $items;
}, 10, 2);