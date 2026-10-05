# Absensi Siswa — Sistem Monitoring Kehadiran Siswa

Aplikasi sekolah untuk mencatat kehadiran siswa secara digital (QR Code dan
fingerprint) dan memberi tahu orang tua/wali melalui WhatsApp.

Alur utama: **siswa absen → sistem validasi → data tersimpan → orang tua
menerima informasi → sekolah memantau dan merekap.**

## Teknologi

- Laravel 12 + PHP 8.2 + MySQL
- Blade + Bootstrap 5 + Bootstrap Icons + vanilla JavaScript
- Queue database untuk notifikasi WhatsApp
- Tema "Papan Tulis Ledger" (`public/css/app.css`)

## Instalasi lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Buat database MySQL `absensi_siswa`, lalu sesuaikan `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_siswa
DB_USERNAME=root
DB_PASSWORD=
APP_TIMEZONE=Asia/Jakarta
```

Jalankan migration + seeder, lalu serve:

```bash
php artisan migrate --seed
php artisan serve
```

## Akun demo (password: `password`)

| Peran      | Email                  |
|------------|------------------------|
| Admin      | `admin@sekolah.sch.id` |
| Orang tua  | `orangtua@example.com` |

## Menjalankan antrean notifikasi

Notifikasi WhatsApp dikirim via queue agar scanner tidak melambat:

```bash
php artisan queue:work
```

Mode default (`WA_DRIVER=log`) hanya mencatat ke log untuk development.
Untuk provider nyata (mis. Fonnte), isi di `.env` (jangan commit):

```
WA_DRIVER=http
WA_API_URL=https://api.fonnte.com/send
WA_API_KEY=<token-perangkat>
```

## Hosting cPanel

1. Buat database + user di cPanel.
2. Import `AbsensiSiswa-database.sql` via phpMyAdmin (struktur + data master).
3. Upload project, arahkan document root ke `public/`.
4. Sesuaikan `.env`: `DB_*`, `APP_URL`, `APP_DEBUG=false`.
5. Pastikan `storage/` dan `bootstrap/cache/` writable + HTTPS aktif (untuk kamera scanner).
6. Queue: cron tiap menit `php artisan queue:work --once`.

## Struktur penting

- `app/Services/AttendanceService.php` — business logic absensi
- `app/Services/QrAttendanceService.php` — validasi scan QR
- `app/Services/FingerprintService.php` — abstraksi perangkat fingerprint
- `app/Services/WhatsAppNotificationService.php` — driver `log` / `http`
- `app/Jobs/SendAttendanceWhatsAppNotification.php` — job antrean WA
- `docs/plan/prd.md` — PRD lengkap
- `docs/plan/master-plan.md` — status pengerjaan
