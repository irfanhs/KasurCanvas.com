<?php
/**
 * KasurCanvas.com - Product Detail Page with Multi-Image Gallery
 * A New Project of SabriTextiles.com
 */
require_once __DIR__ . '/config/db.php';

$slug = trim($_GET['slug'] ?? '');
if (empty($slug)) {
    header('Location: ' . base_url('products.php'));
    exit;
}

try {
    $pdo = get_db();
    
    // Fetch product
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    $product = $stmt->fetch();

    if (!$product) {
        header('Location: ' . base_url('products.php'));
        exit;
    }

    // Fetch multi-images for this product
    $stmtImg = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, display_order ASC");
    $stmtImg->execute([$product['id']]);
    $images = $stmtImg->fetchAll();

    // Fetch related products in the same category or other products
    $stmtRel = $pdo->prepare("SELECT p.*, c.name as category_name,
        (SELECT image_url FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id != ?
        ORDER BY RAND() LIMIT 3");
    $stmtRel->execute([$product['id']]);
    $relatedProducts = $stmtRel->fetchAll();

} catch (Exception $e) {
    die("Error loading product: " . htmlspecialchars($e->getMessage()));
}

$pageTitle = $product['title'] . ' | Kasur Canvas Manufacturers';
$metaDesc = htmlspecialchars($product['short_desc']);
$activeNav = 'products';

$applications = json_decode($product['applications'] ?? '[]', true) ?: [];
$features = json_decode($product['features'] ?? '[]', true) ?: [];
$primaryImg = $images[0]['image_url'] ?? 'assets/images/hero-mill.jpg';
$primaryCaption = $images[0]['caption'] ?? $product['title'];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb Navigation -->
<section style="background: #ffffff; border-bottom: 1px solid var(--border-subtle); padding: 1rem 0;">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?= base_url('index.php') ?>">Home</a>
      <span>›</span>
      <a href="<?= base_url('products.php') ?>">Canvas Products</a>
      <span>›</span>
      <a href="<?= base_url('products.php?cat=' . urlencode($product['category_slug'])) ?>">
        <?= htmlspecialchars($product['category_name']) ?>
      </a>
      <span>›</span>
      <span style="color: var(--primary-navy); font-weight: 600;"><?= htmlspecialchars($product['title']) ?></span>
    </div>
  </div>
</section>

<!-- Product Detail Hero -->
<section class="detail-section">
  <div class="container">
    <div class="detail-layout">

      <!-- Column 1: Multi-Image Interactive Gallery -->
      <div class="gallery-container">
        <div class="gallery-main" title="Click to inspect full image">
          <img id="mainGalleryImg" src="<?= base_url($primaryImg) ?>" alt="<?= htmlspecialchars($product['title']) ?>">
          <div class="gallery-caption" id="mainGalleryCaption"><?= htmlspecialchars($primaryCaption) ?></div>
        </div>

        <?php if (count($images) > 1): ?>
          <div class="gallery-thumbs">
            <?php foreach ($images as $idx => $img): ?>
              <div class="thumb-item <?= $idx === 0 ? 'active' : '' ?>" 
                   data-full="<?= base_url($img['image_url']) ?>" 
                   data-caption="<?= htmlspecialchars($img['caption']) ?>">
                <img src="<?= base_url($img['image_url']) ?>" alt="Thumbnail <?= $idx + 1 ?>">
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div style="background:#f8fafc; border:1px dashed var(--border-subtle); border-radius: var(--radius-md); padding:1rem; text-align:center; font-size:0.85rem; color:#64748b;">
          💡 <strong>Multi-Angle Inspection</strong>: Click thumbnails to view fabric weave macro and factory rolls. Click main image to zoom.
        </div>
      </div>

      <!-- Column 2: Product Specifications & Overview -->
      <div class="detail-info">
        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.75rem;">
          <span class="card-category"><?= htmlspecialchars($product['category_name']) ?></span>
          <?php if (!empty($product['badge_text'])): ?>
            <span class="card-badge gold" style="position:static;"><?= htmlspecialchars($product['badge_text']) ?></span>
          <?php endif; ?>
        </div>

        <h1><?= htmlspecialchars($product['title']) ?></h1>
        <div class="detail-subtitle"><?= htmlspecialchars($product['subtitle']) ?></div>

        <p class="detail-short-desc">
          <?= htmlspecialchars($product['short_desc']) ?>
        </p>

        <!-- Technical Specification Table Card -->
        <div class="specs-table-card">
          <table class="specs-table">
            <tbody>
              <?php if (!empty($product['weight_spec'])): ?>
                <tr>
                  <th>Fabric Weight</th>
                  <td><strong><?= htmlspecialchars($product['weight_spec']) ?></strong></td>
                </tr>
              <?php endif; ?>

              <?php if (!empty($product['width_spec'])): ?>
                <tr>
                  <th>Roll Widths</th>
                  <td><?= htmlspecialchars($product['width_spec']) ?></td>
                </tr>
              <?php endif; ?>

              <?php if (!empty($product['yarn_spec'])): ?>
                <tr>
                  <th>Yarn Construction</th>
                  <td><?= htmlspecialchars($product['yarn_spec']) ?></td>
                </tr>
              <?php endif; ?>

              <?php if (!empty($product['weave_spec'])): ?>
                <tr>
                  <th>Weave Pattern</th>
                  <td><?= htmlspecialchars($product['weave_spec']) ?></td>
                </tr>
              <?php endif; ?>

              <?php if (!empty($product['finish_spec'])): ?>
                <tr>
                  <th>Finish / Chemistry</th>
                  <td><?= htmlspecialchars($product['finish_spec']) ?></td>
                </tr>
              <?php endif; ?>

              <?php if (!empty($product['tensile_spec'])): ?>
                <tr>
                  <th>Tensile / Tear Specs</th>
                  <td><?= htmlspecialchars($product['tensile_spec']) ?></td>
                </tr>
              <?php endif; ?>

              <tr>
                <th>Origin & Mill</th>
                <td>Kasur City, Punjab, Pakistan (Sabri Textiles Group)</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Action Buttons Group -->
        <div class="action-buttons-group">
          <button type="button" class="btn btn-primary btn-lg btn-quote-trigger" data-product-name="<?= htmlspecialchars($product['title']) ?>">
            Request Wholesale RFQ →
          </button>
          <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>?text=Hello,%20I%20need%20price%20and%20specification%20details%20for%20<?= urlencode($product['title']) ?>" 
             target="_blank" 
             class="btn btn-whatsapp btn-lg">
            Direct WhatsApp Inquiry
          </a>
        </div>

        <!-- Quick Assurance Badges -->
        <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:1rem; border-top:1px solid var(--border-subtle); padding-top:1.25rem; font-size:0.8rem; color:#64748b;">
          <div>✓ <strong>Custom Slitting</strong> to exact customer widths</div>
          <div>✓ <strong>Mill Samples</strong> shipped worldwide</div>
          <div>✓ <strong>Lab Certified</strong> ISO/ASTM testing</div>
        </div>

      </div>
    </div>

    <!-- Detailed Tabs Section -->
    <div class="detail-tabs-wrap">
      <div class="tabs-nav">
        <button type="button" class="tab-btn active" data-tab="tab-desc">Comprehensive Description</button>
        <button type="button" class="tab-btn" data-tab="tab-apps">Applications & Use Cases</button>
        <button type="button" class="tab-btn" data-tab="tab-features">Technical Advantages</button>
      </div>

      <!-- Tab 1: Full Description -->
      <div class="tab-pane active" id="tab-desc">
        <div style="max-width: 900px; color: #334155; line-height: 1.8; font-size: 1.05rem;">
          <?= nl2br(htmlspecialchars($product['full_desc'])) ?>
        </div>
      </div>

      <!-- Tab 2: Applications -->
      <div class="tab-pane" id="tab-apps">
        <h3 style="margin-bottom: 1.25rem;">Recommended Industrial & Commercial Applications</h3>
        <ul class="app-list">
          <?php foreach ($applications as $app): ?>
            <li><?= htmlspecialchars($app) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Tab 3: Key Features -->
      <div class="tab-pane" id="tab-features">
        <h3 style="margin-bottom: 1.25rem;">Quality Engineering & Structural Features</h3>
        <ul class="feat-list">
          <?php foreach ($features as $feat): ?>
            <li><?= htmlspecialchars($feat) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
      <div style="margin-top: 6rem; border-top: 1px solid var(--border-subtle); padding-top: 4rem;">
        <div class="section-head left">
          <span class="subhead">Complementary Textiles</span>
          <h2 class="section-title">Related Canvas & Industrial Fabrics</h2>
        </div>

        <div class="product-grid">
          <?php foreach ($relatedProducts as $rel): ?>
            <div class="product-card">
              <div class="card-media">
                <a href="<?= base_url('product-detail.php?slug=' . urlencode($rel['slug'])) ?>">
                  <img src="<?= base_url($rel['primary_image'] ?? 'assets/images/hero-mill.jpg') ?>" 
                       alt="<?= htmlspecialchars($rel['title']) ?>" 
                       loading="lazy">
                </a>
              </div>
              <div class="card-body">
                <span class="card-category"><?= htmlspecialchars($rel['category_name']) ?></span>
                <h3 class="card-title">
                  <a href="<?= base_url('product-detail.php?slug=' . urlencode($rel['slug'])) ?>">
                    <?= htmlspecialchars($rel['title']) ?>
                  </a>
                </h3>
                <p class="card-text"><?= htmlspecialchars($rel['short_desc']) ?></p>
                <div class="card-footer">
                  <a href="<?= base_url('product-detail.php?slug=' . urlencode($rel['slug'])) ?>" class="btn btn-outline btn-sm">
                    View Specs →
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
