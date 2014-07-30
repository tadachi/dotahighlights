<?php
    // Report all PHP errors. Disable in production.
    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    require_once "include/ChromePhp.php";
    require_once __DIR__ . "/vendor/autoload.php";

    class API {

        private $dbaccess;

        function __construct() {

        }

        function run() {
            $url = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["REMOTE_PORT"];

            /* Test */
            $klein = new \Klein\Klein();

            API::highlightsRoutes($klein);
            API::eventRoutes($klein);

            $klein->dispatch();
        }

        function highlightsRoutes($klein) {
            /* Routing */
            $klein->respond("GET", "/highlights", function () {

                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $dbaccess->getHighlights();

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }

                $url = $_SERVER["SERVER_NAME"];
                $data["next"] = $url . "/highlights" . "/limit=25" . "/offset=0" ;
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/highlights/limit=[:limit]", function ($param) {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $dbaccess->getHighlights(urldecode($param->event));

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }

                $url = $_SERVER["SERVER_NAME"];
                $data["next"] = $url . "/highlights" . "/limit=" . $param->limit . "/offset=0" ;
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/highlights/limit=[:limit]/offset=[:offset]", function ($param) {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");
                
                $results = $dbaccess->getHighlights(urldecode($param->event));

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }

                $url = $_SERVER["SERVER_NAME"];
                if ($param->offset > 0) {
                    $data["prev"] = $url . "/highlights" . "/limit=" . $param->limit . "/offset=" . ($param->offset - $param->limit);
                }
                $data["next"] = $url . "/highlights" . "/limit=" . $param->limit . "/offset=" . ($param->offset + $param->limit);
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/highlights/event=[:event]", function ($param) {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $dbaccess->getHighlightsForEvent(urldecode($param->event));

                while ( $row = $results->fetchArray() ) {
                    $data["data"][][] = $row;
                }

                $url = $_SERVER["SERVER_NAME"];
                $data["next"] = $url . "/highlights/event=" . $param->event . "/limit=25" . "/offset=25";
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/highlights/event=[:event]/limit=[:limit]", function ($param) {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $dbaccess->getHighlightsForEvent(urldecode($param->event), $param->limit);

                while ( $row = $results->fetchArray() ) {
                    $data["data"][][] = $row;
                }

                $url = $_SERVER["SERVER_NAME"];
                $data["next"] = $url . "/highlights" . "/event=" . $param->event . "/limit=25" . $param->limit . "/offset=25";
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/highlights/event=[:event]/limit=[:limit]/offset=[:offset]", function ($param) {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $data = array();
                $results = $dbaccess->getHighlightsForEvent(urldecode($param->event), $param->limit, $param->offset);

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }

                $url = $_SERVER["SERVER_NAME"];
                if ($param->offset > 0) {
                    $data["prev"] = $url . "/highlights/event=" . $param->event . "/limit=" . $param->limit . "/offset=" . ($param->offset - $param->limit);
                }
                $data["next"] = $url . "/highlights" . "/event=" . $param->event . "/limit=" . $param->limit . "/offset=" . ($param->offset + $param->limit);
                API::sendJSONResponse(200, $data);
            });
        }

        function eventRoutes($klein) {
            $klein->respond("GET", "/events", function () {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $this->dbaccess->getevents();

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/events/event=[:event]", function () {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $this->dbaccess->getevents();

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }

                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/events/event=[:event]/limit=[:limit]/", function () {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $this->dbaccess->getevents();

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }
                API::sendJSONResponse(200, $data);
            });

            $klein->respond("GET", "/events/event=[:event]/limit=[:limit]/offset=[:offset]", function () {
                require_once "DBQuery.php";
                $dbaccess = new DBQuery("db/dotahighlights.sqlite3");

                $results = $this->dbaccess->getevents();

                while ( $row = $results->fetchArray() ) {
                    $data["data"][] = $row;
                }
                API::sendJSONResponse(200, $data);
            });
        }

        /* Helper method to send a HTTP response code/message */
        function sendJSONResponse($status = 200, $body, $content_type = "application/json; charset=utf-8") {
            // $status_header = "HTTP/1.1 " . $status . " " . API::getStatusCodeMessage($status);
            // header($status_header);
            // header_remove("Server");
            // header("Content-type: " . $content_type);
            // header_remove("X-Powered-By");
            // echo json_encode($body); //PRODUCTION
            echo var_dump($body);    //TEST
        }

        /*
         *Helper method to get a string description for an HTTP status code
         *From http://www.gen-x-design.com/archives/create-a-rest-api-with-php/
         */
        function getStatusCodeMessage($status) {
            // these could be stored in a .ini file and loaded
            // via parse_ini_file()... however, this will suffice
            // for an example
            $codes = Array(
                100 => "Continue",
                101 => "Switching Protocols",
                200 => "OK",
                201 => "Created",
                202 => "Accepted",
                203 => "Non-Authoritative Information",
                204 => "No Content",
                205 => "Reset Content",
                206 => "Partial Content",
                300 => "Multiple Choices",
                301 => "Moved Permanently",
                302 => "Found",
                303 => "See Other",
                304 => "Not Modified",
                305 => "Use Proxy",
                306 => "(Unused)",
                307 => "Temporary Redirect",
                400 => "Bad Request",
                401 => "Unauthorized",
                402 => "Payment Required",
                403 => "Forbidden",
                404 => "Not Found",
                405 => "Method Not Allowed",
                406 => "Not Acceptable",
                407 => "Proxy Authentication Required",
                408 => "Request Timeout",
                409 => "Conflict",
                410 => "Gone",
                411 => "Length Required",
                412 => "Precondition Failed",
                413 => "Request Entity Too Large",
                414 => "Request-URI Too Long",
                415 => "Unsupported Media Type",
                416 => "Requested Range Not Satisfiable",
                417 => "Expectation Failed",
                500 => "Internal Server Error",
                501 => "Not Implemented",
                502 => "Bad Gateway",
                503 => "Service Unavailable",
                504 => "Gateway Timeout",
                505 => "HTTP Version Not Supported"
            );

            return (isset($codes[$status])) ? $codes[$status] : "";
        }
    }

    $api = new API();
    $api->run();





?>
