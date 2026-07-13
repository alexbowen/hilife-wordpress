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
$djs = new WP_Query([
    'post_type'      => 'djs',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
]);
?>

<main class="hilife-main">

    <!-- HERO -->
    <?php 
    $dj_page = get_page_by_path('djs');
    $has_hero = $dj_page && has_post_thumbnail($dj_page->ID);
    ?>
    <div style="padding:72px 40px 56px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;<?php echo $has_hero ? 'min-height:360px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( $has_hero ) : ?>
            <div style="position:absolute;inset:0;">
                <?php echo get_the_post_thumbnail($dj_page->ID, 'full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.65);']); ?>
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.97) 0%,rgba(26,22,18,0.7) 60%,rgba(26,22,18,0.4) 100%);"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(20,184,166,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">The roster</div>
            <h1 style="margin-bottom:16px;">Our DJs</h1>
            <p style="font-size:1rem;line-height:1.8;color:var(--text-dim);max-width:560px;margin-bottom:0;">A hand-picked roster of experienced DJs who genuinely love music. Every one of them chosen for their knowledge, their ability to read a room and their commitment to making your night the one people talk about.</p>
        </div>
    </div>

    <!-- DJ GRID -->
    <div style="padding:64px 40px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px;">
        <?php if ( $djs->have_posts() ) :
            while ( $djs->have_posts() ) : $djs->the_post();
                $summary   = get_field('dj_summary', get_the_ID());
                $link_url  = get_field('dj_link_url', get_the_ID());
                $link_text = get_field('dj_link_text', get_the_ID());
        ?>
            <a href="<?php the_permalink(); ?>" style="display:block;background:var(--surface);border:1px solid var(--border);text-decoration:none;transition:border-color 0.3s;"
               onmouseover="this.style.borderColor='rgba(20,184,166,0.3)'"
               onmouseout="this.style.borderColor='var(--border)'">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="aspect-ratio:1/1;overflow:hidden;background:var(--surface2);">
                        <?php the_post_thumbnail('medium_large', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;']); ?>
                    </div>
                <?php else : ?>
                    <div style="aspect-ratio:1/1;background:var(--surface2);display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--border);">
                        <span style="font-size:9px;letter-spacing:0.2em;text-transform:uppercase;color:var(--border);font-family:var(--font-body);">Photo coming soon</span>
                    </div>
                <?php endif; ?>
                <div style="padding:24px;">
                    <div style="font-family:var(--font-display);font-size:18px;font-weight:600;color:var(--text-bright);margin-bottom:8px;"><?php the_title(); ?></div>
                    <?php if ($summary) : ?>
                        <p style="font-size:12px;color:var(--text-dim);line-height:1.7;font-family:var(--font-body);font-weight:300;margin-bottom:16px;"><?php echo esc_html($summary); ?></p>
                    <?php endif; ?>
                    <span style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);font-family:var(--font-body);">Read more →</span>
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