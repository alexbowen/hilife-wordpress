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
?>
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
