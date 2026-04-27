<header class="hilife-header">
    <div class="hilife-header-inner">
        <a href="<?php echo home_url(); ?>" class="hilife-logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Hi-Life Entertainment">
            <span class="hilife-logo-text">Hi-Life Entertainment</span>
        </a>
        <nav class="hilife-nav">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => false,
            ]); ?>
        </nav>
    </div>
</header>