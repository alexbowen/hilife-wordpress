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
    <div style="padding:72px 40px 56px;border-bottom:1px solid var(--border);position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(227,221,88,0.04) 0%,transparent 60%);pointer-events:none;"></div>
        <div style="position:relative;max-width:700px;">
            <div class="hilife-eyebrow">Get in touch</div>
            <h1 style="margin-bottom:12px;">Tell us about your night</h1>
            <p style="font-size:15px;color:var(--text-dim);max-width:560px;margin-bottom:0;">We'd love to hear about your event. The more detail you can give us, the better we can match you with the right DJ and the right music.</p>
        </div>
    </div>

    <!-- CONTACT GRID -->
    <div style="display:grid;grid-template-columns:1fr 1.6fr;gap:2px;min-height:600px;">

        <!-- LEFT — Contact info -->
        <div style="background:var(--surface);border-right:1px solid var(--border);padding:48px 40px;">
            <div class="hilife-section-label">How to reach us</div>

            <?php
            $mark_photo = get_field('contact_mark_photo', 'option');
            ?>
            <?php if ( $mark_photo ) : ?>
                <div style="width:80px;height:80px;border-radius:50%;overflow:hidden;margin-bottom:20px;border:1px solid var(--border);">
                    <img src="<?php echo esc_url(is_array($mark_photo) ? $mark_photo['url'] : $mark_photo); ?>" alt="Mark Hepworth" style="width:100%;height:100%;object-fit:cover;">
                </div>
            <?php else : ?>
                <div style="width:80px;height:80px;border-radius:50%;background:var(--surface2);border:1px dashed var(--border);margin-bottom:20px;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:9px;letter-spacing:0.15em;text-transform:uppercase;color:var(--border);font-family:var(--font-body);">Photo</span>
                </div>
            <?php endif; ?>

            <div style="font-size:13px;color:var(--text-dim);line-height:1.8;margin-bottom:32px;font-style:italic;padding:16px 20px;border-left:2px solid var(--gold);background:rgba(227,221,88,0.04);">
                I'm often DJing at weekends and evenings so it's usually better to email — let me know when you're free to talk and I'll get back to you.
            </div>

            <div style="margin-bottom:32px;">
                <div style="display:flex;align-items:flex-start;gap:16px;padding:14px 0;border-bottom:1px solid rgba(58,58,56,0.5);">
                    <span style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);font-family:var(--font-body);min-width:60px;margin-top:2px;">Phone</span>
                    <a href="tel:07828688144" style="font-size:14px;color:var(--gold);text-decoration:none;">07828 688144</a>
                </div>
                <div style="display:flex;align-items:flex-start;gap:16px;padding:14px 0;border-bottom:1px solid rgba(58,58,56,0.5);">
                    <span style="font-size:10px;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-dim);font-family:var(--font-body);min-width:60px;margin-top:2px;">Email</span>
                    <a href="mailto:mark@thehi-life.co.uk" style="font-size:14px;color:var(--gold);text-decoration:none;">mark@thehi-life.co.uk</a>
                </div>
            </div>

            <p style="font-size:12px;color:var(--text-dim);line-height:1.8;margin-bottom:0;">
                In emails and messages please give as much information as you have regarding <span style="color:var(--text);font-weight:500;">dates and times</span>, <span style="color:var(--text);font-weight:500;">venue or approximate location</span>, and <span style="color:var(--text);font-weight:500;">type of event and any preferred music styles</span>.
            </p>
        </div>

        <!-- RIGHT — Enquiry form -->
        <div style="background:var(--black);padding:48px 40px;">
            <div class="hilife-section-label">Enquiry form</div>
            <form method="post" action="/actions/enquiry" style="display:flex;flex-direction:column;">

                <!-- Name + Email -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-right:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:flex;align-items:center;gap:6px;font-family:var(--font-body);">Name <span style="color:var(--gold);">*</span></label>
                        <input type="text" name="name" required placeholder="Your full name" style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-left:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:flex;align-items:center;gap:6px;font-family:var(--font-body);">Email address <span style="color:var(--gold);">*</span></label>
                        <input type="email" name="email" required placeholder="your@email.com" style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                </div>

                <!-- Phone + Event type -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-right:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Telephone number</label>
                        <input type="tel" name="phone" placeholder="Your phone number" style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-left:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Event type</label>
                        <select name="event_type" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;appearance:none;-webkit-appearance:none;cursor:pointer;">
                            <option value="" disabled selected>Select occasion</option>
                            <?php
                            $occasions = get_terms(['taxonomy' => 'occasion', 'hide_empty' => false]);
                            foreach ($occasions as $occasion) :
                            ?>
                                <option value="<?php echo esc_attr($occasion->slug); ?>"><?php echo esc_html($occasion->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Event date -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:flex;align-items:center;gap:6px;font-family:var(--font-body);">Event date <span style="color:var(--gold);">*</span></label>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
                        <select name="event_year" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Year</option>
                            <?php for($y = date('Y'); $y <= date('Y') + 3; $y++) : ?>
                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="event_month" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Month</option>
                            <?php
                            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                            foreach($months as $i => $m) echo "<option value='" . ($i+1) . "'>$m</option>";
                            ?>
                        </select>
                        <select name="event_date" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Date</option>
                            <?php for($d = 1; $d <= 31; $d++) echo "<option value='$d'>$d</option>"; ?>
                        </select>
                    </div>
                </div>

                <!-- Venue name + address -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-right:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Venue name</label>
                        <input type="text" name="venue_name" placeholder="Venue or TBC" style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-left:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Venue address</label>
                        <input type="text" name="venue_address" placeholder="Address or area" style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                </div>

                <!-- Start time -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Start time</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <select name="start_hour" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Hour</option>
                            <?php for($h = 12; $h <= 23; $h++) echo "<option value='$h'>" . sprintf('%02d', $h) . ":00</option>"; ?>
                        </select>
                        <select name="start_mins" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Minutes</option>
                            <option value="00">:00</option>
                            <option value="15">:15</option>
                            <option value="30">:30</option>
                            <option value="45">:45</option>
                        </select>
                    </div>
                </div>

                <!-- Finish time -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Finish time</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <select name="finish_hour" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Hour</option>
                            <?php for($h = 18; $h <= 23; $h++) echo "<option value='$h'>" . sprintf('%02d', $h) . ":00</option>"; ?>
                            <?php for($h = 0; $h <= 3; $h++) echo "<option value='$h'>" . sprintf('%02d', $h) . ":00</option>"; ?>
                        </select>
                        <select name="finish_mins" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Minutes</option>
                            <option value="00">:00</option>
                            <option value="15">:15</option>
                            <option value="30">:30</option>
                            <option value="45">:45</option>
                        </select>
                    </div>
                </div>

                <!-- Additional info -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Additional information</label>
                    <textarea name="additional_info" placeholder="Tell us anything else about your event — music preferences, special requests, anything that would help us understand what you're looking for." style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;resize:none;min-height:80px;line-height:1.7;"></textarea>
                </div>

                <!-- Footer -->
                <div style="padding:28px 0 0;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;">
                    <div style="font-size:11px;color:var(--text-dim);border:1px solid var(--border);padding:12px 16px;display:flex;align-items:center;gap:12px;font-family:var(--font-body);">
                        <div style="width:20px;height:20px;border:1px solid var(--border);flex-shrink:0;"></div>
                        <span>I'm not a robot</span>
                    </div>
                    <button type="submit" style="background:var(--gold);color:var(--black);font-family:var(--font-mark);font-size:11px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;padding:14px 32px;border:none;cursor:pointer;white-space:nowrap;">Submit enquiry</button>
                </div>

            </form>
        </div>

    </div>

</main>

<?php include( get_template_directory() . '/footer-hilife.php' ); ?>
<?php wp_footer(); ?>
</body>
</html>