# Project: 

![Laravel Logo](https://laravel.com/img/logomark.min.svg)
![Version](https://img.shields.io/badge/version-0.0.0-blue.svg)

...

## Prerequisites

- [Docker](https://www.docker.com/) - Docker
- [Docker Compose](https://docs.docker.com/compose/) - Docker Compose
- [Git](https://git-scm.com/) - Git

## Installation

**1. Clone the repository:**

```sh
git clone git@github.com:csena72/softonic-interview.git
cd softonic-interview
```

**2. Set up environment variables:**
Copy .env.example to .env:
```sh
cp .env.example .env
```

**3. Install dependencies:**
```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

./vendor/bin/sail up
```

**4. Start containers with Docker Compose:**
If they are not installed automatically, run:
```sh
./vendor/bin/sail composer install
```

Then generate the application key:
```sh
./vendor/bin/sail artisan key:generate
```
**5. Run migrations:**
```sh
./vendor/bin/sail artisan migrate
```
**6. Symbolik link images to /app/public/venue_photos.:**

```sh
./vendor/bin/sail artisan storage:link
```

**8. Access the application:**
The application should be available at (http://localhost).


## Docker Commands
**1. Start the application:**
To start the application (if not already running):
```sh
./vendor/bin/sail up -d
```

**2.View EP:**

(http://localhost/api/apps/21824)

**3. Run command:**
```sh
./vendor/bin/sail artisan app:info 21824
```
**4. Run test:**
```sh
./vendor/bin/sail artisan test --filter AppInfoControllerTest

./vendor/bin/sail artisan test --filter AppInfoServiceTest
```

**5. Shutdown app:**
```sh
./vendor/bin/sail down
```


