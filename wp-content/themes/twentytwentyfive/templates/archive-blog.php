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

    <!-- HERO -->
    <?php $blog_page_id = get_option('page_for_posts');
    $has_hero = $blog_page_id && has_post_thumbnail($blog_page_id); ?>
    <div style="padding:72px 40px 56px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;<?php echo $has_hero ? 'min-height:360px;display:flex;align-items:flex-end;' : ''; ?>">
        <?php if ( $has_hero ) : ?>
            <div style="position:absolute;inset:0;">
                <?php echo get_the_post_thumbnail($blog_page_id, 'full', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;filter:brightness(0.5);']); ?>
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,22,18,0.97) 0%,rgba(26,22,18,0.7) 60%,rgba(26,22,18,0.4) 100%);"></div>
        <?php else : ?>
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(20,184,166,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <?php endif; ?>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">Latest from Hi-Life</div>
            <h1 style="margin-bottom:12px;">Blog</h1>
            <p style="font-size:15px;color:var(--text-dim);max-width:560px;margin-bottom:0;">News, tips and stories from the Hi-Life team.</p>
        </div>
    </div>

    <!-- POSTS -->
    <div style="padding:64px 40px;">
        <?php if ( have_posts() ) : ?>
            <div style="display:flex;flex-direction:column;gap:2px;">
            <?php while ( have_posts() ) : the_post(); ?>
                <article style="background:var(--surface);border:1px solid var(--border);padding:36px 40px;transition:border-color 0.3s;"
                         onmouseover="this.style.borderColor='rgba(227,221,88,0.3)'"
                         onmouseout="this.style.borderColor='var(--border)'">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:32px;">
                        <div style="flex:1;">
                            <div style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);font-family:var(--font-body);margin-bottom:12px;">
                                <?php echo get_the_date('j F Y'); ?>
                            </div>
                            <h2 style="font-family:var(--font-display);font-size:1.4rem;font-weight:600;color:var(--text-bright);margin-bottom:12px;line-height:1.3;">
                                <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;transition:color 0.2s;"
                                   onmouseover="this.style.color='var(--gold)'"
                                   onmouseout="this.style.color='var(--text-bright)'"><?php the_title(); ?></a>
                            </h2>
                            <p style="font-size:13px;color:var(--text-dim);line-height:1.8;margin-bottom:20px;max-width:680px;"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
                            <a href="<?php the_permalink(); ?>" style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);font-family:var(--font-body);text-decoration:none;">Read more →</a>
                        </div>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div style="width:180px;height:120px;flex-shrink:0;overflow:hidden;border:1px solid var(--border);">
                                <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:100%;object-fit:cover;display:block;']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div style="margin-top:48px;display:flex;gap:8px;justify-content:center;">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ]);
                ?>
            </div>

        <?php else : ?>
            <p style="color:var(--text-dim);">No posts found.</p>
        <?php endif; ?>
    </div>

    <!-- CTA STRIP -->
    <div style="padding:48px 40px;border-top:1px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:space-between;gap:32px;">
        <div>
            <div style="font-size:10px;letter-spacing:0.25em;text-transform:uppercase;color:var(--gold);font-family:var(--font-body);margin-bottom:8px;">Planning an event?</div>
            <div style="font-family:var(--font-display);font-size:22px;font-weight:600;color:var(--text-bright);">Let's talk about <em style="font-style:italic;color:var(--gold);">your night</em></div>
        </div>
        <a href="/contact" style="display:inline-block;background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:13px 28px;text-decoration:none;white-space:nowrap;">Get in touch</a>
    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>