# Tanny Shoes — WordPress shoe store

A WooCommerce-ready theme configured for **Tanny Shoes**, a footwear retailer in Arusha, Tanzania. All business details are editable from one Customiser panel without code.

## Quick preview (no WordPress)

Open [preview/index.html](preview/index.html) in a browser, or run:

```powershell
python -m http.server 8080
```

Then visit http://localhost:8080/preview/index.html

## Business configuration

| Setting | Location |
| --- | --- |
| All store details | `wp-content/themes/solehaus/inc/defaults.php` |
| WordPress admin editing | Appearance → Customise → **Tanny Shoes** |
| Static preview | `preview/config.js` |

### Current defaults

- **Business:** Tanny Shoes
- **Location:** Arusha, Tanzania
- **WhatsApp:** +255 624 041 062 → https://wa.me/255624041062
- **Instagram:** @tannyshoes_aimmall
- **Brand colours:** Pink `#E91E8C`, light blue `#7DD3FC`

## WordPress install

1. Copy `wp-content/themes/solehaus` into your WordPress `wp-content/themes/` folder.
2. Install and activate **WooCommerce**.
3. Activate the **Solehaus** theme (internal theme slug; content is branded for Tanny Shoes).
4. Go to **Appearance → Tanny Shoes Setup** and import the demo catalogue.
5. Review **Appearance → Customise → Tanny Shoes**.

## WhatsApp product message format

```
Hello Tanny Shoes, I am interested in [PRODUCT NAME]. Preferred size: [SIZE]. Product price: [PRICE]. Product link: [URL]. Is it available?
```

## Still needed from the business

These are left blank or hidden until you provide them:

- Street address
- Google Maps / Get Directions URL
- Email address
- Opening hours
- Delivery and returns policies
- Real product catalogue (names, prices, stock, photos)
- Official Tanny Shoes logo file

## Required plugin

- WooCommerce only (Elementor optional)
