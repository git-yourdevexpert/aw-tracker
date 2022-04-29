## AWTracker

A monthly subscription-based website visitor tracking web application.

### Steps for installing this project on your local machine

Run the below commands one by one in your terminal or cmd.

```
git clone git@github.com:github.com/aw-tracker.git
cd aw-tracker
composer install
cp .env.example .env
// Update your database credentials in the .env file
// Update mailtrap credentials in the .env file
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run dev
php artisan serve
```
