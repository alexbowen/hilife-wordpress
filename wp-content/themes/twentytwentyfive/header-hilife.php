<?php
if ( defined('HILIFE_HEADER_FETCH') ) {
    $auth = $GLOBALS['hilife_header_auth'] ?? [];
    $is_authenticated = $auth['authenticated'] ?? false;
    $is_admin         = $auth['is_admin'] ?? false;
    $is_internal      = $auth['is_internal'] ?? false;
    $is_customer      = $auth['is_customer'] ?? false;
} else {
    $session_id = $_COOKIE['PHPSESSID'] ?? '';
    $context = stream_context_create([
        'http' => [
            'header' => "Cookie: PHPSESSID=" . $session_id . "\r\n",
        ]
    ]);
    $auth_status = @json_decode(file_get_contents(home_url('/auth/status'), false, $context), true);
    $is_authenticated = $auth_status['authenticated'] ?? false;
    $is_admin         = $auth_status['is_admin'] ?? false;
    $is_internal      = $auth_status['is_internal'] ?? false;
    $is_customer      = $auth_status['is_customer'] ?? false;
}

// Fetch taxonomy terms for dynamic nav
$nav_occasions = get_terms(['taxonomy' => 'occasion', 'hide_empty' => false]);
$nav_locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);
$nav_services  = get_terms(['taxonomy' => 'service',  'hide_empty' => false]);
?>
<header class="hilife-header">
    <div class="hilife-header-inner">
        <a href="<?php echo home_url(); ?>" class="hilife-logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Hi-Life Entertainment">
            <span class="hilife-logo-text">Hi-Life Entertainment</span>
        </a>
        <nav class="hilife-nav" id="hilife-nav">
            <ul>
                <li class="menu-item-has-children">
                    <a href="#">Occasions</a>
                    <ul class="sub-menu">
                        <?php foreach ( $nav_occasions as $term ) : ?>
                            <li><a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Locations</a>
                    <ul class="sub-menu">
                        <?php foreach ( $nav_locations as $term ) : ?>
                            <li><a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Services</a>
                    <ul class="sub-menu">
                        <?php foreach ( $nav_services as $term ) : ?>
                            <li><a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="<?php echo home_url('/djs'); ?>">DJs</a></li>
                <li><a href="<?php echo home_url('/music'); ?>">Music</a></li>
                <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
                <li><a href="<?php echo home_url('/about-us'); ?>">About</a></li>
                <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
                <?php if ( !$is_authenticated ) : ?>
                    <li><a href="<?php echo home_url('/account/sign-in'); ?>">Sign In</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <button class="hilife-hamburger" id="hilife-hamburger" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<?php if ( !defined('HILIFE_HEADER_FETCH') && $is_authenticated ) : ?>
<div style="background:var(--dark);border-bottom:1px solid var(--border);padding:0 40px;">
    <div style="display:flex;align-items:center;height:44px;gap:2rem;">
        <?php if ($is_admin) : ?>
            <a href="/admin/events" style="font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;">Admin</a>
        <?php endif; ?>
        <?php if ($is_internal) : ?>
            <a href="/planner/view/bookings" style="font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;">My Bookings</a>
        <?php endif; ?>
        <?php if ($is_customer) : ?>
            <a href="/planner" style="font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;">Music Planner</a>
        <?php endif; ?>
        <a href="/account" style="font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;">Account</a>
        <a href="/auth/revoke" style="font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;margin-left:auto;">Sign out</a>
    </div>
</div>
<?php endif; ?>