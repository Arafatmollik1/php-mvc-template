## Basic mvc template for php
This is a basic php mvc template you can use to build basic mvc application.

## Prerequisites
- PHP, Composer
- Apache server such as Mamp or Xamp
- Mysql 

## Install 
Download the codebase or git clone.

Check your root directory from htaccess and config.php
Currently "php-mvc-template" is the basename of the project. 

- After download do

`composer install`

- Then put the codebase to you root folder.
For instance if you are using mamp then your folder should be in

`/Application/MAMP/htdocs/`

- Then change the configuration according to you project name or root folder name in `config.php` and `htaccess`. search for the text `php-mvc-template` and change it to your root directory name if you have any
- Next step is to create a datbase using **mysql**. 
- There is no .env file so include that into you root directory and add the varibales you can find from config.
Here is a sample .env file
```
IS_PRODUCTION = no
DB_HOST=localhost
DB_NAME=just_testing
DB_USERNAME=root
DB_PASSWORD=root
SESSION_PASSWORD = fdaimoaido1231ads
```

- Make sure to have the following coloumns in table called `sessions` in your database. 
 1.  hash
 2.  session_data
 3.  session_id
 4.  session_expire
   
You can also make the table with this query
```
CREATE TABLE sessions (
    hash VARCHAR(32) NOT NULL,
    session_data TEXT NOT NULL,
    session_id VARCHAR(255),
    session_expire INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (session_id),
    KEY session_expire (session_expire)
);
```

Now you are ready to run the project. 

## Features
1. **Config file.** In config.php you can define some of your configurations. You can then use it from global $config anywhere in the codebase.
2. **session** session management is done via zebra session. can be found in session.php and can be accessed as global variable $session
3. **/Views**  ---  Head.php, Header.php, Footer.php, 404 error view and 500 view, 503 view for custom maintenace view is defined here. You can adjust your views from there file. Head, header, footer will be included everywhere.
4. **Database.** database is declared globally. Make sure to input your database config into the config file. databse helper can be used from global $database. Mysqli object is defined here 
5. **Controller+Helpe**r are stated in /src folder.
6. To make a new view just put your frontend files into /frontend/[your page name]/index.php
7. You must make controller by the same name in controller folder
8. Wheatever you define in the controller then all the properties can be accessed in the frontend via `$serverData`
9. You can also get the url paths of the broswer and use it for you backend. global variable `$urlData` takes care of it
10. **Js+css Jquery and bootstrap+bootstrap icons are defined.** So it is ready to be used. However if you want to create your **own css or js** then make files to assets/css/[your page name].css and assets/js/[your page name].js
11. **Make you own api**You can make your own api from your own database with very easy setps. Just checkout LocalApi.php and follow the examples on the bottom of the file.
12. You can use the custom made **ApiHelper** to do basic Get, Post, Put, Patch, Delete.
13. You can use the custom made mysql query builder which can be found in utility folder. Checkout `SqlBuilder.php`
14. You can use **DebugLogger** utility to log your backend data into a log file. Example of usage can be found in the DebugLogger.php file. If used the logs can be found in logs/apps.log file
15. **Pest Phpunit tester** is installed so you can use that to do unit testing. Tests created in Tests/Unit directory. After that just do `./vendor/bin/pest` from you root and you can see tests. Checkout Tests/Unit/ExampleTestphp.php
16. **PhpStan** is installed so you are able to catch bugs before it goes to production. Do an automatic testing to your backend by running commad `./vendor/bin/phpstan analyse src/` also level of security check can be increased to 8. Can be found in phpstan.neon
17. **Dotenv** is installed so .env file can be used as well.
18. You can also add actions into the controller. for instance if you have "/something/somethingmore" the `something` is the controller. And in the controller file just do `somethingmoreAction` meaning add Action word at the end of the text and define that a function. and now you have an action inside the controller.
19. Please check **composer.json and utilites** to see what kind of packages are available to be used.


Thank you and enjoy!
