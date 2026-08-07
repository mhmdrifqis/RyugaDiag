# Style Guide — Sistem Pakar Diagnosis Kerusakan BMW Seri 3

> Referensi visual diadaptasi dari prototipe HTML "iMobil" (collapsible sidebar, card-based dashboard). Dokumen ini jadi acuan tampilan saat implementasi di Laravel + Blade + Tailwind CSS.

---

## 1. Prinsip Desain

- **Clean & minim** — banyak whitespace, tidak ramai, fokus ke isi data.
- **Card-based** — semua blok informasi dibungkus card putih dengan sudut membulat dan shadow tipis.
- **Konsisten warna semantik** — hijau = positif/aman/berhasil, merah = bahaya/kritis, kuning = peringatan.
- **Sidebar collapsible** — hemat ruang, penting untuk layar kecil/tablet di bengkel.
- **Font tunggal (Poppins)** — jaga konsistensi, gunakan variasi weight untuk hierarki, bukan font berbeda.

---

## 2. Warna (Color Palette)

Definisikan sebagai CSS variable / Tailwind custom color agar konsisten di seluruh aplikasi.

| Token | Hex | Penggunaan |
|---|---|---|
| `--primary` | `#2C3E50` (navy gelap) | Warna utama: judul, sidebar logo, tombol primary, teks penting |
| `--accent` | `#27AE60` (hijau) | Aksi positif: tombol sukses, status "selesai", ikon aktif, highlight menu aktif |
| `--accent-hover` | `#219653` | Hover state untuk elemen accent |
| `--bg-light` | `#F8F9FA` | Background utama halaman (body) |
| `--card-bg` | `#FFFFFF` | Background card/panel |
| `--sidebar-bg` | `#FDFDFD` | Background sidebar (sedikit beda dari card agar ada pemisahan halus) |
| `--text-main` | `#333333` | Teks isi/body |
| `--text-muted` | `#7F8C8D` | Teks sekunder: label, subtitle, placeholder |
| `--border` | `#E0E0E0` | Border card, tabel, input |
| `--warning` | `#F2C94C` (kuning) | Status perlu perhatian (mis. gejala ambigu, kondisi menengah) |
| `--danger` | `#EB5757` (merah) | Status kritis/gagal (mis. rule tidak ditemukan, kerusakan parah) |

**Pemetaan ke konteks aplikasi diagnosis:**
- Status **"Kerusakan Ditemukan / Diagnosis Berhasil"** → `--accent` (hijau)
- Status **"Perlu Tindakan Segera"** → `--danger` (merah)
- Status **"Rule Tidak Ditemukan / Butuh Review Admin"** → `--warning` (kuning)
- Sidebar & header → `--primary` untuk teks/ikon aktif, `--sidebar-bg`/`--bg-light` untuk background

---

## 3. Tipografi

- **Font family**: `Poppins` (Google Fonts), fallback `sans-serif`.
- **Skala weight**: 300 (light, jarang dipakai), 400 (regular/body), 500 (label/medium emphasis), 600 (heading kecil/card title), 700 (heading besar/logo).

| Elemen | Ukuran | Weight | Warna |
|---|---|---|---|
| Logo aplikasi | 24–28px | 700 | `--primary` |
| Page title (`<h1>`) | 24px | 600 | `--primary` |
| Card title | 16px | 600 | `--primary` |
| Body text | 14px | 400 | `--text-main` |
| Label form | 13px | 500 | `--text-main` |
| Teks muted / caption | 12–13px | 400 | `--text-muted` |
| Angka statistik besar (`stat-card h2`) | 24px | 700 | `--primary` |

---

## 4. Layout & Struktur Halaman

### 4.1 Struktur Global
Aplikasi terdiri dari **2 layer utama**:
1. **Login Layer** — full screen, background foto blur (glassmorphism card di tengah).
2. **App Layer** — layout 2 kolom: **Sidebar** (kiri) + **Main Content** (kanan).

### 4.2 Sidebar (Collapsible)
- Lebar normal: **260px**, lebar collapsed: **85px**.
- Transisi lebar: `0.3s ease` saat toggle (tombol hamburger di header).
- Isi sidebar dari atas ke bawah:
  1. Logo aplikasi + nama (disembunyikan teksnya saat collapsed, hanya ikon)
  2. Menu navigasi (list ikon + label)
  3. Profile card di bagian bawah (avatar + nama + aksi logout) — nempel di bawah pakai `margin-top: auto`
- **Menu aktif**: background putih + shadow tipis + ikon warna `--accent` + teks `--primary` bold.
- **Menu hover**: background abu muda (`#f0f0f0`).
- Saat collapsed: label teks disembunyikan, hanya ikon center, gunakan `title` attribute untuk tooltip aksesibilitas.

**Struktur menu untuk aplikasi ini** (adaptasi dari referensi "iMobil"):
- Dashboard
- Mulai Diagnosa *(khusus role Teknisi)*
- Riwayat Diagnosa *(khusus role Teknisi)*
- Data Gejala *(khusus role Admin)*
- Data Kerusakan *(khusus role Admin)*
- Basis Pengetahuan / Rule *(khusus role Admin)*
- Data Teknisi *(khusus role Admin)*

### 4.3 Header (Main Content)
- Flex row, `justify-content: space-between`.
- Kiri: tombol hamburger (toggle sidebar) + judul halaman dinamis (`<h1 id="page-title">`).
- Kanan: search bar (opsional, ikon kaca pembesar) + ikon notifikasi bell.
- Background transparan (menyatu dengan `--bg-light`), padding `24px 32px`.

### 4.4 Konten / View Section
- Setiap "halaman" dalam SPA-style adalah `<section class="view-section">`, hanya satu yang `display: block` pada satu waktu (pada implementasi Laravel: ini jadi halaman/route terpisah, bukan toggle JS — kecuali kalau mau bikin dashboard SPA-like dengan Alpine.js/Livewire).
- Padding konten: `0 32px 32px 32px`, max-width `1400px`.
- Animasi masuk: fade-in + translateY (opsional, nice-to-have).

---

## 5. Komponen UI

### 5.1 Card
```
background: white;
border-radius: 16px;
padding: 24px;
box-shadow: 0 4px 15px rgba(0,0,0,0.03);
border: 1px solid rgba(0,0,0,0.02);
margin-bottom: 20px;
```
- Selalu punya `card-title` (16px, semibold, warna primary) di bagian atas.
- Gunakan untuk: statistik ringkasan, form, tabel, chart, list item.

### 5.2 Stat Card (Dashboard)
- Grid 4 kolom (desktop) → **1–2 kolom di mobile**.
- Isi: judul kecil (muted) → angka besar (bold, primary) → keterangan kecil (muted).
- Varian highlight: background gelap (`--primary`) dengan teks putih untuk kartu status penting (mis. "Status Sistem: Aman").

### 5.3 Tombol (Button)
| Class | Style | Kapan dipakai |
|---|---|---|
| `.btn-primary` | Background `--primary`, teks putih, shadow tipis | Aksi utama: Login, Simpan data master |
| `.btn-success` | Background `--accent`, teks putih | Aksi konfirmasi positif: "Proses Diagnosa", "Konfirmasi Jadwal" |
| `.btn-danger` *(tambahan, belum ada di referensi tapi perlu untuk konsistensi)* | Background `--danger`, teks putih | Aksi hapus/destruktif |
| `.btn-outline` *(tambahan)* | Border `--border`, teks `--text-main`, background transparan | Aksi sekunder: "Batal", "Kembali" |

Semua tombol: `border-radius: 12px`, `padding: 14px`, `font-weight: 600`, `transition: all 0.3s`.

### 5.4 Form / Input
- `.input-group`: label di atas (13px, medium), input di bawah.
- Input style: `border-radius: 12px`, border tipis `rgba(0,0,0,0.1)`, padding `12px 16px`, background hampir putih.
- Focus state: border berubah ke warna `--primary`.
- Gunakan untuk: form login, form tambah/edit Gejala, Kerusakan, Rule, Teknisi, form pilih gejala saat diagnosa.

### 5.5 Tabel Data (`.data-table`)
- Header (`<th>`): background `#fdfdfd`, teks muted, bold.
- Row border: garis bawah tipis (`--border`), tanpa garis vertikal (clean look).
- Padding sel: `16px`.
- Wajib dibungkus `<div style="overflow-x:auto">` agar responsive di mobile (scroll horizontal, bukan layout pecah).
- Dipakai untuk: daftar Gejala, daftar Kerusakan, daftar Rule, Riwayat Diagnosa.

### 5.6 Badge Status (`.status-badge`)
- Bentuk pill (`border-radius: 20px`), padding `6px 12px`, font kecil (12px).
- Varian warna: 
  - `.status-done` → background `#e8f8f5`, teks `--accent` (hijau) → "Selesai" / "Kerusakan Ditemukan"
  - Tambahan yang perlu dibuat: `.status-warning` (kuning muda + teks `--warning`) → "Perlu Review", `.status-danger` (merah muda + teks `--danger`) → "Kritis"

### 5.7 Progress Bar (Health Indicator)
- Dipakai untuk visualisasi tingkat kecocokan/kepercayaan rule (confidence level) jika nanti dikembangkan.
- Background abu (`#eee`), fill berwarna sesuai level: `.fill-good` (hijau), `.fill-warn` (kuning), `.fill-danger` (merah).
- Struktur: header (label + persentase) di atas bar.

### 5.8 List Item (mis. Riwayat singkat / Jadwal)
- Flex row, gap 15px, border, radius 12px, padding 15px.
- Ada elemen "date box" kecil di kiri (angka besar + bulan) untuk item bertanggal — bisa diadaptasi jadi "kode gejala box" atau "tanggal diagnosa box" di riwayat.

### 5.9 Chart (Chart.js)
- Font chart ikut Poppins, warna default label = `--text-muted`.
- Warna dataset utama: hijau (`--accent`) untuk bar, navy (`--primary`) untuk line/point.
- Dipakai untuk (pengembangan lanjutan): statistik jenis kerusakan tersering, tren jumlah diagnosis per bulan.
- Bungkus chart selalu dalam `.chart-container` dengan `height` tetap agar tidak "meledak" saat resize sidebar.

---

## 6. Responsive / Mobile Behavior

Karena aplikasi wajib jalan baik di mobile (dipakai teknisi di lantai bengkel), berikut aturan adaptasi dari desain desktop-first referensi:

| Breakpoint | Perilaku |
|---|---|
| **Desktop (≥1024px)** | Sidebar full 260px, dashboard grid 4 kolom, tabel normal |
| **Tablet (768–1023px)** | Sidebar default **collapsed** (85px, ikon saja), grid dashboard 2 kolom |
| **Mobile (<768px)** | Sidebar disembunyikan total, muncul sebagai **off-canvas drawer** saat tombol hamburger ditekan (overlay di atas konten, bukan geser konten). Grid dashboard jadi 1 kolom. Tabel di-scroll horizontal (`overflow-x: auto`) atau diubah jadi stacked card per baris untuk tabel penting (mis. Riwayat Diagnosa). |
| **Semua ukuran** | Font, padding, dan tombol tetap mengikuti unit di atas tapi boleh diperkecil ~10-15% di mobile agar tidak terlalu besar di layar kecil (gunakan `clamp()` atau breakpoint Tailwind `sm:` `md:` `lg:`). |

**Catatan implementasi Tailwind:**
- Gunakan `flex`/`grid` dengan class responsive: `grid-cols-1 md:grid-cols-2 lg:grid-cols-4`.
- Sidebar mobile: `fixed inset-y-0 left-0 -translate-x-full transition-transform` + toggle class `translate-x-0` saat dibuka, tambahkan backdrop gelap semi-transparan.

---

## 7. Ikon

- Library: **Font Awesome 6** (solid & regular), sudah dipakai konsisten di referensi (`fa-house`, `fa-calendar-check`, `fa-clock-rotate-left`, dll).
- Ikon untuk modul aplikasi ini:
  - Dashboard → `fa-house`
  - Mulai Diagnosa → `fa-stethoscope` atau `fa-magnifying-glass-chart`
  - Riwayat Diagnosa → `fa-clock-rotate-left`
  - Data Gejala → `fa-list-check`
  - Data Kerusakan → `fa-car-burst`
  - Basis Pengetahuan (Rule) → `fa-diagram-project` atau `fa-sitemap`
  - Data Teknisi → `fa-user-gear`
  - Logout → ikon di profile card (klik card = logout, sesuai referensi)

---

## 8. Halaman Login

- Background: foto full-screen (bisa pakai foto bengkel/mobil BMW), dengan overlay blur.
- Card login: **glassmorphism** — `background: rgba(255,255,255,0.65)`, `backdrop-filter: blur(16px)`, border tipis putih transparan, `border-radius: 24px`.
- Logo + judul aplikasi di tengah atas card.
- Form: 2 input (username/email + password), tambahkan **dropdown/toggle role** (Admin/Teknisi) sesuai kebutuhan sistem ini (berbeda dari referensi asli yang cuma customer).
- Tombol submit: `.btn-primary` full width.

---

## 9. Penamaan Kelas CSS (Konvensi)

Ikuti pola BEM-ringan/utility gabungan Tailwind, disesuaikan dari referensi:
- Layout: `.sidebar`, `.main-content`, `.header`, `.view-section`
- Komponen: `.card`, `.card-title`, `.stat-card`, `.data-table`, `.status-badge`, `.input-group`, `.btn`
- Modifier: `.collapsed`, `.active`, `.fill-good`/`.fill-warn`/`.fill-danger`, `.status-done`/`.status-warning`/`.status-danger`

Jika pindah penuh ke Tailwind utility class, simpan token warna di atas sebagai **custom theme** di `tailwind.config.js` (`colors: { primary: '#2C3E50', accent: '#27AE60', ... }`) supaya nama semantik tetap konsisten dipakai di Blade.

---

## 10. Ringkasan Checklist Implementasi

- [ ] Setup Tailwind config dengan color token di atas (Section 2)
- [ ] Import font Poppins + Font Awesome 6
- [ ] Bangun komponen Blade reusable: `<x-card>`, `<x-stat-card>`, `<x-status-badge>`, `<x-button>`
- [ ] Sidebar collapsible + versi mobile (off-canvas drawer)
- [ ] Halaman login dengan glassmorphism card + role selector
- [ ] Tabel data dengan wrapper scroll horizontal untuk mobile
- [ ] Konsistensi badge status di semua modul (Gejala, Kerusakan, Rule, Riwayat Diagnosa)
