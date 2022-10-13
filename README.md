# AkuPintar Modul CariKampus Test

Framework : Laravel 

Database bisa di download di : https://drive.google.com/file/d/11sGna9Sy_nGdAt3kHzOm1P0teXPH2l0p/view?usp=sharing

Run Project 
```
php artisan serve
```

Untuk API /followkampus, /unfollowkampus, /followingkampus harap login terlebih dahulu. Bisa register user baru atau memakai user dummy.

Setelah login, token API dapat diambil pada tabel users field api_token. Bila menggunakan postman, pada tab authorization menggunakan type BEARER TOKEN lalu token API di store pada field token agar dapat dapat dipakai.

Mohon maaf apabila terdapat kekurangan pada panduan yang saya buat. terima kasih.

# Daftar API
(POST) /Login -> Untuk login user
```
{
    "email": "ezaputra870@gmail.com",
    "password": "test",
    "role": "user"
}
```

(POST) /register -> Untuk register user
```
{
    "email": "ezaputra870@gmail.com",
    "password": "test",
    "notelp" : "08989981903",
    "full_name" : "Eza Putra",
    "alamat" : "Surabaya",
    "kota_id" : "1",
    "umur" : 27
}
```

(POST) /carikampus -> API Pencarian Kampus
```
{
    "kampus_name": "Insti",
    "provinsi_id": 1,
    "jurusan_id" : "1",
    "statuskampus_id" : "1,2",
    "jeniskampus_id" : "1",
    "is_politeknik" : "0"
}
```

(POST) /jurusankampus -> API List Jurusan Kampus
```
{
    "kampus_id": 1
}
```

(POST) /jurusankampus_byname -> API List Jurusan Kampus By Name
```
{
    "kampus_name": "Institut Teknologi Sepuluh Nopember"
}
```

(POST) /followkampus -> API Follow Kampus
```
{
    "kampus_id": "1"
}
```

(POST) /unfollowkampus -> API Unfollow Kampus
```
{
    "kampus_id": "1"
}
```

(POST) /followingkampus -> API List Folowing Kampus
```
{
    "kampus_id": "1"
}
```