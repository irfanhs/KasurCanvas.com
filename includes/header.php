<?php
/**
 * KasurCanvas.com - Modern Header Component
 * A Project of SabriTextiles.com
 */
require_once __DIR__ . '/../config/db.php';

$pageTitle = $pageTitle ?? SITE_NAME . ' | ' . SITE_TAGLINE;
$metaDesc = $metaDesc ?? 'Kasur Canvas is the premier manufacturer and exporter of heavy-duty cotton canvas, waterproof fabric, conveyor duck, and specialty industrial textiles in Kasur, Pakistan. A new project of Sabri Textiles.';
$activeNav = $activeNav ?? 'home';

// Fetch categories for navbar dropdown
try {
    $pdo = get_db();
    $navCategories = $pdo->query("SELECT * FROM `categories` ORDER BY `display_order` ASC")->fetchAll();
    $navProducts = $pdo->query("SELECT `id`, `slug`, `title` FROM `products` ORDER BY `id` ASC LIMIT 6")->fetchAll();
} catch (Exception $e) {
    $navCategories = [];
    $navProducts = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
  <link rel="canonical" href="<?= base_url() ?>">
  
  <!-- OpenGraph Metadata -->
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= base_url() ?>">
  <meta property="og:image" content="<?= base_url('assets/images/hero-mill.jpg') ?>">

  <!-- Google Fonts & Stylesheet -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

  <!-- Top Notification & Hotline Bar -->
  <div class="topbar">
    <div class="container">
      <div class="topbar-left">
        <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" class="parent-badge" title="Visit parent group Sabri Textiles">
          <span></span> A Venture of SabriTextiles.com (Est. 1974)
        </a>
        <span style="opacity: 0.5;">|</span>
        <span class="topbar-link">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
          Kasur City, Punjab, Pakistan
        </span>
      </div>
      <div class="topbar-right">
        <a href="tel:<?= COMPANY_PHONE_RAW ?>" class="topbar-link">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          <?= COMPANY_PHONE ?>
        </a>
        <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>?text=Hi%20KasurCanvas,%20I%20need%20information%20about%20your%20canvas%20cloth%20manufacturing" target="_blank" class="topbar-link" style="color:#4ade80;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
          WhatsApp Inquiry
        </a>
        <a href="mailto:<?= COMPANY_EMAIL ?>" class="topbar-link">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <?= COMPANY_EMAIL ?>
        </a>
      </div>
    </div>
  </div>

  <!-- Sticky Navbar -->
  <header class="site-header">
    <div class="container">
      <nav class="navbar">
        <a href="<?= base_url('home.php') ?>" class="brand-logo" title="Kasur Canvas - KasurCanvas.com">
          <img src="<?= base_url('assets/images/logo.svg') ?>" alt="Kasur Canvas Logo" width="240" height="52">
        </a>

        <!-- Desktop Navigation -->
        <ul class="nav-menu">
          <li>
            <a href="<?= base_url('home.php') ?>" class="nav-link <?= $activeNav === 'home' ? 'active' : '' ?>">Home</a>
          </li>
          <li class="nav-dropdown">
            <a href="<?= base_url('products.php') ?>" class="nav-link <?= $activeNav === 'products' ? 'active' : '' ?>">
              Canvas Products ▾
            </a>
            <div class="dropdown-menu">
              <a href="<?= base_url('products.php') ?>" class="dropdown-item" style="font-weight:700;border-bottom:1px solid #f1f5f9;">
                All Canvas Products →
              </a>
              <?php foreach ($navProducts as $np): ?>
                <a href="<?= base_url('product-detail.php?slug=' . urlencode($np['slug'])) ?>" class="dropdown-item">
                  <?= htmlspecialchars($np['title']) ?>
                </a>
              <?php endforeach; ?>
            </div>
          </li>
          <li>
            <a href="<?= base_url('about.php') ?>" class="nav-link <?= $activeNav === 'about' ? 'active' : '' ?>">About Us</a>
          </li>
          <li>
            <a href="<?= base_url('contact.php') ?>" class="nav-link <?= $activeNav === 'contact' ? 'active' : '' ?>">Contact Us</a>
          </li>
        </ul>

        <!-- Action CTAs -->
        <div class="nav-actions">
          <button type="button" class="btn btn-primary btn-sm btn-quote-trigger" data-product-name="General Export Inquiry">
            Request Quote
          </button>
          <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>" target="_blank" class="btn btn-whatsapp btn-sm" title="Quick WhatsApp Chat">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            WhatsApp
          </a>
          <button class="mobile-toggle" aria-label="Toggle navigation">☰</button>
        </div>
      </nav>
    </div>
  </header>
