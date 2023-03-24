
# Fuel Management Portal

A web application for managing fuel for trucks and generating LPO’s (Local Purchase Orders) for the different suppliers of fuel.

## Features

- Register & Login
- User Roles & permissions
- Add/import master data (trucks, routes stations, comments)
- Add trips for trucks
- Add fuel orders for trips
- Generate LPO's for the fuel orders
- View/Export reports in excel 

## Installation

- Clone the repository
- Copy .env.example to .env
- Set the DB_ environment variables in .env file
- Create a database with the name specified in DB_DATABASE
- ```composer install```
- ```php artisan key:generate```
- Migrate and seed the database with ```php artisan migrate:fresh --seed```
- You can now register and log in

## Built With

* [Laravel](https://laravel.com/) - Backend
* [Livewire](https://laravel-livewire.com/) / [Bootstrap](https://getbootstrap.com/) - Frontend




