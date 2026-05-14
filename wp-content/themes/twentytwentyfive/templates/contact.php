<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

            <?php if ( isset($_GET['success']) ) : ?>
                <div style="background:rgba(227,221,88,0.08);border:1px solid var(--gold);padding:16px 20px;margin-bottom:32px;font-size:13px;color:var(--text);">
                    Thanks — we've received your enquiry and will be in touch shortly.
                </div>
            <?php endif; ?>

            <?php if ( isset($_GET['error']) ) : ?>
                <div style="background:rgba(255,80,80,0.08);border:1px solid rgba(255,80,80,0.4);padding:16px 20px;margin-bottom:32px;font-size:13px;color:var(--text);">
                    Something went wrong — please try again or email us directly.
                </div>
            <?php endif; ?>

            <form name="enquiry-form" action="/actions/event" method="post" novalidate>

                <!-- Name + Email -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-right:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:flex;align-items:center;gap:6px;font-family:var(--font-body);">Name <span style="color:var(--gold);">*</span></label>
                        <input type="text" name="event[primary_contact]" required maxlength="60" pattern="[ a-zA-Z\-]+"
                               placeholder="Your full name"
                               style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-left:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:flex;align-items:center;gap:6px;font-family:var(--font-body);">Email address <span style="color:var(--gold);">*</span></label>
                        <input type="email" name="event[email]" required
                               placeholder="your@email.com"
                               style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                </div>

                <!-- Phone + Event type -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-right:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Telephone number</label>
                        <input type="tel" name="event[client_telephone]" pattern="(\+)?([0-9]){10,16}"
                               placeholder="Your phone number"
                               style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-left:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Event type</label>
                        <select name="event[type]" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;appearance:none;-webkit-appearance:none;cursor:pointer;">
                            <option value="" disabled selected>Select occasion</option>
                            <?php
                            $occasions = get_terms(['taxonomy' => 'occasion', 'hide_empty' => false]);
                            foreach ($occasions as $occasion) :
                            ?>
                                <option value="<?php echo esc_attr($occasion->slug); ?>"><?php echo esc_html($occasion->name); ?></option>
                            <?php endforeach; ?>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Event date -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:flex;align-items:center;gap:6px;font-family:var(--font-body);">Event date <span style="color:var(--gold);">*</span></label>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
                        <select name="dateInput[year]" required style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Year</option>
                            <?php for($y = date('Y'); $y <= date('Y') + 5; $y++) echo "<option value='$y'>$y</option>"; ?>
                        </select>
                        <select name="dateInput[month]" required style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Month</option>
                            <?php
                            for($m = 1; $m <= 12; $m++) {
                                $dateObj = DateTime::createFromFormat('!m', $m);
                                echo "<option value='$m'>" . $dateObj->format('F') . "</option>";
                            }
                            ?>
                        </select>
                        <select name="dateInput[day]" required style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Date</option>
                            <?php for($d = 1; $d <= 31; $d++) echo "<option value='$d'>$d</option>"; ?>
                        </select>
                    </div>
                </div>

                <!-- Venue name + address -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-right:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Venue name</label>
                        <input type="text" name="event[venue_name]" maxlength="60" pattern="[ a-zA-Z0-9\-]+"
                               placeholder="Venue or TBC"
                               style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                    <div style="border-bottom:1px solid var(--border);padding:16px 0;padding-left:24px;">
                        <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Venue address</label>
                        <input type="text" name="event[venue_address]" maxlength="100" pattern="[ a-zA-Z0-9,.\-]+"
                               placeholder="Address or area"
                               style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;">
                    </div>
                </div>

                <!-- Start time -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Start time</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <select name="startTimeInput[hours]" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Hour</option>
                            <?php for($h = 10; $h <= 27; $h++) :
                                $value = $h > 23 ? $h - 24 : $h;
                                if ($h > 24) { $display = ($h-24).'am'; }
                                elseif ($h == 24) { $display = 'Midnight'; }
                                elseif ($h == 12) { $display = 'Noon'; }
                                elseif ($h > 12) { $display = ($h-12).'pm'; }
                                else { $display = $h.'am'; }
                            ?>
                                <option value="<?php echo $value; ?>"><?php echo $display; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="startTimeInput[minutes]" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Minutes</option>
                            <option value="0">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                    </div>
                </div>

                <!-- Finish time -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Finish time</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <select name="finishTimeInput[hours]" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Hour</option>
                            <?php for($h = 12; $h <= 30; $h++) :
                                $value = $h > 23 ? $h - 24 : $h;
                                if ($h > 24) { $display = ($h-24).'am'; }
                                elseif ($h == 24) { $display = 'Midnight'; }
                                elseif ($h == 12) { $display = 'Noon'; }
                                elseif ($h > 12) { $display = ($h-12).'pm'; }
                                else { $display = $h.'am'; }
                            ?>
                                <option value="<?php echo $value; ?>"><?php echo $display; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="finishTimeInput[minutes]" style="background:transparent;border:none;outline:none;color:var(--text-dim);font-family:var(--font-body);font-size:14px;font-weight:300;appearance:none;-webkit-appearance:none;">
                            <option value="" disabled selected>Minutes</option>
                            <option value="0">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                    </div>
                </div>

                <!-- Additional info -->
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <label style="font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:8px;display:block;font-family:var(--font-body);">Additional information</label>
                    <textarea name="admin[notes]" maxlength="300"
                              placeholder="Tell us anything else about your event — music preferences, special requests, anything that would help us understand what you're looking for."
                              style="background:transparent;border:none;outline:none;color:var(--text-bright);font-family:var(--font-body);font-size:14px;font-weight:300;width:100%;resize:none;min-height:80px;line-height:1.7;"></textarea>
                </div>

                <!-- Hidden fields -->
                <input type="hidden" name="admin[booking_type]" value="direct">
                <input type="hidden" name="admin[status]" value="enquiry">
                <input type="hidden" name="action" value="create">

                <!-- reCAPTCHA + Submit -->
                <div style="padding:28px 0 0;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;">
                    <div class="g-recaptcha" data-sitekey="<?php echo defined('GOOGLE_RECAPTCHA_SITEKEY') ? GOOGLE_RECAPTCHA_SITEKEY : ''; ?>"></div>
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