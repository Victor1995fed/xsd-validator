



## Check XML for XSD

This is a web application for check xml use xsd scheme

Install from docker [here](https://github.com/Victor1995fed/xsd-validator-docker)

## System requirements
For local application starting (for development) make sure that you have locally installed next applications:

-   `PHP >= 7.4` _(install: `curl -fsSL get.docker.com | sudo sh`)_
-   `GIT >= 2.9`
-   `Composer >= 1.10`
-   `Mysql >= 5.7`

#### Fast application starting
Just execute into your terminal next commands:

```
$ git clone https://github.com/Victor1995fed/xsd-validator.git
$ cd xsd-validator
$ composer install
$ php artisan migrate
$ php artisan serve
```
- Done! [localhost:8000](localhost:8000)



