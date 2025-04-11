
# 🔐 FromLogin-Registration V2 – Multi-Role Login System (PHP Native)

## ✨ Kutipan

> *"Aku tidak berilmu; yang berilmu hanyalah DIA. Jika tampak ilmu dariku, itu hanyalah pantulan dari Cahaya-Nya."*  

## 🚀 Perbedaan V1 vs V2

| Fitur                          | Versi 1 (V1)                              | Versi 2 (V2)                                                   |
|-------------------------------|-------------------------------------------|----------------------------------------------------------------|
| **Login & Register**          | ✔️ Basic                                   | ✔️ Multi-role login (admin, member, user)                      |
| **Role-based redirect**       | ❌ Tidak ada                               | ✔️ Otomatis redirect sesuai peran                              |
| **Halaman khusus per role**   | ❌ Tidak tersedia                          | ✔️ `adminDashboard.php, kelolauser.php`, `member.php`, `user.php`              |
| **Kelola user (CRUD)**        | ❌ Tidak ada                               | ✔️ Tambah, edit, hapus, filter user (khusus admin)             |
| **Form filter & tambah user** | ❌ Tidak ada                               | ✔️ Desain modern, responsif, form lebih ramping & clean        |
| **Struktur direktori**        | ✔️ Dasar                                   | ✔️ Modular, folder `public/`, `includes/`, `config/` terpisah  |
| **Fungsi reusable (`functions`)** | ❌ Belum ada                           | ✔️ Cek login, peran, redirect otomatis                         |
| **`config.php` & `BASE_URL`** | ❌ Tidak ada                               | ✔️ Memudahkan saat deploy ke hosting                           |
| **Bootstrap**                 | ✔️ Basic                                   | ✔️ Versi terbaru, clean & responsif                           |
| **`.env` support**            | ✔️ Opsional                                | ✔️ Tetap opsional, bisa ditambahkan untuk koneksi DB, dll      |
| **Tampilan**                  | ❌ Flat & minim                            | ✔️ Lebih modern, user-friendly & rapih                         |

---


---

## 📜 Deskripsi

**FromLogin-Registration V2** adalah sistem login multi-role berbasis PHP Native dengan sistem manajemen user. Dirancang agar mudah dikembangkan, dan bisa digunakan sebagai kerangka awal project real.

---

## 🎯 Fitur Utama

- ✅ Registrasi dan Login menggunakan email
- ✅ Role: Admin, Member, User
- ✅ Session-based auth + role-based redirect
- ✅ Admin dapat:
  - Melihat semua user
  - Menambah user baru
  - Edit email, password, role
  - Menghapus user
  - Pencarian filter user
- ✅ Proteksi halaman berdasarkan role
- ✅ Struktur proyek profesional
- ✅ Clean UI dengan Bootstrap 5
- ✅ Komentar di setiap file penting

---

## 🛡️ Keamanan

- Menggunakan `password_hash()` dan `password_verify()`
- SQL injection dicegah dengan PDO prepared statements
- Session dicek dengan fungsi `isLoggedIn()`
- Password minimal 8 karakter
- `.env` opsional untuk menyembunyikan kredensial
- Bisa ditambah proteksi `.env` dengan `.htaccess` *(opsional Sudah Saya Zip Kalo Mau Digunakan)*

## 🔧 Dukungan `.env` (Opsional)

Jika ingin menjaga kredensial database tetap aman:

1. Buat file `.env` di root folder:
DB_HOST=localhost DB_NAME=login_v2 DB_USER=root DB_PASS=

2. Tambahkan kode untuk memuat `.env` di `database.php` (sudah tersedia di versi yang disiapkan zip)

3. Jangan upload `.env` ke publik – lindungi dengan `.htaccess` jika perlu

## 🗂️ Struktur Folder

```
FROMLOGINV2/
│
├── config/
│   └── config.php           ← Konfigurasi DB & BASE_URL
│
├── includes/
│   ├── functions.php        ← Fungsi: isLoggedIn(), isAdmin(), dll
│   └── session.php          ← Pengaturan session
├── style
|   ├── navbar.css
|   ├── index.css
|   ├── register.css
|   ├── kelolauser.css
|
├── img
|   ├── index.png
|   ├── register.png
|
├── public/
│   ├── admin/
│   │   ├── adminDashboard.php
│   │   └── kelolauser.php
│   ├── member/
│   │   └── member.php
│   ├── user/
│   │   └── user.php
│   ├── logout.php
│   ├── navbar.php
│   └── register.php
│
├── bootstrap/
│   └── (CSS & JS Bootstrap)
│
├── index.php                ← Halaman login
└── README.md
```

---

## 🛠️ Instalasi

1. **Clone repo ini** atau [Download ZIP](https://github.com/Alghifari888/FromLogin-RegistrationV2/archive/refs/heads/main.zip)

2. **Import database**
   - Buat database, misalnya: `login_v2`
   - Jalankan SQL berikut di phpMyAdmin atau terminal:

     ```sql
     CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       email VARCHAR(255) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       role ENUM('admin','member','user') NOT NULL DEFAULT 'user',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
     ```

3. **Atur koneksi database**
   - Buka `config/config.php`
   - Ubah sesuai konfigurasi lokalmu:

     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'login_v2');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('BASE_URL', '/FROMLOGINV2/public/');
     ```

4. **Jalankan di server lokal**
   - Simpan folder di `htdocs` (jika pakai XAMPP)
   - Akses: [http://localhost/FROMLOGINV2/public](http://localhost/FROMLOGINV2/public)

---

## 🔐 Akun Default
1. admin@gmail.com (admin123)
2. member@gmail.com (member123)
3. user@gmail.com   (user1234)
---

## 💡 Tips Tambahan

- Pastikan folder `bootstrap/` berisi Bootstrap 5.
- Ubah `BASE_URL` di `config.php` jika pindah ke hosting/domain.
- Jangan lupa amankan file sensitif jika deploy ke internet.

---

## 🧠 Credits

Dibuat oleh [@Alghifari888](https://github.com/Alghifari888) sebagai project belajar dan open-source.

---

## 🌟 License

MIT License. Bebas digunakan untuk belajar, proyek pribadi, atau dikembangkan.

---

**Selamat belajar dan semoga bermanfaat!**  
✨ Kalau project ini membantu, boleh kasih ⭐ di GitHub ya!

```

