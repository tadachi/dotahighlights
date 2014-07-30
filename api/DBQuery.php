<?php
    class DBQuery {

        private $db = NULL;

        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function DBQuery($filepath) {
            // opening db connection
            $this->db = new SQLite3($filepath);
        }

        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function handle() {
            return $this->db->handle();
        }

        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function getEvents($limit = 25, $offset = 0) {
            $sql = sprintf("SELECT title, banner, icon, start_date, end_date FROM events LIMIT %d OFFSET %d", $limit, $offset);
            $results = $this->db->query($sql);
            return $results;
        }

        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function getHighlights($limit = 25, $offset = 0) {
            $sql = sprintf("SELECT title, video_link, start_date, end_date FROM highlights LIMIT %d OFFSET %d", $limit, $offset);
            // echo $sql,"\n\n";
            $results = $this->db->query($sql);
            return $results;
        }

        /**
        * Summary
        * Search for highlights for a specific event.
        *
        * Description
        * Search for highlights for a specific event.
        * Offset is the index for first element provided by the SQL results. Change it if you want to get
        * the next results beyond the limit. Set a sane limit for each request and take advantage of the offset.
        *
        * @param Integer, String, Integer
        *
        * @return Object
        */
        public function getHighlightsForEvent($event_name, $limit = 25, $offset = 0) {
            $event_name_keywords = explode(" ", $event_name);
            $sql = "SELECT h.title, h.video_link, e.title, h.added FROM events AS e INNER JOIN highlights AS h
                    ON e.events_id = h.highlights_events_id";

            if ($event_name != "") {
                for ($i = 0; $i < count($event_name_keywords); $i++) {     // Foreach keyword seperated by space, add an OR LIKE 'keyword'.
                    if($i < 1) {                                           // If only one keyword, just add the WHERE.
                        $sql .= sprintf(" WHERE e.title LIKE '%%%s%%'", $event_name_keywords[$i]);
                    }else {
                        $sql .= sprintf(" OR e.title LIKE '%%%s%%'", $event_name_keywords[$i]);
                    }
                }
            }else {
                $sql .= sprintf(" WHERE e.title LIKE ''");
            }
            $sql .= " ORDER BY h.added DESC"; // Latest videos first/top.
            $sql .= sprintf(" LIMIT %d", $limit);
            $sql .= sprintf(" OFFSET %d", $offset);

            // echo $sql,"\n\n";
            $results = $this->db->query($sql);
            return $results;
        }


        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function searchForHighlights($highlight_name, $limit = 25, $offset = 0) {
            $highlight_keywords = explode(" ", $$highlight_name);
            $sql = "SELECT h.title, h.video_link, e.title e.start_date, e.end_date FROM events AS e INNER JOIN highlights AS h
                    ON e.events_id = h.highlights_events_id";
            // echo $sql,"\n\n";
            if ($highlight_name != "") {
                for ($i = 0; $i < count($highlight_keywords); $i++) {     // Foreach keyword seperated by space, add an OR LIKE 'keyword'.
                    if($i < 1) {                                           // If only one keyword, just add the WHERE.
                        $sql .= sprintf(" WHERE h.title LIKE '%%%s%%'", $highlight_keywords[$i]);
                    }else {
                        $sql .= sprintf(" OR h.title LIKE '%%%s%%'", $highlight_keywords[$i]);
                    }
                }
            }else {
                $sql .= sprintf(" WHERE h.title LIKE ''");
            }
            $results = $this->db->query($sql);
            return $results;
        }

        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function getRatings() {
            $sql = "SELECT rating, ip_address, rating_highlights_id FROM ratings";
            // echo $sql,"\n\n";
            $results = $this->db->query($sql);
            return $results;
        }

        /**
        * Summary
        *
        * Description
        *
        *
        * @param string/type.
        *
        * @return void
        */
        public function getRatingsForHighlight() {
            $sql = "SELECT rating, ip_address, rating_highlights_id FROM ratings";
            // echo $sql,"\n\n";
            $results = $this->db->query($sql);
            return $results;
        }


    }

?>
