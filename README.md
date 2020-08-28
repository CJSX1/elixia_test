<p align="center"><img src="https://avatars2.githubusercontent.com/u/36782484?s=460&u=6b69ad0e9153479f8436ffc3d456a37165a0df37&v=4" width="400"></p>

## Project Set Up

- Clone project repository.
- Go to the folder application using cd command on your cmd or terminal.
- Run composer install on your cmd or terminal.
- Copy .env.example file to .env on the root folder.
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run php artisan key:generate
- Run php artisan jwt:secret to generate JWT token.
