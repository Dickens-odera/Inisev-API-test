## Inisev API test
<p> This is a simple API meant to enable users to subscribe to some website and thereafter shall be receiving email notifications of the of the newly created publications </p>

### Installation
```php
git clone https://github.com/Dickens-odera/Inisev-API-test.git my_directory
cd my_directory
composer install
cp .env.example .env
php artisan key:generate
```

#### Database Setup
In your DB server of choice, create a database and update the .env created above with the following variables

DB_DATABASE = <my_db>
DB_PASSWORD = <my_db_password>
DB_USERNAME = root

Then run the table migrations together with WebsiteTableSeeder as follows:
```php
php artisan migrate --seed
```
### Generating API Documentation
```php
php artisan scribe:generate
```
### Running the Application
```php
php artisan serve
```
Then head over to **localhost:8000/docs** for the API testing environment on your browser
### Command to send email notifications to subscribers after adding a couple of subscribers
```php
php artisan subscribers:mail {domain}
```

