(function () {
  'use strict';

  var cfg = window.TANNY_SHOES_CONFIG;
  if (!cfg) return;

  window.PreviewLayout = {
    cfg: cfg,
    FALLBACK_IMAGE: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',

    tzs: function (n) {
      return 'TZS ' + Number(n).toLocaleString('en-TZ');
    },

    waMessage: function (name, price, url, size) {
      return 'Hello Tanny Shoes, I am interested in ' + name + '. Preferred size: ' + (size || 'Not selected') + '. Product price: ' + this.tzs(price) + '. Product link: ' + url + '. Is it available?';
    },

    pageUrl: function (key) {
      return (cfg.pages && cfg.pages[key]) ? cfg.pages[key] : 'index.html';
    },

    productCard: function (p, wide, productUrl) {
      var self = this;
      var options = p.sizes.map(function (s) {
        return '<option value="' + s + '">' + s + '</option>';
      }).join('');
      var was = p.was > p.price ? '<s class="sh-price sh-price--was">' + self.tzs(p.was) + '</s>' : '';
      var badge = p.badge ? '<span class="sh-badge sh-badge--' + p.badge.toLowerCase() + '">' + p.badge + '</span>' : '';
      var url = productUrl || (self.pageUrl('product') + '?id=' + encodeURIComponent(p.slug || p.name));
      var msg = encodeURIComponent(self.waMessage(p.name, p.price, url, ''));
      return (
        '<article class="sh-card' + (wide ? ' sh-card--wide' : '') + '" data-product-name="' + p.name + '" data-product-price="' + p.price + '" data-product-url="' + url + '">' +
          '<a class="sh-card__media" href="' + url + '">' + badge +
            '<span class="sh-card__media-inner">' +
              '<img src="' + p.image + '" alt="' + p.alt + '" width="640" height="640" loading="lazy" decoding="async">' +
            '</span>' +
          '</a>' +
          '<div class="sh-card__body">' +
            '<div class="sh-card__top"><p class="sh-card__category">' + p.category + '</p></div>' +
            '<h3 class="sh-card__title"><a href="' + url + '">' + p.name + '</a></h3>' +
            '<div class="sh-card__price-row"><p class="sh-card__price"><span class="sh-price">' + self.tzs(p.price) + '</span>' + was + '</p></div>' +
            '<label class="sh-card__sizes">' +
              '<span class="sh-card__sizes-label">Select size</span>' +
              '<select class="sh-size" aria-label="Select size for ' + p.name + '"><option value="">Choose size</option>' + options + '</select>' +
            '</label>' +
            '<div class="sh-card__actions">' +
              '<a class="sh-btn sh-btn--outline sh-btn--view" href="' + url + '" aria-label="View product: ' + p.name + '">View</a>' +
              '<a class="sh-btn sh-btn--whatsapp sh-wa-order" href="' + cfg.whatsappUrl + '?text=' + msg + '" target="_blank" rel="noopener noreferrer" aria-label="Order ' + p.name + ' on WhatsApp">WhatsApp</a>' +
            '</div>' +
          '</div>' +
        '</article>'
      );
    },

    bindImageFallbacks: function (root) {
      var self = this;
      (root || document).querySelectorAll('img').forEach(function (img) {
        if (img.dataset.fallbackBound) return;
        img.dataset.fallbackBound = '1';
        img.addEventListener('error', function () {
          if (img.dataset.fallbackApplied) return;
          img.dataset.fallbackApplied = '1';
          img.src = self.FALLBACK_IMAGE;
          img.alt = img.alt || 'Footwear image preview for Tanny Shoes';
        });
      });
    },

    renderHeader: function () {
      var navItems = cfg.nav.map(function (item) {
        return '<li><a href="' + item[1] + '">' + item[0] + '</a></li>';
      }).join('');

      return (
        '<a class="sh-skip" href="#primary">Skip to content</a>' +
        '<div class="sh-announce" role="region" aria-label="Store announcement">' +
          '<p id="announcement-text">' + cfg.announcement + '</p>' +
        '</div>' +
        '<header class="sh-header" id="site-header">' +
          '<div class="sh-container sh-header__inner">' +
            '<button class="sh-icon-btn sh-nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Open menu">' +
              '<span></span><span></span><span></span>' +
            '</button>' +
            '<div class="sh-logo">' +
              '<a class="sh-logo__word sh-logo__mark" id="site-logo" href="' + this.pageUrl('home') + '" aria-label="' + cfg.storeName + '">' +
                '<span class="sh-logo__icon" aria-hidden="true">TS</span><span>' + cfg.storeName + '</span>' +
              '</a>' +
            '</div>' +
            '<nav class="sh-nav-wrap" id="primary-navigation" aria-label="Primary">' +
              '<ul class="sh-nav" id="primary-nav-list">' + navItems + '</ul>' +
            '</nav>' +
            '<div class="sh-header__actions">' +
              '<button class="sh-icon-btn" type="button" data-open-search aria-haspopup="dialog" aria-controls="sh-search" aria-label="Search products">' +
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>' +
              '</button>' +
              '<a class="sh-icon-btn sh-cart-link" href="' + this.pageUrl('shop') + '" aria-label="Shopping bag">' +
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 7h15l-1.5 9h-12L5 4H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.4" fill="currentColor"/><circle cx="18" cy="20" r="1.4" fill="currentColor"/></svg>' +
                '<span class="sh-cart-count" data-count="0">0</span>' +
              '</a>' +
              '<a class="sh-btn sh-btn--whatsapp sh-btn--header" data-wa-link href="' + cfg.whatsappUrl + '" target="_blank" rel="noopener noreferrer">Order on WhatsApp</a>' +
            '</div>' +
          '</div>' +
        '</header>' +
        '<div class="sh-search" id="sh-search" hidden>' +
          '<div class="sh-search__panel" role="dialog" aria-modal="true" aria-labelledby="sh-search-title">' +
            '<div class="sh-search__top">' +
              '<h2 id="sh-search-title">Search shoes</h2>' +
              '<button type="button" class="sh-icon-btn" data-close-search aria-label="Close search">×</button>' +
            '</div>' +
            '<form class="sh-search__form" role="search" action="' + this.pageUrl('shop') + '">' +
              '<label class="sh-sr" for="sh-search-field">Search products</label>' +
              '<input id="sh-search-field" type="search" name="q" placeholder="Search footwear">' +
              '<button class="sh-btn sh-btn--dark" type="submit">Search</button>' +
            '</form>' +
          '</div>' +
        '</div>'
      );
    },

    renderFooter: function () {
      var storeLinks = cfg.stores.map(function (store) {
        return '<li><a href="' + store.url + '" target="_blank" rel="noopener noreferrer">@' + store.handle + '</a></li>';
      }).join('');

      return (
        '<footer class="sh-footer">' +
          '<div class="sh-container sh-footer__grid">' +
            '<div class="sh-footer__brand">' +
              '<a class="sh-logo__word sh-logo__word--light" href="' + this.pageUrl('home') + '">' + cfg.storeName + '</a>' +
              '<p>' + cfg.footerAbout + '</p>' +
              '<p class="sh-footer__location">' + cfg.city + '</p>' +
              '<p class="sh-footer__wa"><a data-wa-link href="' + cfg.whatsappUrl + '" target="_blank" rel="noopener noreferrer">' + cfg.whatsapp + '</a></p>' +
            '</div>' +
            '<div>' +
              '<h2>Shop</h2>' +
              '<ul class="sh-footer__list">' +
                '<li><a href="' + this.pageUrl('home') + '">Home</a></li>' +
                '<li><a href="' + this.pageUrl('shop') + '">Shop</a></li>' +
                '<li><a href="' + this.pageUrl('home') + '#arrivals">New Arrivals</a></li>' +
                '<li><a href="' + this.pageUrl('home') + '#stores">Our Stores</a></li>' +
              '</ul>' +
            '</div>' +
            '<div>' +
              '<h2>Support</h2>' +
              '<ul class="sh-footer__list">' +
                '<li><a href="' + this.pageUrl('contact') + '">Contact</a></li>' +
                '<li><a href="' + this.pageUrl('delivery') + '">Delivery and Returns</a></li>' +
                '<li><a href="' + this.pageUrl('privacy') + '">Privacy Policy</a></li>' +
                '<li><a href="' + this.pageUrl('terms') + '">Terms and Conditions</a></li>' +
              '</ul>' +
            '</div>' +
            '<div>' +
              '<h2>Related Instagram stores</h2>' +
              '<ul class="sh-footer__list">' + storeLinks + '</ul>' +
            '</div>' +
          '</div>' +
          '<div class="sh-footer__bar">' +
            '<div class="sh-container sh-footer__bar-inner">' +
              '<p>&copy; ' + new Date().getFullYear() + ' ' + cfg.storeName + '. All rights reserved.</p>' +
              '<p>' +
                '<a href="' + this.pageUrl('privacy') + '">Privacy Policy</a> ' +
                '<a href="' + this.pageUrl('terms') + '">Terms and Conditions</a>' +
              '</p>' +
            '</div>' +
          '</div>' +
        '</footer>' +
        '<div class="sh-float">' +
          '<a class="sh-float__wa" data-wa-link href="' + cfg.whatsappUrl + '" target="_blank" rel="noopener noreferrer">' +
            '<span class="sh-sr">Order on WhatsApp</span>' +
            '<svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>' +
          '</a>' +
          '<button class="sh-float__top" type="button" data-back-top hidden>' +
            '<span class="sh-sr">Back to top</span>' +
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>' +
          '</button>' +
        '</div>'
      );
    },

    initShell: function () {
      document.documentElement.style.setProperty('--sh-accent', cfg.accent);
      document.documentElement.style.setProperty('--sh-accent-secondary', cfg.secondary);

      var headerMount = document.getElementById('app-header');
      var footerMount = document.getElementById('app-footer');
      if (headerMount) headerMount.innerHTML = this.renderHeader();
      if (footerMount) footerMount.innerHTML = this.renderFooter();

      document.querySelectorAll('[data-wa-link]').forEach(function (el) {
        el.setAttribute('href', cfg.whatsappUrl);
      });
      document.querySelectorAll('[data-instagram-link]').forEach(function (el) {
        el.setAttribute('href', cfg.instagramUrl);
      });

      this.bindImageFallbacks(document);

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
    }
  };
})();
