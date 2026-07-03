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
$themes = new WP_Query([
    'post_type'      => 'music-theme',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
]);
?>

<main class="hilife-main">

    <!-- HERO -->
    <?php 
    $music_page = get_page_by_path('music');
    $has_hero = $music_page && has_post_thumbnail($music_page->ID);
    ?>
    <div style="padding:72px 40px 56px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;<?php echo $has_hero ? 'min-height:360px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( $has_hero ) : ?>
            <div style="position:absolute;inset:0;">
                <?php echo get_the_post_thumbnail($music_page->ID, 'full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.5);']); ?>
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.97) 0%,rgba(26,22,18,0.7) 60%,rgba(26,22,18,0.4) 100%);"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(20,184,166,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">The music</div>
            <h1 style="margin-bottom:16px;">Music</h1>
            <p style="font-size:1rem;line-height:1.8;color:var(--text-dim);max-width:560px;margin-bottom:0;">Twenty curated sets spanning everything from Motown to metal, Madchester to Speakeasy swing. Browse by genre and tell us what fits your night — our DJs will build around it.</p>
        </div>
    </div>

    <!-- MUSIC GRID -->
    <div style="padding:64px 40px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;">
        <?php if ( $themes->have_posts() ) :
            while ( $themes->have_posts() ) : $themes->the_post();
                $about = get_field('theme_about', get_the_ID());
        ?>
            <a href="<?php the_permalink(); ?>" style="display:block;background:var(--surface);border:1px solid var(--border);text-decoration:none;transition:border-color 0.3s;position:relative;overflow:hidden;"
               onmouseover="this.style.borderColor='rgba(20,184,166,0.3)'"
               onmouseout="this.style.borderColor='var(--border)'">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="aspect-ratio:3/2;overflow:hidden;background:var(--surface2);">
                        <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;']); ?>
                    </div>
                <?php else : ?>
                    <div style="aspect-ratio:3/2;background:var(--surface2);display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--border);">
                        <span style="font-size:9px;letter-spacing:0.2em;text-transform:uppercase;color:var(--border);font-family:var(--font-body);">Image coming soon</span>
                    </div>
                <?php endif; ?>
                <div style="position:absolute;top:0;left:0;right:0;height:2px;background:var(--accent);transform:scaleX(0);transform-origin:left;transition:transform 0.3s;"></div>
                <div style="padding:22px 24px;">
                    <div style="font-family:var(--font-display);font-size:17px;font-weight:600;color:var(--text-bright);margin-bottom:8px;"><?php the_title(); ?></div>
                    <?php if ($about) : ?>
                        <p style="font-size:12px;color:var(--text-dim);line-height:1.7;font-family:var(--font-body);font-weight:300;margin-bottom:14px;"><?php echo esc_html(wp_trim_words($about, 20)); ?></p>
                    <?php endif; ?>
                    <span style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);">View playlist →</span>
                </div>
            </a>
        <?php endwhile;
        wp_reset_postdata();
        endif; ?>
        </div>
    </div>

    <!-- CTA STRIP -->
    <div style="padding:48px 40px;border-top:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:32px;">
        <div>
            <div style="font-size:10px;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);margin-bottom:8px;">Planning an event?</div>
            <div style="font-family:var(--font-display);font-size:22px;font-weight:600;color:var(--text-bright);">Let's talk about <em style="font-style:italic;color:var(--accent);">your night</em></div>
        </div>
        <a href="/contact" style="display:inline-block;background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>