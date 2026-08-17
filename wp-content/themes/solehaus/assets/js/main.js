(function () {
  'use strict';

  var header = document.getElementById('site-header');
  var navToggle = document.querySelector('.sh-nav-toggle');
  var nav = document.getElementById('primary-navigation');
  var search = document.getElementById('sh-search');
  var openSearch = document.querySelector('[data-open-search]');
  var closeSearch = document.querySelector('[data-close-search]');
  var backTop = document.querySelector('[data-back-top]');
  var data = window.solehausData || {};

  function onScroll() {
    if (!header) return;
    header.classList.toggle('is-compact', window.scrollY > 8);
    if (backTop) {
      if (window.scrollY > 500) backTop.removeAttribute('hidden');
      else backTop.setAttribute('hidden', '');
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    });
  }

  function setSearch(open) {
    if (!search) return;
    search.hidden = !open;
    document.body.style.overflow = open ? 'hidden' : '';
    if (open) {
      var field = document.getElementById('sh-search-field');
      if (field) field.focus();
    } else if (openSearch) {
      openSearch.focus();
    }
  }

  if (openSearch) openSearch.addEventListener('click', function () { setSearch(true); });
  if (closeSearch) closeSearch.addEventListener('click', function () { setSearch(false); });
  if (search) {
    search.addEventListener('click', function (e) {
      if (e.target === search) setSearch(false);
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      setSearch(false);
      if (nav) nav.classList.remove('is-open');
    }
  });

  if (backTop) {
    backTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  document.querySelectorAll('img').forEach(function (img) {
    img.addEventListener('error', function () {
      if (img.dataset.fallbackApplied) return;
      img.dataset.fallbackApplied = '1';
      img.src = 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&h=900&q=80&fm=webp';
    });
  });

  function selectedSize(card) {
    var select = card.querySelector('.sh-size');
    return select ? select.value : '';
  }

  function waMessage(card, size) {
    var name = card.getAttribute('data-product-name') || '';
    var price = card.getAttribute('data-product-price') || '';
    var url = card.getAttribute('data-product-url') || window.location.href;
    var formatted = Number(price) ? 'TZS ' + Number(price).toLocaleString('en-TZ') : price;
    return 'Hello Tanny Shoes, I am interested in ' + name + '. Preferred size: ' + (size || 'Not selected') + '. Product price: ' + formatted + '. Product link: ' + url + '. Is it available?';
  }

  document.querySelectorAll('.sh-card').forEach(function (card) {
    var wa = card.querySelector('.sh-wa-order');
    var select = card.querySelector('.sh-size');
    function syncWa() {
      if (!wa) return;
      var size = selectedSize(card);
      wa.href = (data.waBase || '') + '?text=' + encodeURIComponent(waMessage(card, size));
    }
    if (select) select.addEventListener('change', syncWa);
    syncWa();
  });

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.sh-add-to-cart');
    if (!btn) return;
    e.preventDefault();
    var card = btn.closest('.sh-card');
    if (!card) return;
    var size = selectedSize(card);
    if (card.querySelector('.sh-size') && !size) {
      window.alert(data.selectSize || 'Please select a size first.');
      card.querySelector('.sh-size').focus();
      return;
    }
    if (!data.ajaxUrl) {
      return;
    }
    btn.disabled = true;
    var body = new FormData();
    body.append('action', 'solehaus_add_to_cart');
    body.append('nonce', data.nonce || '');
    body.append('product_id', btn.getAttribute('data-product-id') || '');
    body.append('size', size);
    fetch(data.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
      .then(function (r) { return r.json(); })
      .then(function (json) {
        if (!json || !json.success) {
          window.alert((json && json.data && json.data.message) || data.cartError);
          return;
        }
        var count = document.querySelector('.sh-cart-count');
        if (count && json.data && typeof json.data.count !== 'undefined') {
          count.textContent = json.data.count;
          count.setAttribute('data-count', String(json.data.count));
        }
      })
      .catch(function () {
        window.alert(data.cartError);
      })
      .finally(function () {
        btn.disabled = false;
      });
  });

    var form = document.getElementById('sh-newsletter-form');
    if (form) {
      form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!data.ajaxUrl) {
        return;
      }
      var status = form.querySelector('.sh-news__status');
      var email = form.querySelector('input[name="email"]');
      var hp = form.querySelector('input[name="company"]');
      var body = new FormData();
      body.append('action', 'solehaus_subscribe');
      body.append('nonce', data.nonce || '');
      body.append('email', email ? email.value : '');
      body.append('company', hp ? hp.value : '');
      fetch(data.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
        .then(function (r) { return r.json(); })
        .then(function (json) {
          var msg = (json && json.data && json.data.message) || (json && json.success ? data.subscribeOk : data.subscribeErr);
          if (status) status.textContent = msg;
          if (json && json.success) form.reset();
        })
        .catch(function () {
          if (status) status.textContent = data.subscribeErr;
        });
    });
  }
})();
