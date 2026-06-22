<footer class="hilife-footer">
    <div class="hilife-footer-inner">
        <div class="hilife-footer-brand">
            <span class="hilife-logo-text">Hi-Life Entertainment</span>
            <p class="hilife-footer-tagline">
                Professional DJ hire & entertainment<br>
                across the North of England since 2006
            </p>
            <div style="display:flex;gap:16px;margin-top:16px;">
                <a href="https://www.facebook.com/hilifeentertainmentleeds" target="_blank" rel="noopener"
                   style="font-size:0.7rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;transition:color 0.2s;"
                   onmouseover="this.style.color='var(--gold)'"
                   onmouseout="this.style.color='var(--text-dim)'">Facebook</a>
                <a href="https://www.instagram.com/hilifeentertainmentleeds/" target="_blank" rel="noopener"
                   style="font-size:0.7rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);text-decoration:none;transition:color 0.2s;"
                   onmouseover="this.style.color='var(--gold)'"
                   onmouseout="this.style.color='var(--text-dim)'">Instagram</a>
            </div>
        </div>
        <div class="hilife-footer-col">
            <h4>Services</h4>
            <ul>
                <li><a href="/occasion/wedding">Weddings</a></li>
                <li><a href="/occasion/corporate">Corporate</a></li>
                <li><a href="/occasion/private-party">Private Parties</a></li>
                <li><a href="/djs">Our DJs</a></li>
                <li><a href="/music">Music</a></li>
            </ul>
        </div>
        <div class="hilife-footer-col">
            <h4>Locations</h4>
            <ul>
                <?php
                $locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);
                foreach ($locations as $loc) :
                ?>
                    <li><a href="<?php echo get_term_link($loc); ?>"><?php echo $loc->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="hilife-footer-bottom">
        <span>© <?php echo date('Y'); ?> Hi-Life Entertainment</span>
        <span>
            <a href="/privacy-policy">Privacy Policy</a>
            &nbsp;·&nbsp;
            <a href="/cookie-policy">Cookie Policy</a>
        </span>
    </div>
</footer>