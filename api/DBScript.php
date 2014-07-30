<?php

// Report all PHP errors. Disable in production.
error_reporting(E_ALL);
ini_set("display_errors", 1);

$file_db = new SQLite3("db/dotahighlights.sqlite3");

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
                    events_id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    title TEXT,
                    banner TEXT,
                    icon TEXT,
                    start_date TEXT,
                    end_date TEXT
                );

    CREATE TABLE IF NOT EXISTS highlights (
                    highlights_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                    title TEXT,
                    video_link TEXT,
                    added TEXT,
                    start_date TEXT,
                    end_date TEXT,
                    views INTEGER,
                    highlights_events_id INTEGER NOT NULL,
                    FOREIGN KEY(highlights_events_id) REFERENCES events(events_id)
                );

    CREATE TABLE IF NOT EXISTS ratings (
                        rating_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                        rating INTEGER,
                        ip_address TEXT,
                        rating_highlights_id INTEGER,
                        FOREIGN KEY(rating_highlights_id) REFERENCES highlights(highlights_id)
                );
SQL;

$memory_db->exec( $databaseSql );
$file_db->exec( $databaseSql );

$insertSql = <<<SQL
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati1", "Dota The International 1", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" ); /* events_id title banner icon start_date end_date */
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati2", "Dota The International 2", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 3", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati4", "Dota The International 4", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati5", "Dota The International 5", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "sum0714", "The Summit", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "sum0714", "The Summit", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "sum0714", "The Summit", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "sum0714", "The Summit", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 4-2", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 4-3", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 4-2", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 4-2", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 4-3", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "dotati3", "Dota The International 4-2", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "wec2014", "World E-sport Championships 2014", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "wec2014", "World E-sport Championships 2014", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO events (name, title, banner, icon, start_date, end_date) VALUES( "wec2014", "World E-sport Championships 2014", "app/img/edited/banner/dota2ti-banner.png", "app/img/edited/banner/dota2ti-icon.jpg", "2014-06-08", "2014-06-21" );
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 1-1", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-21", "2014-06-08", "2014-06-21", 100, 1); /* video_link title event added start_date end_date views highlights_events_id */
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 1-2", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-22", "2014-06-08", "2014-06-21", 101, 1);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 1-3", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-23", "2014-06-08", "2014-06-21", 112, 1);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 2-1", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-24", "2014-06-08", "2014-06-21", 121, 2);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 2-2", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-25", "2014-06-08", "2014-06-21", 112, 2);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 2-3", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-26", "2014-06-08", "2014-06-21", 121, 2);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 2-4", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-27", "2014-06-08", "2014-06-21", 112, 2);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 3-1", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-28", "2014-06-08", "2014-06-21", 121, 3);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 3-2", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-29", "2014-06-08", "2014-06-21", 112, 3);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("newbee owning vg 3-3", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-30", "2014-06-08", "2014-06-21", 112, 3);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("EG wins dota TI-4", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-23", "2014-06-08", "2014-06-21", 121, 4);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("EG wins dota TI-4", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-23", "2014-06-08", "2014-06-21", 121, 4);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("Liquid wins dota TI", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-23", "2014-06-08", "2014-06-21", 121, 5);
    INSERT OR REPLACE INTO highlights (title, video_link, added, start_date, end_date, views, highlights_events_id) VALUES("Liquid wins dota TI", "https://www.youtube.com/watch?v=OCypKGk8DhY", "2014-06-23", "2014-06-08", "2014-06-21", 121, 5);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(4, "192.168.1.1", 1);                               /* rating_id rating ip_address rating_highlights_id */
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(4, "192.168.1.2", 1);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(3, "192.168.1.3", 1);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(4, "192.168.1.4", 1);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(2, "192.168.1.5", 2);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(1, "192.168.1.6", 2);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(4, "192.168.1.7", 2);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(2, "192.168.1.8", 2);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(5, "192.168.1.9", 2);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(5, "192.168.1.10", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(3, "192.168.1.11", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(1, "192.168.1.12", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(2, "192.168.1.13", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(1, "192.168.1.14", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(1, "192.168.1.15", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(1, "192.168.1.16", 3);
    INSERT OR REPLACE INTO ratings (rating, ip_address, rating_highlights_id) VALUES(2, "192.168.1.17", 3);
SQL;

//$memory_db->exec( $insertSql );
$file_db->exec( $insertSql );
?>
