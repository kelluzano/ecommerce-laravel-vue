## Installation

clone the application 

```
https://github.com/kelluzano/ecommerce-laravel-vue.git
```
run
```
composer install
```
Copy .env.example
```
cp .env.example .env
```

Setup your mail configuration and Stripe Api Key

[Register here for Stripe Payment](https://dashboard.stripe.com/login)

run
```
php artisan key:generate
```

run migration
```
php artisan migrate:fresh --seed
```

```
npm install && npm run dev
```