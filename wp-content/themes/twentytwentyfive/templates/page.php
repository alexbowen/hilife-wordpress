<?php
/**
 * Template Name: Hi-Life Page
 */
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

    <?php if ( have_posts() ) : the_post(); ?>

    <!-- HERO -->
    <?php $has_image = has_post_thumbnail(); ?>
    <div style="padding:72px 40px 56px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;<?php echo $has_image ? 'min-height:360px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( $has_image ) : ?>
            <div style="position:absolute;inset:0;">
                <?php the_post_thumbnail('full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;']); ?>
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.85) 0%,rgba(26,22,18,0.4) 50%,rgba(26,22,18,0.15) 100%);"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(20,184,166,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow"><?php echo get_bloginfo('name'); ?></div>
            <h1 style="margin-bottom:0;"><?php the_title(); ?></h1>
        </div>
    </div>

    <!-- CONTENT -->
    <div style="padding:64px 40px;">
        <div style="max-width:740px;font-size:15px;line-height:1.9;color:var(--text);font-family:var(--font-body);font-weight:300;">
            <?php the_content(); ?>
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

    <?php endif; ?>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>