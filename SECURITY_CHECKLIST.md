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
| `AdminAuthController` & `admin/auth/login.blade.php`: dead code, **menunggu konfirmasi** penghapusan | ⏳ Pending | — |

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

1. **Ganti password admin/user lama** — jika pernah menggunakan password dari seeder lama (Risma, Benedito, hardcoded password).
2. **Rotasi `APP_KEY`** — jika ragu pernah bocor ke repo atau log. Jalankan `php artisan key:generate` dan regenerate semua session aktif.
3. **Rotasi Stripe key** — jika `STRIPE_SECRET` atau `STRIPE_WEBHOOK_SECRET` pernah ter-commit ke git atau terekspos.
4. **Aktifkan webhook event async di Stripe** — `checkout.session.async_payment_succeeded` dan `checkout.session.async_payment_failed` harus diaktifkan di Stripe Dashboard agar `StripeWebhookController` menanganinya dengan benar.
5. **Backup database** sebelum setiap deployment ke production.
6. **Jadwalkan `composer audit` dan `npm audit`** di CI/CD atau minimal setiap bulan.
7. **Turnstile**: daftarkan domain di Cloudflare Turnstile Dashboard, isi `TURNSTILE_SITE_KEY` dan `TURNSTILE_SECRET_KEY`. Saat ini mode fail-open (lewat jika Turnstile gagal).
8. **CSP**: setelah beberapa minggu monitor `Content-Security-Policy-Report-Only` di browser/log, lakukan tighten dan ubah ke `Content-Security-Policy` enforce.
9. **Email verification**: route checkout tidak mewajibkan email terverifikasi. Jika ingin enforce, tambahkan middleware `verified` ke route `checkout.details` dan `checkout.process`. Pastikan alur verifikasi berjalan lancar dan email welcome terkirim saat register.

---

## Risiko yang Tersisa (Known Remaining Risks)

| Risiko | Tingkat | Catatan |
|--------|---------|---------|
| CSP belum enforce | Medium | Masih Report-Only; aktifkan setelah monitoring |
| Email verification tidak diwajibkan di checkout | Low-Medium | Lihat rekomendasi di atas |
| Turnstile fail-open | Low | Dibiarkan agar tidak memblokir pengguna jika Cloudflare down |
| Session tidak dienkripsi secara default (dev) | Low | Perlu set `SESSION_ENCRYPT=true` di production |
| `AdminAuthController` dead code belum dihapus | Info | Menunggu konfirmasi — tidak aktif, tidak berbahaya |
| File upload: magic bytes tidak diverifikasi | Low | Validasi hanya mime-type dari ekstensi; pertimbangkan `finfo` jika diperlukan |
| Quota booking: reservation window 2 jam tidak di-cleanup otomatis | Low | Booking unpaid lewat 2 jam tetap ada di DB; pertimbangkan scheduled job `php artisan` untuk hapus expired booking |
| `DB::transaction` di `BookingController::update` tidak pakai lockForUpdate | Low | Admin-only route, risiko race condition sangat kecil |
