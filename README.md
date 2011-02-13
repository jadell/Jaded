Jaded PHP
=========
Author: Josh Adell <josh.adell@gmail.com>  
Copyright (c) 2011  

Jaded is a library of stuff I have created for my own projects.  It started life as a complete MVC framework, but I wasn't happy with the controllers or views.  Now, it is a simple, lightweight model layer.  It also has a pretty decent Autoloader, and a stub Service class.

Over time, I will also be adding other classes I tend to use over and over again, including some Zend plugins.

Usage
-----
There's a pretty good post at [http://joshadell.com/2010/11/models-can-be-so-jaded.html](http://joshadell.com/2010/11/models-can-be-so-jaded.html) explaining how to use the model library.

The basic idea is that models have three parts:

 *  a definition (what the model is)
 *  a store (how the model persists its data)
 *  a container tying the store and definition together for a single object.

The container and definition don't actually care how the store works (database, csv file, RSS feed, etc.)  The store can actually be swapped out of a model at runtime to facilitate migrations from one storage medium to another, reading from one place and writing to a second, or any other reason your application calls for.

Here's a quick example of a model that uses the DB connector and store included with Jaded:

    class UserDefinition extends Jaded_Model_Definition
    {
        /**
         * Maps a name that calling code can use to an internal field name
         */
        protected $aFieldMap = array(
            "userid"   => "userid",
            "username" => "username",
            "password" => "password",
        );
    
        /**
         * The key fields for this model
         */
        protected $aKeyFields = array(
            "userid" => "auto"
        );
    }
    
    class UserStore extends Jaded_Model_Store_Database
    {
        protected $sTable = "users";
    
        /**
         * This bit is simply the connection name used by Jaded's database wrapper
         */
        protected $sDbId = "project_database";
    }

    class User extends Jaded_Model
    {
        protected $sDefaultDefinition = "UserDefinition";
        protected $sDefaultStore      = "UserStore";
    }

Here is how to persist the model in the data store and load it out again:

    $oUser = new User();
    echo $oUser->getUsername();  // prints ""
    
    $oUser->setUsername("bobuser");
    $oUser->create();
    $iUserId = $oUser->getUserId();
    
    $oUser2 = new User();
    $oUser2->setUserId($iUserId);
    $oUser2->load();
    echo $oUser2->getUsername();  // prints "bobuser"

Models also have `update` and `delete` methods, rounding out the CRUD functionality.

Other helpful advice:

* Put any data access code in the store class (`UserStore` in the example above.)  If the method returns multiple rows, wrap each row in a model and return an array of them.
* Code that is specific to a model, but not data access should go in the container class (`User` in the example above.)  For instance, if there were a method to hash a user's password before storing it, it would go in the `User` class.  `UserStore` would only have to worry about storing the hashed string.
* More than one key field can be defined in the model definition.  Only one can be `auto`, the rest are `key`.  All key field must be set before calling `load`.

