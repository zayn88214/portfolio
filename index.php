<?php
require_once 'db.php';

try {
    $settings = getSettings($pdo);
    $stats = $pdo->query("SELECT * FROM stats ORDER BY id ASC")->fetchAll();
    $projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
    $services = $pdo->query("SELECT * FROM services ORDER BY id ASC")->fetchAll();
    $faqs = $pdo->query("SELECT * FROM faqs ORDER BY id ASC")->fetchAll();
    $skills = $pdo->query("SELECT * FROM skills ORDER BY id ASC")->fetchAll();
    $education = $pdo->query("SELECT * FROM education ORDER BY year DESC")->fetchAll();
} catch (PDOException $e) {
    die("<div style='font-family: sans-serif; padding: 2rem; max-width: 600px; margin: 50px auto; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;'>
            <h2 style='color: #dc2626; margin-top: 0;'>Database Tables Missing</h2>
            <p style='color: #450a0a;'>The database is connected, but the tables are missing. Did you forget to import the <b>zainfolio_database_export.sql</b> file in phpMyAdmin?</p>
            <p style='margin-top: 15px; color: #7f1d1d; font-size: 0.8rem;'>Error trace: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>
         </div>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        <?= e($settings['site_title'] ?? 'Zain Ul Abideen | Full Stack Web Developer') ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" type="image/x-icon" href="images/coding.png" />
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
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
                <a class="nav-link" href="#about">About Me</a>
                <a class="nav-link" href="#services">Services</a>
                <a class="nav-link" href="#projects">Projects</a>
                <a class="nav-link" href="contact.php">Contact</a>
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
            <a class="nav-link" href="#about">About Me</a>
            <a class="nav-link" href="#services">Services</a>
            <a class="nav-link" href="#projects">Projects</a>
            <a class="nav-link" href="contact.php">Contact</a>
            <a href="contact.php" class="btn btn-hire">Hire Me</a>
        </div>
    </header>

    <main>
        <section class="hero reveal">
            <div class="container hero-grid reveal-stagger">
                <div class="hero-copy">
                    <p class="eyebrow">
                        <?= e($settings['hero_eyebrow'] ?? '') ?>
                    </p>
                    <h1>
                        <?= e($settings['hero_title_1'] ?? '') ?> <span>
                            <?= e($settings['hero_title_2'] ?? '') ?>
                        </span>
                        <span class="accent">
                            <?= e($settings['hero_accent'] ?? '') ?>
                        </span>
                    </h1>
                    <p class="subhead">
                        <?= e($settings['hero_subhead'] ?? '') ?>
                    </p>
                    <p class="lead">
                        <?= e($settings['hero_lead'] ?? '') ?>
                    </p>
                    <div class="hero-actions">
                        <a href="#about" class="btn btn-primary">Discover More</a>
                        <a href="contact.php" class="btn btn-ghost">Hire Me</a>
                    </div>
                    <div class="hero-icons-row">
                        <a class="icon-link" href="<?= e($settings['github_link'] ?? '#') ?>" target="_blank"
                            rel="noreferrer" aria-label="GitHub">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 21.13V24m7-12a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7">
                                </path>
                            </svg>
                        </a>
                        <a class="icon-link" href="<?= e($settings['email_link'] ?? '#') ?>" aria-label="Email">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </a>
                        <a class="icon-link" href="<?= e($settings['linkedin_link'] ?? '#') ?>" target="_blank"
                            rel="noreferrer" aria-label="LinkedIn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.469v6.766z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="hero-media">
                    <div class="profile-card float">
                        <img src="<?= e($settings['profile_image_hero'] ?? '') ?>" alt="Zain ul Abideen" />
                    </div>
                    <div class="stats">
                        <?php foreach ($stats as $s): ?>
                            <div class="stat" data-target="<?= e($s['target_number']) ?>">
                                <span class="count">0</span>
                                <p>
                                    <?= e($s['label']) ?>
                                </p>
                            </div>
                            <?php
                        endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="scroll-indicator">
                <span>Scroll Down</span>
                <div class="scroll-line"></div>
            </div>
        </section>

        <section id="about" class="about reveal">
            <div class="container about-grid reveal-stagger">
                <div class="about-copy">
                    <p class="eyebrow">
                        <?= e($settings['about_eyebrow'] ?? '') ?>
                    </p>
                    <h2>
                        <?= e($settings['about_heading'] ?? '') ?>
                    </h2>
                    <p>
                        <?= e($settings['about_text'] ?? '') ?>
                    </p>
                    <div class="hero-actions">
                        <a href="#projects" class="btn btn-primary">Discover More</a>
                        <a href="contact.php" class="btn btn-ghost">Hire Me</a>
                    </div>
                </div>
                <div class="about-card">
                    <img src="<?= e($settings['about_image'] ?? '') ?>" alt="Profile" />
                    <div class="available">Available for work</div>
                </div>
            </div>

            <div class="container" style="margin-top: 4rem;">
                <div class="tabs">
                    <button class="tab active" data-tab="education">Education</button>
                    <button class="tab" data-tab="skills">Skills</button>
                </div>

                <!-- Education Panel -->
                <div class="tab-panel active" data-tab="education">
                    <div class="section-head">
                        <p class="eyebrow">Education</p>
                        <h2>Academic timeline</h2>
                    </div>
                    <div class="timeline reveal-stagger">
                        <?php foreach ($education as $e): ?>
                            <div class="timeline-item">
                                <span class="badge"><?= e($e['year']) ?></span>
                                <h3><?= e($e['title']) ?></h3>
                                <p><?= e($e['school']) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($education)): ?>
                            <p>Education details will be updated soon.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Skills Panel -->
                <div class="tab-panel" data-tab="skills">
                    <div class="section-head">
                        <p class="eyebrow">Skills</p>
                        <h2>Technical strengths</h2>
                    </div>
                    <div class="skills-grid reveal-stagger">
                        <?php foreach ($skills as $index => $s): ?>
                            <div class="skill-icon skill-icon-<?= ($index % 14) + 1 ?>">
                                <iconify-icon icon="<?= e($s['icon']) ?>" aria-hidden="true"></iconify-icon>
                                <p><?= e($s['name']) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($skills)): ?>
                            <p>Skills will be updated soon.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Profile Panel -->

            </div>
        </section>

        <section id="projects" class="work reveal">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">
                        <?= e($settings['work_eyebrow'] ?? '') ?>
                    </p>
                    <h2>
                        <?= e($settings['work_heading'] ?? '') ?>
                    </h2>
                    <p>
                        <?= e($settings['work_text'] ?? '') ?>
                    </p>
                </div>
                <div class="project-grid reveal-stagger">
                    <?php if (empty($projects)): ?>
                        <article class="project-card">
                            <h3>Projects are about to upload soon</h3>
                            <p>Fresh work is on the way. Please check back shortly.</p>
                        </article>
                        <?php
                    else: ?>
                        <?php foreach ($projects as $p): ?>
                            <article class="project-card portfolio-item" data-title="<?= e($p['title']) ?>"
                                data-desc="<?= e($p['description']) ?>" data-link="<?= e($p['link']) ?>"
                                style="cursor: pointer;">
                                <?php if ($p['image_path']): ?>
                                    <img src="<?= e($p['image_path']) ?>" alt="<?= e($p['title']) ?>"
                                        style="width: 100%; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                                    <?php
                                endif; ?>
                                <h3>
                                    <?= e($p['title']) ?>
                                </h3>
                                <p>
                                    <?= e(mb_strimwidth($p['description'], 0, 80, "...")) ?>
                                </p>
                                <span
                                    style="font-size: 0.8rem; background: var(--border-color); padding: 0.2rem 0.6rem; border-radius: 4px; margin-top: 1rem; display: inline-block;">
                                    <?= e($p['category']) ?>
                                </span>
                            </article>
                            <?php
                        endforeach; ?>
                        <?php
                    endif; ?>
                </div>
            </div>
        </section>

        <section id="services" class="work reveal">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">
                        <?= e($settings['services_eyebrow'] ?? '') ?>
                    </p>
                    <h2>
                        <?= e($settings['services_heading'] ?? '') ?>
                    </h2>
                    <p>
                        <?= e($settings['services_text'] ?? '') ?>
                    </p>
                </div>
                <div class="highlight-grid reveal-stagger">
                    <?php foreach ($services as $s): ?>
                        <div class="highlight-card">
                            <h3>
                                <?= e($s['title']) ?>
                            </h3>
                            <p>
                                <?= e($s['description']) ?>
                            </p>
                        </div>
                        <?php
                    endforeach; ?>
                </div>
            </div>
        </section>

        <section id="faq" class="faq reveal">
            <div class="container">
                <div class="section-head">
                    <p class="eyebrow">
                        <?= e($settings['faq_eyebrow'] ?? '') ?>
                    </p>
                    <h2>
                        <?= e($settings['faq_heading'] ?? '') ?>
                    </h2>
                </div>
                <div class="faq-list reveal-stagger">
                    <?php foreach ($faqs as $f): ?>
                        <button class="faq-item" aria-expanded="false">
                            <span>
                                <?= e($f['question']) ?>
                            </span>
                            <span class="icon">+</span>
                        </button>
                        <div class="faq-panel">
                            <p>
                                <?= e($f['answer']) ?>
                            </p>
                        </div>
                        <?php
                    endforeach; ?>
                </div>
            </div>
        </section>

        <section class="cta reveal">
            <div class="container cta-inner">
                <div>
                    <p class="eyebrow">
                        <?= e($settings['cta_eyebrow'] ?? '') ?>
                    </p>
                    <h2>
                        <?= e($settings['cta_heading'] ?? '') ?>
                    </h2>
                </div>
                <a href="contact.php" class="btn btn-primary">Contact Me</a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
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
                    <?= e($settings['footer_copyright'] ?? '') ?>
                </p>
                <a class="footer-meta-item" href="<?= e($settings['email_link'] ?? '#') ?>">
                    <span class="footer-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <span>
                        <?= e(str_replace('mailto:', '', $settings['email_link'] ?? '')) ?>
                    </span>
                </a>
                <a class="footer-meta-item" href="tel:<?= e(str_replace(' ', '', $settings['phone_number'] ?? '')) ?>">
                    <span class="footer-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72c.12.86.3 1.7.57 2.5a2 2 0 0 1-.45 2.11L9 10a16 16 0 0 0 5 5l.67-1.12a2 2 0 0 1 2.11-.45c.8.27 1.64.45 2.5.57A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </span>
                    <span>
                        <?= e($settings['phone_number'] ?? '') ?>
                    </span>
                </a>
            </div>
            <div class="footer-socials">
                <a class="footer-social" href="<?= e($settings['github_link'] ?? '#') ?>" target="_blank"
                    rel="noreferrer" aria-label="GitHub">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 21.13V24">
                        </path>
                    </svg>
                </a>
                <a class="footer-social" href="<?= e($settings['linkedin_link'] ?? '#') ?>" target="_blank"
                    rel="noreferrer" aria-label="LinkedIn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.469v6.766z">
                        </path>
                    </svg>
                </a>
                <a class="footer-social" href="<?= e($settings['email_link'] ?? '#') ?>" aria-label="Email">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <!-- Portfolio Modal -->
    <div id="portfolioModal" class="portfolio-modal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-content">
            <button class="modal-close" aria-label="Close modal">&times;</button>
            <img class="modal-image" src="" alt="Project Image">
            <div class="modal-body">
                <h2 class="modal-title"></h2>
                <p class="modal-desc"></p>
                <a href="#" class="btn btn-primary modal-link" target="_blank" rel="noreferrer">View Live Project</a>
            </div>
        </div>
    </div>

    <!-- Cookie Banner -->
    <div class="cookie" role="dialog" aria-live="polite">
        <div class="cookie-inner">
            <div>
                <h3>Cookies & Privacy</h3>
                <p>
                    Your privacy is important to us. We use cookies to improve your
                    browsing experience, provide essential site functionality, and
                    understand how you interact with our website.
                </p>
            </div>
            <div class="cookie-actions">
                <button class="btn btn-primary" id="acceptCookies">Accept All Cookies</button>
                <button class="btn btn-ghost" id="rejectCookies">Reject</button>
                <button class="btn btn-outline" id="customizeCookies">Customize</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>