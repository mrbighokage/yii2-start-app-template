Yii 2 Start APP Template
===============================

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

DIRECTORY STRUCTURE
-------------------

```
common/
    config/              contains shared configurations
    mail/                contains view files for e-mails
    modules/             contains modules classes used in both backend and frontend
console/
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend/
    config/              contains backend configurations
    modules/             contains backend-specific modules classes
    runtime/             contains files generated during runtime
    themes/              contains views template
    web/                 contains the entry script and Web resources
frontend/
    config/              contains backend configurations
    modules/             contains backend-specific modules classes
    runtime/             contains files generated during runtime
    themes/              contains views template
    web/                 contains the entry script and Web resources
static/
    web/                 contains uploads folder
        /uploads         main uploads folder
            /users       user avatar
            /cache       directory use ThumbHelper
            /..          other uploads folder
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```

REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

for example:

~~~
# php -r "readfile('https://getcomposer.org/installer');" | php
~~~

You can then load framework/extension using the following command:

~~~
# php composer.phar global require "fxp/composer-asset-plugin:1.1.0"
# php -f composer.phar update
~~~


GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

+ Run command `init` to initialize the application with a specific environment.
+ Create a new database and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.
+ Apply migrations with console command `yii migrate`. This will create tables needed for the application to work.
~~~
# yii migrate
~~~
+ Create user "admin" and default RBAC. Default password use from common\config\params.php
~~~
# yii rbac/init
~~~
+ Create domain my-yii2-app.dev and forward to root folder yii2_start_app_template and use:
~~~
- alias to frontend `http://my-yii2-app.dev/`
- alias to backend `http://my-yii2-app.dev/admin`
~~~
