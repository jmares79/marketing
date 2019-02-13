# Objective:
This project was created as a test for reviewing programming and structure concepts as asked by the company.

The test consists about writing an abstract class or interface that models a SQL database connection that:
-   You may build a single interface or compose multiple areas of concerns
-   You can make some assumptions that we’re working with a relational database schema

> The intention of this design was for it to be made **WITHOUT** a framework. The reasons behind it are, to name a few:
    * The requirement was simple enough to not load a full set of libraries that won't be used
    * The opportunity to review old school concepts about clean code and OOP design on a greenfield project
    * Keep the overhead to the minimum, while still getting the job done
    * Show that some concepts like dependency injection and SOLID principles can be achieved without the overhead of an MVC framework (Which of course is recommended in plenty of scenarios without a doubt)
    
    Having said that, I have in my personal repo (Shown below in the notes), some projects that were done using Laravel and Symfony, in case any dev/lead wants to take a look.

Part of the core of the code is intended to be modified WITHOUT the need of modifying all of the classes, following the OPEN-CLOSED principle. For that, it's based on interfaces. Each core/important class implements an Interface, so if anyone needs to drastically change the way the fetching/data handling/results showing are set, the only thing needed is create another class implementing the same interfaces that each class implements, and instantiate the desired new one at the beginning.

**It is OUT of the scope of the test to check/validate every single option of the DB/Adapter, as it's not intended to be a usable ORM style** but the architecture is flexible enough to do that with not so much effort.

# Installation
Clone the repo and run composer install, just in case, also run "dump-autoload".
Create a DB into the used server (In our case, MySql) and add the connection string parameters to the INI file in the `config` folder.

# Description and structure

The project, from the architecture point of view, consists of an entry point "init.php" (For the lack of a better name), that has a  connection string array with the values of the local DB taken from an INI set configuration.

It then instantiates within a try-catch block the basic classes needed for the soft to be useful, and passes them to the TaskController, in order for it to execute the needed steps.

## Important classes and interfaces

The code is structured with the minimum amount of classes for it to be functional, but keeping in mind that extra ones can be added in case the need of updating/upgrading the system is needed, as will be explained later with an example.

The mentioned classes:

* *TaskController*: It is the class that, as a the lack of a truly MVC architecture, executes the needed steps to perform the required task. It receives via Dependency injection an adapter and a mapper. Then the public execute method executes the "save" method to show that the code works.

* *DBFactory*: It's an adapter factory, following a factory design pattern. It has a static function "create" that dynamically creates a class based on the passed parameters, throwing an exception if certain conditions are not met. Despite it could have being done in the middle of the code, having the "new" creation keyword isolated/encapsulated in this class makes easy to, in case the need of changingthe creation in some way, only modify this very class, isolating the rest of the classes that would have been performing that creation, from the potential bugs of the change.

* *User & UserMapper*: This pair of classes are the ones that helps the data to be saved via the adapter into the DB. As we don't have a proper ORM, we need a way of telling the adapter how to save any entity to be created. We do that by using a [Data Mapper Pattern](https://en.wikipedia.org/wiki/Data_mapper_pattern) that performs bidirectional transfer of data between a persistent store and an in memory representation of it (In our case, a User entity, or any other entity). In practice, the mapper helps us to save and retrieve the specific data needed for the entity created without telling the adapter the details for it, and in that way keeping it standard to any new class that can be created.

* *MySql* (Or any concrete adapter class): This class represents the specific adapter type we're handling. In our case obviously a MySql connection, but could be any commercial DB or, if needed, a file or just a simple array to store data. It extends an abstract class (*AbstractAdapter*) that has the basics for modelling new concrete adapters, and also implements an interface (*AdapterInterface*) that provides the basic methods for the most common DB. It's important to note that in separating those 2 concepts (How it is vs what it does) we have the flexibility to not force to implement that interface when creating an adapter that just saves data to disk, or is an array that saves data in memory (But both can be used for example purposes to try the soft). We just can create a new interface with some file based methods or just extend the abstract class and set the host to some directory or so. (Not recommended, much better to create a new interface)


# Improving and updating the code

The main improvement to be done is setting and checking arguments in the adapter layer, in order to handle the way the process is done and try to mimic an ORM in the following versions.

* How do I add another adapter? 
 - Simply by following the convention about a class name that matches the new adapter name (extending and implementing as explained the interface), as the factory will check if that exists, and if so, execute the "new" on that class.

* What if I want an adapter that is not a typical DB?
 - Again, the trick will be in create a new type of interface that follows the structure/behaviour of the desired new adapter and create a new family of adapters similar for it. (One for saving into files, another into a cloud DB, etc)

* Ok, User is not useful, I need another type of objects to be saved, how do I do that?
 - Just create a new entity with the desired structure and a mapper, similar to the existing one, to map the data and perform the bidirectional transfer between the entity and the DB, and don't forget to create the test first (If you're on TDD) or after (Becase we need it!)

## Testing and mocking object

A test was created to show how to do it and how to mock some needed objects for it. 

A *UserMapperTest* is in place, that tests finding and saving different types of users. It basically was done by mocking (Via the PHPUnit API) the needed objects that the mapper needs, in our case a mocked adapter and a mocked user. 

Then, we set the values we need for several of the mocked object's methods to return in order to test every possible case in the codebase, using a data provider (Also PHPUnit API).

It heavily relies on the `method(<name>)` and `willReturn(<value>)` in order to set, in every test iteration, the desired values.

## How to execute

In a Linux bash/console, just exec `php init.php`, and `./vendor/bin/phpunit tests/<DESIRED-TEST>.php` if the tests need to be executed.


## Laravel and Symfony repos

As explained before, in case of needing some coding examples with frameworks, these are the links:

* (https://github.com/jmares79/bank-api)
* (https://github.com/jmares79/snap-test)
* (https://github.com/jmares79/roster)
