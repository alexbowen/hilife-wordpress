<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php include( get_template_directory() . '/header-hilife.php' ); ?>

<?php
$parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$occasion_slug = $parts[0] ?? '';
$location_slug = $parts[1] ?? '';

$occasion = get_term_by('slug', $occasion_slug, 'occasion');
$location = get_term_by('slug', $location_slug, 'location');

$landing_pages = new WP_Query([
    'post_type'   => 'landing_page',
    'post_status' => ['publish', 'draft'],
    'meta_query'  => [
        'relation' => 'AND',
        [
            'key'     => 'occasion_term',
            'value'   => $occasion ? $occasion->term_id : 0,
            'compare' => 'LIKE',
        ],
        [
            'key'     => 'location_term',
            'value'   => $location ? $location->term_id : 0,
            'compare' => 'LIKE',
        ],
    ],
]);

$landing = $landing_pages->have_posts() ? $landing_pages->posts[0] : null;
$headline = $landing ? get_field('landing_headline', $landing->ID) : null;
$intro    = $landing ? get_field('landing_intro', $landing->ID) : null;
wp_reset_postdata();

$headline = $headline ?: ( $occasion->name . ' in ' . $location->name );

$events = new WP_Query([
    'post_type'      => 'event',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query' => [
        'relation' => 'AND',
        [
            'taxonomy' => 'occasion',
            'field'    => 'slug',
            'terms'    => $occasion_slug,
        ],
        [
            'taxonomy' => 'location',
            'field'    => 'slug',
            'terms'    => $location_slug,
        ],
    ],
]);

$feedback = new WP_Query([
    'post_type'      => 'feedback',
    'posts_per_page' => 2,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query' => [
        'relation' => 'AND',
        [
            'taxonomy' => 'occasion',
            'field'    => 'slug',
            'terms'    => $occasion_slug,
        ],
        [
            'taxonomy' => 'location',
            'field'    => 'slug',
            'terms'    => $location_slug,
        ],
    ],
]);
?>

<main class="hilife-main">

<!-- Hero -->
<?php
$hero_image = $landing ? get_field('landing_hero_image', $landing->ID) : null;
?>
<div class="hilife-hero" <?php if ( $hero_image ) : ?>style="position:relative;min-height:460px;display:flex;align-items:flex-end;" <?php endif; ?>>
    <?php if ( $hero_image ) : ?>
        <div style="position:absolute;inset:0;background-image:url('<?php echo esc_url($hero_image['url']); ?>');background-size:cover;background-position:center;filter:brightness(0.6);"></div>
        <div style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,15,14,0.95) 0%, rgba(15,15,14,0.4) 60%, rgba(15,15,14,0.2) 100%);"></div>
    <?php endif; ?>
    <div class="hilife-hero-inner" style="position:relative;z-index:1;<?php if ( $hero_image ) : ?>padding-bottom:var(--space-lg);<?php endif; ?>">
        <div class="hilife-eyebrow">
            <?php echo esc_html( $occasion->name ); ?>
            &nbsp;·&nbsp;
            <?php echo esc_html( $location->name ); ?>
        </div>
        <h1><?php echo esc_html( $headline ); ?></h1>
        <?php if ( $intro ) : ?>
            <p class="hilife-intro"><?php echo esc_html( $intro ); ?></p>
        <?php elseif ( ! $hero_image ) : ?>
            <div class="hilife-placeholder" style="aspect-ratio:16/5">
                <span class="hilife-placeholder-label">Intro copy</span>
                <span class="hilife-placeholder-sub">Add a landing page for this combination to show unique content here</span>
            </div>
        <?php endif; ?>
    </div>
</div>

    <!-- Events -->
    <div class="hilife-container hilife-section">
        <div class="hilife-section-label">Recent Events</div>
        <?php if ( $events->have_posts() ) : ?>
            <ul class="hilife-events">
            <?php while ( $events->have_posts() ) : $events->the_post();
                $venue = get_field('venue_name', get_the_ID());
                $desc  = get_field('event_description', get_the_ID());
            ?>
                <li class="hilife-event">
                    <div>
                        <div class="hilife-event-venue"><?php echo esc_html( $venue ?: get_the_title() ); ?></div>
                        <?php if ( $desc ) : ?>
                            <p class="hilife-event-desc"><?php echo esc_html( $desc ); ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
            </ul>
        <?php else : ?>
            <p style="color:var(--text-dim)">No events found for this combination yet.</p>
        <?php endif; ?>
    </div>

    <!-- Feedback -->
    <?php if ( $feedback->have_posts() ) : ?>
    <div style="background:var(--surface);border-top:1px solid var(--border);padding:var(--space-lg) 0;">
        <div class="hilife-container">
            <div class="hilife-section-label">What our clients say</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;margin-top:var(--space-md);">
            <?php while ( $feedback->have_posts() ) : $feedback->the_post();
                $dj = get_field('dj_name', get_the_ID());
            ?>
                <div style="background:var(--panel);border:1px solid var(--panel-border);border-top:2px solid var(--accent);padding:var(--space-md);">
                    <p style="font-size:14px;line-height:1.8;color:var(--panel-text);font-style:italic;margin-bottom:var(--space-sm);">"<?php echo esc_html( get_the_content() ); ?>"</p>
                    <div style="font-size:12px;color:var(--accent);letter-spacing:0.08em;"><?php echo esc_html( get_the_title() ); ?></div>
                    <?php if ( $dj ) : ?>
                        <div style="font-size:11px;color:var(--panel-text-dim);margin-top:4px;">DJ: <?php echo esc_html( $dj->post_title ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Location switcher -->
    <div style="background:var(--surface);border-top:1px solid var(--border);padding:var(--space-lg) 0;">
        <div class="hilife-container">
            <div class="hilife-section-label"><?php echo esc_html( $occasion->name ); ?> in other locations</div>
            <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:var(--space-sm);">
            <?php
            $locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);
            foreach ( $locations as $loc ) :
                if ( $loc->slug === $location_slug ) continue;
            ?>
                <a href="/<?php echo $occasion_slug; ?>/<?php echo $loc->slug; ?>"
                   style="font-size:0.7rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-dim);border:1px solid var(--border);padding:8px 16px;transition:all 0.2s ease;"
                   onmouseover="this.style.color='var(--accent)';this.style.borderColor='var(--accent)'"
                   onmouseout="this.style.color='var(--text-dim)';this.style.borderColor='var(--border)'">
                    <?php echo esc_html( $loc->name ); ?>
                </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>