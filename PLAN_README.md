Semua tambahan ini saya inginnya bisa diatur semua dari admin panel

# 🏫 Event & Competition Management Development Plan (Updated – Detail Page System)

Rencana pengembangan ini difokuskan pada sistem event tahunan yang scalable, interaktif, dan memiliki halaman detail terpisah untuk setiap mata lomba tanpa menghilangkan konsistensi tema landing page.

---

# 🎯 GOAL UTAMA

Membangun sistem event multi-tahun dengan:

* Save The Date yang tidak mengganggu setelah event selesai.
* Sistem detail lomba yang memiliki halaman masing-masing.
* UI tetap konsisten satu tema dengan landing page.
* Struktur scalable untuk penggunaan jangka panjang.

---

# 🔵 CAKRA – System Logic & Automation

---

## Fase 1: Multi-Year Event Architecture (COMPLETED ✅)

*Fokus: Sistem event reusable setiap tahun.*

* [x] Tambahkan field `event_year`.
* [x] Tambahkan `event_start` & `event_end`. (Database ready)
* [x] Tambahkan `status` (upcoming, ongoing, finished, archived).
* [x] Tambahkan `is_save_the_date_active`.
* [x] Sistem menampilkan event berdasarkan tahun aktif.

---

## Fase 2: Smart Save The Date System (COMPLETED ✅)

*Fokus: Countdown tidak mengganggu setelah event selesai.*

* [x] Countdown muncul hanya jika status = `upcoming`.
* [x] Jika `ongoing` → tampil “Sedang Berlangsung”.
* [x] Jika `finished` → countdown otomatis hilang.
* [x] Jika tanggal belum ada → tampil “Coming Soon”.
* [x] Admin memiliki toggle override manual.
* [x] Auto update status berdasarkan waktu server.

---

## Fase 3: Detailed Schedule & Validation System (COMPLETED ✅)

*Fokus: Detail jam dan validasi stabil.*

* [x] Detail jam mulai & selesai per mata lomba.
* [x] Fitur accordion untuk ringkasan jadwal.
* [x] Real-time validasi nama lomba.
* [x] Prevent duplicate submission (Server-side validation & UI check).
* [x] Perbaikan bug tambah lomba.

---

## Fase 4: Auto Reminder Email System (COMPLETED ✅)

*Fokus: Automasi notifikasi.*

* [x] Email otomatis 5–30 menit sebelum lomba.
* [x] Template profesional (nama, waktu, lokasi, kontak).
* [x] Integrasi command Laravel.
* [x] Prevent double send (Reminder sent flag).

---

# 🟣 ALIN – UI/UX & Page Architecture

---

## Fase 1: Visual & Layout Improvement (COMPLETED ✅)

*Fokus: Tampilan lebih clean & profesional.*

* [x] Perkecil donut chart/atau bisa ganti ganti tipe chartnya
* [x] Tingkatkan kontras warna teks (Dynamic text colors).
* [x] Konsistensi warna & typography (Anti-blue sync).
* [x] Perbaikan spacing & alignment.

---

## Fase 2: Form & Pagination Enhancement (PLANNED 🔄)

*Fokus: Navigasi & form lebih jelas.*

* [x] Field wajib tanda bintang merah (*).
* [x] Field opsional label "(Opsional)".
* [x] Pagination bisa search.
* [x] Tombol ke halaman awal & akhir (Bootstrap 5 links).
* [x] Input manual nomor halaman.

---

## Fase 3: Detail Eskul & Informasi Lomba (COMPLETED ✅)

*Fokus: Informasi lengkap saat dipilih.*

* [x] Foto & nama eskul bisa diklik.
* [x] Tampil detail:

  * Harga tiket (jika ada)
  * Jadwal
  * Juklak & Juknis
  * Deskripsi
  * Kontak panitia
* [x] Data dinamis dari database.

---

## Fase 4: Separate Detail Page Per Mata Lomba (COMPLETED ✅)

Fokus: Setiap mata lomba memiliki halaman detail sendiri dengan layout profesional dan konsisten dengan landing page.

 [x] Buat routing dinamis (contoh: /lomba/:slug).

 [x] Setiap mata lomba memiliki halaman detail terpisah.

 [x] Tema, warna, dan typography tetap konsisten dengan landing page.

 [x] Tambahkan tombol “Kembali ke Event”.

 [x] SEO friendly URL menggunakan slug.

 [x] Tambahkan breadcrumb navigation.

🎨 Layout Detail Page (Left Image – Right Content Structure)

 [x] Gunakan layout 2 kolom (responsive grid).

 Sisi kiri:

 [x] Gambar utama lomba (poster/banner).

 [x] Bisa ditambahkan efek hover atau slight zoom.

 Sisi kanan:

 [x] Judul lomba (Heading besar).

 [x] Status lomba (Upcoming / Ongoing / Finished).

 [x] Deskripsi lengkap.

Informasi detail:

 [x] 📅 Tanggal

 [x] ⏰ Jam

 [x] 📍 Lokasi

 [x] 💰 Harga tiket

 [x] Link download Juklak & Juknis.

 [x] Tombol CTA (Daftar / Save The Date).

 Layout otomatis berubah menjadi 1 kolom saat mobile (gambar di atas, teks di bawah).

 Gunakan spacing & alignment yang rapi agar tidak terlalu padat.
---

## Fase 5: Mobile & Tablet Responsiveness Optimization (COMPLETED ✅)

*Fokus: Memastikan seluruh halaman terlihat rapi, fungsional, dan proporsional di berbagai ukuran layar perangkat (HP & Tablet).*

* [x] **Navbar & Sidebar Admin**: Optimalisasi tampilan navbar menjadi *hamburger menu* / *offcanvas sidebar* ketika dibuka di layar HP agar ruang utama (konten) lebih luas.
* [x] **Grid & Layout Card User**: Menyesuaikan tampilan kartu (*card*) lomba, galeri, dan tim utama menjadi dinamis (1 kolom di HP, 2 kolom di Tablet, dan 3-4 kolom di Desktop).
* [x] **Tabel Data Admin**: Menggunakan kelas `table-responsive` pada daftar tabel agar *scroll* horizontal rapi dan datanya tidak "meluber" merusak layar HP. 
* [x] **Carousel & Banner**: Memastikan gambar latar belakang, slider carousel, dan teks ajakan (*Call to Action*) proporsinya menyesuaikan lebar layar, tidak tertutup atau terpotong.
* [x] **Form Pendaftaran**: Menata *padding*, *margin*, dan *font-size* *input field* pendaftaran agar lebih mudah ditekan menggunakan jari pada layar sentuh.

---

# 📌 Future Enhancement

* [ ] Statistik peserta per lomba.
* [x] Pengumuman juara tiap lomba (juara_1, juara_2, juara_3 fields).
* [x] Buat yang carousel bisa diberi keterangan dari admin (deskripsi, keterangan & link_url).
* [x] Panel admin bisa melakukan Edit & Update Carousel.
* [x] Tampilan admin itu diubah yang side bar warnanya jadi mengikuti bg warna putih tapi tetap kayak ada jarak antara sidebar dan content dan juga buat navbar di atas (Luxury Floating Layout).
* [x] Lomba detail buat jadi seperti form yang kanan keterangannya yang elegan (Premium Info Box Layout).



Untuk yang carousel dan juga galeri mending gini atau gimana 
jadi si carousel mah buat yang juara tahun lalau terus yang galeri itu buat foto foto kegiatan pas lomba berlangsungnya tahn kemaren , atau mau sebaliknya ? 