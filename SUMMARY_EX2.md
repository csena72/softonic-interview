
**1. Start the application:**
To start the application (if not already running):
```sh
./vendor/bin/sail up -d
```

**2. Run command:**
```sh
./vendor/bin/sail detect:duplicates
```

**3. Run test:**
```sh
./vendor/bin/sail artisan test --filter DetectDuplicatesTest
```

**4. Shutdown app:**
```sh
./vendor/bin/sail down
```
