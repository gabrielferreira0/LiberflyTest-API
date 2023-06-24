<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### Step 1

```bash
git clone https://github.com/gabrielferreira0/LiberflyTest-API.git
```

```bash
copy .env.example .env
```
<h2>Preencha com os dados de conexão para o banco no .env</h2>

DB_CONNECTION=mysql </br>  
DB_HOST=127.0.0.1 </br>    
DB_PORT=3306 </br>  
DB_DATABASE=liberflytest </br>  
DB_USERNAME=root </br>  
DB_PASSWORD= </br>  

### Step 2

```bash
composer install
```

### Step 2

```bash
 php artisan migrate 
```
```bash
 php artisan db:seed --class=UserSeeder
```

```bash
 php artisan key:generate
```

```bash
 php artisan jwt:secret
```

```bash
  php artisan serve
```

### Step 3

<h3>API Swagger UI LIK</h3>
http://localhost:8000/api/documentation

<h3>Teste integração</h3>

```bash
  php artisan test  
```

## Imagens
![Screenshot_1](/public/swagger.png "Screenshot_1")
![Screenshot_3](/public/test.png "Screenshot_2")

