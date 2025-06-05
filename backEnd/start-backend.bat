@echo off
echo Starting PHP development server...
cd public
php -S localhost:8000 -t . -d display_errors=1 -d error_reporting=E_ALL 2>&1 | tee ../var/log/php_error.log