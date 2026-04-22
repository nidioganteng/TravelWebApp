<laravel-boost-guidelines>
=== aturan dasar ===

# Panduan Laravel Boost

Panduan Laravel Boost ini dikurasi khusus oleh maintainer Laravel untuk aplikasi ini. Ikuti panduan ini dengan seksama untuk meningkatkan kualitas pengembangan aplikasi Laravel.

## Konteks Dasar
Aplikasi ini adalah aplikasi Laravel. Paket-paket ekosistem Laravel yang digunakan beserta versinya ada di bawah ini. Kamu adalah ahli dalam semua hal tersebut. Pastikan mengikuti versi paket yang spesifik ini.

- php - 8.4.13
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- laravel/breeze (BREEZE) - v2
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- alpinejs (ALPINEJS) - v3
- tailwindcss (TAILWINDCSS) - v4

## Aturan Perubahan File (WAJIB DIIKUTI)
Sebelum melakukan perubahan apapun pada file, kamu HARUS memberitahu user terlebih dahulu dengan format yang jelas:

- **Menghapus file:** "Saya ingin menghapus `[nama file]` karena [alasan spesifik]. Apakah boleh?"
- **Mengedit file:** "Saya ingin mengubah `[nama file]` — saya akan [deskripsi singkat perubahan, contoh: menambahkan method update(), mengubah query di index(), dll.] karena [alasan]. Apakah boleh?"
- **Menambah konten baru ke file:** "Saya ingin menambahkan [deskripsi konten] ke `[nama file]` karena [alasan]. Apakah boleh?"
- **Membuat file baru:** "Saya ingin membuat file baru `[nama file]` karena [alasan]. Apakah boleh?"

Tunggu persetujuan user sebelum melanjutkan setiap tindakan di atas.

## Konvensi
- Ikuti semua konvensi kode yang sudah ada di aplikasi ini. Saat membuat atau mengedit file, periksa file-file saudara (sibling) untuk struktur, pendekatan, dan penamaan yang benar.
- Gunakan nama yang deskriptif untuk variabel dan method. Contoh: `isRegisteredForDiscounts`, bukan `discount()`.
- Periksa komponen yang sudah ada untuk dipakai ulang sebelum membuat yang baru.

## Skrip Verifikasi
- Jangan buat skrip verifikasi atau tinker jika test sudah mencakup fungsionalitas tersebut. Test unit dan feature lebih penting.

## Struktur & Arsitektur Aplikasi
- Tetap pada struktur direktori yang sudah ada; jangan buat folder baru tanpa persetujuan.
- Jangan ubah dependensi aplikasi tanpa persetujuan.

## Bundling Frontend
- Jika user tidak melihat perubahan frontend di UI, kemungkinan mereka perlu menjalankan `npm run build`, `npm run dev`, atau `composer run dev`. Tanyakan kepada mereka.

## Balasan
- Jadilah ringkas dalam penjelasan — fokus pada hal yang penting, bukan hal yang sudah jelas.

## File Dokumentasi
- Buat file dokumentasi hanya jika diminta secara eksplisit oleh user.

=== aturan boost ===

## Laravel Boost
- Laravel Boost adalah MCP server yang hadir dengan alat-alat canggih yang dirancang khusus untuk aplikasi ini. Gunakan mereka.

## Artisan
- Gunakan tool `list-artisan-commands` saat perlu memanggil perintah Artisan untuk memastikan parameter yang tersedia.

## URL
- Setiap kali berbagi URL project dengan user, gunakan tool `get-absolute-url` untuk memastikan scheme, domain/IP, dan port yang benar.

## Tinker / Debugging
- Gunakan tool `tinker` saat perlu mengeksekusi PHP untuk debug kode atau query model Eloquent secara langsung.
- Gunakan tool `database-query` jika hanya perlu membaca dari database.

## Membaca Log Browser dengan Tool `browser-logs`
- Kamu bisa membaca log browser, error, dan exception menggunakan tool `browser-logs` dari Boost.
- Hanya log browser terbaru yang berguna — abaikan log lama.

## Mencari Dokumentasi (Sangat Penting)
- Boost hadir dengan tool `search-docs` yang powerful — gunakan sebelum pendekatan lain saat berurusan dengan Laravel atau paket ekosistemnya. Tool ini otomatis meneruskan daftar paket yang terpasang beserta versinya ke API Boost, sehingga mengembalikan dokumentasi yang spesifik untuk kondisi user.
- Tool `search-docs` cocok untuk semua paket terkait Laravel: Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, dll.
- Wajib gunakan tool ini untuk mencari dokumentasi ekosistem Laravel sebelum menggunakan pendekatan lain.
- Cari dokumentasi sebelum membuat perubahan kode untuk memastikan pendekatan yang benar.
- Gunakan beberapa query yang luas, sederhana, dan berbasis topik. Contoh: `['rate limiting', 'routing rate limiting', 'routing']`.
- Jangan tambahkan nama paket ke query; informasi paket sudah dibagikan. Contoh: gunakan `test resource table`, bukan `filament 4 test resource table`.

### Sintaks Pencarian yang Tersedia
- Kamu bisa dan sebaiknya meneruskan beberapa query sekaligus. Hasil paling relevan akan dikembalikan terlebih dahulu.

1. Pencarian Kata Sederhana dengan auto-stemming - query=authentication - menemukan 'authenticate' dan 'auth'.
2. Beberapa Kata (Logika AND) - query=rate limit - menemukan pengetahuan yang mengandung "rate" DAN "limit".
3. Frasa Tepat (Posisi Tepat) - query="infinite scroll" - kata harus berdampingan dan berurutan.
4. Query Campuran - query=middleware "rate limit" - "middleware" DAN frasa tepat "rate limit".
5. Beberapa Query - queries=["authentication", "middleware"] - SALAH SATU dari istilah ini.

=== aturan php ===

## PHP

- Selalu gunakan kurung kurawal untuk struktur kontrol, meskipun hanya satu baris.

### Constructor
- Gunakan property promotion constructor PHP 8 di `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Jangan biarkan method `__construct()` kosong tanpa parameter kecuali constructor-nya private.

### Deklarasi Tipe
- Selalu gunakan deklarasi return type yang eksplisit untuk method dan fungsi.
- Gunakan type hint PHP yang sesuai untuk parameter method.

<code-snippet name="Return Type Eksplisit dan Param Method" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Komentar
- Lebih suka PHPDoc block daripada komentar inline. Jangan pernah gunakan komentar di dalam kode kecuali ada sesuatu yang sangat kompleks.

## PHPDoc Block
- Tambahkan definisi tipe array shape yang berguna untuk array jika sesuai.

## Enum
- Biasanya, key dalam Enum harus TitleCase. Contoh: `FavoritePerson`, `BestLake`, `Monthly`.

=== aturan test ===

## Penegakan Test

- Setiap perubahan harus diuji secara pemrograman. Tulis test baru atau perbarui test yang ada, lalu jalankan test yang terpengaruh untuk memastikan lulus.
- Jalankan jumlah test minimum yang diperlukan untuk memastikan kualitas kode dan kecepatan. Gunakan `php artisan test --compact` dengan nama file atau filter tertentu.

=== aturan laravel/core ===

## Lakukan dengan Cara Laravel

- Gunakan perintah `php artisan make:` untuk membuat file baru (migrasi, controller, model, dll.). Kamu bisa melihat daftar perintah Artisan yang tersedia menggunakan tool `list-artisan-commands`.
- Jika membuat kelas PHP generik, gunakan `php artisan make:class`.
- Sertakan `--no-interaction` ke semua perintah Artisan untuk memastikan berjalan tanpa input user. Sertakan juga `--options` yang benar untuk perilaku yang tepat.

### Database
- Selalu gunakan method relasi Eloquent yang tepat dengan type hint return. Utamakan method relasi daripada query mentah atau join manual.
- Gunakan model Eloquent dan relasi sebelum menyarankan query database mentah.
- Hindari `DB::`; lebih suka `Model::query()`. Hasilkan kode yang memanfaatkan kemampuan ORM Laravel daripada melewatinya.
- Hasilkan kode yang mencegah masalah N+1 query dengan menggunakan eager loading.
- Gunakan query builder Laravel untuk operasi database yang sangat kompleks.

### Pembuatan Model
- Saat membuat model baru, buat juga factory dan seeder yang berguna. Tanyakan kepada user jika membutuhkan hal lain, menggunakan `list-artisan-commands` untuk memeriksa opsi yang tersedia di `php artisan make:model`.

### API & Eloquent Resources
- Untuk API, default ke penggunaan Eloquent API Resources dan API versioning kecuali rute API yang ada tidak melakukannya, lalu ikuti konvensi aplikasi yang ada.

### Controller & Validasi
- Selalu buat kelas Form Request untuk validasi daripada validasi inline di controller. Sertakan aturan validasi dan pesan error kustom.
- Periksa Form Request saudara untuk melihat apakah aplikasi menggunakan aturan validasi berbasis array atau string.

### Queue
- Gunakan queued job untuk operasi yang memakan waktu dengan interface `ShouldQueue`.

### Autentikasi & Otorisasi
- Gunakan fitur autentikasi dan otorisasi bawaan Laravel (gates, policies, Sanctum, dll.).

### Pembuatan URL
- Saat membuat link ke halaman lain, utamakan named routes dan fungsi `route()`.

### Konfigurasi
- Gunakan environment variable hanya di file konfigurasi — jangan pernah gunakan fungsi `env()` langsung di luar file config. Selalu gunakan `config('app.name')`, bukan `env('APP_NAME')`.

### Testing
- Saat membuat model untuk test, gunakan factory untuk model tersebut. Periksa apakah factory memiliki custom state yang bisa digunakan sebelum mengatur model secara manual.
- Faker: Gunakan method seperti `$this->faker->word()` atau `fake()->randomDigit()`. Ikuti konvensi yang ada apakah menggunakan `$this->faker` atau `fake()`.
- Saat membuat test, gunakan `php artisan make:test [options] {name}` untuk membuat feature test, dan sertakan `--unit` untuk membuat unit test. Sebagian besar test harus berupa feature test.

### Error Vite
- Jika menerima error "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest", jalankan `npm run build` atau minta user menjalankan `npm run dev` atau `composer run dev`.

=== aturan laravel/v12 ===

## Laravel 12

- Gunakan tool `search-docs` untuk mendapatkan dokumentasi yang spesifik versi.
- Sejak Laravel 11, Laravel memiliki struktur file yang lebih ramping yang digunakan project ini.

### Struktur Laravel 12
- Di Laravel 12, middleware tidak lagi didaftarkan di `app/Http/Kernel.php`.
- Middleware dikonfigurasi secara deklaratif di `bootstrap/app.php` menggunakan `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` adalah file untuk mendaftarkan middleware, exception, dan file routing.
- `bootstrap/providers.php` berisi service provider spesifik aplikasi.
- File `app\Console\Kernel.php` tidak lagi ada; gunakan `bootstrap/app.php` atau `routes/console.php` untuk konfigurasi console.
- Perintah console di `app/Console/Commands/` tersedia secara otomatis dan tidak memerlukan registrasi manual.

### Database
- Saat memodifikasi kolom, migrasi harus menyertakan semua atribut yang sebelumnya didefinisikan pada kolom. Jika tidak, atribut tersebut akan dihapus dan hilang.
- Laravel 12 memungkinkan pembatasan record yang dimuat secara eager secara native, tanpa paket eksternal: `$query->latest()->limit(10);`.

### Model
- Cast bisa dan sebaiknya diatur dalam method `casts()` pada model daripada properti `$casts`. Ikuti konvensi yang ada dari model lain.

=== aturan pint/core ===

## Laravel Pint Code Formatter

- Wajib jalankan `vendor/bin/pint --dirty` sebelum menyelesaikan perubahan untuk memastikan kode sesuai dengan style yang diharapkan project.
- Jangan jalankan `vendor/bin/pint --test`, cukup jalankan `vendor/bin/pint` untuk memperbaiki masalah formatting.

=== aturan pest/core ===

## Pest
### Testing
- Jika perlu memverifikasi fitur berfungsi, tulis atau perbarui test Unit / Feature.

### Test Pest
- Semua test harus ditulis menggunakan Pest. Gunakan `php artisan make:test --pest {name}`.
- Jangan hapus test atau file test manapun dari direktori tests tanpa persetujuan. Ini bukan file sementara atau helper — ini adalah inti dari aplikasi.
- Test harus menguji semua happy path, failure path, dan weird path.
- Test berada di direktori `tests/Feature` dan `tests/Unit`.
- Test Pest terlihat dan berperilaku seperti ini:
<code-snippet name="Contoh Test Pest Dasar" lang="php">
it('is true', function () {
    expect(true)->toBeTrue();
});
</code-snippet>

### Menjalankan Test
- Jalankan jumlah test minimal menggunakan filter yang sesuai sebelum menyelesaikan pengeditan kode.
- Untuk menjalankan semua test: `php artisan test --compact`.
- Untuk menjalankan semua test dalam sebuah file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- Untuk memfilter nama test tertentu: `php artisan test --compact --filter=testName` (disarankan setelah membuat perubahan pada file terkait).
- Saat test yang berkaitan dengan perubahanmu lulus, tanyakan kepada user apakah mereka ingin menjalankan seluruh test suite untuk memastikan semuanya masih lulus.

### Pest Assertions
- Saat menegaskan kode status pada respons, gunakan method spesifik seperti `assertForbidden` dan `assertNotFound` daripada `assertStatus(403)` atau sejenisnya, contoh:
<code-snippet name="Contoh Pest Menegaskan Respons postJson" lang="php">
it('returns all', function () {
    $response = $this->postJson('/api/docs', []);

    $response->assertSuccessful();
});
</code-snippet>

### Mocking
- Mocking bisa sangat membantu jika sesuai.
- Saat mocking, kamu bisa menggunakan fungsi Pest `Pest\Laravel\mock`, tapi selalu impor melalui `use function Pest\Laravel\mock;` sebelum menggunakannya. Atau, kamu bisa menggunakan `$this->mock()` jika test yang ada melakukannya.
- Kamu juga bisa membuat partial mock menggunakan import atau method self yang sama.

### Dataset
- Gunakan dataset di Pest untuk menyederhanakan test yang memiliki banyak data duplikat. Ini sering terjadi saat menguji aturan validasi, jadi pertimbangkan solusi ini saat menulis test untuk aturan validasi.

<code-snippet name="Contoh Dataset Pest" lang="php">
it('has emails', function (string $email) {
    expect($email)->not->toBeEmpty();
})->with([
    'james' => 'james@laravel.com',
    'taylor' => 'taylor@laravel.com',
]);
</code-snippet>

=== aturan pest/v4 ===

## Pest 4

- Pest 4 adalah upgrade besar untuk Pest dan menawarkan: browser testing, smoke testing, visual regression testing, test sharding, dan type coverage yang lebih cepat.
- Browser testing sangat powerful dan berguna untuk project ini.
- Browser test harus berada di `tests/Browser/`.
- Gunakan tool `search-docs` untuk panduan detail tentang penggunaan fitur-fitur ini.

### Browser Testing
- Kamu bisa menggunakan fitur Laravel seperti `Event::fake()`, `assertAuthenticated()`, dan model factory dalam browser test Pest 4, serta `RefreshDatabase` (jika diperlukan) untuk memastikan state yang bersih untuk setiap test.
- Berinteraksi dengan halaman (klik, ketik, scroll, pilih, submit, drag-and-drop, gesture sentuh, dll.) jika sesuai untuk menyelesaikan test.
- Jika diminta, uji pada beberapa browser (Chrome, Firefox, Safari).
- Jika diminta, uji pada perangkat dan viewport yang berbeda (seperti iPhone 14 Pro, tablet, atau breakpoint kustom).
- Ganti color scheme (light/dark mode) jika sesuai.
- Ambil screenshot atau jeda test untuk debugging jika sesuai.

### Contoh Test

<code-snippet name="Contoh Browser Test Pest" lang="php">
it('may reset the password', function () {
    Notification::fake();

    $this->actingAs(User::factory()->create());

    $page = visit('/sign-in'); // Kunjungi di browser nyata...

    $page->assertSee('Sign In')
        ->assertNoJavascriptErrors() // atau ->assertNoConsoleLogs()
        ->click('Forgot Password?')
        ->fill('email', 'nuno@laravel.com')
        ->click('Send Reset Link')
        ->assertSee('We have emailed your password reset link!')

    Notification::assertSent(ResetPassword::class);
});
</code-snippet>

<code-snippet name="Contoh Smoke Testing Pest" lang="php">
$pages = visit(['/', '/about', '/contact']);

$pages->assertNoJavascriptErrors()->assertNoConsoleLogs();
</code-snippet>

=== aturan tailwindcss/core ===

## Tailwind CSS

- Gunakan class Tailwind CSS untuk styling HTML; periksa dan gunakan konvensi Tailwind yang ada dalam project sebelum menulis sendiri.
- Tawarkan untuk mengekstrak pola yang berulang menjadi komponen yang sesuai dengan konvensi project (Blade, JSX, Vue, dll.).
- Pikirkan penempatan class, urutan, prioritas, dan default. Hapus class yang redundan, tambahkan class ke parent atau child dengan hati-hati untuk membatasi pengulangan, dan kelompokkan elemen secara logis.
- Kamu bisa menggunakan tool `search-docs` untuk mendapatkan contoh tepat dari dokumentasi resmi jika diperlukan.

### Spacing
- Saat membuat daftar item, gunakan utilitas gap untuk spacing; jangan gunakan margin.

<code-snippet name="Contoh Flex Gap Spacing yang Valid" lang="html">
    <div class="flex gap-8">
        <div>Superior</div>
        <div>Michigan</div>
        <div>Erie</div>
    </div>
</code-snippet>

### Dark Mode
- Jika halaman dan komponen yang ada mendukung dark mode, halaman dan komponen baru harus mendukung dark mode dengan cara yang serupa, biasanya menggunakan `dark:`.

=== aturan tailwindcss/v4 ===

## Tailwind CSS 4

- Selalu gunakan Tailwind CSS v4; jangan gunakan utilitas yang sudah deprecated.
- `corePlugins` tidak didukung di Tailwind v4.
- Di Tailwind v4, konfigurasi menggunakan CSS-first dengan direktif `@theme` — tidak perlu file `tailwind.config.js` terpisah.

<code-snippet name="Memperluas Theme di CSS" lang="css">
@theme {
  --color-brand: oklch(0.72 0.11 178);
}
</code-snippet>

- Di Tailwind v4, kamu mengimpor Tailwind menggunakan statement CSS `@import` biasa, bukan direktif `@tailwind` yang digunakan di v3:

<code-snippet name="Tailwind v4 Import Tailwind Diff" lang="diff">
   - @tailwind base;
   - @tailwind components;
   - @tailwind utilities;
   + @import "tailwindcss";
</code-snippet>

### Utilitas yang Diganti
- Tailwind v4 menghapus utilitas yang deprecated. Jangan gunakan opsi yang deprecated; gunakan penggantinya.
- Nilai opacity masih numerik.

| Deprecated          | Pengganti          |
|---------------------|--------------------|
| bg-opacity-*        | bg-black/*         |
| text-opacity-*      | text-black/*       |
| border-opacity-*    | border-black/*     |
| divide-opacity-*    | divide-black/*     |
| ring-opacity-*      | ring-black/*       |
| placeholder-opacity-* | placeholder-black/* |
| flex-shrink-*       | shrink-*           |
| flex-grow-*         | grow-*             |
| overflow-ellipsis   | text-ellipsis      |
| decoration-slice    | box-decoration-slice |
| decoration-clone    | box-decoration-clone |
</laravel-boost-guidelines>
