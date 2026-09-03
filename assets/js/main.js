/**
 * KasurCanvas.com - Modern Interactive Features
 * A New Project of SabriTextiles.com
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Sticky Navbar on Scroll
  const header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 40) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }

  // 2. Mobile Drawer Navigation
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navMenu = document.querySelector('.nav-menu');
  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');
      mobileToggle.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
        navMenu.classList.remove('active');
        mobileToggle.textContent = '☰';
      }
    });
  }

  // 3. Multi-Image Gallery Switcher (Product Detail)
  const mainGalleryImg = document.getElementById('mainGalleryImg');
  const mainGalleryCaption = document.getElementById('mainGalleryCaption');
  const thumbItems = document.querySelectorAll('.thumb-item');

  if (mainGalleryImg && thumbItems.length > 0) {
    thumbItems.forEach(thumb => {
      thumb.addEventListener('click', () => {
        // Remove active class from all
        thumbItems.forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');

        const newSrc = thumb.getAttribute('data-full');
        const newCaption = thumb.getAttribute('data-caption');

        // Fade transition
        mainGalleryImg.style.opacity = '0.4';
        setTimeout(() => {
          mainGalleryImg.src = newSrc;
          if (mainGalleryCaption) mainGalleryCaption.textContent = newCaption || '';
          mainGalleryImg.style.opacity = '1';
        }, 150);
      });
    });
  }

  // 4. Product Catalog Category Filter & Search
  const filterPills = document.querySelectorAll('.filter-pill');
  const productCards = document.querySelectorAll('.product-card');
  const searchInput = document.getElementById('catalogSearchInput');

  function filterCatalog() {
    const activePill = document.querySelector('.filter-pill.active');
    const selectedCategory = activePill ? activePill.getAttribute('data-category') : 'all';
    const searchQuery = searchInput ? searchInput.value.toLowerCase().trim() : '';

    productCards.forEach(card => {
      const cardCat = card.getAttribute('data-category');
      const cardTitle = (card.querySelector('.card-title') ? card.querySelector('.card-title').textContent : '').toLowerCase();
      const cardText = (card.querySelector('.card-text') ? card.querySelector('.card-text').textContent : '').toLowerCase();

      const matchesCat = (selectedCategory === 'all' || cardCat === selectedCategory);
      const matchesSearch = (!searchQuery || cardTitle.includes(searchQuery) || cardText.includes(searchQuery));

      if (matchesCat && matchesSearch) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });
  }

  if (filterPills.length > 0) {
    filterPills.forEach(pill => {
      pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        filterCatalog();
      });
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterCatalog);
  }

  // 5. Product Tabs Switcher
  const tabBtns = document.querySelectorAll('.tab-btn');
  const tabPanes = document.querySelectorAll('.tab-pane');
  if (tabBtns.length > 0) {
    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-tab');
        tabBtns.forEach(b => b.classList.remove('active'));
        tabPanes.forEach(p => p.classList.remove('active'));

        btn.classList.add('active');
        const targetPane = document.getElementById(targetId);
        if (targetPane) targetPane.classList.add('active');
      });
    });
  }

  // 6. Quick Quote Modal Trigger
  const quoteModal = document.getElementById('quoteModal');
  const quoteModalClose = document.getElementById('quoteModalClose');
  const modalProductName = document.getElementById('modalProductName');
  const quoteButtons = document.querySelectorAll('.btn-quote-trigger');

  if (quoteModal) {
    quoteButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const productName = btn.getAttribute('data-product-name') || 'General Canvas Inquiry';
        if (modalProductName) {
          modalProductName.value = productName;
        }
        quoteModal.classList.add('active');
      });
    });

    if (quoteModalClose) {
      quoteModalClose.addEventListener('click', () => {
        quoteModal.classList.remove('active');
      });
    }

    quoteModal.addEventListener('click', (e) => {
      if (e.target === quoteModal) {
        quoteModal.classList.remove('active');
      }
    });
  }

  // 7. Lightbox Image Viewer for Product Detail
  const galleryMain = document.querySelector('.gallery-main');
  const lightboxModal = document.getElementById('lightboxModal');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxClose = document.getElementById('lightboxClose');

  if (galleryMain && lightboxModal && lightboxImg) {
    galleryMain.addEventListener('click', () => {
      const currentSrc = mainGalleryImg ? mainGalleryImg.src : '';
      if (currentSrc) {
        lightboxImg.src = currentSrc;
        lightboxModal.classList.add('active');
      }
    });

    if (lightboxClose) {
      lightboxClose.addEventListener('click', () => {
        lightboxModal.classList.remove('active');
      });
    }

    lightboxModal.addEventListener('click', (e) => {
      if (e.target === lightboxModal) {
        lightboxModal.classList.remove('active');
      }
    });
  }

  // 8. Contact & Quote AJAX Form Handlers
  const inquiryForms = document.querySelectorAll('.ajax-inquiry-form');
  inquiryForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.innerHTML : 'Submit';
      const toast = form.querySelector('.alert-toast') || document.querySelector('.global-toast');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending Quote Request...';
      }

      try {
        const formData = new FormData(form);
        const actionUrl = form.getAttribute('action') || 'api/submit-inquiry.php';
        
        const response = await fetch(actionUrl, {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (toast) {
          toast.className = 'alert-toast ' + (result.success ? 'success' : 'error');
          toast.textContent = result.message;
          toast.style.display = 'block';
        }

        if (result.success) {
          form.reset();
          setTimeout(() => {
            if (quoteModal && quoteModal.classList.contains('active')) {
              quoteModal.classList.remove('active');
            }
          }, 2500);
        }
      } catch (err) {
        if (toast) {
          toast.className = 'alert-toast error';
          toast.textContent = 'Server communication error. Please try calling or WhatsApping us directly.';
          toast.style.display = 'block';
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      }
    });
  });

  // 9. Stats Counter Animation on Viewport
  const counters = document.querySelectorAll('.stat-number');
  let animated = false;

  function runCounters() {
    if (animated || counters.length === 0) return;
    const firstCounter = counters[0];
    const rect = firstCounter.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      animated = true;
      counters.forEach(counter => {
        const target = +counter.getAttribute('data-target') || 0;
        const suffix = counter.getAttribute('data-suffix') || '';
        let count = 0;
        const speed = target / 30;
        const timer = setInterval(() => {
          count += speed;
          if (count >= target) {
            counter.textContent = target + suffix;
            clearInterval(timer);
          } else {
            counter.textContent = Math.floor(count) + suffix;
          }
        }, 30);
      });
    }
  }

  window.addEventListener('scroll', runCounters);
  runCounters();
});
