# Security Checklist — Mijn Amor Tour & Travel

> Dokumen ini dibuat berdasarkan audit keamanan yang dilakukan dalam 3 tahap.
> Ini bukan klaim "tanpa celah", melainkan panduan tentang apa yang sudah diperbaiki,
> apa yang harus dikonfigurasi manual, dan risiko yang masih perlu dipantau.

---

## Tahap 1 — Pembayaran & Data Sensitif

| Item | Status | File |
|------|--------|------|
| Verifikasi `payment_status === 'paid'` di Stripe session sebelum mark paid | ✅ Fixed | `CheckoutController::success()` |
| Cek kepemilikan booking (403 jika bukan milik user) | ✅ Fixed | `CheckoutController::success()` |
| Idempotency: booking hanya diproses satu kali (lockForUpdate) | ✅ Fixed | `BookingPaymentService::markAsPaid()` |
| Kuota tidak bisa negatif (max 0) + Log::warning jika kuota tidak cukup | ✅ Fixed | `BookingPaymentService::markAsPaid()` |
| Email konfirmasi dikirim setelah transaksi commit, bukan di dalam | ✅ Fixed | `BookingPaymentService` |
| Webhook menangani 3 event Stripe termasuk async payment | ✅ Fixed | `StripeWebhookController` |
| UserSeeder: tidak ada hardcoded password, tolak production jika env kosong | ✅ Fixed | `UserSeeder` |

---

## Tahap 2 — Anti-Spam & Abuse

| Item | Status | File |
|------|--------|------|
| Contact form: honeypot + time trap (fake success untuk bot) | ✅ Fixed | `ContactController` |
| Contact form: validasi not_regex untuk URL/HTML di nama dan pesan | ✅ Fixed | `StoreContactMessageRequest` |
| Contact form: per-email rate limit 3 pesan/jam | ✅ Fixed | `ContactController` |
| Cloudflare Turnstile (opsional, fail-open) | ✅ Fixed | `ContactController` |
| Rate limiting: register 5/min, forgot-password 3/min, reset-password 5/min | ✅ Fixed | `routes/auth.php` |
| Rate limiting: checkout/repay 10/min, contact 3/10min, lang.switch 30/min | ✅ Fixed | `routes/web.php` |
| ThrottleRequestsException → redirect back withErrors (bukan 429) | ✅ Fixed | `bootstrap/app.php` |
| Blade XSS: `{!! departure_locations !!}` di 3 view → `nl2br(e(strip_tags(...)))` | ✅ Fixed | 3 view Blade |
| `strip_tags` sebelum simpan `departure_locations` ke DB | ✅ Fixed | `Admin/ProductController` |
| Dependency audit: 57 CVE diatasi (guzzle, commonmark, symfony, dll) | ✅ Fixed | `composer.lock` |
| npm audit: 0 vulnerabilities | ✅ Fixed | `package-lock.json` |

---

## Tahap 3 — Hardening

| Item | Status | File |
|------|--------|------|
| User `$fillable`: hapus `role`, `status`, `last_seen_at`, `last_page`, `last_ip` | ✅ Fixed | `User` model |
| `UserSeeder`: set `role` dan `status` secara eksplisit (bypass fillable) | ✅ Fixed | `UserSeeder` |
| `TrackUserActivity`: set kolom secara eksplisit, update DB max 1x per 5 menit, skip AJAX/aset | ✅ Fixed | `TrackUserActivity` |
| `RegisteredUserController`: set `status = 'verify'` secara eksplisit | ✅ Fixed | `RegisteredUserController` |
| `SecurityHeaders` middleware: X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy, HSTS (production+HTTPS) | ✅ Fixed | `SecurityHeaders` |
| CSP `Content-Security-Policy-Report-Only` (tidak enforce dulu) | ✅ Fixed | `SecurityHeaders` |
| `TrustProxies` via `TRUSTED_PROXIES` env | ✅ Fixed | `bootstrap/app.php` |
| `Admin/ProductController`: hapus `svg` dari mimes, hapus Log::info debug, delete_images divalidasi Rule::in | ✅ Fixed | `Admin/ProductController` |
| `Admin/ProductController::destroy`: tidak kirim `$e->getMessage()` ke client | ✅ Fixed | `Admin/ProductController` |
| `CheckoutController`: quantity max 20, participants count === quantity, name max 100 | ✅ Fixed | `CheckoutController` |
| `InsufficientQuotaException`: hanya pesan bisnis yang ditampilkan ke user | ✅ Fixed | `CheckoutController` |
| `AppServiceProvider`: log critical jika `APP_DEBUG=true` di production | ✅ Fixed | `AppServiceProvider` |
| `.env.example`: dokumentasi nilai production wajib | ✅ Fixed | `.env.example` |
| Route admin toggle: perbaiki double prefix `/admin/admin/` | ✅ Fixed | `routes/web.php` |
| `throttle:60,1` di group admin | ✅ Fixed | `routes/web.php` |
| `TrackRecord` & `TrackRecordItem`: ganti `$guarded = ['id']` ke `$fillable` eksplisit | ✅ Fixed | Model files |
| `AdminAuthController` & `admin/auth/login.blade.php`: dead code dihapus | ✅ Fixed | commit eda3666 |

---

## Yang Harus Dikonfigurasi Manual di Server

### Wajib sebelum go-live (production)

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=<generated>          # php artisan key:generate
APP_URL=https://yourdomain.com

SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true

STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...

SEED_ADMIN_EMAIL=admin@realdomain.com
SEED_ADMIN_PASSWORD=<strong-password>

TRUSTED_PROXIES=<your-proxy-ip>  # jika pakai reverse proxy/CDN
```

### Aksi manual yang direkomendasikan

1. **Ganti password admin/user lama** — jika pernah menggunakan password dari seeder lama (Risma, Benedito, hardcoded password). Jalankan query:
   ```sql
   UPDATE users SET password = '<hash baru>' WHERE email = '<email admin>';
   ```

2. **Rotasi `APP_KEY`** — jika ragu pernah bocor ke repo atau log:
   ```bash
   php artisan key:generate
   php artisan session:flush  # atau hapus tabel sessions
   ```
   Semua session user akan invalid dan diminta login ulang.

3. **Rotasi Stripe key** — jika `STRIPE_SECRET` atau `STRIPE_WEBHOOK_SECRET` pernah ter-commit ke git atau terekspos. Buat key baru di Stripe Dashboard, update `.env`, restart server.

4. **Aktifkan webhook event async di Stripe** — Buka Stripe Dashboard → Webhooks → pilih endpoint, tambahkan event:
   - `checkout.session.async_payment_succeeded`
   - `checkout.session.async_payment_failed`
   Tanpa ini, pembayaran SEPA/iDEAL async tidak akan dikonfirmasi otomatis.

5. **Set `TRUSTED_PROXIES`** — Jika aplikasi berjalan di belakang reverse proxy (Nginx, Cloudflare, load balancer), isi `TRUSTED_PROXIES` dengan IP proxy agar `$request->ip()` membaca IP asli dari header `X-Forwarded-For`, dan rate limiter tidak memblokir semua user sekaligus.
   ```env
   TRUSTED_PROXIES=10.0.0.1,10.0.0.2  # atau * untuk semua (hati-hati)
   ```

6. **Set `SESSION_SECURE_COOKIE=true`** — Pastikan sudah diset di `.env` production. Cookie session tidak akan dikirim lewat HTTP, hanya HTTPS.

7. **Backup database** sebelum setiap deployment ke production. Minimal harian untuk data transaksi booking.

8. **Jadwalkan `composer audit` dan `npm audit`** — Tambahkan ke CI/CD pipeline atau minimal bulanan:
   ```bash
   composer audit
   npm audit
   ```
   Jika ada CVE baru, jalankan `composer update` dan `npm audit fix`.

9. **Turnstile** — Daftarkan domain di Cloudflare Turnstile Dashboard (turnstile.cloudflare.com), isi `TURNSTILE_SITE_KEY` dan `TURNSTILE_SECRET_KEY` di `.env`. Saat ini mode fail-open (request lolos jika Cloudflare tidak dapat dihubungi).

10. **Membaca laporan CSP Report-Only** — Header `Content-Security-Policy-Report-Only` saat ini hanya melaporkan pelanggaran ke console browser, tidak memblokir. Cara memantau:
    - **Browser DevTools** → tab Console → cari pesan `Refused to load ...` atau `Content Security Policy`
    - **Browser DevTools** → tab Network → filter `csp-report` (jika ada `report-uri` configured)
    - Untuk produksi, tambahkan `report-uri https://your-csp-collector.example.com/report` ke CSP dan arahkan ke layanan seperti [report-uri.com](https://report-uri.com) atau endpoint Laravel sendiri.
    - Setelah beberapa minggu monitoring tanpa false positives, ubah header dari `Content-Security-Policy-Report-Only` ke `Content-Security-Policy` di `SecurityHeaders.php`.

11. **Email verification** — Route checkout tidak mewajibkan email terverifikasi. Jika ingin enforce, tambahkan middleware `verified` ke route `checkout.details` dan `checkout.process` di `routes/web.php`. Pastikan alur verifikasi berjalan lancar dan email welcome terkirim saat register.

---

## Risiko yang Tersisa (Known Remaining Risks)

| Risiko | Tingkat | Catatan |
|--------|---------|---------|
| CSP belum enforce | Medium | Masih Report-Only; aktifkan setelah monitoring |
| Email verification tidak diwajibkan di checkout | Low-Medium | Lihat rekomendasi di atas |
| Turnstile fail-open | Low | Dibiarkan agar tidak memblokir pengguna jika Cloudflare down |
| Session tidak dienkripsi secara default (dev) | Low | Perlu set `SESSION_ENCRYPT=true` di production |
| `TravelRecordController::update` masih pakai mimes dengan svg | Low | Admin-only; pertimbangkan hapus svg jika tidak dipakai |
| File upload: magic bytes tidak diverifikasi | Low | Validasi hanya mime-type dari ekstensi; pertimbangkan `finfo` jika diperlukan |
| Quota booking: reservation window 2 jam tidak di-cleanup otomatis | Low | Booking unpaid lewat 2 jam tetap ada di DB; pertimbangkan scheduled job `php artisan` untuk hapus expired booking |
| `DB::transaction` di `BookingController::update` tidak pakai lockForUpdate | Low | Admin-only route, risiko race condition sangat kecil |
