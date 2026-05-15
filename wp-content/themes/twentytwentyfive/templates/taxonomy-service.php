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
$term        = get_queried_object();
$headline    = get_field('service_headline', $term);
$intro       = get_field('service_intro', $term);
$image_field = get_field('service_hero_image', $term);
$image       = is_array($image_field) ? $image_field['url'] : $image_field;

$occasions = get_terms(['taxonomy' => 'occasion', 'hide_empty' => false]);
$locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);

$events = new WP_Query([
    'post_type'      => 'event',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => [[
        'taxonomy' => 'service',
        'field'    => 'slug',
        'terms'    => $term->slug,
    ]],
]);

$feedback = new WP_Query([
    'post_type'      => 'feedback',
    'posts_per_page' => 2,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => [[
        'taxonomy' => 'service',
        'field'    => 'slug',
        'terms'    => $term->slug,
    ]],
]);
?>

<main class="hilife-main">

    <!-- HERO -->
    <div style="padding:72px 40px 64px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;<?php echo $image ? 'min-height:360px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( $image ) : ?>
            <div style="position:absolute;inset:0;background-image:url('<?php echo esc_url($image); ?>');background-size:cover;background-position:center;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(15,15,14,0.97) 0%,rgba(15,15,14,0.5) 60%,rgba(15,15,14,0.2) 100%);"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(227,221,88,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">Service</div>
            <h1 style="margin-bottom:16px;"><?php echo esc_html($headline ?: $term->name); ?></h1>
            <?php if ( $intro ) : ?>
                <p class="hilife-intro"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- OCCASIONS THIS SERVICE SUITS -->
    <div style="padding:64px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label"><?php echo esc_html($term->name); ?> for every occasion</div>
        <div class="hilife-grid-3">
        <?php foreach ( $occasions as $occasion ) :
            $occ_image_field = get_field('occasion_hero_image', $occasion);
            $occ_image = is_array($occ_image_field) ? $occ_image_field['url'] : $occ_image_field;
        ?>
            <a href="<?php echo esc_url(get_term_link($occasion)); ?>"
               style="position:relative;overflow:hidden;aspect-ratio:3/2;display:block;border:1px solid var(--border);text-decoration:none;">
                <?php if ( $occ_image ) : ?>
                    <div style="position:absolute;inset:0;background-image:url('<?php echo esc_url($occ_image); ?>');background-size:cover;background-position:center;"></div>
                <?php else : ?>
                    <div style="position:absolute;inset:0;background:var(--surface);"></div>
                <?php endif; ?>
                <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(15,15,14,0.95) 0%,rgba(15,15,14,0.3) 70%,transparent 100%);"></div>
                <div style="position:absolute;top:0;left:0;right:0;height:2px;background:var(--gold);transform:scaleX(0);transform-origin:left;transition:transform 0.3s;"></div>
                <div style="position:absolute;bottom:0;left:0;right:0;padding:20px 22px;">
                    <div style="font-family:var(--font-display);font-size:18px;font-weight:600;color:var(--text-bright);margin-bottom:4px;"><?php echo esc_html($occasion->name); ?></div>
                    <div style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);font-family:var(--font-body);">Find out more →</div>
                </div>
            </a>
        <?php endforeach; ?>
        </div>
    </div>

    <!-- WHERE WE OFFER THIS -->
    <div style="padding:48px 40px;background:var(--surface);border-bottom:1px solid var(--border);">
        <div class="hilife-section-label"><?php echo esc_html($term->name); ?> across the North</div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
        <?php foreach ( $locations as $loc ) : ?>
            <a href="<?php echo esc_url(get_term_link($loc)); ?>"
               style="font-size:10px;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-dim);border:1px solid var(--border);padding:8px 18px;font-family:var(--font-body);text-decoration:none;transition:all 0.2s;"
               onmouseover="this.style.color='var(--gold)';this.style.borderColor='rgba(227,221,88,0.4)'"
               onmouseout="this.style.color='var(--text-dim)';this.style.borderColor='var(--border)'">
                <?php echo esc_html($loc->name); ?>
            </a>
        <?php endforeach; ?>
        </div>
    </div>

    <!-- RECENT EVENTS -->
    <div style="padding:64px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">Recent events featuring <?php echo esc_html($term->name); ?></div>
        <?php if ( $events->have_posts() ) : ?>
            <ul class="hilife-events">
            <?php while ( $events->have_posts() ) : $events->the_post();
                $venue = get_field('venue_name', get_the_ID());
                $desc  = get_field('event_description', get_the_ID());
            ?>
                <li class="hilife-event">
                    <div>
                        <div class="hilife-event-venue"><?php echo esc_html($venue ?: get_the_title()); ?></div>
                        <?php if ($desc) : ?>
                            <p class="hilife-event-desc"><?php echo esc_html($desc); ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
            </ul>
        <?php else : ?>
            <p style="color:var(--text-dim)">No events found yet.</p>
        <?php endif; ?>
    </div>

    <!-- FEEDBACK -->
    <?php if ( $feedback->have_posts() ) : ?>
    <div style="padding:64px 40px;background:var(--surface);border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">What people say</div>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
        <?php while ( $feedback->have_posts() ) : $feedback->the_post();
            $dj = get_field('dj_name', get_the_ID());
        ?>
            <div style="background:var(--dark);border:1px solid var(--border);padding:30px;position:relative;">
                <div style="position:absolute;top:14px;left:22px;font-size:44px;color:rgba(227,221,88,0.1);line-height:1;font-family:Georgia,serif;">"</div>
                <p style="font-size:13px;line-height:1.9;color:var(--text);font-style:italic;margin-bottom:18px;"><?php echo esc_html(get_the_content()); ?></p>
                <div style="font-size:11px;color:var(--gold);letter-spacing:0.06em;font-family:var(--font-body);"><?php echo esc_html(get_the_title()); ?></div>
                <?php if ($dj) : ?>
                    <div style="font-size:10px;color:var(--text-dim);margin-top:4px;font-family:var(--font-body);"><?php echo esc_html($dj->post_title); ?></div>
                <?php endif; ?>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- CTA STRIP -->
    <div style="padding:48px 40px;border-top:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:32px;">
        <div>
            <div style="font-size:10px;letter-spacing:0.25em;text-transform:uppercase;color:var(--gold);font-family:var(--font-body);margin-bottom:8px;">Interested in <?php echo esc_html($term->name); ?>?</div>
            <div style="font-family:var(--font-display);font-size:22px;font-weight:600;color:var(--text-bright);">Let's talk about <em style="font-style:italic;color:var(--gold);">your night</em></div>
        </div>
        <a href="/contact" style="display:inline-block;background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>