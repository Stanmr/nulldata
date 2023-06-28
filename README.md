
# Nulldata Webapp

## Getting started

## Prerequisites

Before you begin, ensure you have met the following requirements:

* You have Node 18.16 Installed
* You have PHP 8.2 or greater
* You are familiar with a Laravel app structure

## Architecture

The project is based on Laravel. and it used a standard installation.

- **JWT**:  Handling authentication
- **API/V1** The prefix for the endpoints

---


## Installation

First clone this repository, install the dependencies, and setup your .env file.

```
git clone git@github.com:Stanmr/nulldata.git .
composer install
cp .env.example .env
```

These instructions assume you have created a MySQL database, so please fill in the credentials in your `.env` file

And then run the initial migrations and seeders.

```
php artisan jwt:secret
php artisan migrate --seed
```

When migration is done, 10 dummy users will be created, feel free to use any of the emails, along with the password `password`.

### Endpoints and Postman Collection
There are 6 main endpoints in this webapp. In the `api` folder you will find a Postman collection with example data so you can test the app. Please login first with the dummy users and use the `Bearer <token>` authentication in the requests.

## Further Ideas

I did not have the time to complete the Improvements sections from the assessment, so please do not waste time looking for that.

