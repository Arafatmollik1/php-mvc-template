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

After download do

`composer install`

Then put the codebase to you root folder.
For instance if you are using mamp then your folder should be in

`/Application/MAMP/htdocs/`

Then change the configuration according to you project name or root folder name in config.php and htaccess.
Note that there is no .env file so include that into you root directory and add the varibales you can find from config.

Now you are ready to run the project. 

## Features
1. **Config file.** In config.php you can define some of your configurations. You can then use it from global $config anywhere in the codebase.
2. **/Views**  ---  Head.php is defined here. You can adjust your head html file. It will be included everywhere.
3. **Database.** database is declared globally. Make sure to input your database config into the config file. databse helper can be used from global $database. Mysqli object is defined here 
4. **Controller+Helpe**r are stated in /src folder.
5. To make a new view just put your frontend files into /frontend/[your page name]/index.php
6. You must make controller by the same name in controller folder
7. Wheatever you define in the controller then all the properties can be accessed in the frontend via `$serverData`
8. **Js+css Jquery and bootstrap are defined via CDN.** So it is ready to be used. However if you want to create your **own css or js** then make files to assets/css/[your page name].css and assets/js/[your page name].js
9. You can use the custom made **ApiHelper** to do basic Get, Post, Put, Patch, Delete.
10. You can use **AssertionLogger** utility to log your backend data into a log file. Example of usage can be found in the AssertionLogger.php file. If used the logs can be found in logs/apps.log file
11. **Phpunit** is installed so you can use that to do unit testing. The config file is in phpunit.xml and the Tests should be stated in Tests/<controllername>Test.php. After that just do `./vendor/bin/phpunit` from you root and you can see tests. Checkout Tests/IndexTest.php
12. **PhpStan** is installed so you are able to catch bugs before it goes to production. Do an automatic testing to your backend by running commad `./vendor/bin/phpstan analyse src/` also level of security check can be increased to 8. Can be found in phpstan.neon
13. **Dotenv** is installed so .env file can be used as well.
14. You can also add actions into the controller. for instance if you have "/something/somethingmore" the `something` is the controller. And in the controller file just do `somethingmoreAction` meaning add Action word at the end of the text and define that a function. and now you have an action inside the controller.
15. Please check **composer.json and utilites** to see what kind of packages are available to be used.


Thank you and enjoy!
