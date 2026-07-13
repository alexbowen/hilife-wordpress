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
    <div style="padding:72px 40px 48px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;<?php echo has_post_thumbnail() ? 'min-height:360px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( has_post_thumbnail() ) : ?>
            <div style="position:absolute;inset:0;">
                <?php the_post_thumbnail('full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;']); ?>
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.85) 0%,rgba(26,22,18,0.4) 50%,rgba(26,22,18,0.15) 100%);"></div>
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
    <div style="padding:40px 40px;border-bottom:1px solid var(--border);">
        <div class="hilife-section-label">Sample playlist</div>
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
    <div style="padding:40px;border-top:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:32px;">
        <a href="/music" style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--panel-text);font-family:var(--font-body);text-decoration:none;">← All music</a>
        <a href="/contact" style="display:inline-block;background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:13px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

<?php endif; ?>
</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>
