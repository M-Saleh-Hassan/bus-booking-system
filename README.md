## About

This is a simple bus booking system having:
- Egypt cities as stations [Cairo, Giza, AlFayyum, AlMinya, Asyut...].

- Predefined trips between 2 stations that cross over in-between stations.
ex: Cairo to Asyut trip that crosses over AlFayyum -firstly- then AlMinya.

- Bus for each trip, each bus has 12 available seats to be booked by users, each seat has an
unique id.

- Users can book an available trip seat.

## Installation
- It's required to have Laravel v7.0.
- **Composer install**
- **php artisan migrate**
- **php artisan db:seed**
will create all stations and dummy users till now.
- **php artisan jwt:secret**

## Database Schema
![Schema](link-to-image)

## Postman Collection
- Collection: [PostMan Collection](https://www.getpostman.com/collections/e74cff66a8214fd7df18)
- Documentation: [V.1](https://documenter.getpostman.com/view/5467107/SzS8tQn4
)
## Admin Area
- still working on

## Dump Data
- User: test@test.com/123456


## Unit Testing

## Technicalities

## TODO

- Pagination
- Comments

