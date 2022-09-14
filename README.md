## Requirements

    1. npm (version 8.x.x)
    2. composer
    3. php 8 or higher
## Installation

    Setup command for first time installation:

    1. Run `Composer install` to install dependency.
    2. Run `npm install` for Development.
    3. Run `npm run dev` for Development.
    4. Copy and replace below detail into your .env file

    # api key
        APP_KEY=base64:M6L17OhGW2DVu3slfRv1n5c3V8qDeXJ3X1e4tLyMzpc=
    
    # mysql database connection
    1. save some time by connecting to a remote database
        DB_CONNECTION=mysql
        DB_HOST=remotemysql.com
        DB_PORT=3306
        DB_DATABASE=Ob16rSmdxw
        DB_USERNAME=Ob16rSmdxw
        DB_PASSWORD=E6j4RTyVO4
    2. you can also setup your local database and use laravel migration to start.
    3. Also on local database you need to fetch data from api, use `yourdomain/fetch-data` url to fetch data.


## Learning application

If everything goes as expected you may find a list of products on the page. and a search box on the  top. you'll also see register and login links on the top that you can use to create an admin account as for now any account is by default is admin.

1. if you are using the remote database given above an admin account is already created, you can access below account. 
email : admin@user.in 
password : password

2. Add, Edit, Delete buttons are visible after login. 
3. To search select the category from the dropdown and type in the input box and hit enter.

