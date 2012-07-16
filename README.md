# Cabbie

## Task

Develop a program that, given a series of points (latitude,longitude,timestamp) for a cab journey from A-B, will disregard potentially erroneous points.
Try to demonstrate a knowledge of Object Oriented concepts in your answer.
Your answer must be returned as a single PHP file which can be run against the PHP 5.3 CLI.
The attached dataset is provided as an example, with a png of the 'cleaned' route as a guide.

## Assumptions

 - Erroneous errors are duplicate points
 - Data files containing POINTS are ALWAYS in timestamp order, i.e. chronological

## Usage

Download the phar file from [here](https://github.com/downloads/james-turner/Cabbie/cabbie.phar "Cabbie Phar file")

from CLI:

    php cabbie.phar path/to/points.csv

The result should give you the output, including the list of points that are valid, i.e. erroneous points are removed.


## Tests (Dependencies)

 - PHPUnit

## Tests (Runtime)

To run the tests just cd to the project directory and do:

    phpunit test/*