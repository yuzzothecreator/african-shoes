(function () {
  'use strict';

  var cfg = window.TANNY_SHOES_CONFIG;
  if (!cfg) return;

  var layout = window.PreviewLayout;

  function productCard(p, wide) {
    if (layout) return layout.productCard(p, wide);
    return '';
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
    logo.setAttribute('href', layout ? layout.pageUrl('home') : 'index.html');
    logo.innerHTML = '<span class="sh-logo__icon" aria-hidden="true">TS</span><span>' + cfg.storeName + '</span>';
    logo.setAttribute('aria-label', cfg.storeName);
  }

  document.querySelectorAll('[data-wa-link]').forEach(function (el) {
    el.setAttribute('href', cfg.whatsappUrl);
  });

  var heroImg = document.getElementById('hero-image');
  if (heroImg && cfg.hero && cfg.hero.image) {
    heroImg.src = cfg.hero.image;
    heroImg.alt = 'Customer browsing stylish footwear at ' + cfg.storeName + ' in Arusha, Tanzania';
  }

  var heroShop = document.querySelector('.sh-hero__actions .sh-btn--light');
  if (heroShop && layout) heroShop.setAttribute('href', layout.pageUrl('shop'));

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
      var href = layout ? layout.pageUrl('shop') + '?category=' + cat.slug : 'shop.html?category=' + cat.slug;
      return (
        '<a class="sh-cat" href="' + href + '">' +
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

  var aboutCta = document.querySelector('#about .sh-btn--dark');
  if (aboutCta && layout) aboutCta.setAttribute('href', layout.pageUrl('contact'));

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

  if (layout) {
    var shopLinks = document.getElementById('footer-shop-links');
    if (shopLinks) {
      shopLinks.innerHTML =
        '<li><a href="' + layout.pageUrl('home') + '">Home</a></li>' +
        '<li><a href="' + layout.pageUrl('shop') + '">Shop</a></li>' +
        '<li><a href="' + layout.pageUrl('home') + '#arrivals">New Arrivals</a></li>' +
        '<li><a href="' + layout.pageUrl('home') + '#stores">Our Stores</a></li>';
    }

    document.querySelectorAll('.sh-footer__list a[href="#contact"]').forEach(function (link) {
      if (link.textContent.indexOf('Contact') !== -1) link.setAttribute('href', layout.pageUrl('contact'));
    });

    var footerBar = document.querySelector('.sh-footer__bar-inner p:last-child');
    if (footerBar) {
      footerBar.innerHTML =
        '<a href="' + layout.pageUrl('privacy') + '">Privacy Policy</a> ' +
        '<a href="' + layout.pageUrl('terms') + '">Terms and Conditions</a>';
    }

    var cartLink = document.querySelector('.sh-cart-link');
    if (cartLink) cartLink.setAttribute('href', layout.pageUrl('shop'));
  }

  document.querySelectorAll('[data-instagram-link]').forEach(function (el) {
    el.setAttribute('href', cfg.instagramUrl);
  });

  document.documentElement.style.setProperty('--sh-accent', cfg.accent);
  document.documentElement.style.setProperty('--sh-accent-secondary', cfg.secondary);

  if (layout) layout.bindImageFallbacks(document);

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
