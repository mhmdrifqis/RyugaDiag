# Task.md — Rincian Menu & Fitur per Role

Dokumen ini merinci menu, halaman, dan tugas (task) di dalam aplikasi **Sistem Pakar Diagnosis Kerusakan Mobil BMW Seri 3 (Forward Chaining)**, dipecah berdasarkan role pengguna: **Admin** dan **Teknisi**. Gunakan dokumen ini sebagai acuan saat membuat routes, controller, dan view di Laravel.

---

## 0. Ringkasan Role

| Role | Hak Akses Utama |
|---|---|
| **Admin** | Mengelola seluruh data master sistem (Gejala, Kerusakan, Rule/Basis Pengetahuan, Akun Teknisi) + memantau seluruh riwayat diagnosis |
| **Teknisi** | Melakukan proses diagnosa kendaraan (input gejala → lihat hasil) + melihat riwayat diagnosa miliknya sendiri |

Login satu pintu (`/login`), sistem mengarahkan ke dashboard sesuai role setelah autentikasi berhasil.

---

## 1. ROLE: ADMIN

### 1.1 Menu Sidebar Admin
1. Dashboard Admin
2. Data Gejala
3. Data Kerusakan
4. Basis Pengetahuan (Rule)
5. Data Teknisi
6. (Opsional Fase Lanjutan) Riwayat Diagnosa Global
7. Logout

---

### 1.2 Dashboard Admin
**Route**: `/admin/dashboard`

**Tugas/Isi halaman:**
- [ ] Card ringkasan: Total Gejala
- [ ] Card ringkasan: Total Kerusakan
- [ ] Card ringkasan: Total Rule (Basis Pengetahuan)
- [ ] Card ringkasan: Total Teknisi aktif
- [ ] (Opsional) Card ringkasan: Total Diagnosa hari ini / bulan ini (seluruh teknisi)
- [ ] Notifikasi singkat "rule tidak ditemukan" jika ada teknisi yang mengalami hasil diagnosa gagal (menandakan perlu tambah gejala/rule baru)
- [ ] Panel info/arahan singkat cara pakai (opsional, sesuai referensi UI "Area Administrator")

---

### 1.3 Data Gejala
**Route**: `/admin/gejala` (index, create, edit, delete)

**Field yang dikelola:**
- Kode Gejala (`kode_gejala`) — contoh: G001
- Nama Gejala (`nama_gejala`)
- Deskripsi (`deskripsi`)

**Tugas:**
- [ ] Halaman list (tabel) semua gejala — kolom: Kode, Nama Gejala, Deskripsi Singkat, Aksi (Edit/Hapus)
- [ ] Tombol "+ Tambah Data" → buka form tambah gejala
- [ ] Form tambah gejala (kode, nama, deskripsi) dengan validasi (kode unik, nama wajib diisi)
- [ ] Form edit gejala (prefill data lama)
- [ ] Aksi hapus gejala + modal konfirmasi
- [ ] Validasi: gejala yang sudah dipakai di Rule tidak boleh dihapus langsung (tampilkan peringatan / soft-delete) — cegah data rule jadi anak yatim
- [ ] Search/filter gejala by nama atau kode (opsional, nice-to-have)
- [ ] Pagination jika data gejala banyak

---

### 1.4 Data Kerusakan
**Route**: `/admin/kerusakan` (index, create, edit, delete)

**Field yang dikelola:**
- Kode Kerusakan (`kode_kerusakan`) — contoh: K001
- Nama Kerusakan (`nama_kerusakan`)
- Deskripsi (`deskripsi`)
- Solusi Penanganan (`solusi`)

**Tugas:**
- [ ] Halaman list (tabel) semua kerusakan — kolom: Kode, Nama Kerusakan, Solusi/Penanganan (ringkas), Aksi
- [ ] Tombol "+ Tambah Data" → form tambah kerusakan
- [ ] Form tambah kerusakan (kode, nama, deskripsi, solusi — textarea untuk solusi karena bisa panjang)
- [ ] Form edit kerusakan
- [ ] Aksi hapus kerusakan + modal konfirmasi
- [ ] Validasi: kerusakan yang sudah dipakai di Rule atau Riwayat Diagnosa tidak boleh dihapus langsung
- [ ] Search/filter kerusakan by nama atau kode (opsional)
- [ ] Pagination

---

### 1.5 Basis Pengetahuan (Rule)
**Route**: `/admin/rule` (index, create, delete)

Ini adalah **jantung sistem pakar** — menghubungkan Gejala ↔ Kerusakan dalam format IF–THEN.

**Field yang dikelola:**
- Pilih Gejala (`id_gejala`, dropdown dari master Gejala) → bagian **IF**
- Pilih Kerusakan (`id_kerusakan`, dropdown dari master Kerusakan) → bagian **THEN**

**Tugas:**
- [ ] Halaman list (tabel) semua rule — kolom: ID Rule, Gejala (IF), Kerusakan (THEN), Aksi (Hapus)
- [ ] Tombol "+ Buat Rule" → form buat rule baru
- [ ] Form buat rule: dropdown pilih gejala + dropdown pilih kerusakan → tombol simpan
- [ ] Validasi: kombinasi gejala+kerusakan yang sama tidak boleh duplikat
- [ ] Aksi hapus rule + modal konfirmasi
- [ ] (Catatan penting untuk pengembangan) Rule di dokumen asli 1 gejala → 1 kerusakan. Jika kebutuhan nyata butuh **1 kerusakan = kombinasi banyak gejala (AND logic)**, perlu didiskusikan ulang strukturnya sebelum development (lihat catatan di PRD.md bagian Data Model)
- [ ] Filter/grouping rule berdasarkan kerusakan tertentu (opsional) — supaya admin gampang cek "kerusakan X sudah punya rule gejala apa saja"
- [ ] Pagination

---

### 1.6 Data Teknisi
**Route**: `/admin/teknisi` (index, create, edit, delete)

**Field yang dikelola:**
- Nama Teknisi (`nama_teknisi`)
- Username (`username`)
- Password (`password`, hashed)

**Tugas:**
- [ ] Halaman list (tabel) semua akun teknisi — kolom: ID, Nama Teknisi, Username, Aksi (Edit/Hapus)
- [ ] Tombol "+ Tambah Akun" → form tambah teknisi baru
- [ ] Form tambah teknisi (nama, username, password + konfirmasi password)
- [ ] Form edit teknisi (nama, username bisa diubah; password opsional diisi ulang jika ingin ganti)
- [ ] Aksi hapus akun teknisi + modal konfirmasi
- [ ] Validasi: username unik
- [ ] Validasi: teknisi yang sudah punya riwayat diagnosa tidak bisa dihapus permanen (gunakan soft-delete agar riwayat diagnosa lama tetap punya referensi nama teknisi)
- [ ] Pagination

---

### 1.7 (Opsional Fase Lanjutan) Riwayat Diagnosa Global
**Route**: `/admin/riwayat-diagnosa`

**Tugas:**
- [ ] Admin bisa melihat **semua riwayat diagnosa dari semua teknisi** (bukan cuma miliknya sendiri seperti role Teknisi)
- [ ] Filter berdasarkan: rentang tanggal, nama teknisi, jenis kerusakan
- [ ] Lihat detail per diagnosa: gejala yang dipilih, hasil kerusakan, solusi yang ditampilkan saat itu
- [ ] Export riwayat ke Excel/PDF (opsional)

---

## 2. ROLE: TEKNISI

### 2.1 Menu Sidebar Teknisi
1. Dashboard Teknisi
2. Mulai Diagnosa
3. Riwayat Diagnosa
4. Logout

---

### 2.2 Dashboard Teknisi
**Route**: `/teknisi/dashboard`

**Tugas/Isi halaman:**
- [ ] Card ringkasan: Jumlah Diagnosa Hari Ini (oleh teknisi yang login)
- [ ] Card ringkasan: Total Diagnosa yang pernah dilakukan (akumulasi, oleh teknisi yang login)
- [ ] Card ringkasan: Notifikasi Sistem (misal: "Tidak ada" atau info jika ada rule baru ditambahkan admin)
- [ ] Panel "Area Teknisi" berisi sapaan + tombol shortcut "Mulai Diagnosa Sekarang"

---

### 2.3 Mulai Diagnosa
**Route**: `/teknisi/diagnosa/create` (form input) → `/teknisi/diagnosa/proses` (hasil)

Ini adalah **fitur inti** yang dipakai teknisi sehari-hari.

**Tugas — Langkah 1: Input Gejala**
- [ ] Tampilkan seluruh daftar gejala dalam bentuk **checklist** (checkbox), diambil dari master Data Gejala
- [ ] Teknisi mencentang satu atau lebih gejala sesuai kondisi kendaraan yang diperiksa
- [ ] Tombol "Proses Diagnosa" untuk submit gejala terpilih
- [ ] Validasi: minimal 1 gejala harus dipilih sebelum submit

**Tugas — Langkah 2: Proses Inferensi (Backend)**
- [ ] Sistem mengirim gejala terpilih ke `ForwardChainingService`
- [ ] Engine mencocokkan gejala dengan tabel `rules` menggunakan metode Forward Chaining
- [ ] Jika ditemukan rule yang cocok → tentukan jenis kerusakan
- [ ] Jika tidak ditemukan rule yang cocok → siapkan pesan "Kerusakan tidak ditemukan / Rule tidak ditemukan"

**Tugas — Langkah 3: Tampilkan Hasil**
- [ ] Halaman hasil diagnosa menampilkan:
  - Daftar gejala/fakta yang dipilih (ringkasan)
  - Kesimpulan jenis kerusakan (nama kerusakan)
  - Rekomendasi tindakan/solusi perbaikan (dari field `solusi` master Kerusakan)
- [ ] Jika rule tidak ditemukan → tampilkan pesan jelas + saran (mis. "silakan hubungi admin untuk menambahkan rule baru")
- [ ] Simpan otomatis hasil diagnosa ke tabel `diagnosas` (id_teknisi, id_kerusakan, tanggal_diagnosa)
- [ ] Simpan detail gejala yang dipilih ke tabel `detail_diagnosas` (id_diagnosa, id_gejala, jawaban)
- [ ] Tombol "Kembali / Diagnosa Ulang" untuk memulai diagnosa baru
- [ ] (Opsional Fase Lanjutan) Tombol "Cetak / Simpan Laporan" untuk export hasil ke PDF (diserahkan ke pelanggan)

---

### 2.4 Riwayat Diagnosa
**Route**: `/teknisi/riwayat-diagnosa`

**Tugas:**
- [ ] Halaman list (tabel) seluruh riwayat diagnosa **milik teknisi yang sedang login saja** (bukan milik teknisi lain)
- [ ] Kolom tabel: ID/Referensi Diagnosa, Waktu/Tanggal Diagnosa, Nama Teknisi, Hasil Identifikasi (Kerusakan), Aksi (Lihat Detail)
- [ ] Klik "Lihat" → buka halaman/modal detail:
  - Tanggal diagnosa
  - Daftar gejala yang dipilih saat itu
  - Jenis kerusakan yang disimpulkan
  - Solusi yang direkomendasikan
- [ ] Pagination jika riwayat sudah banyak
- [ ] (Opsional) Filter riwayat berdasarkan rentang tanggal

---

## 3. Matriks Ringkas Menu vs Role

| Menu / Halaman | Admin | Teknisi |
|---|:---:|:---:|
| Dashboard (versi masing-masing) | ✅ | ✅ |
| Data Gejala (CRUD) | ✅ | ❌ |
| Data Kerusakan (CRUD) | ✅ | ❌ |
| Basis Pengetahuan / Rule (CRUD) | ✅ | ❌ |
| Data Teknisi (CRUD) | ✅ | ❌ |
| Mulai Diagnosa | ❌ | ✅ |
| Riwayat Diagnosa (milik sendiri) | ❌ | ✅ |
| Riwayat Diagnosa (semua teknisi) | ✅ *(fase lanjutan)* | ❌ |
| Logout | ✅ | ✅ |

---

## 4. Catatan Teknis untuk Implementasi

- **Middleware/Guard**: buat middleware `role:admin` dan `role:teknisi` (atau gunakan Laravel Gate/Policy) untuk membatasi akses route sesuai matriks di atas — jangan hanya sembunyikan menu di UI, tapi juga blokir di level route/controller.
- **Route grouping**: kelompokkan route dengan prefix `admin/*` dan `teknisi/*`, masing-masing dibungkus middleware role terkait.
- **Redirect setelah login**: cek role user → arahkan ke `/admin/dashboard` atau `/teknisi/dashboard`.
- **Konsistensi UI**: setiap halaman list wajib pakai komponen tabel & card sesuai `StyleGuide.md`, dan setiap form wajib pakai `.input-group` style yang sama.
- **Urutan pengerjaan**: task-task di dokumen ini dikerjakan sesuai `Phases` yang sudah ditentukan di `PRD.md` (Phase 1 = modul Admin, Phase 2 = mesin inferensi + modul Diagnosa Teknisi, Phase 3 = Riwayat + polish UI).
