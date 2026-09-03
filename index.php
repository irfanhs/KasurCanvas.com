<?php
/**
 * KasurCanvas.com - Home Page
 * A New Project of SabriTextiles.com
 */
$pageTitle = 'Kasur Canvas | Heavy-Duty Cotton Canvas & Industrial Fabric Manufacturers';
$metaDesc = 'Kasur Canvas is Pakistan’s leading manufacturer and exporter of heavy-duty cotton duck canvas, waterproof waxed fabric, conveyor belt cloth, and specialty industrial textiles. Based in Kasur City, a proud venture of Sabri Textiles.';
$activeNav = 'home';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

require_once __DIR__ . '/includes/header.php';

// Fetch featured products from database
try {
    $pdo = get_db();
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name, 
        (SELECT image_url FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.is_featured = 1
        ORDER BY p.id ASC");
    $stmt->execute();
    $featuredProducts = $stmt->fetchAll();
} catch (Exception $e) {
    $featuredProducts = [];
}
?>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-pattern"></div>
  <div class="container">
    <div class="hero-grid">
      <div class="hero-content">
        <div class="hero-badge-wrap">
          <span>★</span> A New Project of SabriTextiles.com • Kasur, Pakistan
        </div>
        <h1 class="hero-title">
          Mastering the Art of <span class="highlight">Heavy-Duty Canvas</span> Since 1974.
        </h1>
        <p class="hero-desc">
          Rooted in the historic textile capital of Kasur City, <strong>Kasur Canvas</strong> manufactures world-class 100% cotton duck, weather-sealed waxed tarpaulins, heavy conveyor reinforcement fabrics, and precision technical textiles. Engineered for the most demanding global industries.
        </p>

        <div class="hero-cta">
          <a href="<?= base_url('products.php') ?>" class="btn btn-primary btn-lg">
            Explore Canvas Catalog →
          </a>
          <button type="button" class="btn btn-outline btn-lg btn-quote-trigger" data-product-name="General Wholesale Inquiry" style="color:#ffffff; border-color:rgba(255,255,255,0.25);">
            Request Mill Pricing
          </button>
        </div>

        <div class="hero-stats">
          <div class="stat-item">
            <div class="stat-number" data-target="50" data-suffix="M+">50M+</div>
            <div class="stat-label">Meters of Fabric Woven</div>
          </div>
          <div class="stat-item">
            <div class="stat-number" data-target="35" data-suffix="+">35+</div>
            <div class="stat-label">Export Destinations</div>
          </div>
          <div class="stat-item">
            <div class="stat-number" data-target="100" data-suffix="%">100%</div>
            <div class="stat-label">International Standards</div>
          </div>
        </div>
      </div>

      <!-- Hero Visual Card -->
      <div class="hero-visual">
        <div class="hero-card-img">
          <img src="<?= base_url('assets/images/hero-mill.jpg') ?>" alt="Kasur Canvas Textile Weaving Facility in Kasur, Pakistan" width="800" height="520">
        </div>
        <div class="hero-float-badge">
          <div class="float-icon">★</div>
          <div class="float-text">
            <h4>Vertically Integrated</h4>
            <p>Spinning • Twisting • Weaving • Waterproofing</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Parent Company Trust Banner -->
<section style="background: #ffffff; padding: 2.25rem 0; border-bottom: 1px solid var(--border-subtle);">
  <div class="container" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
    <div style="display:flex; align-items:center; gap:1.25rem;">
      <div style="width:52px; height:52px; border-radius:12px; background:rgba(217,119,6,0.1); color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:800;">
        50+
      </div>
      <div>
        <h4 style="font-size: 1.15rem; margin-bottom: 0.15rem;">A Prestige Venture of Sabri Textiles</h4>
        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0;">Continuing 50+ years of textile excellence from Kasur City, Pakistan to the global market.</p>
      </div>
    </div>
    <div style="display:flex; gap:1.5rem; align-items:center; flex-wrap:wrap;">
      <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="font-size:0.85rem;">
        Visit SabriTextiles.com ↗
      </a>
      <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>" target="_blank" class="btn btn-whatsapp btn-sm">
        Direct WhatsApp: <?= COMPANY_PHONE ?>
      </a>
    </div>
  </div>
</section>

<!-- Featured Products Section -->
<section class="products-section">
  <div class="container">
    <div class="section-head">
      <span class="subhead">Engineered Canvas Collection</span>
      <h2 class="section-title">Industrial Grade Canvas For Every Application</h2>
      <p class="section-desc">
        From pure natural cotton duck to chemical-resistant filter media and heavy waxed tarpaulin, explore our flagship canvas varieties woven to meet the most exacting global specifications.
      </p>
    </div>

    <div class="product-grid">
      <?php foreach ($featuredProducts as $product): ?>
        <div class="product-card" data-category="<?= htmlspecialchars($product['category_id']) ?>">
          <div class="card-media">
            <img src="<?= base_url($product['primary_image'] ?? 'assets/images/hero-mill.jpg') ?>" 
                 alt="<?= htmlspecialchars($product['title']) ?>" 
                 loading="lazy">
            <?php if (!empty($product['badge_text'])): ?>
              <span class="card-badge gold"><?= htmlspecialchars($product['badge_text']) ?></span>
            <?php endif; ?>
          </div>

          <div class="card-body">
            <span class="card-category"><?= htmlspecialchars($product['category_name']) ?></span>
            <h3 class="card-title">
              <a href="<?= base_url('product-detail.php?slug=' . urlencode($product['slug'])) ?>">
                <?= htmlspecialchars($product['title']) ?>
              </a>
            </h3>
            <p class="card-text"><?= htmlspecialchars($product['short_desc']) ?></p>

            <div class="card-specs-preview">
              <?php if (!empty($product['weight_spec'])): ?>
                <span class="spec-chip">⚖ <?= htmlspecialchars($product['weight_spec']) ?></span>
              <?php endif; ?>
              <?php if (!empty($product['weave_spec'])): ?>
                <span class="spec-chip">🧵 <?= htmlspecialchars($product['weave_spec']) ?></span>
              <?php endif; ?>
            </div>

            <div class="card-footer">
              <a href="<?= base_url('product-detail.php?slug=' . urlencode($product['slug'])) ?>" class="btn btn-outline btn-sm">
                View Specs & Gallery
              </a>
              <button type="button" class="btn btn-primary btn-sm btn-quote-trigger" data-product-name="<?= htmlspecialchars($product['title']) ?>">
                Inquire Quote
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3.5rem;">
      <a href="<?= base_url('products.php') ?>" class="btn btn-navy btn-lg">
        Browse All Canvas Products & Fabrics →
      </a>
    </div>
  </div>
</section>

<!-- Manufacturing Heritage in Kasur City -->
<section class="craft-section">
  <div class="container">
    <div class="craft-grid">
      <div class="craft-content">
        <span class="subhead">The Kasur Heritage</span>
        <h2>Woven in Pakistan's Traditional Heart of Textile Excellence</h2>
        <p style="color: #475569; font-size: 1.05rem;">
          Kasur City in Punjab has for centuries been synonymous with durable cotton weaving and textile craftsmanship. As a modern extension of <strong>Sabri Textiles</strong>, Kasur Canvas blends this rich historical heritage with contemporary European shuttleless air-jet looms and stringent ISO testing laboratories.
        </p>

        <div class="craft-features">
          <div class="craft-feat-item">
            <div class="craft-icon">1</div>
            <div>
              <h4>Virgin Combed Cotton</h4>
              <p>Strictly selected long-staple Pakistani cotton ensures supreme tensile strength.</p>
            </div>
          </div>
          <div class="craft-feat-item">
            <div class="craft-icon">2</div>
            <div>
              <h4>Ring Twisting</h4>
              <p>Heavy plied yarns (up to 4-ply and 6-ply) engineered to withstand friction and tear.</p>
            </div>
          </div>
          <div class="craft-feat-item">
            <div class="craft-icon">3</div>
            <div>
              <h4>Computerized Weaving</h4>
              <p>High-tension air-jet looms ensure consistent thread count and zero structural flaws.</p>
            </div>
          </div>
          <div class="craft-feat-item">
            <div class="craft-icon">4</div>
            <div>
              <h4>Weatherproof Chemistry</h4>
              <p>Specialized wax, fluorocarbon, and PU coatings for extreme outdoor durability.</p>
            </div>
          </div>
        </div>

        <a href="<?= base_url('about.php') ?>" class="btn btn-primary">
          Read Our Manufacturing Story →
        </a>
      </div>

      <div class="craft-img-wrap">
        <img src="<?= base_url('assets/images/kasur-heritage.jpg') ?>" alt="Kasur Canvas Textile Factory Machinery in Kasur City" width="700" height="480">
      </div>
    </div>
  </div>
</section>

<!-- Global Export & Custom Specifications Banner -->
<section style="background: linear-gradient(135deg, #090e1a 0%, #0f172a 100%); color: #ffffff; padding: 5rem 0;">
  <div class="container">
    <div style="text-align: center; max-width: 820px; margin: 0 auto 3rem;">
      <span class="subhead" style="color: #fbbf24;">Tailored Manufacturing</span>
      <h2 style="color: #ffffff; font-size: 2.4rem; margin-bottom: 1rem;">Custom Sizes, Weights & Finishes On Demand</h2>
      <p style="color: #cbd5e1; font-size: 1.05rem;">
        Do you need specific GSM densities, custom roll widths up to 120 inches, flame-retardant certification (BS 5867 / NFPA 701), or specialized defense-grade camouflage shades? Our Kasur mill develops custom canvas runs tailored to your exact bill of materials.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.75rem;">
      <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-lg); padding: 1.75rem; text-align: center;">
        <div style="font-size: 2.2rem; margin-bottom: 0.75rem;">📐</div>
        <h4 style="color:#ffffff; margin-bottom: 0.5rem;">Custom Widths</h4>
        <p style="color:#94a3b8; font-size:0.875rem; margin-bottom:0;">Seamless rolls from 36 inches up to 120 inches wide without joints.</p>
      </div>

      <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-lg); padding: 1.75rem; text-align: center;">
        <div style="font-size: 2.2rem; margin-bottom: 0.75rem;">⚖️</div>
        <h4 style="color:#ffffff; margin-bottom: 0.5rem;">7oz to 36oz Weights</h4>
        <p style="color:#94a3b8; font-size:0.875rem; margin-bottom:0;">From lightweight liners and bags to heavy industrial conveyor belt plies.</p>
      </div>

      <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-lg); padding: 1.75rem; text-align: center;">
        <div style="font-size: 2.2rem; margin-bottom: 0.75rem;">🛡️</div>
        <h4 style="color:#ffffff; margin-bottom: 0.5rem;">Specialty Chemical Finishes</h4>
        <p style="color:#94a3b8; font-size:0.875rem; margin-bottom:0;">Waterproofing, wax emulsion, fire retardancy, rot & mildew inhibition.</p>
      </div>

      <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-lg); padding: 1.75rem; text-align: center;">
        <div style="font-size: 2.2rem; margin-bottom: 0.75rem;">🚢</div>
        <h4 style="color:#ffffff; margin-bottom: 0.5rem;">Export Ready Packaging</h4>
        <p style="color:#94a3b8; font-size:0.875rem; margin-bottom:0;">Moisture-barrier shrink wrapped export rolls with international barcoding.</p>
      </div>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
      <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>?text=Hello,%20I%20have%20custom%20canvas%20specifications%20for%20my%20order" target="_blank" class="btn btn-whatsapp btn-lg">
        Discuss Custom Specifications on WhatsApp →
      </a>
    </div>
  </div>
</section>

<!-- Call to Action Banner -->
<section style="padding: 5rem 0; background: #ffffff;">
  <div class="container">
    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: var(--radius-xl); padding: 3.5rem; border: 1px solid #fcd34d; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
      <div style="max-width: 650px;">
        <span class="subhead" style="color: #b45309;">Ready to place an order?</span>
        <h2 style="color: #78350f; font-size: 2.2rem; margin-bottom: 0.75rem;">Get Direct Manufacturer Pricing From Kasur Canvas</h2>
        <p style="color: #92400e; font-size: 1.05rem; margin-bottom: 0;">
          Direct communication with our mill sales engineers in Kasur. Sample swatches shipped worldwide for verification.
        </p>
      </div>
      <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="<?= base_url('contact.php') ?>" class="btn btn-navy btn-lg">
          Contact Our Team
        </a>
        <button type="button" class="btn btn-primary btn-lg btn-quote-trigger" data-product-name="General Export Quote">
          Instant RFQ
        </button>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
