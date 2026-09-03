<?php
/**
 * KasurCanvas.com - Products Catalog Page
 * Sourced & Re-written from SabriTextiles.com
 */
$pageTitle = 'Canvas Products Catalog | Kasur Canvas - Sabri Textiles Venture';
$metaDesc = 'Explore our comprehensive range of heavy-duty cotton duck canvas, waterproof fabrics, conveyor belt cloth, Dosuti fabrics, industrial filtration media, painter drop cloths, and tactical ripstop.';
$activeNav = 'products';

require_once __DIR__ . '/includes/header.php';

// Fetch all categories
try {
    $pdo = get_db();
    $categories = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC")->fetchAll();
    
    // Fetch all products with their categories and primary images
    $stmt = $pdo->query("SELECT p.*, c.name as category_name, c.slug as category_slug,
        (SELECT image_url FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.id ASC");
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    $categories = [];
    $products = [];
}

// Active category filter from query string if present
$selectedCat = $_GET['cat'] ?? 'all';
?>

<!-- Catalog Header Banner -->
<section style="background: linear-gradient(135deg, #090e1a 0%, #1e293b 100%); color: #ffffff; padding: 4.5rem 0 5rem;">
  <div class="container" style="text-align: center; max-width: 840px;">
    <span class="subhead" style="color: #fbbf24;">The Complete Collection</span>
    <h1 style="color: #ffffff; font-size: 2.8rem; margin-bottom: 1rem;">
      Industrial & Heavy-Duty Canvas Fabrics
    </h1>
    <p style="color: #cbd5e1; font-size: 1.1rem; line-height: 1.7;">
      Manufactured in Kasur City with 100% pure long-staple Pakistani cotton and heavy synthetic reinforcement. Sourced with pride from the master weavers of <strong>Sabri Textiles</strong>.
    </p>
  </div>
</section>

<!-- Main Products Section -->
<section class="products-section" style="background: var(--bg-body); padding: 4rem 0 6rem;">
  <div class="container">
    
    <!-- Filter & Search Toolbar -->
    <div class="catalog-toolbar">
      <div class="filter-pills">
        <button type="button" class="filter-pill <?= $selectedCat === 'all' ? 'active' : '' ?>" data-category="all">
          All Canvas Products (<?= count($products) ?>)
        </button>
        <?php foreach ($categories as $cat): ?>
          <button type="button" 
                  class="filter-pill <?= $selectedCat === $cat['slug'] ? 'active' : '' ?>" 
                  data-category="<?= htmlspecialchars($cat['id']) ?>">
            <?= htmlspecialchars($cat['name']) ?>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" id="catalogSearchInput" placeholder="Filter by product name, GSM, weave...">
      </div>
    </div>

    <!-- Product Grid -->
    <div class="product-grid">
      <?php foreach ($products as $p): ?>
        <div class="product-card" 
             data-category="<?= htmlspecialchars($p['category_id']) ?>"
             data-category-slug="<?= htmlspecialchars($p['category_slug']) ?>"
             style="<?= ($selectedCat !== 'all' && $selectedCat !== $p['category_slug']) ? 'display:none;' : '' ?>">
          
          <div class="card-media">
            <a href="<?= base_url('product-detail.php?slug=' . urlencode($p['slug'])) ?>">
              <img src="<?= base_url($p['primary_image'] ?? 'assets/images/hero-mill.jpg') ?>" 
                   alt="<?= htmlspecialchars($p['title']) ?>" 
                   loading="lazy">
            </a>
            <?php if (!empty($p['badge_text'])): ?>
              <span class="card-badge gold"><?= htmlspecialchars($p['badge_text']) ?></span>
            <?php endif; ?>
          </div>

          <div class="card-body">
            <span class="card-category"><?= htmlspecialchars($p['category_name']) ?></span>
            <h3 class="card-title">
              <a href="<?= base_url('product-detail.php?slug=' . urlencode($p['slug'])) ?>">
                <?= htmlspecialchars($p['title']) ?>
              </a>
            </h3>
            <p class="card-text"><?= htmlspecialchars($p['short_desc']) ?></p>

            <div class="card-specs-preview">
              <?php if (!empty($p['weight_spec'])): ?>
                <span class="spec-chip">⚖ <?= htmlspecialchars($p['weight_spec']) ?></span>
              <?php endif; ?>
              <?php if (!empty($p['weave_spec'])): ?>
                <span class="spec-chip">🧵 <?= htmlspecialchars($p['weave_spec']) ?></span>
              <?php endif; ?>
              <?php if (!empty($p['finish_spec'])): ?>
                <span class="spec-chip">🛡 <?= htmlspecialchars($p['finish_spec']) ?></span>
              <?php endif; ?>
            </div>

            <div class="card-footer">
              <a href="<?= base_url('product-detail.php?slug=' . urlencode($p['slug'])) ?>" class="btn btn-outline btn-sm">
                Specs & Multi-Images →
              </a>
              <button type="button" 
                      class="btn btn-primary btn-sm btn-quote-trigger" 
                      data-product-name="<?= htmlspecialchars($p['title']) ?>">
                Inquire Quote
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Custom Canvas Order Callout -->
    <div style="margin-top: 5rem; background: #ffffff; border-radius: var(--radius-xl); padding: 3rem; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
      <div style="max-width: 680px;">
        <span class="subhead">Looking for something specific?</span>
        <h3 style="font-size: 1.8rem; margin-bottom: 0.5rem;">Custom Weaves, Special GSM & Proprietary Finishes</h3>
        <p style="color: #64748b; margin-bottom: 0;">
          If your engineering project requires specific hydrostatic ratings, non-standard widths (up to 3.05m), specialty flame-retardant chemistry, or customized colored identification threads, our technical weaving laboratory in Kasur can weave sample swatches on demand.
        </p>
      </div>
      <div>
        <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>?text=Hello%20KasurCanvas,%20I%20have%20custom%20canvas%20requirements" target="_blank" class="btn btn-whatsapp btn-lg">
          Talk to a Textile Engineer 💬
        </a>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
