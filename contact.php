<?php
require_once 'db.php';
$settings = getSettings($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact |
        <?= e($settings['site_title'] ?? 'Zain Ul Abideen')?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" type="image/x-icon" href="images/coding.png" />
</head>

<body>
    <div class="ambient-bg" aria-hidden="true"></div>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="index.php" aria-label="Zain home">
                <span class="brand-mark">&lt;/&gt;</span>
                <span class="brand-text">ZAIN</span>
            </a>
            <nav class="nav">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="index.php#about">About Me</a>
                <a class="nav-link" href="index.php#services">Services</a>
                <a class="nav-link" href="index.php#projects">Projects</a>
                <a class="nav-link is-active" href="contact.php">Contact</a>
            </nav>
            <div class="nav-actions">
                <button class="nav-toggle" type="button" aria-label="Toggle menu" aria-expanded="false">
                    <span class="nav-toggle-bar" aria-hidden="true"></span>
                </button>
                <button class="theme-toggle" type="button" aria-label="Toggle theme">
                    <span class="theme-dot" aria-hidden="true"></span>
                </button>
                <a href="contact.php" class="btn btn-hire">Hire Me</a>
            </div>
        </div>
        <div class="mobile-nav" aria-label="Mobile navigation">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="index.php#about">About Me</a>
            <a class="nav-link" href="index.php#services">Services</a>
            <a class="nav-link" href="index.php#projects">Projects</a>
            <a class="nav-link is-active" href="contact.php">Contact</a>
            <a href="contact.php" class="btn btn-hire">Hire Me</a>
        </div>
    </header>

    <main>
        <section class="page-hero reveal">
            <div class="container">
                <span class="badge">Let's Connect</span>
                <h1>Ready to bring your ideas to life?</h1>
                <p>Let's discuss your project and create something amazing together. My inbox is always open for
                    collaboration, web development, UI/UX design, or consultancy.</p>
            </div>
        </section>

        <section class="work reveal">
            <div class="container split contact-grid reveal-stagger">
                <div class="contact-form-wrapper">
                    <div class="section-head">
                        <p class="eyebrow">Let's Work Together</p>
                        <h2>Hi, I'm
                            <?= e($settings['hero_title_1'] ?? 'Zain')?>!
                        </h2>
                        <p>Fill out the form below to collaborate on your next build.</p>
                    </div>
                    <form class="modern-form" id="contactForm">
                        <div id="successMessage"
                            style="display: none; padding: 15px; background-color: #4CAF50; color: white; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                            ✓ Message Sent Successfully! I'll get back to you soon.
                        </div>
                        <div id="errorMessage"
                            style="display: none; padding: 15px; background-color: #f44336; color: white; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="first_name" placeholder="Your first name"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="last_name" placeholder="Your last name"
                                    required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="your.email@example.com"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="+92 XXX XXXXXXX" />
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" placeholder="Tell me about your project..."
                                required></textarea>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">Send Message</button>
                            <button class="btn btn-outline" type="reset">Clear</button>
                        </div>
                    </form>
                </div>
                <aside class="contact-info-card">
                    <div class="profile-section">
                        <img src="<?= e($settings['about_image'] ?? 'images/profileimg.png')?>" alt="Zain Ul Abideen"
                            class="profile-image" />
                        <div class="availability-badge">Available for work</div>
                    </div>
                    <div class="info-content">
                        <h3>
                            <?= e(($settings['hero_title_1'] ?? '') . ' ' . ($settings['hero_title_2'] ?? ''))?>
                        </h3>
                        <div class="socials-links">
                            <a href="<?= e($settings['linkedin_link'] ?? '#')?>" target="_blank"
                                rel="noreferrer">LinkedIn</a>
                            <a href="<?= e($settings['github_link'] ?? '#')?>" target="_blank"
                                rel="noreferrer">GitHub</a>
                            <a href="<?= e($settings['email_link'] ?? '#')?>">Email</a>
                        </div>
                        <div class="contact-details">
                            <div class="detail-item">
                                <span class="label">Phone</span>
                                <p>
                                    <?= e($settings['phone_number'] ?? '')?>
                                </p>
                            </div>
                            <div class="detail-item">
                                <span class="label">Email</span>
                                <p>
                                    <?= e(str_replace('mailto:', '', $settings['email_link'] ?? ''))?>
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <!-- Duplicate Footer from index.php or ideally use require_once 'footer.php', but keeping it simple self-contained -->
        <div class="container footer-inner">
            <div class="footer-brand">
                <a class="brand" href="index.php" aria-label="Zain Ul Abideen home">
                    <span class="brand-mark">&lt;/&gt;</span>
                    <span class="brand-text">Zain</span>
                </a>
                <button class="cookie-settings" type="button">Cookie Settings</button>
            </div>
            <div class="footer-meta">
                <p>
                    <?= e($settings['footer_copyright'] ?? '')?>
                </p>
                <a class="footer-meta-item" href="<?= e($settings['email_link'] ?? '#')?>">
                    <span class="footer-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <span>
                        <?= e(str_replace('mailto:', '', $settings['email_link'] ?? ''))?>
                    </span>
                </a>
                <a class="footer-meta-item" href="tel:<?= e(str_replace(' ', '', $settings['phone_number'] ?? ''))?>">
                    <span class="footer-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72c.12.86.3 1.7.57 2.5a2 2 0 0 1-.45 2.11L9 10a16 16 0 0 0 5 5l.67-1.12a2 2 0 0 1 2.11-.45c.8.27 1.64.45 2.5.57A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </span>
                    <span>
                        <?= e($settings['phone_number'] ?? '')?>
                    </span>
                </a>
            </div>
            <div class="footer-socials">
                <a class="footer-social" href="<?= e($settings['github_link'] ?? '#')?>" target="_blank"
                    rel="noreferrer" aria-label="GitHub">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 21.13V24">
                        </path>
                    </svg>
                </a>
                <a class="footer-social" href="<?= e($settings['linkedin_link'] ?? '#')?>" target="_blank"
                    rel="noreferrer" aria-label="LinkedIn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.469v6.766z">
                        </path>
                    </svg>
                </a>
                <a class="footer-social" href="<?= e($settings['email_link'] ?? '#')?>" aria-label="Email">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>