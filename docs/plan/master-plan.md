# MASTER PLAN — Sistem Monitoring Kehadiran Siswa

Legenda: `[x]` selesai, `[ ]` belum. Diperbarui setiap tahap selesai.

## Riwayat — sudah selesai

- [x] Phase 1–9 PRD: auth + role, master data (siswa/ortu/kelas + relasi),
      QR generate + scanner, AttendanceService (hadir/terlambat otomatis,
      anti-duplikat), dashboard + hari ini + riwayat + rekap + koreksi beralasan,
      dashboard ortu, WA (service + job + log, driver `log`),
      FingerprintService + mock, middleware role, pengaturan sekolah,
      log notifikasi, export CSV, halaman Belum Absen
- [x] Hosting: `AbsensiSiswa-database.sql` terverifikasi import + push
- [x] Polish ikon seluruh halaman + push
- [x] Tema "Sekolah Modern Hangat" Tahap 1–3 (CSS terpusat, sidebar gelap,
      login split-screen + eye-toggle, stat cards, page header, empty-state,
      mobile nav, scanner loading) + push
- [x] Dokumen: `docs/plan/prd.md`, `docs/plan/roadmap-sisa.md`,
      `docs/plan/master-plan.md`

## P1. Rombak total "Papan Tulis Ledger" (disetujui: Konsep A, total)

Token: Papan `#1E4D3B` / Pekat `#143627` / Kertas `#EDF2EF` /
Kunyit `#C77F0A` / Tinta `#1C2B26`. Font: Plus Jakarta Sans.

- [x] Fase 1: tulis ulang `app.css`, sidebar papan-tulis, tabel ledger + hover,
      badge stempel, toast, 3 layout, verifikasi render
- [x] Fase 2: komponen toast + ganti alert di layout admin & parent
- [x] Fase 3: dashboard hero + progress + auto-refresh 30 detik (endpoint JSON),
      scanner + login kulit baru
- [x] Fase 4: live search AJAX (debounce 300ms) siswa/ortu/kelas
- [x] Fase 5: stempel status semua halaman, verifikasi HTTP + push

## P2. Paket A — rapi-rapi final

- [ ] Hapus `welcome.blade.php`, `APP_NAME` benar, README (install, kredensial
      demo, queue, driver WA), final push

## P3. Paket B — fitur P2 PRD

- [ ] Export Excel/PDF, hari libur, statistik lanjutan, multi-sekolah,
      halaman 403/404, automated test

## P4. Paket C — WA nyata (butuh API key pemilik)

- [ ] Daftar fonnte.com → connect device (scan QR, nomor kedua) → token →
      adaptasi service → uji scan → worker permanen

## Catatan keputusan

- Model `Guardian` dipakai sebagai pengganti `Parent` (reserved keyword PHP);
  tabel tetap `parents`.
- Realtime = AJAX + auto-refresh (bukan WebSocket; tidak cocok untuk cPanel).
- Notifikasi aksi = toast saja; hapus tetap `confirm()` bawaan.
- Badge stempel hanya untuk status kehadiran.
