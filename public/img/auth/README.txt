Auth Background Images
======================

Upload 3 file ke folder ini dengan nama PERSIS seperti berikut:

  slide-hero.webp    →  Slide 1 — foto perjalanan/destinasi umum
  slide-bali.webp    →  Slide 2 — foto Bali
  slide-vatican.webp →  Slide 3 — foto Vatikan

Spesifikasi yang direkomendasikan:
  Format   : WebP  (JPEG/PNG juga didukung, tapi ganti ekstensi di config/auth_ui.php)
  Resolusi : 1920 × 1080 px  (landscape, rasio 16:9)
  Ukuran   : maks 300 KB per file  (gunakan squoosh.app atau cwebp untuk kompresi)

Setelah upload, segarkan cache dengan:
  php artisan config:clear

Untuk mengganti nama, tambah slide, atau mengubah teks headline/deskripsi:
  → Edit config/auth_ui.php
  → Tambah/ubah key teks di lang/*.json  (en, id, nl, de, pt)
