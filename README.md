# EventBooking

* EventBooking simple system to upload json file with events and search in the data.

## Installing

* Make sure you have installed php7.4.
* Make sure you have installed mysql.
* From terminal in project directory run composer install
* In .env file change DATABASE_URL to your credentials.
* From terminal in project directory run php bin/console doctrine:database:create
* From terminal in project directory run php bin/console doctrine:migrations:migrate

## How It works

* From terminal in project directory run php bin/console server:start
* Go to listening local host add /event at the end
* From Top Left you will see click upload new events and upload json file
* Click List All Events and add your search criteria.


## How To Make It Better

* We could receive downloadable link to Event system throw Api.
* DownLoad file save it in directory.
* Push file name to queue.
* Process the file in the queue
* Add more file validations.
