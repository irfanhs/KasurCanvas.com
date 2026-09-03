<?php
/**
 * KasurCanvas.com - About Us Page
 * Sourced & Re-written in own words celebrating Kasur manufacturing & Sabri Textiles legacy
 */
$pageTitle = 'About Us | Kasur Canvas - A New Project of Sabri Textiles';
$metaDesc = 'Learn about Kasur Canvas, the specialized heavy canvas weaving division of Sabri Textiles. Discover our vertically integrated weaving mills in Kasur City, Pakistan, and 50+ years of export heritage.';
$activeNav = 'about';

require_once __DIR__ . '/includes/header.php';
?>

<!-- About Hero Section -->
<section class="about-hero">
  <div class="container" style="max-width: 860px;">
    <span class="subhead" style="color: #fbbf24;">Master Weavers of Pakistan</span>
    <h1>Industrial Canvas Born From Decades of Textile Mastery</h1>
    <p style="font-size: 1.15rem; color: #cbd5e1; line-height: 1.8;">
      <strong>Kasur Canvas</strong> is the specialized industrial and heavy-duty canvas weaving project of <strong>Sabri Textiles</strong> (SabriTextiles.com). Operating from the historic textile capital of Kasur City in Punjab, Pakistan, we combine generational artisanal weaving with modern computerized air-jet technology.
    </p>
  </div>
</section>

<!-- Company Overview & Sabri Textiles Heritage -->
<section style="padding: 5.5rem 0; background: #ffffff;">
  <div class="container">
    <div class="craft-grid">
      <div>
        <span class="subhead">A Legacy of 50+ Years</span>
        <h2 style="font-size: 2.3rem; margin-bottom: 1.25rem;">Backed by the Heritage of Sabri Textiles</h2>
        <p style="color: #475569; font-size: 1.05rem; line-height: 1.8;">
          Founded in 1974, <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" style="color:#d97706; font-weight:600; text-decoration:underline;">Sabri Textiles</a> has stood as one of Pakistan's foremost manufacturers and exporters of disaster relief tents, luxury glamping shelters, institutional towels, bathrobes, and heavy-duty tarpaulins.
        </p>
        <p style="color: #475569; font-size: 1.05rem; line-height: 1.8;">
          To meet skyrocketing global demand for high-performance duck canvas, specialized conveyor belt ducks, and precision filtration media, the group established <strong>KasurCanvas.com</strong> as a dedicated industrial business unit. Here, every loom, twisting spindle, and finishing bath is tuned strictly for heavy industrial textiles.
        </p>

        <div style="background: #f8fafc; border-left: 4px solid var(--accent-gold); padding: 1.25rem 1.5rem; border-radius: 0 var(--radius-md) var(--radius-md) 0; margin: 1.75rem 0;">
          <h4 style="font-size: 1.05rem; color: var(--primary-navy); margin-bottom: 0.25rem;">The Kasur City Advantage</h4>
          <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 0;">
            Kasur City is historically celebrated across South Asia for its rich textile and leather tanning heritage. Our proximity to the fertile cotton belts of southern Punjab grants us direct access to pristine first-grade raw cotton fibers before any intermediate brokers.
          </p>
        </div>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
          <a href="<?= base_url('products.php') ?>" class="btn btn-primary">
            Explore Canvas Lineup →
          </a>
          <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" class="btn btn-outline">
            Visit SabriTextiles.com ↗
          </a>
        </div>
      </div>

      <div class="craft-img-wrap">
        <img src="<?= base_url('assets/images/kasur-heritage.jpg') ?>" alt="Kasur Canvas Textile Weaving Facility in Kasur City" width="700" height="480">
      </div>
    </div>
  </div>
</section>

<!-- Vertically Integrated Manufacturing Process -->
<section style="padding: 5.5rem 0; background: var(--bg-body); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
  <div class="container">
    <div class="section-head">
      <span class="subhead">End-to-End Vertical Integration</span>
      <h2 class="section-title">From Raw Cotton Bales to Heavy Finished Rolls</h2>
      <p class="section-desc">
        Complete control over every stage of production ensures flawless uniformity, zero yarn slippage, and verified tensile endurance for every shipment.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
      <div style="background:#ffffff; border-radius:var(--radius-lg); padding:2rem; border:1px solid var(--border-subtle); box-shadow:var(--shadow-sm);">
        <div style="width:48px; height:48px; border-radius:12px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; margin-bottom:1.25rem;">01</div>
        <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Cotton Selection & Spinning</h3>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.7; margin-bottom: 0;">
          We select exclusively long-staple Pakistani cotton. In our spinning department, fibers are carded, combed, and spun into uniform ring-spun yarns with minimal neps and low hairiness.
        </p>
      </div>

      <div style="background:#ffffff; border-radius:var(--radius-lg); padding:2rem; border:1px solid var(--border-subtle); box-shadow:var(--shadow-sm);">
        <div style="width:48px; height:48px; border-radius:12px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; margin-bottom:1.25rem;">02</div>
        <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Heavy Yarn Twisting</h3>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.7; margin-bottom: 0;">
          Heavy canvas requires multi-fold twisted yarns. Our twisting division binds 2 to 6 plies with balanced twist-per-inch (TPI) to maximize breaking load and tear resistance.
        </p>
      </div>

      <div style="background:#ffffff; border-radius:var(--radius-lg); padding:2rem; border:1px solid var(--border-subtle); box-shadow:var(--shadow-sm);">
        <div style="width:48px; height:48px; border-radius:12px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; margin-bottom:1.25rem;">03</div>
        <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Air-Jet Shuttleless Weaving</h3>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.7; margin-bottom: 0;">
          Our wide-width European air-jet and projectile looms weave seamless fabrics up to 120 inches (305 cm) under computerized tension sensors, eliminating thin spots or mispicks.
        </p>
      </div>

      <div style="background:#ffffff; border-radius:var(--radius-lg); padding:2rem; border:1px solid var(--border-subtle); box-shadow:var(--shadow-sm);">
        <div style="width:48px; height:48px; border-radius:12px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; margin-bottom:1.25rem;">04</div>
        <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Chemical Finishing & Coating</h3>
        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.7; margin-bottom: 0;">
          Continuous processing ranges handle scouring, bleaching, reactive dyeing, wax impregnation, fluorocarbon water-repelling coatings, and flame-retardant chemical baths.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- On-Site Quality Control Laboratory -->
<section style="padding: 5.5rem 0; background: #ffffff;">
  <div class="container">
    <div class="craft-grid" style="grid-template-columns: 0.9fr 1.1fr;">
      <div class="craft-img-wrap">
        <img src="<?= base_url('assets/images/warehouse-rolls.jpg') ?>" alt="Kasur Canvas Quality Inspected Rolls in Warehouse" width="700" height="480">
      </div>

      <div>
        <span class="subhead">Zero Compromise on Quality</span>
        <h2 style="font-size: 2.3rem; margin-bottom: 1.25rem;">Certified Testing for Global Compliance</h2>
        <p style="color: #475569; font-size: 1.05rem; line-height: 1.8;">
          Every production run at Kasur Canvas is tested in our in-house climate-controlled laboratory prior to export clearing. We certify each roll with full test certificates adhering to international standards:
        </p>

        <ul class="feat-list" style="margin: 1.5rem 0;">
          <li><strong>Tensile & Grab Breaking Strength</strong>: ASTM D5034 / ISO 13934-1</li>
          <li><strong>Hydrostatic Water Pressure Head</strong>: AATCC 127 / DIN 53886</li>
          <li><strong>Tear Resistance (Elmendorf)</strong>: ASTM D1424</li>
          <li><strong>Colorfastness to Light & Rubbing</strong>: ISO 105-B02 / ISO 105-X12</li>
          <li><strong>Air Permeability for Filter Media</strong>: ASTM D737</li>
          <li><strong>Flame Retardancy</strong>: BS 5867 / NFPA 701 (On Request)</li>
        </ul>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
          <a href="<?= base_url('contact.php') ?>" class="btn btn-navy">
            Request Certified Mill Samples →
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Banner -->
<section style="background: linear-gradient(135deg, #090e1a 0%, #1e293b 100%); color: #ffffff; padding: 4.5rem 0; text-align: center;">
  <div class="container" style="max-width: 780px;">
    <span class="subhead" style="color: #fbbf24;">Partner with Kasur Canvas</span>
    <h2 style="color: #ffffff; font-size: 2.3rem; margin-bottom: 1rem;">Direct Mill Supply for Importers & Wholesalers</h2>
    <p style="color: #cbd5e1; font-size: 1.05rem; margin-bottom: 2rem;">
      Whether you need container-load volumes of waterproof truck canvas or specialized conveyor belting ducks, connect directly with our international export department.
    </p>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="<?= base_url('contact.php') ?>" class="btn btn-primary btn-lg">
        Contact Factory Office
      </a>
      <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>" target="_blank" class="btn btn-whatsapp btn-lg">
        WhatsApp Export Desk
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
