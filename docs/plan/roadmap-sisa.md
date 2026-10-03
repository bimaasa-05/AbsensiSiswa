# Roadmap Sisa — Sistem Monitoring Kehadiran Siswa

Dokumen ini merangkum pekerjaan yang belum dikerjakan dari PRD (`prd.md`) dan
rencana lanjutannya. Status MVP (P0 + P1): **selesai 100%**.

## Paket A — Rapi-rapi final (kecil)

- [ ] Hapus `resources/views/welcome.blade.php` (tak terpakai, mengandung Tailwind)
- [ ] Ubah `APP_NAME=Laravel` menjadi nama aplikasi yang benar (`.env` + `.env.example`)
- [ ] Tulis README: cara install, konfigurasi `.env`, kredensial demo,
      cara menjalankan `queue:work`, cara ganti driver WhatsApp
- [ ] Final push dan verifikasi ulang di branch main

Kredensial demo (password: `password`):

- Admin: `admin@sekolah.sch.id`
- Orang tua: `orangtua@example.com`

## Paket B — Fitur P2 dari PRD (opsional, effort sedang-besar)

- [ ] Export Excel/PDF rekap (saat ini CSV saja; perlu `maatwebsite/excel` / `dompdf`)
- [ ] Hari libur (tabel + logika lewati akhir pekan/tanggal merah di absensi)
- [ ] Statistik lanjutan di dashboard (tren kehadiran, persentase per kelas)
- [ ] Multi-sekolah (effort besar, mengubah banyak tabel)
- [ ] Halaman error 403/404 kustom berbahasa Indonesia
- [ ] Automated test (`php artisan test`) untuk login, scan QR, dan koreksi

## Paket C — WhatsApp nyata (butuh API key dari pemilik)

Struktur kode siap (`WA_DRIVER=http`). Langkah:

1. Daftar di fonnte.com (gratis untuk development, tanpa batas waktu)
2. Menu Device → Add Device → Connect → scan QR dengan WhatsApp HP
   (disarankan nomor kedua, bukan nomor utama; layanan unofficial)
3. Salin token device → simpan ke `.env` (jangan commit):
   `WA_DRIVER=http`, `WA_API_URL=https://api.fonnte.com/send`, `WA_API_KEY=<token>`
4. Sesuaikan `WhatsAppNotificationService::sendViaHttp()` ke format Fonnte
   (header `Authorization: TOKEN`, field `target` + `message`, sukses jika
   `status: true` pada respons)
5. Uji 1x scan absensi → jalankan worker → verifikasi pesan masuk di HP
6. Jalankan worker permanen (`queue:work` via supervisor/systemd/cron)

## Catatan hosting (cPanel)

- File `AbsensiSiswa-database.sql` di root project: struktur + data master
  (2 users, 5 kelas, 3 orang tua, 5 siswa, 1 pengaturan), tanpa data absensi.
  Import via phpMyAdmin ke database apa pun (tidak mengikat nama DB).
- Tabel `migrations` ikut ter-dump agar `php artisan migrate` tidak jalan ulang.
- Sesuaikan `.env` di hosting: `DB_*`, `APP_URL`, `APP_DEBUG=false`.
  `APP_KEY` boleh pakai yang ada.
- Document root arahkan ke `public/`; `storage/` dan `bootstrap/cache/` writable.
- Scanner butuh HTTPS + izin kamera (AutoSSL cPanel umumnya cukup).
- Queue di shared hosting: cron tiap menit `php artisan queue:work --once`
  atau `php artisan schedule:run`.
