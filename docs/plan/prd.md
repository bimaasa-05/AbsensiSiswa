
# PRD --- Sistem Monitoring Kehadiran Siswa

**Versi:** 1.0\
**Status:** Draft / Siap dijadikan acuan development\
**Framework:** Laravel 12\
**Database:** MySQL\
**Frontend:** Blade + Bootstrap 5 + CSS + JavaScript\
**Bahasa:** Indonesia\
**Target:** Aplikasi sekolah untuk pencatatan kehadiran siswa dan
pemberitahuan kepada orang tua/wali.

------------------------------------------------------------------------

## 1. Ringkasan Produk

Sistem Monitoring Kehadiran Siswa adalah aplikasi sekolah yang digunakan
untuk mencatat kehadiran siswa secara digital dan membantu orang
tua/wali mengetahui apakah anaknya telah melakukan absensi di sekolah.

Siswa dapat melakukan absensi menggunakan dua metode:

1.  **QR Code**
2.  **Fingerprint**

Setelah absensi berhasil dan tervalidasi, sistem menyimpan data
kehadiran ke database. Sistem kemudian dapat mengirimkan pemberitahuan
melalui WhatsApp kepada nomor orang tua/wali yang terdaftar.

Aplikasi dibuat sederhana, mudah digunakan, dan realistis untuk
lingkungan sekolah. Fokus utama versi pertama adalah:

> **Siswa melakukan absensi → sistem memvalidasi → data tersimpan →
> orang tua menerima informasi → sekolah dapat memantau dan merekap
> kehadiran.**

------------------------------------------------------------------------

# 2. Latar Belakang

Sekolah membutuhkan cara yang lebih praktis untuk mencatat kehadiran
siswa. Di sisi lain, orang tua sering kali tidak mengetahui secara
langsung apakah anaknya benar-benar sudah sampai di sekolah.

Permasalahan yang ingin diselesaikan:

-   Orang tua tidak selalu mengetahui waktu anak sampai di sekolah.
-   Pencatatan absensi manual membutuhkan waktu.
-   Rekap kehadiran membutuhkan pekerjaan administratif tambahan.
-   Informasi kehadiran tidak selalu langsung diketahui orang tua.
-   Sekolah membutuhkan histori kehadiran yang mudah dicari.
-   Risiko titip absen perlu dikurangi.
-   Sekolah membutuhkan sistem yang dapat dikembangkan dari QR menuju
    fingerprint.

------------------------------------------------------------------------

# 3. Tujuan Produk

## 3.1 Tujuan Utama

Membangun sistem absensi siswa yang mampu:

-   mencatat kehadiran siswa secara digital;
-   menyediakan metode absensi QR Code dan fingerprint;
-   mencatat tanggal dan waktu absensi;
-   menentukan status kehadiran;
-   memberikan informasi kehadiran kepada orang tua melalui WhatsApp;
-   menyediakan riwayat kehadiran;
-   membantu admin/guru memantau kehadiran siswa.

## 3.2 Tujuan Tambahan

-   Mengurangi pencatatan manual.
-   Mengurangi kesalahan input data.
-   Mempermudah pencarian riwayat absensi.
-   Membuat data kehadiran lebih terstruktur.
-   Menjadi dasar untuk pengembangan sistem sekolah yang lebih besar.

------------------------------------------------------------------------

# 4. Target Pengguna

Sistem memiliki tiga kelompok pengguna utama:

## 4.1 Admin/Guru

Bertanggung jawab mengelola data dan memantau absensi.

## 4.2 Siswa

Melakukan absensi melalui QR Code atau fingerprint.

Siswa tidak perlu menggunakan dashboard yang kompleks untuk versi
pertama.

## 4.3 Orang Tua/Wali

Menerima pemberitahuan kehadiran dan dapat melihat histori kehadiran
anak.

------------------------------------------------------------------------

# 5. Scope Versi 1

## Termasuk

-   Login admin/guru.
-   Dashboard admin.
-   CRUD data siswa.
-   CRUD data kelas.
-   CRUD data orang tua/wali.
-   Relasi siswa dengan orang tua.
-   Pembuatan QR Code siswa.
-   Halaman/scanner absensi QR.
-   Struktur integrasi fingerprint.
-   Pencatatan absensi masuk.
-   Pencatatan absensi pulang.
-   Status Hadir.
-   Status Terlambat.
-   Status Izin.
-   Status Sakit.
-   Status Alpha.
-   Riwayat absensi.
-   Filter absensi.
-   Rekap absensi.
-   Notifikasi WhatsApp setelah absensi valid.
-   Dashboard/riwayat orang tua.
-   Pengaturan jam masuk sekolah.
-   Log aktivitas penting.
-   Responsive desktop/tablet/mobile.

## Tidak termasuk pada MVP

-   Pembayaran sekolah.
-   SPP.
-   Nilai siswa.
-   Jadwal pelajaran lengkap.
-   Chat orang tua-guru.
-   Ujian online.
-   E-learning.
-   GPS tracking anak secara real-time.
-   Face recognition.
-   Notifikasi email sebagai fitur utama.
-   Marketplace atau fitur non-absensi lainnya.

------------------------------------------------------------------------

# 6. Prinsip Produk

Aplikasi harus mengikuti prinsip:

1.  **Sederhana**
2.  **Cepat**
3.  **Mudah dipahami**
4.  **Tidak berlebihan**
5.  **Data kehadiran harus tervalidasi**
6.  **Tidak menganggap siswa tidak hadir hanya karena belum scan sebelum
    batas waktu tertentu**
7.  **WhatsApp hanya dikirim setelah absensi berhasil disimpan**
8.  **UI harus terlihat seperti aplikasi sekolah yang dibuat secara
    profesional, bukan template AI**

------------------------------------------------------------------------

# 7. Role dan Hak Akses

## 7.1 Admin/Guru

Admin/Guru dapat:

-   login;
-   melihat dashboard;
-   melihat data siswa;
-   menambah siswa;
-   mengubah siswa;
-   menghapus siswa;
-   mengelola kelas;
-   mengelola orang tua;
-   menghubungkan siswa dengan orang tua;
-   membuat/regenerasi QR siswa;
-   membuka halaman scanner;
-   melihat absensi hari ini;
-   melihat riwayat absensi;
-   memfilter absensi;
-   melihat siswa yang belum melakukan absensi;
-   melakukan koreksi absensi dengan alasan;
-   melihat rekap kehadiran;
-   mengatur jam masuk;
-   mengatur batas keterlambatan;
-   melihat status pengiriman WhatsApp.

## 7.2 Siswa

Siswa:

-   memiliki data identitas;
-   memiliki QR Code unik;
-   memiliki identitas fingerprint jika perangkat fingerprint digunakan;
-   melakukan absensi masuk;
-   melakukan absensi pulang.

Siswa tidak diberi akses untuk mengubah data absensi miliknya sendiri.

## 7.3 Orang Tua/Wali

Orang tua/wali:

-   melihat profil anak;
-   melihat status kehadiran hari ini;
-   melihat jam masuk;
-   melihat jam pulang;
-   melihat status kehadiran;
-   melihat histori absensi;
-   menerima notifikasi WhatsApp.

Orang tua tidak dapat mengubah data absensi.

------------------------------------------------------------------------

# 8. Alur Utama Sistem

## 8.1 Alur Absensi QR

``` text
Siswa datang ke sekolah
        ↓
Siswa menunjukkan QR Code
        ↓
Scanner membaca QR
        ↓
Sistem mencari siswa
        ↓
Validasi QR
        ↓
Cek apakah siswa sudah absen
        ↓
Cek jam sekolah
        ↓
Tentukan status
        ↓
Simpan absensi
        ↓
Tampilkan "Absensi Berhasil"
        ↓
Kirim notifikasi WhatsApp
        ↓
Orang tua menerima informasi
```

## 8.2 Alur Fingerprint

``` text
Siswa datang
      ↓
Siswa menempelkan jari
      ↓
Perangkat fingerprint mengenali siswa
      ↓
Perangkat mengirim identitas ke sistem
      ↓
Laravel memvalidasi siswa
      ↓
Cek absensi hari tersebut
      ↓
Tentukan status
      ↓
Simpan absensi
      ↓
Kirim WhatsApp
```

Fingerprint harus dibuat menggunakan abstraction/service sehingga
implementasi perangkat dapat diganti tanpa mengubah business logic
utama.

------------------------------------------------------------------------

# 9. Aturan Bisnis Absensi

## 9.1 Satu Absensi Masuk per Hari

Satu siswa hanya boleh memiliki satu absensi masuk untuk satu tanggal.

Jika siswa mencoba scan kembali:

> "Anda sudah melakukan absensi masuk hari ini."

Jangan membuat record absensi baru.

## 9.2 Absensi Pulang

Absensi pulang hanya dapat dilakukan setelah siswa memiliki absensi
masuk pada hari tersebut.

## 9.3 Status

Contoh aturan:

-   sebelum atau sama dengan jam masuk: `Hadir`
-   setelah jam masuk dan melewati batas keterlambatan: `Terlambat`
-   `Izin` dan `Sakit` dapat diberikan berdasarkan data/aksi resmi
    sekolah
-   `Alpha` digunakan ketika siswa dinyatakan tidak hadir tanpa
    keterangan sesuai aturan sekolah

Jam dan batas keterlambatan harus configurable, bukan hard-code.

Contoh:

``` text
Jam masuk       : 07:00
Batas toleransi : 15 menit
```

Maka:

``` text
06:45 → Hadir
07:00 → Hadir
07:10 → Hadir
07:16 → Terlambat
```

Aturan final dapat disesuaikan oleh sekolah.

## 9.4 Duplikasi

Sistem harus mencegah:

-   QR scan berulang;
-   fingerprint berulang;
-   dua request bersamaan yang membuat record ganda.

Gunakan validasi aplikasi dan database constraint yang sesuai.

------------------------------------------------------------------------

# 10. QR Code

Setiap siswa mempunyai QR Code unik.

QR Code tidak boleh hanya berisi nama siswa.

Gunakan identifier/token unik yang dapat divalidasi oleh server.

Contoh konsep:

``` text
student_token
```

atau UUID.

Jangan menyimpan data sensitif siswa secara langsung di QR.

## Fitur QR

-   Generate QR.
-   Regenerate QR.
-   Download/cetak QR.
-   Menampilkan QR pada kartu siswa.
-   Scanner QR.
-   Validasi token.
-   Menolak QR yang tidak valid.
-   Menolak QR siswa yang sudah dinonaktifkan.

## Keamanan QR

Jika QR dicetak, sistem harus memahami bahwa QR dapat dipinjamkan.

Karena itu QR bukan jaminan anti-titip-absen 100%.

Fingerprint dapat digunakan sebagai metode dengan tingkat verifikasi
identitas yang lebih kuat.

------------------------------------------------------------------------

# 11. Fingerprint

Fingerprint adalah fitur yang disiapkan sebagai metode absensi kedua.

## Prinsip

Jangan membuat kode Laravel bergantung langsung pada satu merek
fingerprint.

Buat layer/service:

``` text
FingerprintService
```

Tanggung jawab:

-   menerima identifier fingerprint;
-   mencari siswa;
-   memvalidasi status siswa;
-   mengembalikan identitas siswa ke AttendanceService.

Business logic absensi tetap berada pada service absensi.

Contoh:

``` text
Fingerprint Device
        ↓
Fingerprint Integration
        ↓
FingerprintService
        ↓
AttendanceService
        ↓
Database
```

Jika perangkat fingerprint belum tersedia saat development, gunakan
mock/simulation agar sistem dapat dikembangkan tanpa perangkat fisik.

------------------------------------------------------------------------

# 12. WhatsApp Notification

WhatsApp digunakan sebagai kanal pemberitahuan kepada orang tua.

Laravel tidak boleh menganggap WhatsApp sebagai bagian dari database
absensi.

Setelah absensi berhasil:

``` text
Absensi tersimpan
       ↓
Buat notification job
       ↓
WhatsApp provider/API
       ↓
Nomor orang tua
```

Gunakan queue/job agar proses pengiriman tidak memperlambat halaman
absensi.

## Isi Notifikasi

Contoh:

``` text
Notifikasi Kehadiran Sekolah

Yth. Orang Tua/Wali Bima,

Bima telah melakukan absensi masuk.

Tanggal : Senin, 5 Oktober 2026
Jam     : 06:48 WIB
Kelas   : XII RPL 1
Status  : Hadir
Metode  : QR Code

Informasi ini merupakan pemberitahuan otomatis dari sistem sekolah.
```

Untuk absensi pulang:

``` text
Bima telah melakukan absensi pulang.

Tanggal : Senin, 5 Oktober 2026
Jam     : 14:05 WIB
Kelas   : XII RPL 1
Status  : Pulang
```

## Provider WhatsApp

Jangan mengunci aplikasi ke provider tertentu pada level business logic.

Buat interface/service:

``` text
WhatsAppNotificationService
```

Provider dapat ditentukan kemudian.

Development dapat menggunakan mode simulasi/log.

------------------------------------------------------------------------

# 13. Anti-Spam WhatsApp

Sistem harus mencegah pengiriman notifikasi berulang.

Contoh:

``` text
Scan pertama
→ Simpan absensi
→ Kirim notifikasi

Scan kedua
→ Tolak karena sudah absen
→ Jangan kirim WhatsApp lagi
```

Simpan status:

``` text
notification_status
```

Contoh:

-   pending
-   sent
-   failed

Simpan juga waktu pengiriman dan pesan error jika tersedia.

------------------------------------------------------------------------

# 14. Dashboard Admin

Dashboard harus menampilkan informasi yang benar-benar berguna.

Contoh:

``` text
Selamat pagi, Admin

Tanggal: Senin, 5 Oktober 2026

Total Siswa       420
Sudah Hadir       386
Terlambat          18
Belum Absen        16

--------------------------------

Absensi Terbaru

06:45  Bima       XII RPL 1   Hadir
06:47  Andi       XII RPL 2   Hadir
07:18  Sinta      XI RPL 1    Terlambat
```

Jangan memenuhi dashboard dengan terlalu banyak card.

Gunakan hanya data yang membantu pekerjaan admin.

------------------------------------------------------------------------

# 15. Halaman Admin

## 15.1 Login

Field:

-   Email/username
-   Password
-   Remember me jika diperlukan
-   Tombol Login

Tidak perlu login dengan desain berlebihan.

## 15.2 Dashboard

Menampilkan:

-   ringkasan absensi;
-   absensi terbaru;
-   siswa belum hadir;
-   statistik sederhana.

## 15.3 Data Siswa

Kolom:

-   No
-   NIS/NISN
-   Nama
-   Kelas
-   Orang Tua
-   Status
-   Aksi

Aksi:

-   Detail
-   Edit
-   QR
-   Nonaktifkan

## 15.4 Form Siswa

Field minimal:

-   NIS/NISN
-   Nama lengkap
-   Jenis kelamin jika dibutuhkan sekolah
-   Kelas
-   Nomor WhatsApp siswa jika diperlukan
-   Orang tua/wali
-   Status siswa

Jangan meminta data pribadi yang tidak diperlukan.

## 15.5 Data Orang Tua

Field:

-   Nama
-   Nomor WhatsApp
-   Email opsional
-   Status

Relasi:

``` text
Orang Tua
   ↓
Satu atau beberapa siswa
```

Desain harus mendukung kemungkinan satu orang tua memiliki lebih dari
satu anak.

## 15.6 Data Kelas

Field:

-   Nama kelas
-   Tingkat
-   Jurusan opsional
-   Tahun ajaran
-   Status

## 15.7 Absensi Hari Ini

Tabel:

-   Waktu
-   Nama siswa
-   Kelas
-   Metode
-   Status
-   Status WhatsApp

Filter:

-   kelas
-   status
-   metode
-   rentang waktu

## 15.8 Riwayat Absensi

Filter:

-   tanggal;
-   tanggal mulai/akhir;
-   siswa;
-   kelas;
-   status;
-   metode.

## 15.9 Rekap

Contoh:

``` text
Nama       Hadir  Terlambat  Izin  Sakit  Alpha
Bima         18       2        1     0      0
Andi         20       1        0     0      0
```

Export dapat ditambahkan jika dibutuhkan.

------------------------------------------------------------------------

# 16. Halaman Orang Tua

Orang tua mendapatkan tampilan yang lebih sederhana.

## Dashboard

``` text
Anak Saya

Bima
XII RPL 1

STATUS HARI INI
Hadir

Jam masuk
06:48

Jam pulang
14:05
```

Kemudian:

``` text
Riwayat Kehadiran

Tanggal       Status       Masuk
05 Okt        Hadir        06:48
04 Okt        Hadir        06:51
03 Okt        Terlambat    07:19
02 Okt        Izin         -
```

Jika orang tua mempunyai beberapa anak, tampilkan selector:

``` text
Bima — XII RPL 1
Sinta — X RPL 2
```

------------------------------------------------------------------------

# 17. Halaman Scanner

Halaman scanner harus sangat sederhana karena digunakan untuk proses
cepat.

Contoh:

``` text
ABSENSI SISWA

[ Area Scanner QR ]

Arahkan QR Code ke kamera

Status:
Menunggu scan...
```

Setelah berhasil:

``` text
✓ ABSENSI BERHASIL

Bima
XII RPL 1

06:48
Hadir

Notifikasi orang tua sedang diproses...
```

Setelah beberapa detik kembali ke mode scanner.

Jangan membuat scanner memiliki banyak menu yang mengganggu.

------------------------------------------------------------------------

# 18. UI/UX dan Visual Design

## PENTING

Agent AI **jangan membuat desain yang terlihat seperti template
AI/dashboard generator**.

Hindari:

-   gradient berlebihan;
-   background penuh gradasi;
-   glassmorphism;
-   neon;
-   terlalu banyak shadow;
-   card dengan border-radius ekstrem;
-   semua elemen berbentuk pill;
-   dashboard penuh 8--12 card;
-   ilustrasi random;
-   emoji sebagai ikon utama;
-   teks marketing berlebihan;
-   layout yang terlalu ramai;
-   warna ungu/gradient AI yang generik;
-   heading seperti "Welcome Back, Super Admin!";
-   penggunaan font futuristik;
-   desain yang terasa seperti landing page startup.

## Gaya Visual yang Diinginkan

Gunakan gaya:

> **Simple School Administration System**

Karakter visual:

-   bersih;
-   profesional;
-   tenang;
-   praktis;
-   terasa seperti software sekolah sungguhan;
-   fokus pada data;
-   mudah dibaca;
-   tidak terlalu dekoratif.

## Warna

Gunakan palet sederhana.

Contoh:

``` text
Primary   : #1F4E79
Secondary : #5B7083
Success   : #2E7D32
Warning   : #B7791F
Danger    : #C62828
Background: #F5F7FA
Surface   : #FFFFFF
Text      : #263238
Border    : #DDE3E8
```

Warna boleh disesuaikan sedikit, tetapi pertahankan karakter profesional
dan sederhana.

Jangan menggunakan banyak warna sekaligus.

## Typography

Gunakan font web yang mudah dibaca.

Prioritas:

-   Inter
-   Source Sans 3
-   system font

Jangan menggunakan font dekoratif.

## Border Radius

Gunakan radius kecil sampai sedang.

Contoh:

``` text
4px
6px
8px
```

Jangan membuat semua card menjadi kapsul besar.

## Shadow

Gunakan shadow tipis hanya jika diperlukan.

Lebih baik gunakan:

``` text
border: 1px solid #DDE3E8;
```

daripada shadow besar.

------------------------------------------------------------------------

# 19. Layout Admin

Gunakan struktur:

``` text
┌─────────────────────────────────────────────┐
│ Header / User                                │
├───────────────┬─────────────────────────────┤
│ Sidebar       │                             │
│               │       Content               │
│ Dashboard     │                             │
│ Siswa         │                             │
│ Orang Tua     │                             │
│ Kelas         │                             │
│ Absensi       │                             │
│ Rekap         │                             │
│ Pengaturan    │                             │
│               │                             │
└───────────────┴─────────────────────────────┘
```

Sidebar tidak perlu terlalu lebar.

Active menu harus terlihat jelas.

Contoh:

``` text
Dashboard
Data Siswa
Data Orang Tua
Data Kelas
Absensi
Rekap
Pengaturan
```

------------------------------------------------------------------------

# 20. Halaman Absensi Harian

Prioritaskan tabel data dibanding dekorasi.

Contoh:

``` text
Absensi Hari Ini
Senin, 5 Oktober 2026

[ Semua Kelas ] [ Semua Status ] [ Semua Metode ]

---------------------------------------------------------
Jam    Nama       Kelas       Metode       Status
---------------------------------------------------------
06:45  Bima       XII RPL 1   QR            Hadir
06:47  Andi       XII RPL 2   Fingerprint   Hadir
07:18  Sinta      XI RPL 1    QR            Terlambat
---------------------------------------------------------
```

Gunakan badge sederhana untuk status.

------------------------------------------------------------------------

# 21. Responsive Design

Aplikasi harus dapat digunakan pada:

-   Desktop;
-   Laptop;
-   Tablet;
-   Mobile.

Tetapi prioritas admin adalah desktop/laptop.

Halaman orang tua harus nyaman di mobile.

Scanner juga harus nyaman pada layar yang tersedia.

Gunakan Bootstrap 5 responsive utilities.

------------------------------------------------------------------------

# 22. Teknologi

## Backend

-   Laravel 12
-   PHP 8.2+
-   Laravel Blade
-   Laravel Validation
-   Laravel Authentication
-   Laravel Policies/Gates jika diperlukan
-   Laravel Queue untuk notifikasi
-   Laravel Scheduler jika diperlukan

## Database

-   MySQL

## Frontend

-   Blade
-   Bootstrap 5
-   Bootstrap Icons
-   CSS custom
-   Vanilla JavaScript

## Larangan UI

Jangan menggunakan Tailwind CSS.

Jangan mengubah project menjadi React/Vue kecuali memang ada kebutuhan
teknis yang benar-benar jelas.

------------------------------------------------------------------------

# 23. Struktur Database Awal

Gunakan penamaan Laravel yang konsisten.

## users

Untuk akun yang dapat login.

Kolom contoh:

``` text
id
name
email
password
role
status
remember_token
created_at
updated_at
```

Role awal:

``` text
admin
parent
```

Jika nantinya guru membutuhkan akun sendiri, role dapat diperluas.

## students

``` text
id
nis
nisn
name
class_id
parent_id
gender
status
qr_token
fingerprint_identifier
created_at
updated_at
```

## parents

``` text
id
name
phone
email
status
created_at
updated_at
```

## classes

``` text
id
name
level
major
academic_year
status
created_at
updated_at
```

## attendances

``` text
id
student_id
attendance_date
check_in
check_out
method
status
check_in_notification_status
check_out_notification_status
notes
created_at
updated_at
```

Method:

``` text
qr
fingerprint
```

Status:

``` text
present
late
permission
sick
absent
```

## attendance_corrections

Untuk koreksi manual admin.

``` text
id
attendance_id
user_id
old_status
new_status
reason
created_at
updated_at
```

## notification_logs

``` text
id
student_id
attendance_id
channel
recipient
type
status
message
provider_message_id
sent_at
error_message
created_at
updated_at
```

Channel:

``` text
whatsapp
```

Type:

``` text
check_in
check_out
```

## school_settings

Untuk pengaturan sekolah.

Contoh:

``` text
id
school_name
school_address
school_phone
check_in_time
late_after
check_out_time
timezone
created_at
updated_at
```

Struktur final dapat disesuaikan ketika ERD dibuat.

------------------------------------------------------------------------

# 24. Relasi Database

Konsep relasi:

``` text
classes
   │
   └────< students >──── parents

students
   │
   └────< attendances

attendances
   │
   └────< attendance_corrections

attendances
   │
   └────< notification_logs

users
   │
   └────< attendance_corrections
```

Catatan:

Satu orang tua dapat memiliki beberapa siswa.

Satu siswa memiliki satu kelas aktif.

Satu siswa memiliki banyak riwayat absensi.

------------------------------------------------------------------------

# 25. Keamanan

Minimal implementasikan:

-   password hashing Laravel;
-   CSRF protection;
-   authentication;
-   authorization;
-   validation;
-   rate limiting pada endpoint scanner jika diperlukan;
-   sanitasi input;
-   database constraints;
-   unique QR token;
-   unique NIS/NISN jika aturan sekolah mengharuskannya;
-   audit/koreksi absensi;
-   jangan menyimpan data fingerprint mentah di aplikasi jika perangkat
    sudah menyediakan identifier yang aman.

Jangan menaruh API key WhatsApp di source code.

Gunakan `.env`.

------------------------------------------------------------------------

# 26. API / Service Architecture

Business logic jangan ditaruh seluruhnya di Controller.

Gunakan service class.

Contoh:

``` text
app/
├── Services/
│   ├── AttendanceService.php
│   ├── QrAttendanceService.php
│   ├── FingerprintService.php
│   └── WhatsAppNotificationService.php
```

Controller bertugas menerima request dan mengembalikan response.

Contoh:

``` text
AttendanceController
        ↓
AttendanceService
        ↓
Attendance Model
        ↓
Database
```

Notifikasi:

``` text
AttendanceService
        ↓
Queue Job
        ↓
WhatsAppNotificationService
        ↓
WhatsApp Provider
```

------------------------------------------------------------------------

# 27. QR Scanner

Untuk browser-based QR scanner, gunakan library yang stabil dan ringan.

Jangan membuat scanner dari nol jika library yang sesuai sudah tersedia.

Scanner harus:

-   meminta permission kamera;
-   menangani kamera tidak tersedia;
-   menangani permission ditolak;
-   memberi feedback ketika QR valid;
-   memberi feedback ketika QR invalid;
-   mencegah scan berulang;
-   kembali ke mode siap scan setelah proses selesai.

------------------------------------------------------------------------

# 28. Feedback UI

Setiap proses harus memberikan feedback yang jelas.

Contoh sukses:

``` text
✓ Absensi berhasil dicatat.
```

Duplikat:

``` text
Siswa sudah melakukan absensi masuk hari ini.
```

QR tidak valid:

``` text
QR Code tidak valid atau sudah tidak aktif.
```

Siswa tidak aktif:

``` text
Data siswa tidak aktif. Silakan hubungi admin.
```

Error sistem:

``` text
Absensi belum dapat diproses. Silakan coba kembali.
```

Jangan menampilkan error teknis database kepada pengguna.

------------------------------------------------------------------------

# 29. Empty State

Jika tidak ada data:

``` text
Belum ada data absensi hari ini.
```

Jangan menampilkan tabel kosong tanpa penjelasan.

------------------------------------------------------------------------

# 30. Loading State

Ketika proses membutuhkan waktu:

``` text
Memproses absensi...
```

Untuk pengiriman WhatsApp:

``` text
Absensi berhasil.
Notifikasi orang tua sedang diproses.
```

Jangan membuat user menunggu request WhatsApp secara synchronous jika
dapat menggunakan queue.

------------------------------------------------------------------------

# 31. Pengaturan Sekolah

Admin dapat mengatur:

-   nama sekolah;
-   alamat;
-   nomor sekolah;
-   jam masuk;
-   batas keterlambatan;
-   jam pulang;
-   timezone.

Gunakan timezone Indonesia yang sesuai dengan kebutuhan sekolah.

------------------------------------------------------------------------

# 32. Laporan

Versi pertama minimal menyediakan:

-   laporan harian;
-   laporan berdasarkan rentang tanggal;
-   laporan per kelas;
-   laporan per siswa;
-   rekap status kehadiran.

Export Excel/PDF dapat dibuat sebagai fitur tambahan setelah sistem inti
selesai.

------------------------------------------------------------------------

# 33. Notifikasi Belum Hadir

Fitur ini tidak boleh langsung menganggap siswa alpha hanya karena belum
scan.

Alur yang disarankan:

``` text
Jam masuk
    ↓
Menunggu absensi
    ↓
Batas monitoring sekolah
    ↓
Cari siswa yang belum memiliki absensi
    ↓
Tentukan tindakan sesuai kebijakan sekolah
```

Jika sekolah menginginkan notifikasi kepada orang tua:

``` text
"Ananda belum tercatat melakukan absensi sampai pukul 07:30."
```

Gunakan bahasa yang informatif, bukan menyimpulkan anak tidak masuk.

------------------------------------------------------------------------

# 34. Edge Cases

Agent harus menangani minimal:

### QR sudah pernah digunakan hari ini

Tolak duplikasi.

### Siswa mencoba check-out tanpa check-in

Tolak dan beri informasi.

### QR tidak dikenal

Tolak.

### Siswa nonaktif

Tolak.

### WhatsApp gagal

Absensi tetap dianggap berhasil jika record absensi sudah tersimpan.

Notification log menjadi:

``` text
failed
```

Admin dapat melihat status tersebut.

### Database berhasil, WhatsApp gagal

Jangan rollback absensi hanya karena WhatsApp gagal.

### WhatsApp provider lambat

Gunakan queue.

### Dua request absensi masuk bersamaan

Gunakan transaction/database constraint yang sesuai.

### Hari libur

Sediakan kemungkinan konfigurasi hari sekolah/libur pada pengembangan
lanjutan.

------------------------------------------------------------------------

# 35. UX Scanner yang Direkomendasikan

Scanner adalah proses operasional, sehingga tampilannya jangan seperti
dashboard.

Gunakan:

``` text
ABSENSI SISWA

Senin, 5 Oktober 2026
06:48 WIB

[        SCANNER        ]

Arahkan QR Code siswa ke kamera

Status:
Menunggu scan
```

Setelah berhasil:

``` text
✓ ABSENSI BERHASIL

Bima
XII RPL 1

06:48 WIB
Hadir
QR Code
```

Kemudian otomatis kembali ke scanner.

------------------------------------------------------------------------

# 36. Gaya Copywriting

Gunakan bahasa Indonesia yang natural dan formal sederhana.

Gunakan:

-   "Data Siswa"
-   "Absensi Hari Ini"
-   "Riwayat Absensi"
-   "Tambah Siswa"
-   "Simpan Data"
-   "Absensi Berhasil"
-   "Belum Ada Data"

Hindari:

-   "Let's Get Started!"
-   "Welcome Back, Super Admin!"
-   "Your Attendance Journey"
-   "Smart Attendance Experience"
-   jargon startup yang tidak diperlukan.

------------------------------------------------------------------------

# 37. Instruksi Khusus untuk Agent AI

Agent harus:

1.  Membaca struktur project terlebih dahulu sebelum mengubah file.
2.  Jangan menghapus fitur yang sudah ada tanpa alasan.
3.  Jangan mengganti framework frontend.
4.  Gunakan Laravel 12.
5.  Gunakan MySQL.
6.  Gunakan Blade + Bootstrap 5 + custom CSS + JavaScript.
7.  Jangan menggunakan Tailwind.
8.  Jangan membuat UI generik hasil template AI.
9.  Jangan menambahkan library besar jika tidak diperlukan.
10. Jangan menaruh business logic kompleks di Blade.
11. Gunakan Form Request untuk validasi kompleks.
12. Gunakan Service untuk business logic absensi.
13. Gunakan Queue untuk notifikasi WhatsApp.
14. Gunakan `.env` untuk credentials.
15. Gunakan database migration.
16. Gunakan seeder untuk data development.
17. Gunakan route yang terstruktur.
18. Gunakan policy/middleware untuk authorization.
19. Jangan hard-code jam sekolah.
20. Jangan hard-code nomor WhatsApp.
21. Jangan menganggap WhatsApp berhasil hanya karena request dikirim.
22. Jangan membuat absensi ganda.
23. Jangan menyimpan fingerprint mentah tanpa kebutuhan yang jelas.
24. Jangan menampilkan error teknis kepada pengguna.
25. Buat sistem dapat dikembangkan untuk fingerprint device nyata.

------------------------------------------------------------------------

# 38. Urutan Development

Jangan mengerjakan semuanya sekaligus.

## Phase 1 --- Project Foundation

-   Setup Laravel 12.
-   Setup MySQL.
-   Authentication.
-   Layout admin.
-   Role/authorization.

## Phase 2 --- Master Data

-   Kelas.
-   Siswa.
-   Orang tua.
-   Relasi siswa-orang tua.

## Phase 3 --- QR Attendance

-   Generate QR.
-   Scanner.
-   AttendanceService.
-   Check-in.
-   Check-out.
-   Status otomatis.
-   Duplicate prevention.

## Phase 4 --- Dashboard & History

-   Dashboard.
-   Absensi hari ini.
-   Riwayat.
-   Filter.
-   Rekap.

## Phase 5 --- Parent Monitoring

-   Dashboard orang tua.
-   Status hari ini.
-   Histori anak.

## Phase 6 --- WhatsApp

-   Notification service.
-   Queue.
-   Notification log.
-   Provider integration.
-   Retry/failure handling.

## Phase 7 --- Fingerprint

-   FingerprintService.
-   Mock fingerprint.
-   API/device adapter.
-   Real device integration jika tersedia.

## Phase 8 --- Security & Testing

-   Authorization.
-   Validation.
-   Duplicate testing.
-   Notification failure testing.
-   Scanner testing.
-   Responsive testing.

## Phase 9 --- Polish

-   UI refinement.
-   Empty state.
-   Loading state.
-   Error state.
-   Accessibility dasar.
-   Performance.

------------------------------------------------------------------------

# 39. Acceptance Criteria

Sistem dianggap memenuhi MVP jika:

### Authentication

-   Admin dapat login.
-   User tanpa hak akses tidak dapat membuka halaman admin.

### Student

-   Admin dapat membuat siswa.
-   Siswa terhubung dengan kelas.
-   Siswa terhubung dengan orang tua.
-   Siswa memiliki QR unik.

### QR Attendance

-   QR valid dapat digunakan.
-   QR invalid ditolak.
-   Siswa hanya dapat check-in satu kali per hari.
-   Sistem mencatat tanggal dan waktu.
-   Sistem menentukan status sesuai pengaturan.
-   Check-out dapat dilakukan.

### Fingerprint

-   Sistem memiliki service/interface untuk fingerprint.
-   Mock fingerprint dapat digunakan untuk testing.
-   Struktur siap dihubungkan ke perangkat nyata.

### WhatsApp

-   Absensi berhasil menghasilkan notification job.
-   Nomor orang tua diambil dari data yang terdaftar.
-   Pengiriman dicatat.
-   Kegagalan WhatsApp tidak menghapus absensi.
-   Tidak ada spam akibat scan berulang.

### Parent

-   Orang tua dapat melihat status anak.
-   Orang tua dapat melihat riwayat.

### Admin

-   Admin dapat melihat absensi hari ini.
-   Admin dapat memfilter data.
-   Admin dapat melihat riwayat.
-   Admin dapat melakukan koreksi dengan alasan.

### UI

-   Responsive.
-   Bootstrap 5.
-   Tidak menggunakan Tailwind.
-   Tidak menggunakan gradient berlebihan.
-   Tidak menggunakan glassmorphism.
-   Tidak menggunakan desain dashboard AI generik.
-   Tabel dan form mudah digunakan.
-   Warna konsisten.
-   Typography mudah dibaca.

------------------------------------------------------------------------

# 40. Definition of Done

Sebuah fitur dianggap selesai jika:

-   migration tersedia;
-   model dan relasi tersedia;
-   controller/service tersedia jika dibutuhkan;
-   validation tersedia;
-   route tersedia;
-   Blade tersedia;
-   authorization diperiksa;
-   success state tersedia;
-   error state tersedia;
-   empty state tersedia;
-   responsive;
-   tidak menghasilkan error Laravel;
-   diuji pada skenario normal;
-   diuji pada skenario duplikasi/error;
-   tidak merusak fitur lain.

------------------------------------------------------------------------

# 41. Struktur Folder yang Disarankan

``` text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Parent/
│   │   └── Attendance/
│   └── Requests/
│
├── Models/
│   ├── User.php
│   ├── Student.php
│   ├── Parent.php
│   ├── SchoolClass.php
│   ├── Attendance.php
│   ├── AttendanceCorrection.php
│   └── NotificationLog.php
│
├── Services/
│   ├── AttendanceService.php
│   ├── QrAttendanceService.php
│   ├── FingerprintService.php
│   └── WhatsAppNotificationService.php
│
└── Jobs/
    └── SendAttendanceWhatsAppNotification.php

resources/
├── views/
│   ├── layouts/
│   ├── admin/
│   ├── parent/
│   ├── attendance/
│   └── components/

routes/
├── web.php
└── api.php

database/
├── migrations/
└── seeders/
```

Nama file dapat disesuaikan dengan konvensi Laravel yang digunakan
project.

------------------------------------------------------------------------

# 42. Prioritas Fitur

## P0 --- Wajib

-   Login.
-   Data siswa.
-   Data orang tua.
-   Data kelas.
-   QR Code.
-   Scanner.
-   Absensi masuk.
-   Absensi pulang.
-   Status kehadiran.
-   Riwayat.
-   Dashboard admin.

## P1 --- Sangat Penting

-   WhatsApp notification.
-   Dashboard orang tua.
-   Notification log.
-   Koreksi absensi.
-   Rekap.

## P2 --- Pengembangan

-   Fingerprint device nyata.
-   Export PDF/Excel.
-   Hari libur.
-   Multi sekolah.
-   Statistik lebih detail.

------------------------------------------------------------------------

# 43. Konsep Arsitektur Final

``` text
                 ┌──────────────────┐
                 │      ADMIN       │
                 └────────┬─────────┘
                          │
                          ↓
                 ┌──────────────────┐
                 │ Laravel 12       │
                 │ Web Application  │
                 └────────┬─────────┘
                          │
             ┌────────────┼────────────┐
             ↓            ↓            ↓
          QR Scan     Fingerprint   Parent Web
             │            │            │
             └────────────┼────────────┘
                          ↓
                ┌───────────────────┐
                │ AttendanceService │
                └─────────┬─────────┘
                          ↓
                    ┌───────────┐
                    │   MySQL   │
                    └─────┬─────┘
                          ↓
                   Notification Job
                          ↓
                   WhatsApp API
                          ↓
                    Orang Tua
```

------------------------------------------------------------------------

# 44. Kesimpulan Produk

Produk ini bukan sekadar aplikasi untuk mencatat siswa hadir.

Nilai utama sistem adalah:

> **Membuat proses kehadiran siswa menjadi lebih terstruktur sekaligus
> memberikan informasi kepada orang tua setelah anak melakukan
> absensi.**

Versi pertama harus tetap sederhana dan fokus.

Jangan menambahkan fitur yang tidak berhubungan langsung dengan masalah
utama sebelum sistem absensi, monitoring, dan notifikasi benar-benar
stabil.

------------------------------------------------------------------------

# 45. Instruksi Akhir untuk Agent

Sebelum melakukan coding:

1.  Audit project Laravel yang tersedia.
2.  Tampilkan struktur folder yang relevan.
3.  Cocokkan PRD dengan struktur project.
4.  Identifikasi fitur yang sudah ada.
5.  Jangan menghapus struktur existing tanpa alasan.
6.  Buat implementation plan.
7.  Kerjakan berdasarkan phase.
8.  Setelah setiap phase selesai, lakukan pengecekan migration, route,
    model, controller, view, dan relasi.
9.  Prioritaskan functional correctness sebelum visual polish.
10. Setelah fungsi stabil, baru lakukan penyempurnaan UI.

**Target akhir:**

Aplikasi absensi sekolah berbasis Laravel 12 + MySQL yang sederhana,
profesional, mudah digunakan, memiliki QR Code sebagai metode utama,
siap menerima integrasi fingerprint, dan mampu mengirimkan informasi
kehadiran kepada orang tua melalui WhatsApp.

**Catatan desain paling penting:**

> Jangan membuat aplikasi terlihat seperti hasil generator AI. Gunakan
> desain administrasi sekolah yang sederhana, realistis, rapi,
> konsisten, dan berorientasi pada pekerjaan pengguna.
