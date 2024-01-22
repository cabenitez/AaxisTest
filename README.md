# AaxisTest (Challenge for Aaxis)
## Basic Technical Test (PHP Symfony Developer)

### Requeriments 
```
php: >=8.2
postgresql: >= 13.11
```

### Installation
1. Clone this repository with `git clone https://github.com/cabenitez/AaxisTest.git`
2. Enter to `AaxisTest` folder and execute `composer install` 
3. Configure you database conection editing `.env` file, set your credentials in `DATABASE_URL` parameter
4. Create database running `php bin/console doctrine:database:create`
5. Create tables running `php bin/console doctrine:migrations:migrate` 
6. Update Relations `php bin/console doctrine:schema:update --force`
7. Execute the server running `symfony serve`
8. Go to https://127.0.0.1:8000 for check if the platform are running
9. Enable `sodium` extension in you php.ini `extension=sodium`
10. generate your own keypars with `php bin/console lexik:jwt:generate-keypair`
11. 

### Import endpoints from Postman
[Collection](https://api.postman.com/collections/997492-4c4567ce-92d8-4cdc-9920-3542c3a8bc6e?access_key=PMAT-01HMQMCEHRGPJV11NYHED38EY2)

### Endpoints
* User Create
* User Login
* Product Load
* Product Update
* Product List
