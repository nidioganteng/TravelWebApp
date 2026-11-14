# SEO Checklist — Mijn Amor Tour & Travel

> Dokumen ini mencatat apa yang sudah dipasang, konfigurasi yang diperlukan,
> langkah manual di berbagai platform, dan batasan yang perlu diketahui.

---

## Yang Sudah Dipasang

| Item | Status | File |
|------|--------|------|
| `<title>` dinamis per halaman | ✅ | `layouts/app.blade.php` props |
| Meta description per halaman | ✅ | `layouts/app.blade.php` props |
| `<link rel="canonical">` | ✅ | `layouts/app.blade.php` |
| Meta robots (`index,follow` / `noindex,nofollow`) | ✅ | `layouts/app.blade.php`, `guest.blade.php`, `admin.blade.php` |
| Open Graph (og:title, description, image, url, type, site_name) | ✅ | `layouts/app.blade.php` |
| Twitter Card (summary_large_image) | ✅ | `layouts/app.blade.php` |
| og:image default: `background_hero.png` (1549×1032) | ✅ | `layouts/app.blade.php` |
| SEO lang keys (en, nl, id, de, pt) | ✅ | `lang/*.json` |
| JSON-LD TravelAgency — home & contact | ✅ | `seo/travel_agency.blade.php` |
| JSON-LD Article — track-record.show | ✅ | `seo/article.blade.php` |
| JSON-LD ItemList — products | ✅ | `seo/product_list.blade.php` |
| `json_encode` dengan `HEX_TAG\|HEX_AMP` (safe encoding) | ✅ | semua seo/*.blade.php |
| Dynamic `robots.txt` (disallow 9 path privat + Sitemap) | ✅ | `routes/web.php` |
| Dynamic `sitemap.xml` (1 jam cache, TrackRecord + halaman statis) | ✅ | `routes/web.php`, `seo/sitemap.blade.php` |
| `img alt` bermakna di semua halaman publik | ✅ | front/components/** |
| `loading="lazy"` untuk gambar bawah fold | ✅ | front/components/** |
| Hero images tidak lazy | ✅ | `showchild.blade.php` |
| Satu `<h1>` per halaman publik | ✅ | homeabout, hometestimonial, aboutdestination, showtestimonial |
| Redirect HTTP → HTTPS (production only) | ✅ | `ForceHttps` middleware |
| `GOOGLE_SITE_VERIFICATION` meta tag (opsional) | ✅ | `layouts/app.blade.php`, `config/app.php` |

---

## Env Baru

Tambahkan ke `.env` di server production jika dibutuhkan:

```env
# Google Search Console — HTML tag verification (opsional)
# Dapatkan dari: Search Console → Settings → Ownership verification → HTML tag
GOOGLE_SITE_VERIFICATION=
```

Env yang sudah ada di `.env.example` dan tetap relevan untuk SEO:

```env
APP_URL=https://yourdomain.com          # dipakai canonical, sitemap, JSON-LD
APP_ENV=production                      # mengaktifkan ForceHttps dan HSTS
TRUSTED_PROXIES=<proxy-ip>             # agar redirect HTTPS tidak loop di balik proxy
```

---

## Langkah Manual di Berbagai Platform

### 1. Google Search Console (GSC)

**Cara verifikasi — pilih salah satu:**

**A. Tipe Domain (direkomendasikan — mencakup semua subdomain dan http/https):**
1. Buka [search.google.com/search-console](https://search.google.com/search-console)
2. Klik **Add Property** → pilih **Domain**
3. Masukkan domain tanpa `https://`, contoh: `mijnamor.nl`
4. Ikuti instruksi verifikasi via DNS TXT record di registrar domain Anda
5. Klik **Verify**

**B. HTML tag (simpler, tapi hanya cover satu origin):**
1. Pilih **URL prefix** → masukkan `https://yourdomain.com`
2. Pilih metode verifikasi **HTML tag**
3. Salin nilai content dari tag yang diberikan
4. Tambahkan ke `.env`: `GOOGLE_SITE_VERIFICATION=<nilai-dari-GSC>`
5. Deploy, lalu klik **Verify** di GSC

**Submit sitemap:**
1. Di GSC → Sitemaps (menu kiri)
2. Tambahkan: `sitemap.xml`
3. Klik **Submit**
4. Tunggu status berubah dari "Pending" ke "Success" (biasanya < 24 jam)

**Request Indexing halaman prioritas:**
1. Di GSC → ikon search bar di atas → masukkan URL halaman (misal `https://yourdomain.com/`)
2. Klik **Request Indexing**
3. Ulangi untuk: `/about`, `/products`, `/contact`, dan setiap URL track-record

### 2. Bing Webmaster Tools

1. Buka [webmaster.bing.com](https://www.bing.com/webmasters)
2. Klik **Add a site** → masukkan URL root
3. Verifikasi via XML file atau meta tag (mirip GSC)
4. Import dari GSC: Bing menawarkan **Import from Google Search Console** — ini cara paling cepat
5. Submit sitemap: Sitemaps → masukkan `sitemap.xml`

### 3. Rich Results Test

Untuk memastikan JSON-LD dibaca Google dengan benar:
1. Buka [search.google.com/test/rich-results](https://search.google.com/test/rich-results)
2. Masukkan URL halaman (home, contact, products, satu track-record)
3. Periksa apakah structured data terdeteksi tanpa error
4. Untuk track-record (Article): pastikan `headline`, `datePublished`, `image` terbaca
5. Untuk products (ItemList): pastikan list item terdeteksi

### 4. PageSpeed Insights

1. Buka [pagespeed.web.dev](https://pagespeed.web.dev)
2. Masukkan URL halaman (uji minimal home, products, satu track-record)
3. Target score: **LCP < 2.5 detik**, **CLS < 0.1**, **FID/INP < 200ms**
4. Perhatikan rekomendasi: biasanya gambar (format WebP), font loading, JS blocking
5. Langkah lanjutan jika score rendah: konversi gambar ke WebP, tambahkan `fetchpriority="high"` pada hero image

### 5. Google Business Profile

Jika bisnis memiliki lokasi fisik atau melayani area tertentu (Belanda):
1. Buka [business.google.com](https://business.google.com)
2. Klaim atau buat profil "Mijn Amor Travel"
3. Tambahkan: nama, alamat, telepon (+310612397002), website, kategori (Travel Agency), jam operasional, foto
4. Verifikasi via kartu pos atau telepon
5. Profil yang terverifikasi muncul di Google Maps dan Knowledge Panel

---

## Batasan yang Perlu Diketahui

### Bahasa (hreflang)

Situs ini menggunakan **satu URL untuk semua bahasa** — bahasa dipilih via `session('locale')`, bukan via URL terpisah (seperti `/nl/`, `/en/`, `/id/`).

**Akibatnya:**
- Google hanya mengindeks satu versi (bahasa default sesi pertama yang di-crawl, biasanya English)
- `hreflang` tidak bisa dipasang karena tidak ada URL unik per bahasa
- Mesin pencari tidak tahu bahwa konten yang sama tersedia dalam bahasa lain

**Jika ingin mengindeks semua bahasa:**
- Implementasikan URL prefix per bahasa: `/en/`, `/nl/`, `/id/`, dll.
- Ini perlu perubahan routing yang cukup besar (prefix route group per locale)
- Setelah ada URL per bahasa, tambahkan `hreflang` di `<head>` via `@stack` atau loop di layout

### CSP masih Report-Only

Header `Content-Security-Policy-Report-Only` aktif tapi belum enforce. Lihat `SECURITY_CHECKLIST.md` untuk cara mengaktifkan setelah monitoring.

### og:image adalah URL relatif dari APP_URL

Pastikan `APP_URL` di production menggunakan `https://` agar `asset()` menghasilkan URL absolut yang benar untuk og:image dan JSON-LD logo.

### Sitemap lastmod hanya untuk TrackRecord

Halaman statis (home, about, products, contact) tidak memiliki `lastmod` di sitemap karena tidak ada timestamp otomatis. Ini valid — Google akan crawl berdasarkan frekuensi.

### File upload: format gambar

Gambar yang diupload disimpan sebagai JPEG/PNG. Untuk PageSpeed yang lebih baik, pertimbangkan konversi ke WebP di `ImageService` menggunakan library GD atau Intervention Image.
