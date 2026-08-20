Setup Project
1. Environment
   a. PHP 8.2
   b. MySQL 5.7.39

2. Setup <br/>
   Step 1: Run "Composer install"
   Step 2: Make .env file
   Step 3: Run "php artisan key:generate"
   Step 4: Connect MySql
   Step 5: Run "php artisan migrate"

3. Make admin login
   Run "php artisan tinker"

4. Setup ckfinder
   Run "php artisan ckfinder:download"

5. Import Province
   Run "composer require kjmtrue/vietnam-zone"
   "php artisan vietnamzone:import"
   "composer remove kjmtrue/vietnam-zone"

6. Run App
