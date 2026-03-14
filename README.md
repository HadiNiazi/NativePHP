<p align="center">
<a href="https://www.youtube.com/watch?v=G9BM1q5Jl50&list=PLDc9bt_00KcJ6eZQODz-TrkuFA5sTmrg5&ab_channel=CareerDevelopmentLab" target="_blank">
Build Task Tracker App using Laravel & NativePHP
</a>
</p>

## Installation Steps

Follow these steps to install and run the application.

### 1. Install Composer Dependencies

``` bash
composer install
```

### 2. Install Node Dependencies & Build Assets

``` bash
npm install
npm run build
```

### 3. Create Environment File

``` bash
cp .env.example .env
```

### 4. Generate Application Key

``` bash
php artisan key:generate
```

### 5. Configure Database & Run Migration

Update your database credentials in the `.env` file and run:

``` bash
php artisan migrate
```

### 6. Run the Mobile Application

``` bash
php artisan native:run
```

------------------------------------------------------------------------

###  App Bundling Performance increasing Steps

``` bash
php artisan optimize:clear          # Clean everything
php artisan optimize                # This is the magic — caches routes, config, views, events
```

Then rebuild frontend assets (super important for first load):

``` bash
npm run build -- --mode=android     # or --mode=ios depending on your phone
```

Now start Jump:

``` bash
php artisan native:jump --skip-build   # skips unnecessary rebuild
```

Extra speed tricks if still slow:

* Make sure your phone and computer are on the same fast Wi-Fi (no VPN, no 5G hotspot).
* Add --host=0.0.0.0 if needed: php artisan native:jump --host=0.0.0.0
* Your first route/screen should be as light as possible (no heavy DB queries, no big loops on boot).


------------------------------------------------------------------------

## Video Tutorial

Watch the first video tutorial click below:

https://youtu.be/j_jgf7aOO7M?si=7R5oeiZeBuhAOZqt

------------------------------------------------------------------------

## Learn More Laravel 

Visit my YouTube channels to learn more about Laravel and web
development.

**English Content Channel**\
https://www.youtube.com/@LaravelLover

**Urdu Content Channel**\
https://www.youtube.com/@hadayatniazi

------------------------------------------------------------------------

## My Recent Laravel Courses

-   **Create API in Laravel**\
    https://www.youtube.com/watch?v=0h-unkoowZ4&list=PLDc9bt_00KcKrWYI1tULOFlYtnwnt8Hg-

-   **Create Multi Language Content in Laravel**\
    https://www.youtube.com/watch?v=9oeksj5VfJk&list=PLDc9bt_00KcIXjG4TK7_p8NOAC0Ecq4Ec

-   **Deploy Laravel App on DigitalOcean**\
    https://www.youtube.com/watch?v=Maie8_TU-oM&list=PLDc9bt_00KcIvfcUjeoaZkzcXAJpYEQ0D

------------------------------------------------------------------------

## Contact

If you have any questions, feel free to reach out:

**Email:** hadiniazi801@gmail.com

------------------------------------------------------------------------

⭐ If you like this project, please consider giving it a **star on
GitHub**.
