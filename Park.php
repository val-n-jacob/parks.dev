<?php

/**
 * A Class for interacting with the national_parks database table
 *
 * contains static methods for retrieving records from the database
 * contains an instance method for persisting a record to the database
 *
 * Usage Examples
 *
 * Retrieve a list of parks and display some values for each record
 *
 *      $parks = Park::all();
 *      foreach($parks as $park) {
 *          echo $park->id . PHP_EOL;
 *          echo $park->name . PHP_EOL;
 *          echo $park->description . PHP_EOL;
 *          echo $park->areaInAcres . PHP_EOL;
 *      }
 * 
 * Inserting a new record into the database
 *
 *      $park = new Park();
 *      $park->name = 'Acadia';
 *      $park->location = 'Maine';
 *      $park->areaInAcres = 48995.91;
 *      $park->dateEstablished = '1919-02-26';
 *
 *      $park->insert();
 *
 */
class Park
{

    ///////////////////////////////////
    // Static Methods and Properties //
    ///////////////////////////////////

    /**
     * our connection to the database
     */
    public static $dbc = null;

    /**
     * establish a database connection if we do not have one
     */
    public static function dbConnect() {
        if (! is_null(self::$dbc)) {
            return;
        }
        self::$dbc = require 'testdb.php';
    }

    /**
     * returns the number of records in the database
     */
    public static function count() {
        // TODO: call dbConnect to ensure we have a database connection
        self::dbConnect();
        // TODO: use the $dbc static property to query the database for the
        //       number of existing park records
        $count = 'SELECT count(*) from national_parks';
        $stmt = self::$dbc->query($count);
        return $stmt->FetchColumn();
    }

    /**
     * returns all the records
     */
    public static function all() {
        // TODO: call dbConnect to ensure we have a database connecti
         self::dbConnect();
        // TODO: use the $dbc static property to query the database for all the
        //       records in the parks table
        $all = 'SELECT * from national_parks';
        $stmt = self::$dbc->query($all);
        $rows = $stmt->FetchAll();
        // TODO: iterate over the results array and transform each associative
        //       array into a Park object
        $parks = [];
        foreach ($rows as $row){
            $park = new Park();
            $park->name = $row['name'];
            $park->location = $row['location'];
            $park->areaInAcres = $row['area_in_acres'];
            $park->dateEstablished = $row['date_established'];
            $park->description = $row['description'];
            $parks[] = $park;
        }
        // TODO: return an array of Park objects
        return $parks;
    }

    /**
     * returns $resultsPerPage number of results for the given page number
     */
    public static function paginate($pageNo, $resultsPerPage = 4) {
        // TODO: call dbConnect to ensure we have a database connection
         self::dbConnect();
        // TODO: calculate the limit and offset needed based on the passed
        //       values
         $offset = ($pageNo - 1) * $resultsPerPage;

        $query ='
        SELECT *
        FROM national_parks
        LIMIT :limit offset :offset';

        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $rows = $stmt->FetchAll();
        // TODO: iterate over the results array and transform each associative
        //       array into a Park object
        $parks = [];
        foreach ($rows as $row){
            $park = new Park();
            $park->name = $row['name'];
            $park->location = $row['location'];
            $park->areaInAcres = $row['area_in_acres'];
            $park->dateEstablished = $row['date_established'];
            $park->description = $row['description'];
            $parks[] = $park;
        }
        // TODO: return an array of Park objects
        return $parks;


        // TODO: use the $dbc static property to query the database with the
        //       calculated limit and offset
        // TODO: return an array of the found Park objects
    }

    /////////////////////////////////////
    // Instance Methods and Properties //
    /////////////////////////////////////

    /**
     * properties that represent columns from the database
     */
    public $id;
    public $name;
    public $location;
    public $dateEstablished;
    public $areaInAcres;
    public $description;

    /**
     * inserts a record into the database
     */
    public function insert() {
        // TODO: call dbConnect to ensure we have a database connection
         self::dbConnect();
        // TODO: use the $dbc static property to create a perpared statement for
        //       inserting a record into the parks table
         $query ='INSERT INTO national_parks (name, location, date_established, area_in_acres, description)VALUES (:name, :location, :date_established, :area_in_acres, :description);'; 


        $stmt = self::$dbc->prepare($query);
        // TODO: use the $this keyword to bind the values from this object to
        //       the prepared statement
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':location', $this->location, PDO::PARAM_STR);
        $stmt->bindValue(':date_established', $this->dateEstablished, PDO::PARAM_STR);
        $stmt->bindValue(':area_in_acres', $this->areaInAcres, PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);

        $stmt->execute();
        $this->id = self::$dbc->lastInsertId();

        // TODO: excute the statement and set the $id property of this object to
        //       the newly created id
    }
}
