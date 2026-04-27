<?php

$region_map = [
    'Sheffield'  => 'sheffield-derbyshire',
    'Leeds'      => 'leeds-yorkshire',
    'Manchester' => 'manchester-cheshire',
    'Lancashire' => 'liverpool-lancashire',
    'Newcastle'  => 'newcastle-north-east',
];

// Clear existing events
$existing = get_posts(['post_type' => 'event', 'posts_per_page' => -1, 'fields' => 'ids']);
foreach ($existing as $id) {
    wp_delete_post($id, true);
}
echo "Cleared existing events\n";

// Parse the SQL dump
$sql = file_get_contents( ABSPATH . 'gigs.sql' );

// Extract all INSERT rows
preg_match_all(
    '/\((\d+),\s*\'((?:[^\'\\\\]|\\\\.)*)\',\s*\'((?:[^\'\\\\]|\\\\.)*)\',\s*\'((?:[^\'\\\\]|\\\\.)*)\',\s*\'((?:[^\'\\\\]|\\\\.)*)\'\)/',
    $sql,
    $matches,
    PREG_SET_ORDER
);

$created = 0;
$skipped = 0;

foreach ( $matches as $match ) {
    $id          = $match[1];
    $venue       = stripslashes( $match[2] );
    $place       = stripslashes( $match[3] );
    $description = stripslashes( $match[4] );
    $region      = stripslashes( $match[5] );

    if ( ! isset( $region_map[ $region ] ) ) {
        echo "Skipping (region: $region): $venue\n";
        $skipped++;
        continue;
    }

    $location_slug = $region_map[ $region ];
    $venue_name    = $venue . ', ' . $place;
    $post_title    = $venue . ' - ' . $description;

    $post_id = wp_insert_post([
        'post_title'   => $post_title,
        'post_content' => '',
        'post_type'    => 'event',
        'post_status'  => 'publish',
    ]);

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_field( 'venue_name', $venue_name, $post_id );
        update_field( 'event_description', $description, $post_id );
        update_field( 'is_upcoming', false, $post_id );

        $term = get_term_by( 'slug', $location_slug, 'location' );
        if ( $term ) {
            wp_set_object_terms( $post_id, $term->term_id, 'location' );
        }

        echo "Created: $post_title\n";
        $created++;
    } else {
        echo "Failed: $post_title\n";
    }
}

echo "\nDone! Created: $created — Skipped: $skipped\n";