<?php

// SQL for creating database structure
$databaseSql = <<<SQL
    CREATE TABLE `user` (
        `id` INTEGER PRIMARY KEY AUTOINCREMENT,
        `name` TEXT NOT NULL,
        UNIQUE( `name` )
    );

    CREATE TABLE `userProfile` (
        `userId` INTEGER NOT NULL CONSTRAINT `userProfile_userId` REFERENCES `user`( `id` ) ON UPDATE CASCADE ON DELETE CASCADE,
        `image` TEXT NOT NULL
    );
SQL;

// SQL for inserting dummy data
$dataSql = <<<SQL
    INSERT INTO `user` VALUES( 1, "John" );
    INSERT INTO `user` VALUES( 2, "Mary" );
    INSERT INTO `user` VALUES( 3, "Joe" );
    INSERT INTO `userProfile` VALUES( 1, "/images/john.jpg" );
    INSERT INTO `userProfile` VALUES( 2, "/images/mary.jpg" );
    INSERT INTO `userProfile` VALUES( 3, "/images/joe.jpg" );
SQL;

// create a temporary SQLite instance in memory
$db = new PDO( "sqlite::memory:", null, null, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
) );

// activate use of foreign key constraints
$db->exec( "PRAGMA foreign_keys = ON;" );

// create database
$db->exec( $databaseSql );
// insert dummy data
$db->exec( $dataSql );

/*
// should dump 3 records
var_dump( $db->query( "SELECT * FROM `userProfile`;" )->fetchAll() );

// delete 1 user, cascade deleting 1 userProfile as well
$db->exec( "DELETE FROM `user` WHERE `id` = 1;" );

// should dump 2 records
var_dump( $db->query( "SELECT * FROM `userProfile`;" )->fetchAll() );
*/

    // Report all PHP errors
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    // Create new database in memory
    $memory_db = new PDO( "sqlite::memory:", null, null, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ) );

    $memory_db->exec("PRAGMA foreign_keys = ON;");

    /**************************************
    * Create tables                       *
    **************************************/

$databaseSql = <<<SQL
    CREATE TABLE IF NOT EXISTS events (
                    events_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                    title TEXT,
                    banner TEXT,
                    icon TEXT,
                    message TEXT,
                    start_date TEXT,
                    end_date TEXT
                );

    CREATE TABLE IF NOT EXISTS highlights (
                    highlights_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                    title TEXT,
                    start_date TEXT,
                    end_date TEXT,
                    event TEXT,
                    added TEXT,
                    views INTEGER,
                    highlights_events_id INTEGER NOT NULL,
                    FOREIGN KEY(highlights_events_id) REFERENCES events(events_id)
                );

    CREATE TABLE IF NOT EXISTS ratings (
                        rating_id INTEGER NOT NULL PRIMARY KEY,
                        rating INTEGER,
                        ip_address TEXT,
                        rating_highlights_id INTEGER,
                        FOREIGN KEY(rating_highlights_id) REFERENCES highlights(highlights_id)
                );
SQL;

$memory_db->exec( $databaseSql );

$dataSql = <<<SQL
    INSERT INTO events VALUES( 1, "test", "test", "test", "test", "test", "test" );
    INSERT INTO events VALUES( 2, "test", "test", "test", "test", "test", "test" );
    INSERT INTO highlights VALUES( 1, "test", "test", "test", "test", "test", 9000, 1);
    INSERT INTO highlights VALUES( NULL, "test", "test", "test", "test", "test", 9000, 1);
    INSERT INTO highlights VALUES( NULL, "test", "test", "test", "test", "test", 9000, 1);
    insert INTO ratings VALUES( 1, 0.5, "192.168.1.1", 1);
SQL;

$memory_db->exec( $dataSql );

//var_dump( $memory_db->query( "SELECT * FROM events;" )->fetchAll() );
// var_dump( $memory_db->query( "SELECT * FROM highlights;" )->fetchAll() );
?>
