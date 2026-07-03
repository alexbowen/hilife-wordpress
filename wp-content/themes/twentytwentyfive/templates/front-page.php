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
$occasions = get_terms([
    'taxonomy'   => 'occasion',
    'hide_empty' => false,
    'number'     => 3,
]);

$services = get_terms([
    'taxonomy'   => 'service',
    'hide_empty' => false,
]);

$locations = get_terms([
    'taxonomy'   => 'location',
    'hide_empty' => false,
]);

$events = new WP_Query([
    'post_type'      => 'event',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$feedback = new WP_Query([
    'post_type'      => 'feedback',
    'posts_per_page' => 2,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$home_page_id = get_option('page_on_front');
$has_hero = $home_page_id && has_post_thumbnail($home_page_id);
?>

<main class="hilife-main">

    <!-- HERO -->
    <div style="padding:72px 40px 64px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;background:linear-gradient(135deg,var(--surface) 0%,var(--black) 60%,#1c1a0c 100%);<?php echo $has_hero ? 'min-height:420px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( $has_hero ) : ?>
            <div style="position:absolute;inset:0;">
                <?php echo get_the_post_thumbnail($home_page_id, 'full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.5);']); ?>
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.97) 0%,rgba(26,22,18,0.7) 60%,rgba(26,22,18,0.4) 100%);"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 80% 50%,rgba(20,184,166,0.05) 0%,transparent 55%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">Leeds & the North of England · Est. 2006</div>
            <p style="font-size:clamp(1.8rem, 3.5vw, 2.4rem);color:var(--text-bright);line-height:1.3;margin-bottom:20px;font-family:var(--font-display);font-weight:400;">
                Professional DJ hire for weddings, corporate events and private parties — music that actually fits your night.
            </p>
            <p style="font-size:14px;color:var(--text-dim);line-height:1.8;margin-bottom:32px;font-family:var(--font-body);font-weight:300;max-width:480px;">
                Based in Leeds, covering the North of England since 2006. A roster of experienced DJs who genuinely love music and know how to read a room.
            </p>
            <a href="/contact" style="display:inline-block;background:var(--accent);color:#071a18;font-family:var(--font-mark);font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;">Get in touch</a>
        </div>
    </div>

    <!-- OCCASIONS -->
    <div style="padding:48px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">What's the occasion</div>
        <div class="hilife-grid-3">
        <?php foreach ( $occasions as $occasion ) :
            $image_field = get_field('occasion_hero_image', $occasion);
            $image = is_array($image_field) ? $image_field['url'] : $image_field;
            $link  = get_term_link($occasion);
        ?>
            <a href="<?php echo esc_url($link); ?>" style="position:relative;overflow:hidden;aspect-ratio:4/3;display:block;border:1px solid var(--panel-border);background:var(--panel);text-decoration:none;transition:border-color 0.3s;"
               onmouseover="this.style.borderColor='var(--accent)'"
               onmouseout="this.style.borderColor='var(--panel-border)'">
                <?php if ( $image ) : ?>
                    <div style="position:absolute;inset:0;background-image:url('<?php echo esc_url($image); ?>');background-size:cover;background-position:center;filter:brightness(0.55);transition:filter 0.4s;"></div>
                <?php else : ?>
                    <div style="position:absolute;inset:0;background:var(--panel);display:flex;align-items:center;justify-content:center;">
                        <span style="font-size:9px;letter-spacing:0.2em;text-transform:uppercase;color:var(--border);font-family:var(--font-body);">Add occasion image</span>
                    </div>
                <?php endif; ?>
                <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.97) 0%,rgba(26,22,18,0.4) 60%,transparent 100%);"></div>
                <div style="position:absolute;bottom:0;left:0;right:0;padding:24px;">
                    <div style="font-family:var(--font-display);font-size:22px;font-weight:400;color:var(--text-bright);margin-bottom:6px;"><?php echo esc_html($occasion->name); ?></div>
                    <?php if ( $occasion->description ) : ?>
                        <div style="font-size:13px;color:var(--text-dim);line-height:1.6;font-family:var(--font-body);font-weight:300;margin-bottom:14px;"><?php echo esc_html($occasion->description); ?></div>
                    <?php endif; ?>
                    <span style="font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);">Find out more →</span>
                </div>
            </a>
        <?php endforeach; ?>
        </div>
    </div>

    <!-- WHAT WE DO -->
    <div style="padding:48px 40px;background:var(--surface);border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">What we do</div>
        <div class="hilife-grid-3">
        <?php foreach ( $services as $service ) :
            $image_field = get_field('service_hero_image', $service);
            $image = is_array($image_field) ? $image_field['url'] : $image_field;
            $link  = get_term_link($service);
        ?>
            <a href="<?php echo esc_url($link); ?>" style="position:relative;overflow:hidden;border:1px solid var(--panel-border);background:var(--panel);min-height:180px;display:block;text-decoration:none;transition:border-color 0.3s;padding:28px 26px;"
               onmouseover="this.style.borderColor='var(--accent)'"
               onmouseout="this.style.borderColor='var(--panel-border)'">
                <?php if ( $image ) : ?>
                    <div style="position:absolute;inset:0;background-image:url('<?php echo esc_url($image); ?>');background-size:cover;background-position:center;opacity:0.2;filter:brightness(0.6);"></div>
                    <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,22,18,0.92) 0%,rgba(26,22,18,0.7) 100%);"></div>
                <?php endif; ?>
                <div style="position:relative;">
                    <div style="font-family:var(--font-display);font-size:19px;font-weight:400;color:var(--text-bright);margin-bottom:8px;"><?php echo esc_html($service->name); ?></div>
                    <?php if ( $service->description ) : ?>
                        <div style="font-size:13px;color:var(--text-dim);line-height:1.7;font-family:var(--font-body);font-weight:300;margin-bottom:16px;"><?php echo esc_html($service->description); ?></div>
                    <?php endif; ?>
                    <span style="font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);">Find out more →</span>
                </div>
            </a>
        <?php endforeach; ?>
        </div>
    </div>

    <!-- LOCATIONS -->
    <div style="padding:32px 40px;background:var(--dark);border-bottom:1px solid var(--border);">
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span style="font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);margin-right:12px;white-space:nowrap;">Areas we cover</span>
            <?php foreach ( $locations as $loc ) : ?>
                <a href="<?php echo esc_url(get_term_link($loc)); ?>"
                   style="font-size:11px;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-dim);border:1px solid var(--border);padding:7px 16px;font-family:var(--font-body);text-decoration:none;transition:all 0.2s;"
                   onmouseover="this.style.color='var(--accent)';this.style.borderColor='var(--accent)'"
                   onmouseout="this.style.color='var(--text-dim)';this.style.borderColor='var(--border)'">
                    <?php echo esc_html($loc->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RECENT EVENTS -->
    <div style="padding:48px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">Recent events</div>
        <div class="hilife-grid-2">
        <?php if ( $events->have_posts() ) :
            while ( $events->have_posts() ) : $events->the_post();
                $venue = get_field('venue_name', get_the_ID());
                $desc  = get_field('event_description', get_the_ID());
        ?>
            <div style="background:var(--panel);border:1px solid var(--panel-border);padding:18px 24px;display:flex;gap:16px;align-items:flex-start;">
                <div style="width:6px;height:6px;border-radius:50%;background:var(--accent);margin-top:8px;flex-shrink:0;"></div>
                <div>
                    <div style="font-size:14px;font-weight:500;color:var(--panel-text);margin-bottom:4px;font-family:var(--font-body);"><?php echo esc_html($venue ?: get_the_title()); ?></div>
                    <?php if ($desc) : ?>
                        <div style="font-size:12px;color:var(--panel-text-dim);font-family:var(--font-body);font-weight:300;"><?php echo esc_html($desc); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
        endif; ?>
        </div>
    </div>

    <!-- FEEDBACK -->
    <div style="padding:48px 40px;background:var(--surface);border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">What people say</div>
        <div class="hilife-grid-2" style="gap:16px;">
        <?php if ( $feedback->have_posts() ) :
            while ( $feedback->have_posts() ) : $feedback->the_post();
                $dj = get_field('dj_name', get_the_ID());
        ?>
            <div style="background:var(--panel);border:1px solid var(--panel-border);border-top:2px solid var(--accent);padding:28px;position:relative;">
                <div style="position:absolute;top:14px;left:22px;font-size:44px;color:rgba(20,184,166,0.12);line-height:1;font-family:Georgia,serif;">"</div>
                <p style="font-size:14px;line-height:1.9;color:var(--panel-text);font-style:italic;margin-bottom:16px;"><?php echo esc_html(get_the_content()); ?></p>
                <div style="font-size:12px;color:var(--accent);letter-spacing:0.06em;font-family:var(--font-body);"><?php echo esc_html(get_the_title()); ?></div>
                <?php if ($dj) : ?>
                    <div style="font-size:11px;color:var(--panel-text-dim);margin-top:4px;font-family:var(--font-body);"><?php echo esc_html($dj->post_title); ?></div>
                <?php endif; ?>
            </div>
        <?php endwhile;
        wp_reset_postdata();
        endif; ?>
        </div>
    </div>

    <!-- MUSIC -->
    <div style="padding:48px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">The music</div>
        <div style="max-width:700px;">
            <p style="font-size:14px;color:var(--text-dim);line-height:1.8;font-family:var(--font-body);font-weight:300;margin-bottom:24px;">
                From Motown to metal, Madchester to Speakeasy swing. Our DJs know their music — and they'll tailor every set to your night rather than playing the same playlist they played last weekend.
            </p>
            <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:24px;">
                <?php
                $music_terms = get_posts(['post_type' => 'music-theme', 'posts_per_page' => 11, 'orderby' => 'rand']);
                foreach ( $music_terms as $mt ) : ?>
                    <a href="<?php echo get_permalink($mt->ID); ?>"
                       style="font-size:11px;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-dim);border:1px solid var(--border);padding:7px 16px;font-family:var(--font-body);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.color='var(--accent)';this.style.borderColor='var(--accent)'"
                       onmouseout="this.style.color='var(--text-dim)';this.style.borderColor='var(--border)'">
                        <?php echo esc_html($mt->post_title); ?>
                    </a>
                <?php endforeach; ?>
                <a href="/music" style="font-size:11px;letter-spacing:0.08em;text-transform:uppercase;color:var(--accent);border:1px solid rgba(20,184,166,0.3);padding:7px 16px;font-family:var(--font-body);text-decoration:none;">+ more →</a>
            </div>
        </div>
    </div>

    <!-- CTA STRIP -->
    <div style="padding:40px;border-top:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;">
        <div>
            <div style="font-size:11px;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);margin-bottom:8px;">Planning an event?</div>
            <div style="font-family:var(--font-body);font-size:20px;font-weight:300;color:var(--text-bright);">Let's talk about <em style="font-style:italic;color:var(--accent);">your night</em></div>
        </div>
        <a href="/contact" style="display:inline-block;background:var(--accent);color:#071a18;font-family:var(--font-mark);font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>
