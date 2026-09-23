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
<div class="hilife-hero" <?php if ( $hero_image ) : ?>style="position:relative;min-height:460px;display:flex;align-items:flex-end;" <?php endif; ?>>
    <?php if ( $hero_image ) : ?>
        <div style="position:absolute;inset:0;background-image:url('<?php echo esc_url($hero_image['url']); ?>');background-size:cover;background-position:center;filter:brightness(0.7);"></div>
        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.85) 0%,rgba(26,22,18,0.4) 50%,rgba(26,22,18,0.15) 100%);"></div>
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
    <div style="padding:48px 40px;border-bottom:1px solid var(--border);">
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
    <div style="padding:48px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">Recent <?php echo esc_html( $occasion->name ); ?> events in <?php echo esc_html( $location->name ); ?></div>
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
    <div style="background:var(--surface);padding:48px 40px;">
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
    <div style="padding:48px 40px;border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">Music for your <?php echo esc_html($occasion->name); ?></div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:var(--space-sm);">
        <?php foreach ( $music_themes as $mt ) : ?>
            <a href="<?php echo get_permalink($mt->ID); ?>"
               style="font-size:0.7rem;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-dim);border:1px solid var(--border);padding:7px 16px;font-family:var(--font-body);text-decoration:none;transition:all 0.2s;"
               onmouseover="this.style.color='var(--accent)';this.style.borderColor='var(--accent)'"
               onmouseout="this.style.color='var(--text-dim)';this.style.borderColor='var(--border)'">
                <?php echo esc_html($mt->post_title); ?>
            </a>
        <?php endforeach; ?>
            <a href="/music" style="font-size:0.7rem;letter-spacing:0.08em;text-transform:uppercase;color:var(--accent);border:1px solid rgba(20,184,166,0.3);padding:7px 16px;font-family:var(--font-body);text-decoration:none;">+ more →</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Location switcher -->
    <div style="padding:32px 40px;background:var(--dark);border-bottom:1px solid var(--border);">
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span style="font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);margin-right:12px;white-space:nowrap;"><?php echo esc_html( $occasion->name ); ?> in other areas</span>
            <?php
            $locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);
            foreach ( $locations as $loc ) :
                if ( $loc->slug === $location_slug ) continue;
            ?>
                <a href="/<?php echo esc_attr( $occasion_slug ); ?>/<?php echo esc_attr( $loc->slug ); ?>"
                   style="font-size:11px;letter-spacing:0.08em;text-transform:uppercase;color:var(--panel-text);border:1px solid var(--border);padding:7px 16px;font-family:var(--font-body);text-decoration:none;transition:all 0.2s;"
                   onmouseover="this.style.color='var(--accent)';this.style.borderColor='var(--accent)'"
                   onmouseout="this.style.color='var(--panel-text)';this.style.borderColor='var(--border)'">
                    <?php echo esc_html( $loc->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CTA STRIP -->
    <div style="padding:40px;border-top:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;">
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
