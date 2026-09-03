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
      <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>" target="_blank" rel="noopener" class="btn btn-whatsapp btn-sm" style="font-size:0.85rem;">
        Chat With Export Desk
      </a>
    </div>
  </div>
</section>

<!-- Featured Canvas Products Grid -->
<section class="products-section" style="background: var(--bg-body);">
  <div class="container">
    <div class="section-header">
      <span class="subhead">Heavy-Duty Portfolio</span>
      <h2>Featured Industrial Canvas Qualities</h2>
      <p>Precision-woven on state-of-the-art air-jet and heavy projectile looms using premium virgin cotton yarns and high-tenacity synthetic reinforcement.</p>
    </div>

    <div class="product-grid">
      <?php foreach ($featuredProducts as $p): ?>
        <div class="product-card">
          <div class="card-media">
            <a href="<?= base_url('product-detail.php?slug=' . urlencode($p['slug'])) ?>">
              <img src="<?= base_url($p['primary_image'] ?: 'assets/images/hero-mill.jpg') ?>" 
                   alt="<?= htmlspecialchars($p['title']) ?>" 
                   loading="lazy" 
                   width="420" 
                   height="260">
            </a>
            <?php if (!empty($p['badge_text'])): ?>
              <span class="card-badge"><?= htmlspecialchars($p['badge_text']) ?></span>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <span class="card-category"><?= htmlspecialchars($p['category_name'] ?? 'Industrial Canvas') ?></span>
            <h3 class="card-title">
              <a href="<?= base_url('product-detail.php?slug=' . urlencode($p['slug'])) ?>">
                <?= htmlspecialchars($p['title']) ?>
              </a>
            </h3>
            <p class="card-desc">
              <?= htmlspecialchars(mb_strimwidth($p['short_desc'], 0, 140, '...')) ?>
            </p>

            <div class="card-specs">
              <div class="spec-pill">
                <strong>Weight:</strong> <?= htmlspecialchars(mb_strimwidth($p['weight_spec'], 0, 26, '...')) ?>
              </div>
              <div class="spec-pill">
                <strong>Weave:</strong> <?= htmlspecialchars(mb_strimwidth($p['weave_spec'], 0, 26, '...')) ?>
              </div>
            </div>

            <div class="card-footer">
              <a href="<?= base_url('product-detail.php?slug=' . urlencode($p['slug'])) ?>" class="btn btn-primary btn-sm">
                View Specifications →
              </a>
              <button type="button" class="btn btn-outline btn-sm btn-quote-trigger" data-product-name="<?= htmlspecialchars($p['title']) ?>">
                Inquire
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3.5rem;">
      <a href="<?= base_url('products.php') ?>" class="btn btn-primary btn-lg">
        View All Canvas Products & Custom Specifications →
      </a>
    </div>
  </div>
</section>

<!-- Manufacturing Capability & Mill Showcase -->
<section class="craft-section">
  <div class="container">
    <div class="craft-grid">
      <div class="craft-content">
        <span class="subhead">Vertically Integrated Mills</span>
        <h2>From Raw Cotton Bales to Heavy Export Fabrics</h2>
        <p>
          Unlike trading intermediaries, <strong>Kasur Canvas</strong> controls the entire production cycle under one industrial roof. Located in Kasur City — the epicenter of Punjab's textile prowess — our facility leverages vertically integrated processing:
        </p>

        <div class="craft-features">
          <div class="craft-feature-item">
            <div class="icon">01</div>
            <div class="text">
              <h4>Ring Spinning & Heavy Twisting</h4>
              <p>Spinning high-tenacity 10/2, 7/2, and plied yarn counts from pure combed Pakistani cotton fibers.</p>
            </div>
          </div>
          <div class="craft-feature-item">
            <div class="icon">02</div>
            <div class="text">
              <h4>High-Speed Air-Jet & Projectile Looms</h4>
              <p>Woven on computer-controlled looms producing seamless widths from 36 inches up to 120 inches (3+ meters).</p>
            </div>
          </div>
          <div class="craft-feature-item">
            <div class="icon">03</div>
            <div class="text">
              <h4>Weatherproofing & Specialty Finishes</h4>
              <p>Continuous paraffin wax immersion, hydrophobic fluorocarbon finishes, rot-proofing, and flame retardancy.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="craft-img-wrap">
        <img src="<?= base_url('assets/images/warehouse-rolls.jpg') ?>" 
             alt="Kasur Canvas Textile Warehouse Inventory in Kasur, Pakistan" 
             loading="lazy" 
             width="680" 
             height="520">
      </div>
    </div>
  </div>
</section>

<!-- Technical Applications Section -->
<section style="background: #ffffff; padding: 5rem 0; border-top: 1px solid var(--border-subtle);">
  <div class="container">
    <div class="section-header">
      <span class="subhead">End-Use Engineering</span>
      <h2>Serving Demanding Global Sectors</h2>
      <p>Our heavy fabrics are tested and deployed across critical industrial, commercial, and institutional applications globally.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem;">
      <div style="background: #f8fafc; padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); transition: var(--transition);">
        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🎪</div>
        <h4 style="margin-bottom: 0.5rem; font-size: 1.15rem;">Relief & Military Shelters</h4>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6;">Weatherproof army canvas and flame-retardant relief tents engineered to endure desert heat and monsoon downpours.</p>
      </div>

      <div style="background: #f8fafc; padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); transition: var(--transition);">
        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🚛</div>
        <h4 style="margin-bottom: 0.5rem; font-size: 1.15rem;">Transport & Logistics Tarps</h4>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6;">High-tensile truck tarpaulins and maritime cargo covers with double-stitched hems and solid brass eyelets.</p>
      </div>

      <div style="background: #f8fafc; padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); transition: var(--transition);">
        <div style="font-size: 2rem; margin-bottom: 0.75rem;">⚙️</div>
        <h4 style="margin-bottom: 0.5rem; font-size: 1.15rem;">Conveyor & Power Belting</h4>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6;">Synthetic-cotton composite fabrics calibrated for rubber transmission belts and continuous mining conveyors.</p>
      </div>

      <div style="background: #f8fafc; padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); transition: var(--transition);">
        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🛡️</div>
        <h4 style="margin-bottom: 0.5rem; font-size: 1.15rem;">Contractor Protection</h4>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6;">Triple-AAA painter canvas drop cloths and tactical ripstop luggage textiles designed for extreme resistance.</p>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Banner -->
<section style="background: linear-gradient(135deg, var(--primary-navy) 0%, #0f172a 100%); color:#ffffff; padding: 5rem 0; text-align: center;">
  <div class="container" style="max-width: 780px;">
    <span class="subhead" style="color: #fbbf24;">Direct Mill Partnership</span>
    <h2 style="color:#ffffff; font-size: 2.4rem; margin-bottom: 1.25rem;">Looking for Custom Canvas Specs or Container Quotes?</h2>
    <p style="color:#cbd5e1; font-size: 1.05rem; line-height: 1.8; margin-bottom: 2.25rem;">
      We manufacture to your precise GSM, width, yarn count, and finishing specifications. Benefit from mill-direct pricing and personalized export documentation from Kasur City, Pakistan.
    </p>
    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
      <button type="button" class="btn btn-primary btn-lg btn-quote-trigger" data-product-name="Custom Mill Order Inquiry">
        Request Custom Quote →
      </button>
      <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>" target="_blank" rel="noopener" class="btn btn-whatsapp btn-lg">
        WhatsApp Export Desk
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
