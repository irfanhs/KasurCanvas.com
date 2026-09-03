<?php
/**
 * KasurCanvas.com - Modern Footer Component
 * A Project of SabriTextiles.com
 */
?>
  <!-- Floating WhatsApp Contact Button -->
  <a href="https://wa.me/<?= COMPANY_PHONE_RAW ?>?text=Hello%20KasurCanvas,%20I%20am%20interested%20in%20canvas%20cloth%20export%20and%20pricing" 
     class="whatsapp-float" 
     target="_blank" 
     rel="noopener" 
     title="Chat with our Export Manager on WhatsApp">
    <svg viewBox="0 0 24 24">
      <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
    </svg>
  </a>

  <!-- Global Quick Quote Modal -->
  <div class="modal-overlay" id="quoteModal">
    <div class="modal-box">
      <button class="modal-close" id="quoteModalClose">✕</button>
      <div style="margin-bottom: 1.25rem;">
        <span class="subhead">Instant RFQ</span>
        <h3 style="font-size: 1.5rem; margin-top: 0.25rem;">Request a Wholesale Quote</h3>
        <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 0;">Get mill-direct pricing and technical samples from Kasur Canvas.</p>
      </div>

      <div class="alert-toast"></div>

      <form class="ajax-inquiry-form" action="<?= base_url('api/submit-inquiry.php') ?>" method="POST">
        <input type="hidden" name="product_name" id="modalProductName" value="General Canvas Inquiry">
        
        <div class="form-row">
          <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="customer_name" required placeholder="John Doe">
          </div>
          <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" placeholder="Global Logistics Ltd">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Business Email *</label>
            <input type="email" name="email" required placeholder="procurement@company.com">
          </div>
          <div class="form-group">
            <label>Phone / WhatsApp</label>
            <input type="tel" name="phone" placeholder="+1 (555) 000-0000">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Destination Country</label>
            <input type="text" name="country" placeholder="United States, UAE, UK...">
          </div>
          <div class="form-group">
            <label>Estimated Quantity (Yards / Meters)</label>
            <input type="text" name="quantity" placeholder="e.g. 5,000 Yards">
          </div>
        </div>

        <div class="form-group">
          <label>Specifications or Requirements *</label>
          <textarea name="message" rows="3" required placeholder="Specify preferred weight (oz / GSM), roll width, finish (waxed, natural, dyed), and delivery timeline..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
          Submit Request for Quote →
        </button>
      </form>
    </div>
  </div>

  <!-- Global Lightbox Modal -->
  <div class="modal-overlay" id="lightboxModal" style="background: rgba(0,0,0,0.9);">
    <div style="position:relative; max-width: 90vw; max-height: 90vh;">
      <button class="modal-close" id="lightboxClose" style="background:#ffffff; color:#000000; top:-15px; right:-15px;">✕</button>
      <img id="lightboxImg" src="" alt="Canvas Texture Zoom" style="max-height: 85vh; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.8);">
    </div>
  </div>

  <!-- Site Enterprise Footer -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Col 1: About Kasur Canvas & Sabri Textiles -->
        <div class="footer-col">
          <div style="margin-bottom: 1.25rem;">
            <img src="<?= base_url('assets/images/logo.svg') ?>" alt="Kasur Canvas" width="220" height="48" style="filter: brightness(0) invert(1);">
          </div>
          <p style="font-size: 0.9rem; line-height: 1.7; color: #94a3b8; margin-bottom: 1.25rem;">
            <strong>Kasur Canvas</strong> is the specialized industrial heavy-duty canvas manufacturing arm of <strong>Sabri Textiles</strong> (founded 1974). Based in Pakistan's historic textile capital of Kasur City, we operate integrated spinning, twisting, and shuttleless air-jet weaving facilities exporting high-grade canvas across 35+ global destinations.
          </p>
          <div class="parent-badge" style="background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.25);">
            <span></span> Official Project of <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" style="color: #fbbf24; text-decoration: underline; margin-left: 4px;">SabriTextiles.com</a>
          </div>
        </div>

        <!-- Col 2: Navigation Links -->
        <div class="footer-col">
          <h4>Explore</h4>
          <ul class="footer-links">
            <li><a href="<?= base_url('index.php') ?>">Home Page</a></li>
            <li><a href="<?= base_url('products.php') ?>">Canvas Catalog</a></li>
            <li><a href="<?= base_url('about.php') ?>">About Our Kasur Mill</a></li>
            <li><a href="<?= base_url('contact.php') ?>">Contact & Location</a></li>
            <li><a href="<?= PARENT_URL ?>" target="_blank" rel="noopener">Sabri Textiles Group ↗</a></li>
            <li><a href="<?= PARENT_URL ?>/canvas-cloth/" target="_blank" rel="noopener">Sabri Canvas Cloth Archive ↗</a></li>
          </ul>
        </div>

        <!-- Col 3: Product Highlights -->
        <div class="footer-col">
          <h4>Canvas Range</h4>
          <ul class="footer-links">
            <li><a href="<?= base_url('products.php?cat=duck-canvas') ?>">Cotton Duck Canvas</a></li>
            <li><a href="<?= base_url('products.php?cat=waterproof-waxed') ?>">Waterproof & Waxed Canvas</a></li>
            <li><a href="<?= base_url('products.php?cat=industrial-technical') ?>">Conveyor Belt Canvas</a></li>
            <li><a href="<?= base_url('products.php?cat=specialty-canvas') ?>">Authentic Dosuti Cloth</a></li>
            <li><a href="<?= base_url('products.php?cat=filtration-media') ?>">Industrial Filter Cloth</a></li>
            <li><a href="<?= base_url('products.php?cat=specialty-canvas') ?>">AAA Painter Drop Cloth</a></li>
            <li><a href="<?= base_url('products.php?cat=specialty-canvas') ?>">Tactical RipStop Canvas</a></li>
          </ul>
        </div>

        <!-- Col 4: Factory & Contact Details -->
        <div class="footer-col">
          <h4>Factory & Headquarters</h4>
          <ul class="footer-contact">
            <li>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
              <span>Main Nimazpura Road, Kasur City - Punjab (PAKISTAN)</span>
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <span>Phone / WhatsApp: <br><strong style="color:#ffffff;"><?= COMPANY_PHONE ?></strong></span>
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <span><?= COMPANY_EMAIL ?></span>
            </li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p>© <?= date('Y') ?> <strong>KasurCanvas.com</strong> — All Rights Reserved. A proud industrial division of <a href="<?= PARENT_URL ?>" target="_blank" rel="noopener" style="color:#fbbf24;">Sabri Textiles</a>.</p>
        <p style="color: #64748b;">Industrial Canvas Weaving • Scouring • Wax Waterproofing • Custom Export Slitting</p>
      </div>
    </div>
  </footer>

  <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
