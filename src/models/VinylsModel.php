<?php

require_once "Vinyl.php";

final class VinylsModel {

    private $db = Database::getInstance();

    /**
     * Gets a specified number of vinyls from the database.
     * @param n the number of vinyls to send
     * @param params a map of values to query the database on:
     * params structure:
     *  { 
     *      id -> ..., album -> ..., genre -> ...,
     *      artist -> ..., track -> ...
     *  }
     * @return json of vinyls data
     */    
    public function getVinyls($n = -1, $params) {
        $vinyls = [];
        $query = "SELECT
            v.id_vinyl,
            v.cost,
            a.title,
            a.cover_img,
            a.genre,
            ar.name AS artist
            FROM
            vinyls v JOIN albums a ON v.id_album = a.id_album
            JOIN artists ar ON a.id_artist = ar.id_artist";
        $keys = array_keys($params);
        // get the first key and switch on it to get the right string added to the query
        switch (reset($keys)) {
            case "id":
                $query = $query . " WHERE v.id_vinyl = " . $params->id;
                break;
            case "album":
                $query = $query . " WHERE a.title LIKE '%" . $params->album . "%'";
                break;
            case "genre":
                $query = $query . " WHERE v.genre LIKE '% " . $params->album . "%'";
                break;
            case "track":
                $query = $query . " JOIN albumstracks ta
                    ON a.id_album = ta.id_album JOIN tracks t
                    ON t.id_track = ta.id_track WHERE t.title LIKE '%". $params->track . "%'";
                    break;
            case "artist":
                $query = $query . " WHERE ar.name LIKE '%" . $params->artist . "%'";
                break;
        }
        // in case it needs a limitation
        if ($n > 0) {
            $query = $query . " LIMIT ?";
            $result = $this->db->executeResults($query, "i", $n);
        } else {
            $result = $this->db->executeResults($query);
        }
        foreach ($result as $row):
            // create an empty object
            $json = new stdClass();
            // extract datas from record
            $json->id = $row->id_vinyl;
            $json->cost = $row->cost;
            $json->title = $row->title;
            $json->cover_img = $row->cover_img;
            $json->genre = $row->genre;
            $json->artist = $row->artist;
            // add new vinyl topo vinyls list
            array_push($vinyls, $json);
        endforeach;
        return json_encode($vinyls);
    }

    /**
     * Gets the details of a single vinyl (vinyl page)
     * from a given id.
     * @param id of the vinyl in question
     * @return json containing details on the vinyl
     */
    public function getVinylDetails($id) {
        $details = new stdClass();
        // query to get vinyls info
        $vinyl = "SELECT 
            v.id_vinyl,
            v.cost,
            v.rpm,
            v.inch,
            v.type,
            a.id_album,
            a.title,
            a.release_date,
            a.cover_img,
            ar.name AS artist
            FROM 
            vinyls v
            JOIN albums a ON v.id_vinyl = a.id_album
            JOIN artists ar ON ar.id_artist = a.id_artist
            WHERE v.id_vinyl = ?";
        // query to get the tracks from a vinyl [needs id_album from previous query]
        $tracks = "SELECT
            t.title,
            t.duration
            FROM
            albums a
            JOIN albumstracks ta ON ta.id_album = a.id_album
            JOIN tracks t ON t.id_track = ta.id_track
            WHERE a.id_album = ?";
        // prepare statement
        $result = $this->db->executeResults($vinyl, "i", $id);
        if (!empty($result)):
            // store id_album for the next query
            $album =  $result->id_album;
            // store the results
            $details->id = $result->id_vinyl;
            $details->cost = $result->cost;
            $details->rpm = $result->rpm;
            $details->inch = $result->inch;
            $details->type = $result->type;
            $details->title = $result->title;
            $details->release_date = $result->release_date;
            $details->cover_img = $result->cover_img;
            $details->artist = $result->artist;
        endif;
        // prepare second statement
        $result = $this->db->executeResults($tracks, "i", $album);
        // create a list to store all (title, duration) tracks
        $track_list = [];
        foreach ($result as $row):
            array_push($track_list, [$row->title, $row->duration]);
        endforeach;
        // also add tracks to details
        $details->tracks = $track_list;
        return json_encode($details);
    }

    /**
     * Function to be called to get the preview of a vinyl
     * (cart, checkout and order pages).
     * @param id of the vinyl to get the preview of
     * @return json containing the information on the vinyl
     */
    public function getPreview($id) {
        $preview = new stdClass();
        // query to get vinyls info
        $query = "SELECT
            v.cost,
            v.rpm,
            v.inch,
            v.type,
            a.title,
            a.genre,
            a.cover_img,
            ar.name AS artist
            FROM 
            vinyls v
            JOIN albums a ON v.id_vinyl = a.id_album
            JOIN artists ar ON ar.id_artist = a.id_artist
            WHERE v.id_vinyl = ?";
        // execute query
        $result = $this->db->executeResults($query);
        if (!empty($result)):
            // store results
            $preview->cost = $result->cost;
            $preview->rpm = $result->rpm;
            $preview->inch = $result->inch;
            $preview->genre = $result->genre;
            $preview->type = $result->type;
            $preview->title = $result->title;
            $preview->cover_img = $result->cover_img;
            $preview->artist = $result->artist;
        endif;
        return json_encode($preview);
    }

    /**
     * Gets the order previews (user page)
     * from a given vinyl id.
     * @param id of the vinyl to get the preview of
     * @return json with the  preview infos
     */
    public function getUserOrderPreview($id) {
        $preview = new stdClass();
        $query = "SELECT
            v.cost,
            a.title,
            a.cover_img,
            FROM 
            vinyls v
            JOIN albums a ON v.id_vinyl = a.id_album";
        // execute query
        $result = $this->db->executeResults($query);
        if (!empty($result)):
            // store results
            $preview->cost = $result->cost;
            $preview->title = $result->title;
            $preview->cover_img = $result->cover_img;
        endif;
        return json_encode($preview);
    }

    public function getSuggested($id) {
        $suggested = [];
        $infos = "SELECT
            v.id_vinyl
            a.genre,
            ar.name AS artist
            FROM
            vinyls v
            JOIN albums a ON v.id_album = a.id_album
            JOIN artists ar ON ar.id_artist = a.id_artist
            WHERE v.id_vinyl = ?";
        $vinyls = "SELECT
            v.id_vinyl,
            a.cover_img,
            a.title
            FROM
            vinyls v
            JOIN albums a ON v.id_album = a.id_album
            JOIN artists ar ON ar.id_artist = a.id_artist
            WHERE (a.genre = ? OR ar.name = ?)
            AND v.id_vinyl <> ?
            LIMIT 6";
        // execute query
        $result = $this->db->executeResults($infos, "i", $id);
        // store infos
        if (!empty($result)):
            $result = $this->db->executeResults($vinyls, ["s", "s", "i"], [$result->genre, $result->artist, $id]);
            foreach($result as $row):
                $vinyl = new stdClass();
                $vinyl->cover_img = $row->cover_img;
                $vinyl->title = $row->title;
                array_push($suggested, $vinyl);
            endforeach;
        endif;
        return json_encode($suggested);
    }
}
?>