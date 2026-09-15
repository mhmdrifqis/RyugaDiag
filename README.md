# RyugaDiag - Sistem Pakar Diagnosa Kerusakan Mobil BMW Seri 3

<div align="center">
  <img src="public/image/ryugadiag_logo.jpg" alt="RyugaDiag Logo" width="200" style="border-radius: 20px;">
  <br><br>
  <strong>Aplikasi Sistem Pakar Berbasis Web dengan Algoritma Forward Chaining</strong>
</div>

<br>

**RyugaDiag** adalah aplikasi Sistem Pakar yang dirancang untuk membantu teknisi bengkel dalam mendiagnosa kerusakan secara spesifik pada mobil **BMW Seri 3**. Aplikasi ini dibangun menggunakan mesin penalaran inferensi **Forward Chaining**, di mana sistem menyimpulkan jenis kerusakan berdasarkan sekumpulan fakta (gejala) yang diinputkan oleh pengguna.

Aplikasi ini menggunakan teknologi *modern stack* dengan desain antarmuka bergaya *Glassmorphism* yang cantik, responsif, dan sangat intuitif.

---

## ✨ Fitur Utama

### 👑 Role Admin (Pakar / Manajemen Data)
- **Manajemen Gejala**: Tambah, Edit, Hapus data gejala kerusakan (*Facts*).
- **Manajemen Kerusakan**: Tambah, Edit, Hapus data jenis kerusakan beserta rekomendasi solusinya (*Hypothesis*).
- **Basis Pengetahuan (Rule)**: Menentukan relasi sebab-akibat (IF-THEN) antara kumpulan gejala dan satu kerusakan.
- **Import Data (Excel)**: Fitur unggah data Gejala, Kerusakan, dan Rule secara massal menggunakan file berektensi `.xlsx`.

### 👨‍🔧 Role Teknisi (Pengguna Sistem Pakar)
- **Mulai Diagnosa**: Formulir interaktif dengan fitur *Smart Search Multi-select* (AlpineJS) untuk mencari dan mencentang gejala yang dialami mobil pelanggan.
- **Hasil Diagnosa**: Menampilkan kesimpulan kerusakan berdasarkan algoritma *Forward Chaining*, lengkap dengan peringatan, deskripsi, dan panduan solusi.
- **Riwayat Diagnosa**: Melihat daftar rekam jejak diagnosa yang pernah dilakukan oleh teknisi yang bersangkutan.
- **Cetak Laporan**: Fitur mencetak (*print*) dokumen Detail Hasil Diagnosa dan Tabel Rekap Riwayat Diagnosa (tampilan disesuaikan otomatis untuk kertas).

---

## 🚀 Teknologi yang Digunakan

- **Framework PHP**: [Laravel 11](https://laravel.com/)
- **Frontend / Styling**: [Tailwind CSS](https://tailwindcss.com/)
- **Interaktivitas JavaScript**: [Alpine.js](https://alpinejs.dev/)
- **Database**: MySQL (MariaDB)
- **Library Excel**: [Maatwebsite Laravel Excel](https://docs.laravel-excel.com/)

---

## 🛠️ Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi RyugaDiag di komputer (localhost) Anda:

### 1. Persyaratan Sistem
Pastikan komputer Anda sudah terinstal perangkat lunak berikut:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Server (XAMPP / Laragon)
- Git

### 2. Clone Repositori
Buka terminal dan jalankan:
```bash
git clone https://github.com/mhmdrifqis/RyugaDiag.git
cd RyugaDiag
```

### 3. Instalasi Dependensi (Backend & Frontend)
```bash
composer install
npm install
npm run build
```

### 4. Konfigurasi Environment (Database)
Salin file konfigurasi *environment*:
```bash
cp .env.example .env
```
Buka file `.env`, lalu atur koneksi database Anda (sesuaikan dengan Laragon/XAMPP):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ryugadiag
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan Anda sudah membuat database kosong bernama `ryugadiag` di phpMyAdmin atau Laragon sebelum lanjut).*

### 5. Generate Key & Migrasi Database
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```
*(Catatan: Perintah `--seed` akan menjalankan Seeder untuk membuat akun default sistem).*

### 6. Jalankan Server
```bash
php artisan serve
```
Aplikasi sekarang dapat diakses di browser melalui URL: `http://localhost:8000`

---

## 🔐 Kredensial Default

Gunakan akun berikut untuk mencoba masuk ke sistem setelah instalasi:

**Admin (Manajemen Pengetahuan)**
- Email: `admin@ryugadiag.com`
- Password: `password`

**Teknisi (Operasional)**
- Email: `teknisi@ryugadiag.com`
- Password: `password`

---

## 📝 Konfigurasi Waktu (Timezone)
Sistem ini telah dikonfigurasi secara bawaan untuk menggunakan zona waktu **Waktu Indonesia Barat (WIB) / Asia/Jakarta**. 

Jika ada ketidaksesuaian waktu pada saat menyimpan riwayat diagnosa, pastikan variabel berikut tetap ada di file `.env` Anda:
```env
APP_TIMEZONE=Asia/Jakarta
```

---
*RyugaDiag — Dirancang dengan kebanggaan untuk mempermudah pekerjaan mekanik dengan tingkat presisi diagnosa layaknya seorang pakar mesin BMW.*
