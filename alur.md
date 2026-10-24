PRD & Alur Proyek: REST API Buku (Laravel)
Dokumen Kebutuhan Produk (PRD) berdasarkan Acara 25 (Pembuatan API) dan Acara 26 (Pengujian dengan Postman)
1. Ringkasan Proyek
Proyek ini membangun REST API sederhana untuk mengelola data buku menggunakan framework Laravel. API menyediakan operasi CRUD (Create, Read, Update, Delete) dengan format respons JSON. Acara 25 berfokus pada pembangunan API, sedangkan Acara 26 berfokus pada pengujian seluruh endpoint menggunakan Postman.
2. Latar Belakang
Pengelolaan data buku membutuhkan layanan backend yang dapat diakses oleh berbagai klien (web, mobile, atau aplikasi lain). REST API menjadi jembatan standar untuk kebutuhan tersebut. Melalui proyek ini, mahasiswa mempelajari alur lengkap pengembangan API di Laravel, mulai dari database, model, controller, routing, hingga pengujian endpoint.
3. Tujuan
• Membangun tabel dan model untuk menyimpan data buku.
• Menyediakan endpoint CRUD yang mengembalikan respons JSON.
• Menerapkan validasi pada proses penambahan data.
• Menguji seluruh endpoint menggunakan Postman dan memastikan kode status HTTP sesuai.
4. Ruang Lingkup
Termasuk dalam lingkup:
• Model Book dan migration tabel books.
• BookController pada folder Api dengan lima method (index, store, show, update, destroy).
• Routing API melalui routes/api.php dan Route::apiResource().
• Konfigurasi bootstrap/app.php agar routes/api.php aktif.
• Pengujian manual endpoint menggunakan Postman.
Di luar lingkup:
• Autentikasi dan otorisasi (token, Sanctum, dan sejenisnya).
• Antarmuka pengguna (frontend).
• Pengujian otomatis (PHPUnit/Pest).
• Pagination, pencarian, dan filter data.
5. Pengguna dan Pemangku Kepentingan
Peran
Kebutuhan
Mahasiswa/Developer
Membangun dan menguji API dengan benar
Dosen/Asisten
Menilai kesesuaian hasil dengan langkah acara
Klien API (web/mobile)
Mengakses data buku melalui endpoint JSON
6. Teknologi yang Digunakan
Komponen
Keterangan
Framework
Laravel (menggunakan bootstrap/app.php, yaitu Laravel 11 ke atas)
Bahasa
PHP
Database
MySQL/MariaDB atau sesuai konfigurasi .env
Alat uji
Postman
Format data
JSON
7. Model Data
Tabel books:
Field
Tipe
Keterangan
id
bigint (PK, auto increment)
Identitas unik buku
title
string
Judul buku (wajib)
description
text
Deskripsi buku
status
boolean
1 = aktif, 0 = nonaktif
created_at
timestamp
Waktu data dibuat
updated_at
timestamp
Waktu data diubah
Model Book menggunakan $fillable = ['title', 'description', 'status'] agar mass assignment dapat dilakukan.
8. Kebutuhan Fungsional
Kode
Kebutuhan
Method / Endpoint
Hasil yang Diharapkan
FR-01
Menampilkan seluruh data buku
GET /api/books
200 OK, daftar buku (JSON)
FR-02
Menambahkan data buku dengan validasi
POST /api/books
201 Created, data buku baru
FR-03
Menampilkan satu buku berdasarkan ID
GET /api/books/{id}
200 OK, detail buku
FR-04
Mengubah data buku
PUT /api/books/{id}
200 OK, data yang telah diperbarui
FR-05
Menghapus data buku
DELETE /api/books/{id}
Pesan "Book deleted"
9. Kebutuhan Non-Fungsional
• Semua respons menggunakan format JSON.
• Penamaan route mengikuti konvensi RESTful melalui Route::apiResource().
• Input divalidasi sebelum disimpan ke database.
• Kode terstruktur: controller API ditempatkan pada folder app/Http/Controllers/Api.
• Kode status HTTP sesuai standar (200, 201, 404, 422).
10. Alur Proyek - Acara 25 (Pembangunan API)
Tahap
Langkah
Keluaran
1. Persiapan database
Membuat Model Book beserta migration (php artisan make:model Book -m)
File model dan migration
2. Struktur tabel
Menambahkan field title, description, status, dan timestamps pada migration
Skema tabel books
3. Eksekusi migration
Menjalankan php artisan migrate
Tabel books terbentuk di database
4. Konfigurasi model
Menambahkan $fillable pada Model Book
Mass assignment aktif
5. Pembuatan controller
Membuat BookController di folder Api (php artisan make:controller Api/BookController --api)
File controller
6. Method index()
Mengembalikan seluruh data buku dalam JSON
Endpoint daftar buku
7. Method store()
Menambah data buku dengan validasi
Endpoint tambah buku
8. Method show()
Menampilkan buku berdasarkan ID
Endpoint detail buku
9. Method update()
Mengubah data buku
Endpoint ubah buku
10. Method destroy()
Menghapus data buku
Endpoint hapus buku
11. Routing
Membuat routes/api.php dan mendaftarkan Route::apiResource('books', BookController::class)
Route API terdaftar
12. Konfigurasi bootstrap
Mengatur bootstrap/app.php agar memuat routes/api.php (atau php artisan install:api)
Prefix /api aktif
13. Uji awal
Menguji GET /api/books
JSON data buku tampil
11. Alur Proyek - Acara 26 (Pengujian dengan Postman)
Tahap
Langkah
Hasil yang Diharapkan
1. Persiapan
Membuka Postman untuk menguji API dari Acara 25
Postman siap digunakan
2. Uji POST
Mengirim POST ke /api/books dengan Body x-www-form-urlencoded berisi title, description, status
Respons 201 Created
3. Uji GET (semua)
GET /api/books
Daftar buku tampil
4. Uji GET (detail)
GET /api/books/{id}
Detail buku sesuai ID
5. Uji PUT
PUT /api/books/{id}, mengubah status dari 1 menjadi 0
Data yang diperbarui tampil di respons
6. Uji DELETE
DELETE /api/books/{id}
Respons "Book deleted"
7. Uji ulang
Mengulang pengujian menggunakan data buku sesuai contoh pada BKPM
Seluruh endpoint berjalan sesuai harapan
Catatan pengujian: pada Postman, tambahkan header Accept: application/json agar respons error validasi (422) tampil dalam format JSON, bukan halaman redirect. Untuk PUT dengan x-www-form-urlencoded, pastikan method yang dipilih adalah PUT dan data dikirim lewat Body.
12. Contoh Request dan Respons
POST /api/books (Body: x-www-form-urlencoded)
• title: Pemrograman Web Laravel
• description: Panduan dasar membangun aplikasi web dengan Laravel
• status: 1
Contoh respons (201 Created):
{
  "id": 1,
  "title": "Pemrograman Web Laravel",
  "description": "Panduan dasar membangun aplikasi web dengan Laravel",
  "status": 1,
  "created_at": "2026-10-24T08:00:00.000000Z",
  "updated_at": "2026-10-24T08:00:00.000000Z"
}
PUT /api/books/1 (mengubah status):
• status: 0
Respons berisi data buku dengan nilai status 0.
DELETE /api/books/1:
{
  "message": "Book deleted"
}
13. Contoh Kerangka Kode
Migration (potongan):
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->boolean('status')->default(1);
    $table->timestamps();
});
Routes (routes/api.php):
use App\Http\Controllers\Api\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('books', BookController::class);
Controller (potongan):
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|boolean',
    ]);

    $book = Book::create($validated);
    return response()->json($book, 201);
}

public function destroy(Book $book)
{
    $book->delete();
    return response()->json(['message' => 'Book deleted']);
}
14. Kriteria Penerimaan
• Tabel books berhasil dibuat melalui migration dengan seluruh field yang dibutuhkan.
• Kelima endpoint dapat diakses dan mengembalikan JSON.
• POST menghasilkan status 201 dan data tersimpan di database.
• Validasi menolak data yang tidak lengkap.
• PUT mengubah data (contoh: status 1 menjadi 0) dan respons memuat data terbaru.
• DELETE menghapus data dan menampilkan pesan "Book deleted".
• Seluruh pengujian di Postman berhasil, termasuk pengujian ulang dengan data contoh BKPM.
15. Risiko dan Mitigasi
Risiko
Mitigasi
Route /api tidak terbaca
Pastikan routes/api.php terdaftar di bootstrap/app.php
Mass assignment error
Periksa $fillable pada Model Book
Error validasi tampil sebagai redirect
Tambahkan header Accept: application/json di Postman
Koneksi database gagal
Periksa konfigurasi .env dan jalankan ulang migration
Data PUT tidak terbaca
Gunakan x-www-form-urlencoded pada Body dan method PUT
16. Rencana Pengembangan Lanjutan
• Menambahkan autentikasi menggunakan Laravel Sanctum.
• Menggunakan API Resource dan Form Request untuk respons dan validasi yang lebih rapi.
• Menambahkan pagination dan pencarian pada GET /api/books.
• Menambahkan pengujian otomatis dengan PHPUnit/Pest.
• Menyusun dokumentasi API (misalnya Postman Collection atau Swagger).