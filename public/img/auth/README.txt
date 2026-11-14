Auth Background Images
======================

Upload 3 file ke folder ini dengan nama PERSIS seperti berikut:

  slide-1.webp   →  Foto perjalanan / destinasi (slide 1)
  slide-2.webp   →  Foto perjalanan / destinasi (slide 2)
  slide-3.webp   →  Foto perjalanan / destinasi (slide 3)

Spesifikasi yang direkomendasikan:
  Format   : WebP  (JPEG/PNG juga didukung, tapi ganti ekstensi di config/auth_ui.php)
  Resolusi : 1920 × 1080 px  (landscape, rasio 16:9)
  Ukuran   : maks 300 KB per file  (gunakan squoosh.app atau cwebp untuk kompresi)

Setelah upload, segarkan cache dengan:
  php artisan config:clear

Untuk mengubah teks headline / deskripsi tiap slide:
  → Edit lang/*.json  (en, id, nl, de, pt)
  → Key: user.auth_headline, user.auth_subheadline
         user.auth_headline_slide2, user.auth_subheadline_slide2
         user.auth_headline_slide3, user.auth_subheadline_slide3
