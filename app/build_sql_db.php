<?php

// Report all PHP errors. Disable in production.
error_reporting(E_ALL);
ini_set("display_errors", 1);

$file_db = new SQLite3('db/dotahighlights.sqlite3');

// Create new database in memory.
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
                    events_id INTEGER NOT NULL PRIMARY KEY,
                    title TEXT,
                    banner TEXT,
                    icon TEXT,
                    start_date TEXT,
                    end_date TEXT
                );

    CREATE TABLE IF NOT EXISTS highlights (
                    highlights_id INTEGER NOT NULL PRIMARY KEY,
                    video_link TEXT,
                    title TEXT,
                    event TEXT,
                    added TEXT,
                    start_date TEXT,
                    end_date TEXT,
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
$file_db->exec( $databaseSql );
  
$insertSql = <<<SQL
    INSERT OR REPLACE INTO events VALUES( 1, "Dota The International 4-1", "app\img\edited\banner\dota2ti-banner.png", "app\img\edited\banner\dota2ti-icon.jpg", "2014-06-08", "2014-06-21" ); /* events_id title banner icon start_date end_date */
    INSERT OR REPLACE INTO events VALUES( 2, "Dota The International 4-2", "app\img\edited\banner\dota2ti-banner.png", "app\img\edited\banner\dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events VALUES( 3, "Dota The International 4-3", "app\img\edited\banner\dota2ti-banner.png", "app\img\edited\banner\dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO highlights VALUES( 1, "https://www.youtube.com/watch?v=OCypKGk8DhY", "newbee owning vg", "Dota The International 4", "2014-06-23", "2014-06-08", "2014-06-21", 1, 1); /* video_link title event added start_date end_date views highlights_events_id */
    INSERT OR REPLACE INTO highlights VALUES( 2, "https://www.youtube.com/watch?v=OCypKGk8DhY", "newbee owning vg", "Dota The International 4", "2014-06-23", "2014-06-08", "2014-06-21", 1, 1);
    INSERT OR REPLACE INTO highlights VALUES( 3, "https://www.youtube.com/watch?v=OCypKGk8DhY", "newbee owning vg", "Dota The International 4", "2014-06-23", "2014-06-08", "2014-06-21", 1, 1);
    INSERT OR REPLACE INTO ratings VALUES( 1, 0.5, "192.168.1.1", 1);                               /* rating_id rating ip_address rating_highlights_id */
SQL;

$memory_db->exec( $insertSql );
$file_db->exec( $insertSql );

var_dump( $memory_db->query( "SELECT * FROM events;" )->fetchAll() );
var_dump( $memory_db->query( "SELECT * FROM highlights;" )->fetchAll() );
?>
