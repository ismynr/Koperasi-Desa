# Sistem Tabungan Koperasi Unit Desa

## Deskripsi Sistem
### Role dan Peran Masing2
1.	Admin
    -   Admin dapat melakukan mendaftarkan, mengedit, dan menghapus data anggota,
    -   Admin dapat menambah tabungan (klaim lunas) anggota,
    -   Admin dapat menarik tabungan dari anggota, 
    -   Admin dapat menyetujui permintaan pengajuan dari anggota,
    -   Admin dapat menambah pinjaman anggota
    -   Admin dapat meng-klaim lunas angsuran pinjaman anggota 
2.	Anggota
    -   Anggota dapat mengajukan pinjaman kepada admin
    -   Anggota dapat melihat tagihan setoran untuk tabungan 
    -   Anggota dapat melihat mutasi (riwayat penarikan dan setoran)
    -   Anggota dapat melihat tagihan pinjaman dan riwayat pinjaman 
<br>

### Login
-   Admin
    -   Email: admin@gmail.com
    -   Password: password
-   Anggota
    -   Email: anggota@gmail.com
    -   Password: password
<br>

## Code Structure
### Data Models

### Controllers

### Requests

###
<br>

## Instalasi
### Persyaratan
-   XAMPP
-   NPM
-   Composer
-   DBMS
-   Browser
-   Code Editor 
### Clone Dari Github
-   Open terminal / git bash
-   git clone [url_github]
-   cd [nama_repo]
-   composer install
-   npm install && npm run dev
-   cp .env.example .env
-   setting database and email konfigurasi di .env
-   php artisan key:generate
-   php artisan migrate:fresh --seed
<br>

## Deployment
-   Definisikan Procfile 
```bash
echo web: vendor/bin/heroku-php-apache2 public/ > Procfile
git add .
git commit -m 'add procfile'
```
-   Create Apps di Heroku 
-   Konek ke Github
-   Install resource JawsDB MySQL
-   Sesuaikan konfig dari env ke Heroku
