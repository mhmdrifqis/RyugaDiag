# PRD — Sistem Pakar Diagnosis Kerusakan Mobil BMW Seri 3 (Forward Chaining)

## 1. Overview

**Untuk siapa**
- **Teknisi bengkel** (khususnya di CV. Ryuga Spareparts) — pengguna utama yang melakukan diagnosis kerusakan kendaraan sehari-hari.
- **Admin bengkel** — pengelola data master (gejala, kerusakan, rule, akun teknisi) dan pemantau riwayat diagnosis.
- **Teknisi baru/junior** — pengguna sekunder yang memanfaatkan sistem sebagai media belajar karena pengetahuan teknisi senior sudah terdokumentasi dalam rule.

**Masalah yang diselesaikan**
- Diagnosis kerusakan BMW Seri 3 (1990–2006) saat ini masih manual, sangat bergantung pada pengalaman teknisi senior.
- Tidak ada dokumentasi terstruktur antara gejala ↔ jenis kerusakan, sehingga hasil diagnosis antar teknisi bisa berbeda (inkonsisten).
- Interpretasi kode OBD-II masih manual → rawan human error dan memakan waktu lama, terutama untuk kasus kompleks.
- Tidak ada riwayat diagnosis yang tersimpan rapi untuk dijadikan referensi ke depan.

**Value Proposition**
- Diagnosis lebih **cepat**: teknisi tinggal pilih gejala, sistem langsung menyimpulkan kerusakan via mesin inferensi Forward Chaining.
- Diagnosis lebih **konsisten**: hasil tidak lagi tergantung siapa yang memeriksa, karena aturan (rule) sudah baku di knowledge base.
- **Basis pengetahuan terdokumentasi** → jadi media belajar untuk teknisi baru.
- **Riwayat diagnosis otomatis tersimpan** di database, memudahkan audit/rujukan servis berikutnya.
- Bisa diakses dari **HP/tablet di area bengkel** (responsive), tidak perlu instalasi khusus.

---

## 2. Tech Stack

| Kategori | Pilihan | Catatan |
|---|---|---|
| Backend Framework | **Laravel** (versi LTS terbaru, gunakan Laravel 11/12 saat build) | Sesuai permintaan; cocok untuk rule-based CRUD + inference engine sederhana |
| Frontend | Blade + Tailwind CSS (atau Laravel Breeze/Jetstream untuk auth scaffolding) | Prioritaskan **mobile responsive** — dashboard sidebar collapsible di layar kecil |
| Database | **MySQL** | Sudah ditentukan di dokumen asli (3.2 Perancangan Basis Data) |
| ORM | Eloquent (bawaan Laravel) | Manfaatkan relasi model sesuai ERD/LRS |
| Auth | Laravel Breeze / Fortify, role-based (Admin, Teknisi) | Gunakan middleware/role guard, bukan tabel `users` terpisah tapi 1 tabel `users` + kolom `role`, ATAU tetap pisah `admin` & `teknisi` sesuai ERD asli (lihat catatan di Data Model) |
| Inference Engine | PHP native class (Forward Chaining service) di dalam Laravel (`app/Services/ForwardChainingService.php`) | Tidak perlu library eksternal, cukup query rule + gejala terpilih |
| Hosting | VPS (misal: Niagahoster/DigitalOcean/Biznet) dengan LAMP/LEMP stack, atau shared hosting cPanel yang support Laravel | Sesuaikan skala bengkel (single-tenant, low traffic) — VPS murah/shared hosting cukup |
| Payment | **Tidak diperlukan** (internal tool bengkel, tidak ada transaksi pembayaran) | — jika ke depan mau dijual sebagai SaaS multi-bengkel, baru pertimbangkan Midtrans/Xendit |
| Version Control | Git + GitHub/GitLab | — |
| Testing | PHPUnit/Pest bawaan Laravel (opsional untuk MVP, wajib untuk fase lanjut) | — |

---

## 3. Features

Legend: 🟢 = MVP (wajib fase 1) · 🟡 = Fase lanjutan (nice-to-have setelah MVP jalan)

### A. Autentikasi & Otorisasi
- 🟢 Login (Admin & Teknisi, satu halaman login dengan pilihan role)
- 🟢 Logout
- 🟡 Reset password / lupa password

### B. Modul Admin — Data Master
- 🟢 Kelola Data Gejala (CRUD: kode, nama, deskripsi)
- 🟢 Kelola Data Kerusakan (CRUD: kode, nama, deskripsi, solusi)
- 🟢 Kelola Basis Pengetahuan / Rule (hubungkan gejala ↔ kerusakan, format IF–THEN)
- 🟢 Kelola Data Teknisi (CRUD akun teknisi)
- 🟢 Dashboard Admin (ringkasan: total gejala, total kerusakan, total rule, total teknisi)
- 🟡 Export data master (gejala/kerusakan/rule) ke Excel/PDF
- 🟡 Import rule massal via CSV/Excel

### C. Modul Teknisi — Diagnosis
- 🟢 Dashboard Teknisi (ringkasan: diagnosis hari ini, total diagnosis, notifikasi)
- 🟢 Mulai Diagnosa: pilih 1+ gejala dari checklist
- 🟢 Proses inferensi Forward Chaining → cocokkan gejala dengan rule
- 🟢 Tampilkan hasil diagnosis (jenis kerusakan) + rekomendasi solusi
- 🟢 Simpan hasil diagnosis + detail gejala terpilih ke riwayat (database)
- 🟢 Lihat Riwayat Diagnosa (list + detail per baris)
- 🟡 Cetak/Export hasil diagnosis ke PDF (untuk diserahkan ke pelanggan)
- 🟡 Pesan "kerusakan tidak ditemukan" dengan saran (mis. tambahkan gejala/rule baru → notifikasi ke admin)

### D. Cross-cutting
- 🟢 Responsive UI (mobile-first, sidebar bisa collapse di layar kecil)
- 🟡 Notifikasi/log aktivitas (siapa mengubah data apa, kapan)
- 🟡 Multi-bengkel/tenant (jika mau dikembangkan jadi produk SaaS)
- 🟡 Statistik/analytics kerusakan paling sering terjadi (grafik)

---

## 4. Data Model

Berdasarkan ERD & LRS pada dokumen (3.2.1–3.2.3), berikut tabel utama dan relasinya. Total **7 tabel inti**.

### Tabel & Field

**1. `admins`**
- `id_admin` (PK, INT, auto increment)
- `nama_admin` (VARCHAR 100)
- `username` (VARCHAR 50)
- `password` (VARCHAR 255, hashed)

**2. `teknisis`**
- `id_teknisi` (PK, INT, auto increment)
- `nama_teknisi` (VARCHAR 100)
- `username` (VARCHAR 50)
- `password` (VARCHAR 255, hashed)

**3. `gejalas`**
- `id_gejala` (PK, INT, auto increment)
- `kode_gejala` (VARCHAR 10)
- `nama_gejala` (VARCHAR 150)
- `deskripsi` (TEXT)

**4. `kerusakans`**
- `id_kerusakan` (PK, INT, auto increment)
- `kode_kerusakan` (VARCHAR 10)
- `nama_kerusakan` (VARCHAR 150)
- `deskripsi` (TEXT)
- `solusi` (TEXT)

**5. `rules`** (Basis Pengetahuan)
- `id_rule` (PK, INT, auto increment)
- `id_gejala` (FK → gejalas.id_gejala)
- `id_kerusakan` (FK → kerusakans.id_kerusakan)

**6. `diagnosas`**
- `id_diagnosa` (PK, INT, auto increment)
- `id_teknisi` (FK → teknisis.id_teknisi)
- `id_kerusakan` (FK → kerusakans.id_kerusakan)
- `tanggal_diagnosa` (DATETIME)

**7. `detail_diagnosas`**
- `id_detail` (PK, INT, auto increment)
- `id_diagnosa` (FK → diagnosas.id_diagnosa)
- `id_gejala` (FK → gejalas.id_gejala)
- `jawaban` (ENUM: 'Ya','Tidak')

### Relasi Antar Entitas

| Entitas A | Relasi | Entitas B | Kardinalitas |
|---|---|---|---|
| Gejala | memiliki | Rule | One-to-Many |
| Kerusakan | memiliki | Rule | One-to-Many |
| Teknisi | melakukan | Diagnosa | One-to-Many |
| Kerusakan | menghasilkan | Diagnosa | One-to-Many |
| Diagnosa | memiliki | Detail Diagnosa | One-to-Many |
| Gejala | dipilih pada | Detail Diagnosa | One-to-Many |

**Catatan implementasi Laravel:**
- Gunakan Eloquent relationship: `Gejala::hasMany(Rule::class)`, `Kerusakan::hasMany(Rule::class)`, `Teknisi::hasMany(Diagnosa::class)`, `Diagnosa::hasMany(DetailDiagnosa::class)`, dll.
- Struktur data sudah dinormalisasi hingga **3NF** (tidak ada repeating group atau ketergantungan transitif) — aman langsung dipakai sebagai skema migration.
- Pertimbangkan menambahkan `timestamps()` (`created_at`, `updated_at`) standar Laravel di semua tabel untuk audit trail, meskipun tidak ada di rancangan asli.
- Untuk auth, bisa tetap 2 tabel terpisah (`admins`, `teknisis`) sesuai ERD asli dengan multi-guard Laravel, atau disederhanakan jadi 1 tabel `users` + kolom `role` — pilih salah satu di awal fase 1 agar tidak refactor besar di tengah jalan.

---

## 5. Phases (Urutan Pengerjaan)

### Phase 0 — Setup & Fondasi
- Install Laravel, konfigurasi `.env`, koneksi MySQL
- Setup Tailwind CSS + layout responsive dasar (sidebar admin/teknisi)
- Setup autentikasi (Breeze) + role guard (Admin/Teknisi)
- Buat migration + model untuk 7 tabel inti sesuai Data Model di atas
- Buat seeder data dummy (gejala, kerusakan, rule contoh) untuk testing

### Phase 1 — MVP: Modul Admin (Data Master)
- CRUD Gejala
- CRUD Kerusakan
- CRUD Basis Pengetahuan (Rule) — form pilih gejala + kerusakan
- CRUD Data Teknisi
- Dashboard Admin dengan ringkasan angka (total gejala/kerusakan/rule/teknisi)

### Phase 2 — MVP: Mesin Inferensi & Modul Diagnosis Teknisi
- Bangun `ForwardChainingService`: input = array gejala terpilih, proses = cocokkan ke tabel `rules`, output = kerusakan yang sesuai
- Halaman "Mulai Diagnosa": checklist gejala → tombol proses
- Halaman hasil diagnosa: tampilkan kerusakan + solusi, atau pesan "rule tidak ditemukan"
- Simpan hasil ke `diagnosas` + `detail_diagnosas`
- Dashboard Teknisi (ringkasan diagnosis hari ini/total)

### Phase 3 — MVP: Riwayat & Penyempurnaan UI
- Halaman Riwayat Diagnosa (list + detail per diagnosis)
- Pastikan seluruh halaman responsive di mobile (test di viewport HP)
- QA menyeluruh: validasi form, pesan error, konfirmasi hapus data
- Deploy ke hosting/VPS, setup domain & SSL

### Phase 4 — Pengembangan Lanjutan (Post-MVP)
- Export/cetak hasil diagnosa & data master ke PDF/Excel
- Import rule massal
- Log aktivitas admin/teknisi
- Statistik kerusakan tersering (chart)
- (Opsional) Multi-tenant jika ingin dijual ke bengkel lain sebagai produk

---

*Dokumen ini disusun berdasarkan hasil analisis & perancangan (BAB III–IV) sistem pakar diagnosis kerusakan BMW Seri 3 dengan metode Forward Chaining, disesuaikan untuk kebutuhan implementasi teknis di Laravel dengan tampilan responsive mobile.*
