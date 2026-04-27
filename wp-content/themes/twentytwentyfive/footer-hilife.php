<footer class="hilife-footer">
    <div class="hilife-footer-inner">
        <div class="hilife-footer-brand">
            <span class="hilife-logo-text">Hi-Life Entertainment</span>
            <p class="hilife-footer-tagline">
                Professional DJ hire & entertainment<br>
                across the North of England since 2006
            </p>
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