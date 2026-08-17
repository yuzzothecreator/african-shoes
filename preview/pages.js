(function () {
  'use strict';

  var layout = window.PreviewLayout;
  var cfg = window.TANNY_SHOES_CONFIG;
  if (!layout || !cfg) return;

  var page = document.body.dataset.page;
  if (!page) return;

  layout.initShell();

  function setMeta(title, description) {
    document.title = title;
    var meta = document.querySelector('meta[name="description"]');
    if (meta) meta.setAttribute('content', description);
  }

  function pageHero(kicker, title, text) {
    return (
      '<div class="sh-page-hero">' +
        '<div class="sh-container sh-page-hero__inner">' +
          (kicker ? '<p class="sh-kicker sh-kicker--light">' + kicker + '</p>' : '') +
          '<h1>' + title + '</h1>' +
          (text ? '<p class="sh-page-hero__lead">' + text + '</p>' : '') +
        '</div>' +
      '</div>'
    );
  }

  function legalSections(sections) {
    return sections.map(function (section) {
      return '<h2>' + section.heading + '</h2><p>' + section.body + '</p>';
    }).join('');
  }

  function findProduct(slug) {
    return cfg.products.find(function (p) { return p.slug === slug; }) || cfg.products[0];
  }

  function categoryLabel(slug) {
    var cat = cfg.categories.find(function (c) { return c.slug === slug; });
    return cat ? cat.name : '';
  }

  if (page === 'shop') {
    var params = new URLSearchParams(window.location.search);
    var category = params.get('category') || '';
    var query = (params.get('q') || '').trim().toLowerCase();
    var filtered = cfg.products.filter(function (p) {
      var matchCategory = true;
      if (category) {
        var cat = cfg.categories.find(function (c) { return c.slug === category; });
        matchCategory = cat ? p.category === cat.name : true;
      }
      var matchQuery = !query || p.name.toLowerCase().indexOf(query) !== -1 || p.category.toLowerCase().indexOf(query) !== -1;
      return matchCategory && matchQuery;
    });

    var title = categoryLabel(category) || 'Shop';
    setMeta(cfg.storeName + ' — ' + title, 'Browse demonstration footwear from Tanny Shoes in Arusha, Tanzania. Contact us on WhatsApp for current availability.');

    var filterLinks = cfg.categories.slice(0, 3).map(function (cat) {
      return '<a class="sh-chip' + (category === cat.slug ? ' is-active' : '') + '" href="shop.html?category=' + cat.slug + '">' + cat.name + '</a>';
    }).join('');

    document.getElementById('page-content').innerHTML =
      pageHero('Collection', title, 'Demonstration products for layout preview. Message Tanny Shoes on WhatsApp for current styles, sizes and prices in TZS.') +
      '<div class="sh-container sh-page">' +
        '<div class="sh-shop-toolbar">' +
          '<div class="sh-shop-toolbar__filters">' + filterLinks + '<a class="sh-chip' + (!category ? ' is-active' : '') + '" href="shop.html">All</a></div>' +
          '<p class="sh-shop-toolbar__count">' + filtered.length + ' demo products</p>' +
        '</div>' +
        '<div class="sh-products sh-products--grid">' +
          filtered.map(function (p) { return layout.productCard(p, false); }).join('') +
        '</div>' +
      '</div>';
  }

  if (page === 'about') {
    setMeta(cfg.storeName + ' — About', cfg.about.text);
    document.getElementById('page-content').innerHTML =
      pageHero('About us', cfg.about.headline, cfg.about.text) +
      '<div class="sh-container sh-page">' +
        '<div class="sh-story__grid sh-story__grid--page">' +
          '<div class="sh-story__media">' +
            '<img src="' + cfg.aboutPage.image + '" alt="' + cfg.aboutPage.imageAlt + '" width="900" height="1100" loading="lazy" decoding="async">' +
          '</div>' +
          '<div class="sh-story__copy">' +
            '<p class="sh-kicker">Our story</p>' +
            '<h2>Based in Arusha, Tanzania</h2>' +
            '<p>' + cfg.about.text + '</p>' +
            '<p>Follow <a href="' + cfg.instagramUrl + '" target="_blank" rel="noopener noreferrer">@' + cfg.instagram + '</a> for footwear updates, or message us on WhatsApp to ask about sizes and availability.</p>' +
            '<div class="sh-page__actions">' +
              '<a class="sh-btn sh-btn--dark" href="' + layout.pageUrl('shop') + '">Browse shop</a>' +
              '<a class="sh-btn sh-btn--whatsapp" href="' + cfg.whatsappUrl + '" target="_blank" rel="noopener noreferrer">WhatsApp</a>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>';
  }

  if (page === 'contact') {
    setMeta(cfg.storeName + ' — Contact', 'Contact Tanny Shoes in Arusha, Tanzania on WhatsApp or Instagram.');
    document.getElementById('page-content').innerHTML =
      pageHero('Get in touch', 'Contact', 'Reach Tanny Shoes on WhatsApp or Instagram for orders, sizes, and availability.') +
      '<div class="sh-container sh-page">' +
        '<div class="sh-contact sh-contact--simple">' +
          '<div class="sh-contact__card">' +
            '<ul class="sh-contact__list">' +
              '<li><span>Business</span><strong>' + cfg.storeName + '</strong></li>' +
              '<li><span>Location</span><div>' + cfg.city + '</div></li>' +
              '<li><span>WhatsApp</span><a href="' + cfg.whatsappUrl + '" target="_blank" rel="noopener noreferrer">' + cfg.whatsapp + '</a></li>' +
              '<li><span>Instagram</span><a href="' + cfg.instagramUrl + '" target="_blank" rel="noopener noreferrer">@' + cfg.instagram + '</a></li>' +
            '</ul>' +
            '<div class="sh-contact__actions">' +
              '<a class="sh-btn sh-btn--whatsapp" href="' + cfg.whatsappUrl + '" target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>' +
              '<a class="sh-btn sh-btn--secondary" href="' + cfg.instagramUrl + '" target="_blank" rel="noopener noreferrer">Visit Instagram</a>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>';
  }

  if (page === 'privacy' || page === 'terms') {
    var doc = cfg.legal[page];
    setMeta(cfg.storeName + ' — ' + doc.title, doc.intro);
    document.getElementById('page-content').innerHTML =
      pageHero('Legal', doc.title, doc.intro) +
      '<div class="sh-container sh-page sh-page--narrow sh-prose">' + legalSections(doc.sections) + '</div>';
  }

  if (page === 'delivery') {
    var delivery = cfg.legal.delivery;
    setMeta(cfg.storeName + ' — ' + delivery.title, delivery.intro);
    document.getElementById('page-content').innerHTML =
      pageHero('Customer support', delivery.title, delivery.intro) +
      '<div class="sh-container sh-page sh-page--narrow sh-prose">' +
        '<h2>Delivery</h2><p>' + delivery.delivery + '</p>' +
        '<h2>Returns</h2><p>' + delivery.returns + '</p>' +
      '</div>';
  }

  if (page === 'product') {
    var slug = new URLSearchParams(window.location.search).get('id') || cfg.products[0].slug;
    var product = findProduct(slug);
    var productUrl = window.location.href.split('#')[0];
    var msg = encodeURIComponent(layout.waMessage(product.name, product.price, productUrl, ''));
    var sizeOptions = product.sizes.map(function (s) {
      return '<option value="' + s + '">' + s + '</option>';
    }).join('');

    setMeta(product.name + ' — ' + cfg.storeName, product.description || cfg.tagline);
    document.getElementById('page-content').innerHTML =
      '<div class="sh-container sh-page sh-product-page">' +
        '<nav class="sh-breadcrumbs" aria-label="Breadcrumb">' +
          '<a href="' + layout.pageUrl('home') + '">Home</a><span>/</span><a href="' + layout.pageUrl('shop') + '">Shop</a><span>/</span><span>' + product.name + '</span>' +
        '</nav>' +
        '<div class="sh-product-page__grid">' +
          '<div class="sh-product-page__media">' +
            (product.badge ? '<span class="sh-badge sh-badge--' + product.badge.toLowerCase() + '">' + product.badge + '</span>' : '') +
            '<img src="' + product.image + '" alt="' + product.alt + '" width="900" height="900">' +
          '</div>' +
          '<div class="sh-product-page__summary">' +
            '<p class="sh-card__category">' + product.category + '</p>' +
            '<h1>' + product.name + '</h1>' +
            '<p class="sh-product-page__price"><span class="sh-price">' + layout.tzs(product.price) + '</span></p>' +
            '<p class="sh-product-page__note">' + (product.description || 'Demonstration product for website layout.') + '</p>' +
            '<label class="sh-card__sizes">' +
              '<span class="sh-card__sizes-label">Select size</span>' +
              '<select class="sh-size" aria-label="Select size for ' + product.name + '"><option value="">Choose size</option>' + sizeOptions + '</select>' +
            '</label>' +
            '<div class="sh-product-page__actions">' +
              '<a class="sh-btn sh-btn--whatsapp sh-wa-order" href="' + cfg.whatsappUrl + '?text=' + msg + '" target="_blank" rel="noopener noreferrer">Order on WhatsApp</a>' +
              '<a class="sh-btn sh-btn--outline" href="' + layout.pageUrl('shop') + '">Back to shop</a>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>';
  }

  layout.bindImageFallbacks(document);
})();
