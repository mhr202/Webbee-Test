# Webbee Test

## Local Development (Mac OS / Ubuntu)

- Laravel version 2.7.1

**System Level Dependencies:**

- mySQL 8.0.33

**Project Level Dependencies**

- composer install

**Setting up the Database**

- php artisan migrate
- php artisan db:seed

**Reset Database**

- php artisan migrate:reset

**Running the Server**

- php artisan serve

**Running Tests**

- php artisan test

# API Endpoints

## Slots:

### Get Slots

Method: `GET`

url: `/api/slots/{$serviceId}`

## Booking

### Book A Slot

API: Tag a Campaign

Method: `POST`

url: `/api/bookings`

Parameters:

    {
      "bookings": [
        {
          "start_time": "08:35",
          "end_time": "09:05",
          "day": "2023-06-1",
          "service_name": "Men Haircut",
          "first_name": "John",
          "last_name": "Doe",
          "email": "johndoe@example.com"
        },
        {
          ...
        },
      ]
    }
