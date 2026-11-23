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
    $about    = get_field('theme_about', get_the_ID());
    $playlist = get_field('theme_playlist', get_the_ID());
?>

    <!-- HERO -->
    <div<?php echo has_post_thumbnail() ? ' class="hilife-hero--has-image"' : ''; ?> style="<?php echo has_post_thumbnail() ? 'padding:72px var(--gutter) 112px;position:relative;overflow:hidden;min-height:360px;display:flex;align-items:flex-end;' : 'padding:72px var(--gutter) 48px;position:relative;overflow:hidden;'; ?>">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="hilife-hero-bg">
                <div class="hilife-hero-media">
                    <?php the_post_thumbnail('full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;']); ?>
                </div>
            </div>
            <div class="hilife-hero-overlay"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(20,184,166,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">Music</div>
            <h1 style="margin-bottom:16px;"><?php the_title(); ?></h1>
            <?php if ($about) : ?>
                <p style="font-size:1rem;line-height:1.8;color:var(--text);max-width:var(--content-width);margin-bottom:0;font-family:var(--font-body);font-weight:300;"><?php echo esc_html($about); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- PLAYLIST -->
    <?php if ($playlist) : ?>
    <div class="hilife-section hilife-band--black">
        <h2 class="hilife-section-title">Sample playlist</h2>
        <ol style="list-style:none;columns:2;gap:var(--space-md);padding-left:0;">
        <?php foreach ($playlist as $row) : ?>
            <li style="font-size:14px;color:var(--panel-text);padding:8px 12px 8px 0;border-bottom:1px solid var(--panel-border);background:var(--panel);break-inside:avoid;display:flex;align-items:baseline;">
                <span style="padding-left:16px;"><?php echo esc_html($row['track']); ?></span>
            </li>
        <?php endforeach; ?>
        </ol>
    </div>
    <?php endif; ?>

    <!-- BACK + CTA -->
    <div class="hilife-section hilife-band--warm hilife-cta-strip">
        <a href="/music" style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--panel-text);font-family:var(--font-body);text-decoration:none;">← All music</a>
        <a href="/contact" style="display:inline-block;background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:13px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

<?php endif; ?>
</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>
