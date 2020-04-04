# Analytics

## TL;DR

- Adjust docker-compose `.env` file.
- Build and run docker containers:

```sh
export UID
docker-compose up --build
```

- Log into php container and apply database migrations:

```sh
docker-compose exec php-fpm sh
php artisan migrate
```
