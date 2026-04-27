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

<main class="hilife-main">
<?php if ( have_posts() ) : the_post();
    $summary   = get_field('dj_summary', get_the_ID());
    $link_url  = get_field('dj_link_url', get_the_ID());
    $link_text = get_field('dj_link_text', get_the_ID());
?>

    <!-- HERO -->
    <div style="padding:72px 40px 64px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(227,221,88,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <div style="position:relative;display:grid;grid-template-columns:200px 1fr;gap:48px;align-items:start;max-width:900px;">
            <?php if ( has_post_thumbnail() ) : ?>
                <div style="aspect-ratio:1/1;overflow:hidden;border:1px solid var(--border);">
                    <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;']); ?>
                </div>
            <?php else : ?>
                <div style="aspect-ratio:1/1;background:var(--surface);border:1px dashed var(--border);display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:9px;letter-spacing:0.2em;text-transform:uppercase;color:var(--border);font-family:var(--font-body);">Photo</span>
                </div>
            <?php endif; ?>
            <div>
                <div class="hilife-eyebrow">DJ</div>
                <h1 style="margin-bottom:16px;"><?php the_title(); ?></h1>
                <?php if ($summary) : ?>
                    <p class="hilife-intro"><?php echo esc_html($summary); ?></p>
                <?php endif; ?>
                <?php if ($link_url) : ?>
                    <a href="<?php echo esc_url($link_url); ?>" target="_blank"
                       style="display:inline-block;margin-top:16px;font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);border:1px solid rgba(227,221,88,0.3);padding:10px 20px;font-family:var(--font-body);text-decoration:none;">
                        <?php echo esc_html($link_text ?: 'Listen'); ?> →
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- BIO -->
    <div style="padding:64px 40px;border-bottom:1px solid var(--border);">
        <div style="max-width:700px;">
            <div class="hilife-section-label">About</div>
            <div style="font-size:14px;line-height:1.9;color:var(--text);font-family:var(--font-body);font-weight:300;">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    <!-- BACK LINK -->
    <div style="padding:32px 40px;">
        <a href="/djs" style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);font-family:var(--font-body);text-decoration:none;">← Back to all DJs</a>
    </div>

<?php endif; ?>
</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>