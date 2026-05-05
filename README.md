# 🌐 Web Profile & Information System  
## Ponpes Darul Ulum Tlasih

Sistem profil web dan informasi resmi untuk Pondok Pesantren Darul Ulum Tlasih, Tulangan.  
Proyek ini dikembangkan oleh **DigitalNote by Rofian** sebagai langkah strategis untuk mendigitalisasi informasi institusi serta mempermudah manajemen data santri secara terpadu dan efisien.

---

## 📌 Tentang Proyek

Aplikasi ini dirancang sebagai pusat informasi digital bagi wali santri dan masyarakat luas.  
Dibangun menggunakan framework **CodeIgniter 4**, sistem ini menawarkan performa yang ringan, cepat, dan tingkat keamanan yang lebih tinggi melalui pemisahan akses publik.

---

## ✨ Fitur Utama

- 📖 **Digitalisasi Profil**  
  Publikasi profil lengkap, visi, misi, dan program pesantren.

- 🧑‍🎓 **Manajemen Santri**  
  Sistem pengelolaan data santri yang terstruktur dan mudah diakses.

- 🔐 **Keamanan Terjamin**  
  Implementasi struktur folder `public/` sebagai akses utama untuk melindungi core sistem.

- 📱 **Responsif**  
  Tampilan optimal untuk smartphone maupun desktop.

---

## 🛠️ Tech Stack

- **Framework**: CodeIgniter 4  
- **Bahasa Pemrograman**: PHP 7.4+  
- **Database**: MySQL  
- **Pengembang**: DigitalNote by Rofian  

---

## ⚙️ Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal:

### 1. Clone Repository
```bash
git clone https://github.com/Luthfan-Rofian/web-profile-darululum.git
```

### 2. Environment Setup

- Ubah nama file `env` menjadi `.env`
- Buka file `.env` lalu sesuaikan konfigurasi database:

```
database.default.hostname
database.default.database
database.default.username
database.default.password
```

- Atur juga:

```
app.baseURL = 'http://localhost:8080'
```

---

### 3. Server Requirements

Pastikan server Anda memenuhi spesifikasi berikut:

- PHP **7.4 atau lebih tinggi**
- PHP Extensions:
  - `intl`
  - `mbstring`
  - `json`
  - `mysqlnd`
  - `xml`

---

### 4. Konfigurasi Web Server

> ⚠️ **PENTING**  
> Arahkan Document Root web server (Apache/Nginx) ke folder `/public` agar aplikasi berjalan dengan benar dan aman.

---

## 💸 Dukungan Pengembangan

Proyek ini terus dikembangkan oleh **DigitalNote by Rofian** untuk mendukung kemajuan teknologi di instansi pendidikan Islam.

Jika Anda merasa proyek ini bermanfaat dan ingin memberikan dukungan:

👉 **Dukung di Saweria**  
https://saweria.co/Luthfanrofian

---

## ❤️ Kontribusi

Kontribusi sangat terbuka!  
Silakan fork repository ini dan ajukan pull request.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk tujuan edukasi dan pengembangan sistem informasi pesantren.

---

<p align="center">
Dikembangkan dengan dedikasi oleh <b>DigitalNote by Rofian</b> 🚀
</p>
