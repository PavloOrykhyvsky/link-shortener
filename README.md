# Link shortener

- Version of PHP 7.4.*
- Database - PostgreSQL

### Repository

1. Create a project code directory.
2. Clone this repository in your project code directory:
    ```
    git clone https://github.com/PavloOrykhyvsky/link-shortener.git
    ```

### Project Setup

1. Install packages. Run ```composer install```
2. Edit .env file with your ```DATABASE_URL```
3. Migrate database. Run ```php ./bin/console doctrine:migrations:migrate```
4. To start app run ```php -S localhost:8001 -t public/ ```
5. Pages: 
    - ```http://localhost:8001/links``` - links CRUD
    - ```http://localhost:8001/login``` - login page
    - ```http://localhost:8001/register``` - registration page
    - ```http://localhost:8001/logout``` - logout page