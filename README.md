## Ice and Fire API - assignment

### Requirement
This project uses Laravel 9.x, php ^8.0 

### Valet Setup
1. Install [valet](https://laravel.com/docs/9.x/valet) (if you don't already have valet)
2. Setup your database, and update db configurations in .env file
3. To link this project directory with valet, Run `valet link` in your terminal

### Sail Setup (docker)
1. You need to have docker installed to use this option. See sail documentation [here](https://laravel.com/docs/9.x/sail)
2. Make sure to set up docker-compose environment variable required for this setup. These include `FORWARD_APP_PORT`, `FORWARD_DB_PORT`
3. To start the application in the container, run `sail up` in your terminal.

**tldr;**
If you have mysql running on the same port as configured in your env file, you may have to turn it off to prevent it from interfering with docker's forwarding port for mysql  

### Postman Collection
1. Import postman collection included in the root of this project - "Ice and Fire API.postman_collection.json"
2. After importing postman collection, create an environment on postman that could be used to test the project
   Postman Environment variables needed include, `base_url`, `external_search_string`, `delete_book_id`, `update_book_id`, `show_book_id`
