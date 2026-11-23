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
$hero_intro = $intro ?: $occasion->description;
?>
<div class="hilife-hero<?php echo $hero_image ? ' hilife-hero--has-image' : ''; ?>" <?php if ( $hero_image ) : ?>style="position:relative;min-height:460px;display:flex;align-items:flex-end;" <?php endif; ?>>
    <?php if ( $hero_image ) : ?>
        <div class="hilife-hero-bg">
            <div class="hilife-hero-media" style="background-image:url('<?php echo esc_url($hero_image['url']); ?>');background-size:cover;background-position:center;filter:brightness(0.7);"></div>
        </div>
        <div class="hilife-hero-overlay"></div>
    <?php endif; ?>
    <div class="hilife-hero-inner" style="position:relative;z-index:1;<?php if ( $hero_image ) : ?>padding-bottom:var(--space-lg);<?php endif; ?>">
        <div class="hilife-eyebrow">
            <?php echo esc_html( $occasion->name ); ?>
            &nbsp;·&nbsp;
            <?php echo esc_html( $location->name ); ?>
        </div>
        <h1><?php echo esc_html( $headline ); ?></h1>
        <?php if ( $hero_intro ) : ?>
            <p class="hilife-intro"><?php echo esc_html( $hero_intro ); ?></p>
        <?php endif; ?>
    </div>
</div>

    <!-- Occasion description -->
    <div class="hilife-section hilife-band--warm">
        <div class="hilife-eyebrow"><?php echo esc_html( $occasion->name ); ?></div>
        <?php if ( $occasion->description ) : ?>
            <p style="font-size:1rem;line-height:1.8;color:var(--text);font-family:var(--font-body);font-weight:300;max-width:var(--content-width);margin-bottom:var(--space-sm);"><?php echo esc_html( $occasion->description ); ?></p>
        <?php endif; ?>
        <?php if ( $location->description ) : ?>
            <p style="font-size:1rem;line-height:1.8;color:var(--text);font-family:var(--font-body);font-weight:300;max-width:var(--content-width);margin-bottom:var(--space-sm);"><?php echo esc_html( $location->description ); ?></p>
        <?php endif; ?>
        <a href="/contact" style="display:inline-block;margin-top:var(--space-sm);background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:13px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;">Get in touch about your <?php echo esc_html( $occasion->name ); ?></a>
    </div>

    <!-- Events -->
    <div class="hilife-section hilife-band--paper">
        <h2 class="hilife-section-title">Recent <?php echo esc_html( $occasion->name ); ?> events in <?php echo esc_html( $location->name ); ?></h2>
        <?php if ( $events->have_posts() ) : ?>
        <div class="hilife-grid-2" style="gap:16px;">
        <?php while ( $events->have_posts() ) : $events->the_post();
            $venue = get_field('venue_name', get_the_ID());
            $desc  = get_field('event_description', get_the_ID());
        ?>
            <div style="background:var(--panel);border:1px solid var(--panel-border);border-top:2px solid var(--accent);padding:24px 28px;">
                <div style="font-size:1rem;font-weight:500;color:var(--panel-text);margin-bottom:8px;font-family:var(--font-body);"><?php echo esc_html($venue ?: get_the_title()); ?></div>
                <?php if ($desc) : ?>
                    <p style="font-size:0.875rem;color:var(--panel-text-dim);font-family:var(--font-body);font-weight:300;margin-bottom:0;"><?php echo esc_html($desc); ?></p>
                <?php endif; ?>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
        </div>
        <?php else : ?>
            <p style="color:var(--text-dim)">No events found for this combination yet.</p>
        <?php endif; ?>
    </div>

    <!-- Feedback -->
    <?php if ( $feedback->have_posts() ) : ?>
    <div class="hilife-section hilife-band--paper">
        <h2 class="hilife-section-title">What our clients say</h2>
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
    <?php endif; ?>

    <!-- Music themes -->
    <?php
    $music_themes = get_posts([
        'post_type'      => 'music-theme',
        'posts_per_page' => 6,
        'orderby'        => 'rand',
    ]);
    ?>
    <?php if ( $music_themes ) : ?>
    <div class="hilife-section hilife-band--teal">
        <h2 class="hilife-section-title">Music for your <?php echo esc_html($occasion->name); ?></h2>
        <div class="hilife-card-grid">
        <?php foreach ( $music_themes as $mt ) : ?>
            <a class="hilife-card" href="<?php echo get_permalink($mt->ID); ?>">
                <?php if ( has_post_thumbnail($mt->ID) ) : ?>
                    <span class="hilife-card-media"><?php echo get_the_post_thumbnail($mt->ID, 'medium', ['alt' => '']); ?></span>
                <?php endif; ?>
                <span class="hilife-card-title"><?php echo esc_html($mt->post_title); ?></span>
            </a>
        <?php endforeach; ?>
            <a class="hilife-card hilife-card--more" href="/music"><span class="hilife-card-title">+ more</span></a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Location switcher -->
    <div class="hilife-section hilife-band--black">
        <h2 class="hilife-section-title"><?php echo esc_html( $occasion->name ); ?> in other areas</h2>
        <div class="hilife-chips">
            <?php
            $locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);
            foreach ( $locations as $loc ) :
                if ( $loc->slug === $location_slug ) continue;
            ?>
                <a class="hilife-chip" href="/<?php echo esc_attr( $occasion_slug ); ?>/<?php echo esc_attr( $loc->slug ); ?>"><?php echo esc_html( $loc->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CTA STRIP -->
    <div class="hilife-section hilife-band--warm hilife-cta-strip">
        <div>
            <div style="font-size:11px;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);margin-bottom:8px;">Planning an event?</div>
            <div style="font-family:var(--font-body);font-size:20px;font-weight:300;color:var(--text-bright);">Let's talk about <em style="font-style:italic;color:var(--accent);">your night</em></div>
        </div>
        <a href="/contact" style="display:inline-block;background:var(--gold);color:#0F0F0E;font-family:var(--font-mark);font-size:13px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>
