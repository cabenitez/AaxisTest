# AaxisTest (Challenge for Aaxis)
## Basic Technical Test (PHP Symfony Developer)

### Requeriments 
```
php: >=8.2
postgresql: >= 13.11
```
> Enable `sodium` extension in you php.ini `extension=sodium`

### Installation
1. Clone this repository with `git clone https://github.com/cabenitez/AaxisTest.git`
2. Enter to `AaxisTest` folder and execute `composer install` 
3. Execute the server running `symfony serve`
4. Go to https://127.0.0.1:8000 for check if the platform are running
5. Configure you database conection editing `.env` file, set your credentials in `DATABASE_URL` parameter
6. Create database running `php bin/console doctrine:database:create`
7. Create tables running `php bin/console doctrine:migrations:migrate` 
8. Update Relations `php bin/console doctrine:schema:update --force`
9. generate your own keypars with `php bin/console lexik:jwt:generate-keypair`
10. Clear cache running `php bin/console cache:clear`
 

### Endpoints (import from Postman)

[Collection](https://api.postman.com/collections/997492-4c4567ce-92d8-4cdc-9920-3542c3a8bc6e?access_key=PMAT-01HMQMCEHRGPJV11NYHED38EY2)

[Documentation](https://documenter.getpostman.com/view/997492/2s9YymH53t)
