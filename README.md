-----

# 🍽️ Kitchen Panel Management System (TP7DPBO2425C)

## 1\. Tema Website

Sistem ini adalah **Panel Manajemen Dapur** (Kitchen Panel) yang dirancang untuk mengelola menu (makanan dan minuman), meja, anggota (member), dan pesanan di sebuah tempat makan atau *cafe*.

Aplikasi ini bertujuan untuk:

  * Mencatat dan mengelola **Daftar Menu Makanan dan Minuman** beserta stok dan harganya.
  * Mencatat dan mengelola **Daftar Meja** yang tersedia.
  * Mencatat **Daftar Member**.
  * Membuat, melihat, dan memproses **Pesanan** yang masuk, menghubungkan makanan, minuman, meja, dan member.

## 2\. Struktur Database

Database yang digunakan adalah `db_kitchen`. Database ini terdiri dari 5 entitas utama:

| Tabel | Deskripsi | Relasi (Foreign Key) |
| :--- | :--- | :--- |
| `foods` | Daftar menu makanan. | - |
| `drinks` | Daftar menu minuman. | - |
| `tables` | Daftar nomor meja di lokasi. | - |
| `members` | Daftar anggota/pelanggan terdaftar. | - |
| `orders` | Mencatat setiap transaksi pesanan. | `food_id`, `drink_id`, `table_id`, `member_id` (semua *Foreign Key*) |

File **`database/db_kitchen.sql`** berisi struktur tabel lengkap dan data awal (*seeder*) untuk memudahkan pengujian.

### Detail Relasi (Memenuhi Spesifikasi)

Tabel `orders` memiliki relasi *Foreign Key* ke empat tabel lainnya:

  * `food_id` merujuk ke `foods.id`
  * `drink_id` merujuk ke `drinks.id`
  * `table_id` merujuk ke `tables.id`
  * `member_id` merujuk ke `members.id`

## 3\. Struktur & Flow Program (CRUD)

### A. Arsitektur

Aplikasi dibangun dengan arsitektur sederhana berbasis **Native PHP** dan **OOP (Object-Oriented Programming)**, menggunakan **PDO (PHP Data Objects)** untuk koneksi database.

  * **`config/db.php`**: Kelas koneksi database (PDO).
  * **`class/*.php`**: Kelas entitas (`Foods`, `Drinks`, `Tables`, `Members`, `Orders`) yang bertanggung jawab untuk semua interaksi database.
  * **`view/*.php`**: Berisi *view* (tampilan HTML) dan logika *controller* sederhana untuk menangani input form dan menampilkan data.
  * **`index.php`**: Berfungsi sebagai *router* utama, memuat kelas dan *view* yang sesuai berdasarkan parameter `?page=`.

### B. Implementasi CRUD

Setiap entitas (Foods, Drinks, Tables, Members, Orders) memiliki implementasi **CRUD (Create, Read, Update, Delete)** lengkap.

### C. Koneksi Database & Query (Memenuhi Spesifikasi)

**Semua operasi database (CREATE, READ by ID, UPDATE, DELETE)** pada semua kelas entitas (**`class/*.php`**) menggunakan **Prepared Statement** melalui PDO:

```php
// Contoh Prepared Statement (UPDATE)
$stmt = $this->db->prepare("UPDATE foods SET food_name = ?, harga = ?, stok = ? WHERE id = ?");
return $stmt->execute([$food_name, $harga, $stok, $id]);
```

**Tidak ada** penggunaan *query* mentah langsung (`$this->db->query("SELECT * FROM table")` tanpa *prepare* digunakan hanya untuk `getAll*()` yang tidak menerima input user, namun *query* ini juga aman karena menggunakan PDO).

### D. Pencegahan Duplikasi Data

Untuk mencegah duplikasi data saat pengguna me-refresh halaman setelah mengirim formulir (POST), semua operasi **CREATE**, **UPDATE**, dan **DELETE** diimplementasikan menggunakan pola **PRG (Post-Redirect-Get)**. Setelah operasi berhasil, aplikasi akan melakukan *redirect* kembali ke halaman daftar (`header("Location: ...")`).

## 4\. Dokumentasi
https://youtu.be/F3S2srdWjF8
