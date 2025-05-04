# TP8DPBO2025C1

## Janji
Saya Mochamad Zidan Rusdhiana dengan NIM 2305464 mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Desain Program
![tp8 drawio](https://github.com/user-attachments/assets/bc9da082-05e4-48a4-a18a-74588a40f244)


Sistem Manajemen Akademik Mahasiswa ini dirancang menggunakan arsitektur Model-View-Controller (MVC) yang menyediakan struktur terpisah untuk mengelola data, presentasi, dan logika bisnis. Arsitektur ini memungkinkan pengembangan dan pemeliharaan yang lebih mudah dengan memisahkan tanggung jawab di antara komponen-komponen program.

### Arsitektur MVC

1. **Model**: Berinteraksi dengan database dan menangani logika bisnis terkait data
2. **View**: Menampilkan data ke pengguna dan menangani antarmuka pengguna
3. **Controller**: Memproses permintaan pengguna, berinteraksi dengan Model, dan mengarahkan ke View yang tepat

## Struktur Database

Sistem menggunakan database MySQL bernama `tp_mvc` yang terdiri dari tiga tabel utama:

### Tabel `students`
Menyimpan data mahasiswa dengan atribut:
- `id`: Primary key auto-increment
- `name`: Nama lengkap mahasiswa
- `nim`: Nomor Induk Mahasiswa (unik)
- `phone`: Nomor telepon mahasiswa
- `join_date`: Tanggal bergabung/registrasi mahasiswa

### Tabel `courses`
Menyimpan informasi mata kuliah dengan atribut:
- `id`: Primary key auto-increment
- `course_code`: Kode mata kuliah
- `course_name`: Nama mata kuliah
- `credit`: Jumlah SKS (Satuan Kredit Semester)
- `semester`: Semester di mana mata kuliah ditawarkan (Ganjil/Genap)

### Tabel `enrollments`
Menyimpan data pendaftaran/pengambilan mata kuliah oleh mahasiswa:
- `id`: Primary key auto-increment
- `student_id`: Foreign key ke tabel students
- `course_id`: Foreign key ke tabel courses
- `enrollment_date`: Tanggal pendaftaran mata kuliah
- `grade`: Nilai mata kuliah

## Relasi Antar Entitas

### Relasi Student - Enrollment - Course
- Satu mahasiswa (Student) dapat mengambil banyak mata kuliah melalui Enrollment (One-to-Many)
- Satu mata kuliah (Course) dapat diambil oleh banyak mahasiswa melalui Enrollment (One-to-Many)
- Enrollment menjadi junction table yang menghubungkan Student dan Course dalam hubungan Many-to-Many

## Komponen-Komponen MVC

### Model
Model menangani interaksi dengan database dan logika bisnis yang berhubungan dengan data. Terdapat tiga model:

1. **Student Model**: Mengelola data mahasiswa
   - Metode: getAll(), getById(), create(), update(), delete()

2. **Course Model**: Mengelola data mata kuliah
   - Metode: getAll(), getById(), create(), update(), delete()

3. **Enrollment Model**: Mengelola data pendaftaran mata kuliah
   - Metode: getAll(), getById(), create(), update(), delete(), getAllStudents(), getAllCourses()

### Controller
Controller memproses permintaan pengguna, berinteraksi dengan Model, dan mengarahkan ke View yang sesuai:

1. **StudentController**: Mengelola operasi CRUD untuk mahasiswa
   - Metode: index(), create(), store(), edit(), update(), delete()

2. **CourseController**: Mengelola operasi CRUD untuk mata kuliah
   - Metode: index(), create(), store(), edit(), update(), delete()

3. **EnrollmentController**: Mengelola operasi CRUD untuk pendaftaran mata kuliah
   - Metode: index(), create(), store(), edit(), update(), delete()

### View
View bertanggung jawab untuk menampilkan data ke pengguna:

1. **StudentView**: Menampilkan formulir dan tabel untuk data mahasiswa
   - Metode: index(), create(), edit()

2. **CourseView**: Menampilkan formulir dan tabel untuk data mata kuliah
   - Metode: index(), create(), edit()

3. **EnrollmentView**: Menampilkan formulir dan tabel untuk data pendaftaran
   - Metode: index(), create(), edit()

## Alur Program

1. **Entry Point**: `index.php` berfungsi sebagai entry point aplikasi yang menerima permintaan dari pengguna

2. **Routing**: Berdasarkan parameter `controller` dan `action` yang diterima dari URL, sistem akan memanggil controller dan metode yang sesuai

3. **Proses Permintaan**:
   - Controller dipanggil dan diinisialisasi
   - Controller memanggil metode model untuk mendapatkan atau memanipulasi data
   - Model berinteraksi dengan database dan mengembalikan hasil ke controller
   - Controller meneruskan data ke view yang sesuai
   - View merender tampilan dengan data yang diberikan oleh controller

4. **Contoh Alur untuk Menampilkan Daftar Mahasiswa**:
   - Pengguna mengakses URL: `index.php?controller=student&action=index`
   - Sistem membuat instance `StudentController`
   - `StudentController` memanggil metode `index()`
   - Di dalam metode `index()`, controller memanggil `$this->student->getAll()` untuk mendapatkan semua data mahasiswa
   - Controller memanggil `$this->view->index($students)` untuk merender tampilan dengan data mahasiswa
   - Tampilan daftar mahasiswa ditampilkan kepada pengguna

5. **Contoh Alur untuk Menambah Mahasiswa Baru**:
   - Pengguna mengakses URL: `index.php?controller=student&action=create`
   - `StudentController` memanggil metode `create()`
   - Controller memanggil `$this->view->create()` untuk menampilkan form tambah mahasiswa
   - Pengguna mengisi form dan mengirimkannya
   - Form dikirim ke URL: `index.php?controller=student&action=store`
   - `StudentController` memanggil metode `store()`
   - Controller mengumpulkan data dari form dan memanggil `$this->student->create()`
   - Setelah data tersimpan, pengguna dialihkan ke halaman daftar mahasiswa

## Dokumentasi

https://github.com/user-attachments/assets/e63f7bf3-a27a-40c1-bc4e-2ffae2a7a58b

