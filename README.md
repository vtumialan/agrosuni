# Agrosuni (v2.0.0)

Plataforma para gestionar el inventario, realizar compras de productos y gestión de locales y proveedores.
(Laravel & MySQL)

---

## Run in development without Docker

1. Copy .env.example file to .env and edit database credentials there
2. Run in cmd:

```x-sh
    composer install
    php artisan key:generate
    php artisan serve --host=0.0.0.0 --port=8181
```

3. [Enter here](http://localhost:8181/)
4. [Documentation](http://localhost:8181/api/vi/documentation)
