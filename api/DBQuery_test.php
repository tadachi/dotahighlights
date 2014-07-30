<?php
    require_once "include/ChromePhp.php";
    require_once "DBQuery.php";
    /* Test */
    $db = new DBQuery("db/dotahighlights.sqlite3");
    $results = $db->getEvents();
    // while ( $row = $results->fetchArray() ) {
    //     ChromePhp::log($row);
    // }
    $results = $db->getHighlightsForEvent(25, "");
    while ( $row = $results->fetchArray() ) {
        $data[] = $row;
        echo var_dump($row);
        //ChromePhp::log($row);
    }
    // $results = $db->searchForHighlights(25, "dota 5");
    // while ( $row = $results->fetchArray() ) {
    //     echo var_dump($row);
    //     //ChromePhp::log($row);
    // }
?>
