<?php
/**
 * KasurCanvas.com - Contact Us Page
 * A New Project of SabriTextiles.com
 */
$pageTitle = 'Contact Us | Kasur Canvas - Mill Direct Inquiries';
$metaDesc = 'Get in touch with Kasur Canvas for mill-direct pricing, custom canvas weaving runs, and international export orders. Located in Kasur City, Punjab, Pakistan.';
$activeNav = 'contact';

require_once __DIR__ . '/includes/header.php';

// Fetch product titles for the inquiry dropdown
try {
    $pdo = get_db();
    $formProducts = $pdo->query("SELECT id, title FROM products ORDER BY id ASC")->fetchAll();
} catch (Exception $e) {
    $formProducts = [];
}
?>

<!-- Contact Hero Banner -->
<section style="background: linear-gradient(135deg, #090e1a 0%, #1e293b 100%); color: #ffffff; padding: 4.5rem 0 5rem;">
  <div class="container" style="text-align: center; max-width: 820px;">
    <span class="subhead" style="color: #fbbf24;">Export Inquiries & Factory Visits</span>
    <h1 style="color: #ffffff; font-size: 2.8rem; margin-bottom: 1rem;">
      Connect With Our Kasur Mill
    </h1>
    <p style="color: #cbd5e1; font-size: 1.1rem; line-height: 1.7;">
      Have a specific canvas requirement, bulk order inquiry, or sample request? Reach our export team directly via phone, WhatsApp, or through the inquiry form below.
    </p>
  </div>
</section>

<!-- Main Contact Section -->
<section class="contact-section" style="background: var(--bg-body);">
  <div class="container">
    <div class="contact-grid">

      <!-- Left Column: Contact Information -->
      <div>
        <span class="subhead">Factory & Export Office</span>
        <h2 style="font-size: 2.1rem; margin-bottom: 1.25rem;">We Are Here to Support Your Sourcing</h2>
        <p style="color: #64748b; font-size: 1rem; line-height: 1.7; margin-bottom: 2rem;">
          Our export desk coordinates global shipments from Kasur via Lahore Dry Port and Karachi Sea Ports (FOB / CIF terms). Mill tours are welcomed by appointment for international procurement delegations.
        </p>

        <!-- Information Cards -->
        <div style="display:flex; flex-direction:column; gap:1.25rem; margin-bottom: 2.5rem;">
          <div style="background:#ffffff; padding:1.25rem 1.5rem; border-radius:var(--radius-md); border:1px solid var(--border-subtle); display:flex; gap:1rem; align-items:flex-start;">
            <div style="width:44px; height:44px; border-radius:10px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
              📍
            </div>
            <div>
              <h4 style="font-size:1rem; margin-bottom:0.25rem;">Mill Location</h4>
              <p style="color:#64748b; font-size:0.9rem; margin-bottom:0;">
                Main Nimazpura Road, Kasur City - Punjab (PAKISTAN)
              </p>
            </div>
          </div>

          <div style="background:#ffffff; padding:1.25rem 1.5rem; border-radius:var(--radius-md); border:1px solid var(--border-subtle); display:flex; gap:1rem; align-items:flex-start;">
            <div style="width:44px; height:44px; border-radius:10px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
              📞
            </div>
            <div>
              <h4 style="font-size:1rem; margin-bottom:0.25rem;">Telephone & WhatsApp</h4>
              <p style="color:#64748b; font-size:0.9rem; margin-bottom:0.35rem;">
                <a href="tel:<?= COMPANY_PHONE_RAW ?>" style="font-weight:600; color:var(--primary-navy);">
                  <?= COMPANY_PHONE ?>
                </a>
              </p>
              <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>" target="_blank" class="btn btn-whatsapp btn-sm" style="margin-top:0.25rem;">
                Open WhatsApp Chat →
              </a>
            </div>
          </div>

          <div style="background:#ffffff; padding:1.25rem 1.5rem; border-radius:var(--radius-md); border:1px solid var(--border-subtle); display:flex; gap:1rem; align-items:flex-start;">
            <div style="width:44px; height:44px; border-radius:10px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
              ✉
            </div>
            <div>
              <h4 style="font-size:1rem; margin-bottom:0.25rem;">Email Inquiries</h4>
              <p style="color:#64748b; font-size:0.9rem; margin-bottom:0;">
                General: <a href="mailto:<?= COMPANY_EMAIL ?>" style="color:var(--accent-gold); font-weight:600;"><?= COMPANY_EMAIL ?></a><br>
                Parent Desk: <a href="mailto:info@sabritextiles.com" style="color:var(--accent-gold);">info@sabritextiles.com</a>
              </p>
            </div>
          </div>

          <div style="background:#ffffff; padding:1.25rem 1.5rem; border-radius:var(--radius-md); border:1px solid var(--border-subtle); display:flex; gap:1rem; align-items:flex-start;">
            <div style="width:44px; height:44px; border-radius:10px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
              🌐
            </div>
            <div>
              <h4 style="font-size:1rem; margin-bottom:0.25rem;">Parent Organization</h4>
              <p style="color:#64748b; font-size:0.9rem; margin-bottom:0;">
                <strong>Sabri Textiles</strong> (Founded 1974)<br>
                Website: <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" style="color:var(--accent-gold); font-weight:600;">https://sabritextiles.com</a>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Interactive Quote / Inquiry Form -->
      <div>
        <div class="contact-card">
          <span class="subhead">Direct Mill RFQ</span>
          <h3 style="font-size: 1.6rem; margin-bottom: 0.5rem;">Send an Inquiry to Our Mill</h3>
          <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 1.5rem;">
            Fill in your project requirements below. Submissions are entered directly into our production queue.
          </p>

          <div class="alert-toast global-toast"></div>

          <form class="ajax-inquiry-form" action="<?= base_url('api/submit-inquiry.php') ?>" method="POST">
            <div class="form-row">
              <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="customer_name" required placeholder="e.g. David Miller">
              </div>
              <div class="form-group">
                <label>Company / Organization</label>
                <input type="text" name="company_name" placeholder="e.g. Miller Tarpaulins LLC">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Business Email *</label>
                <input type="email" name="email" required placeholder="david@millertarp.com">
              </div>
              <div class="form-group">
                <label>Phone / WhatsApp *</label>
                <input type="tel" name="phone" required placeholder="+1 (555) 234-5678">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Canvas Product of Interest</label>
                <select name="product_name">
                  <option value="General Canvas Inquiry">General Canvas Inquiry</option>
                  <?php foreach ($formProducts as $fp): ?>
                    <option value="<?= htmlspecialchars($fp['title']) ?>"><?= htmlspecialchars($fp['title']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Destination Country</label>
                <input type="text" name="country" placeholder="e.g. United Kingdom, UAE, USA">
              </div>
            </div>

            <div class="form-group">
              <label>Estimated Quantity (Meters / Yards / Rolls)</label>
              <input type="text" name="quantity" placeholder="e.g. 10,000 meters / 1x 20ft Container">
            </div>

            <div class="form-group">
              <label>Detailed Specifications or Inquiries *</label>
              <textarea name="message" rows="4" required placeholder="Please describe required GSM, fabric width (inches), finish (waxed, natural, dyed, fire retardant), testing standards, and target delivery port..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
              Submit Mill Inquiry →
            </button>
          </form>
        </div>
      </div>

    </div>

    <!-- Kasur Map & Geography Card -->
    <div style="margin-top: 5rem; background:#ffffff; border-radius:var(--radius-xl); border:1px solid var(--border-subtle); overflow:hidden; box-shadow:var(--shadow-sm);">
      <div style="padding:2rem 2.5rem; background: #0f172a; color:#ffffff; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
          <h3 style="color:#ffffff; font-size:1.3rem; margin-bottom:0.25rem;">Manufacturing Location: Kasur, Pakistan</h3>
          <p style="color:#94a3b8; font-size:0.875rem; margin-bottom:0;">
            Main Nimazpura Road, Kasur - 55050, Punjab, Pakistan (approx. 50 km from Lahore International Airport).
          </p>
        </div>
        <a href="https://maps.google.com/?q=Kasur+Punjab+Pakistan" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
          Open in Google Maps ↗
        </a>
      </div>

      <div style="height: 320px; width: 100%; background: #e2e8f0; position: relative; display: flex; align-items: center; justify-content: center;">
        <!-- Embedded Google Maps View for Kasur, Pakistan -->
        <iframe 
          title="Kasur Canvas Location Map"
          width="100%" 
          height="100%" 
          frameborder="0" 
          scrolling="no" 
          marginheight="0" 
          marginwidth="0" 
          src="https://maps.google.com/maps?q=Kasur,Punjab,Pakistan&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
          style="border:0; filter: contrast(1.05);">
        </iframe>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
