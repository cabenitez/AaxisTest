# AaxisTest (Challenge for Aaxis)
## Basic Technical Test (PHP Symfony Developer)

[Definitions](https://github.com/cabenitez/AaxisTest/blob/main/PDF-php-symfony-test-2023-en.pdf)

![Symfony Logo](/public/images/symfony.png "Symfony Framework")
This project was developed with Symfony v7.0

### Requeriments 
```
php: >=8.2
postgresql: >= 13.11
```
> Enable `sodium` extension in you *php.ini* file `extension=sodium`

### Installation
1. Clone this repository with `git clone https://github.com/cabenitez/AaxisTest.git`
2. Enter to `AaxisTest` folder and execute `composer install` 
3. Configure you database conection editing `.env` file, set your credentials in `DATABASE_URL` parameter
4. Create database running `php bin/console doctrine:database:create`
5. Create tables running `php bin/console doctrine:migrations:migrate` 
6. Update Schema `php bin/console doctrine:schema:update --force`
7. Generate your keypars with `php bin/console lexik:jwt:generate-keypair`
8. Clear cache running `php bin/console cache:clear`
9. Execute the server running `symfony serve` 
10. Go to https://127.0.0.1:8000 for check if the platform are running

### Endpoints (import from Postman)

[Collection](https://api.postman.com/collections/997492-4c4567ce-92d8-4cdc-9920-3542c3a8bc6e?access_key=PMAT-01HMQMCEHRGPJV11NYHED38EY2)

[Documentation](https://documenter.getpostman.com/view/997492/2s9YymH5Ce)
