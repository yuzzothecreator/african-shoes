(function () {
  'use strict';

  var cfg = window.TANNY_SHOES_CONFIG;
  if (!cfg) return;

  var FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&h=900&q=80&fm=webp';

  document.documentElement.style.setProperty('--sh-accent', cfg.accent);
  document.documentElement.style.setProperty('--sh-accent-secondary', cfg.secondary);

  function bindImageFallbacks(root) {
    (root || document).querySelectorAll('img').forEach(function (img) {
      if (img.dataset.fallbackBound) return;
      img.dataset.fallbackBound = '1';
      img.addEventListener('error', function onError() {
        if (img.dataset.fallbackApplied) return;
        img.dataset.fallbackApplied = '1';
        img.src = FALLBACK_IMAGE;
        img.alt = img.alt || 'Footwear image preview for Tanny Shoes';
      });
    });
  }

  function tzs(n) {
    return 'TZS ' + Number(n).toLocaleString('en-TZ');
  }

  function waMessage(name, price, url, size) {
    return 'Hello Tanny Shoes, I am interested in ' + name + '. Preferred size: ' + (size || 'Not selected') + '. Product price: ' + tzs(price) + '. Product link: ' + url + '. Is it available?';
  }

  function productCard(p, wide) {
    var options = p.sizes.map(function (s) {
      return '<option value="' + s + '">' + s + '</option>';
    }).join('');
    var was = p.was > p.price ? '<s class="sh-price sh-price--was">' + tzs(p.was) + '</s>' : '';
    var badge = p.badge ? '<span class="sh-badge sh-badge--' + p.badge.toLowerCase() + '">' + p.badge + '</span>' : '';
    var url = window.location.href.split('#')[0] + '#featured';
    var msg = encodeURIComponent(waMessage(p.name, p.price, url, ''));
    return (
      '<article class="sh-card' + (wide ? ' sh-card--wide' : '') + '" data-product-name="' + p.name + '" data-product-price="' + p.price + '" data-product-url="' + url + '">' +
        '<a class="sh-card__media" href="#featured">' + badge +
          '<img src="' + p.image + '" alt="' + p.alt + '" width="640" height="640" loading="lazy" decoding="async">' +
        '</a>' +
        '<div class="sh-card__body">' +
          '<p class="sh-card__category">' + p.category + '</p>' +
          '<h3 class="sh-card__title"><a href="#featured">' + p.name + '</a></h3>' +
          '<p class="sh-card__price"><span class="sh-price">' + tzs(p.price) + '</span>' + was + '</p>' +
          '<label class="sh-card__sizes"><span>Size</span>' +
            '<select class="sh-size" aria-label="Select size for ' + p.name + '"><option value="">Select size</option>' + options + '</select>' +
          '</label>' +
          '<div class="sh-card__actions">' +
            '<a class="sh-btn sh-btn--dark" href="#featured">View Product</a>' +
            '<a class="sh-btn sh-btn--whatsapp sh-wa-order" href="' + cfg.whatsappUrl + '?text=' + msg + '" target="_blank" rel="noopener noreferrer">Order on WhatsApp</a>' +
          '</div>' +
        '</div>' +
      '</article>'
    );
  }

  document.title = cfg.storeName + ' — Shoes for Every Step';
  var meta = document.querySelector('meta[name="description"]');
  if (meta) meta.setAttribute('content', cfg.tagline);

  var ann = document.getElementById('announcement-text');
  if (ann) ann.textContent = cfg.announcement;

  var nav = document.getElementById('primary-nav-list');
  if (nav) {
    nav.innerHTML = cfg.nav.map(function (item) {
      return '<li><a href="' + item[1] + '">' + item[0] + '</a></li>';
    }).join('');
  }

  var logo = document.getElementById('site-logo');
  if (logo) {
    logo.innerHTML = '<span class="sh-logo__icon" aria-hidden="true">TS</span><span>' + cfg.storeName + '</span>';
    logo.setAttribute('aria-label', cfg.storeName);
  }

  document.querySelectorAll('[data-wa-link]').forEach(function (el) {
    el.setAttribute('href', cfg.whatsappUrl);
  });

  var heroImg = document.getElementById('hero-image');
  if (heroImg && cfg.hero && cfg.hero.image) {
    heroImg.src = cfg.hero.image;
    heroImg.alt = 'Stylish footwear lifestyle image for ' + cfg.storeName + ' in Arusha, Tanzania';
  }

  var setText = function (id, value) {
    var el = document.getElementById(id);
    if (el) el.textContent = value;
  };
  setText('hero-eyebrow', cfg.hero.eyebrow);
  setText('hero-headline', cfg.hero.headline);
  setText('hero-text', cfg.hero.text);
  setText('hero-primary-label', cfg.hero.primaryLabel);
  setText('hero-secondary-label', cfg.hero.secondaryLabel);

  var cats = document.getElementById('category-grid');
  if (cats) {
    cats.innerHTML = cfg.categories.map(function (cat) {
      return (
        '<a class="sh-cat" href="#featured">' +
          '<img src="' + cat.image + '" alt="' + cat.alt + '" width="640" height="800" loading="lazy" decoding="async">' +
          '<span class="sh-cat__label"><strong>' + cat.name + '</strong><em>Explore Collection</em></span>' +
        '</a>'
      );
    }).join('');
  }

  var grid = document.getElementById('product-grid');
  if (grid) grid.innerHTML = cfg.products.map(function (p) { return productCard(p, false); }).join('');

  var rail = document.getElementById('arrivals-rail');
  if (rail) rail.innerHTML = cfg.arrivals.map(function (p) { return productCard(p, true); }).join('');

  setText('about-headline', cfg.about.headline);
  setText('about-text', cfg.about.text);
  setText('community-headline', cfg.community.headline);
  setText('community-text', cfg.community.text);
  setText('community-followers', cfg.instagramFollowers);
  setText('footer-about', cfg.footerAbout);
  setText('footer-city', cfg.city);
  setText('footer-whatsapp', cfg.whatsapp);
  setText('contact-business', cfg.storeName);
  setText('contact-location', cfg.city);
  setText('contact-whatsapp', cfg.whatsapp);
  setText('contact-instagram', '@' + cfg.instagram);

  var stores = document.getElementById('stores-grid');
  if (stores) {
    stores.innerHTML = cfg.stores.map(function (store) {
      return (
        '<article class="sh-store-card">' +
          '<h3>' + store.name + '</h3>' +
          '<p class="sh-store-card__handle">@' + store.handle + '</p>' +
          '<p>' + store.description + '</p>' +
          '<a class="sh-text-link" href="' + store.url + '" target="_blank" rel="noopener noreferrer">Visit on Instagram</a>' +
        '</article>'
      );
    }).join('');
  }

  var footerStores = document.getElementById('footer-stores');
  if (footerStores) {
    footerStores.innerHTML = cfg.stores.map(function (store) {
      return '<li><a href="' + store.url + '" target="_blank" rel="noopener noreferrer">@' + store.handle + '</a></li>';
    }).join('');
  }

  document.querySelectorAll('[data-instagram-link]').forEach(function (el) {
    el.setAttribute('href', cfg.instagramUrl);
  });

  bindImageFallbacks(document);

  window.solehausData = {
    ajaxUrl: '',
    nonce: '',
    waBase: cfg.whatsappUrl,
    storeName: cfg.storeName,
    selectSize: 'Please select a size first.',
    subscribeOk: 'Thank you. We will write when new catalogue information is available.',
    subscribeErr: 'Please enter a valid email address.'
  };

  var script = document.createElement('script');
  script.src = '../wp-content/themes/solehaus/assets/js/main.js';
  document.body.appendChild(script);
})();
