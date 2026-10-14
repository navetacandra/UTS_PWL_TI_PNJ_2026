# Simple CRUD

> Repository untuk memenuhi tugas proyek Ujian Tengah Semester Pemrograman Web Lanjut

---

## Behind The Project
- Menggunakan PHP Native dengan sistem file routing pada `/index.php`.
- Menggunakan sistem berbasis API (request melalui fetch/AJAX).
- Mengimplementasi CSRF guard.
- Mengimplementasi auth route.

## Sistem
### Routing
```php
if($_SERVER['SCRIPT_NAME'] == "/index.php" && $path == "") {
  $path .= "/login"; // default page
}
```
Kode di atas akan memaksa menampilkan halaman login sebagai halaman bawaan ketika tidak ada *resource*/*route* spesifik yang diminta.

```php
if(is_file($target)) { // static file
  return false;
}
```
Kode di atas berguna untuk mengembalikan file statis yang ada pada saat server dijalankan menggunakan *built-in* server php dengan *command* `php -S localhost:5000 index.php`

```php
if(!file_exists($target)) {
  $error_code = 404;
  $error_status = "NOT_FOUND";
  $error_message = "The link may be outdated, or the page might have been moved or deleted. Try the dashboard to get back on track.";
  require_once __DIR__ . '/error_response.php';
  die();
}
```
Kode di atas bertugas untuk melakukan pengecekan ketersediaan *resource* (file PHP), jika tidak ada maka kembalikan `error_response.php` dengan informasi error 404 (Not Found).

### Authenticated Route
```php
function authenticated(string $redirect = "")
{
  if (!isset($_SESSION["user"])) {
    if (strlen($redirect) > 0) {
      header("Location: $redirect");
    } else {
      http_response_code(401);
      header("Content-Type: application/json");
      echo json_encode([
        "status" => 401,
        "message" => "Authenticated user only.",
      ]);
    }
    return false;
  }
  return true;
}

function unauthenticated(string $redirect = "")
{
  if (isset($_SESSION["user"])) {
    if (strlen($redirect) > 0) {
      header("Location: $redirect");
    } else {
      http_response_code(401);
      header("Content-Type: application/json");
      echo json_encode([
        "status" => 401,
        "message" => "Unauthenticated user only.",
      ]);
    }
    return false;
  }
  return true;
}
```
Pada kode di atas, fungsi `authenticated` dan `unauthenticated` memiliki kemiripan dalam proses pengecekannya. Fungsi `authenticated` hanya menerima pengguna jika memiliki nilai *user* pada sesi, sedangkan `unauthenticated` hanya menerima pengguna yang **tidak** memilki nilai *user* pada sesi. Kedua fungsi memiliki dua mode, mode pertama adalah mode redirect untuk memindahkan pengguna ke halaman yang aman; mode kedua adalah mode API, dimana sistem akan mengembalikan pesan error (JSON) dengan kode HTTP 401 Unathorized.

### CSRF Guard
```php
session_start();

function gen_csrf_token() {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verify_csrf_token() {
  if(!isset($_REQUEST['csrf_token']) || ($_REQUEST['csrf_token'] != $_SESSION['csrf_token'])) {
    http_response_code(403);
    header("Content-Type: application/json");
    echo json_encode([
      "status" => 403,
      "message" => "Invalid CSRF token."
    ]);

    return false;
  }

  return true;
}
```
Pada kode di atas, fungi `gen_csrf_token` akan menyimpan nilai acak ke `csrf_token` pada sesi pengguna. Sedangkan fungsi `verify_csrf_token` akan melakukan pencocokan nilai `csrf_token` yang dikirim pada request dengan `csrf_token` yang tersimpan pada sesi.

### Force Request Filter
```php
function filter_request()
{
  foreach (array_keys($_GET) as $k) {
    $_GET[$k] = htmlspecialchars(trim($_GET[$k]));
  }

  foreach (array_keys($_POST) as $k) {
    $_POST[$k] = htmlspecialchars(trim($_POST[$k]));
  }
}
filter_request();
```
Fungsi `filter_request` pada kode akan melakukan `trim` pada request **GET** dan **POST** serta mengubah nilai dengan fungsi `htmlspecialchars` agar nilai dapat disimpan dan ditampilkan dengan aman.

### Request Validation
```php
if (!isset($email)) {
  $errors["email"] = "Email is required!";
} else if (!is_string($email)) {
  $errors["email"] = "Email must be string!";
} else if (strlen($email) < 1) {
  $errors["email"] = "Email is required!";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors["email"] = "Email must be valid email!";
}
```
Merupakan salah satu contoh validasi request (contoh: email). Karena email adalah *field* yang wajib diisi maka pengecekan dilakukan dengan `isset` dan `strlen > 1`, keduanya harus bernilai `true`. Email harus dikirim dalam bentuk string, maka dilakukan pengecekan tipe data dengan `is_string`. PHP memiliki fitur bawaan untuk validasi bentuk email dengan `filter_var` parameter `FILTER_VALIDATE_EMAIL`.

## Desain Database
Desain dasar database dapat dilihat pada file `database.sql`

## Admin Template
Menggunakan template Adminator dari Colorlib. [Lihat](https://preview.colorlib.com/theme/adminator/index.html)
