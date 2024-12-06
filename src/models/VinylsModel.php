<?php

require_once "Vinyl.php";

final class VinylsModel {

    private $conn = Database::getInstance()->getConnection();

    /**
     * get a specified number of vinyls from the database.
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
        $vinyls = array();
        $query = "SELECT
            v.id_vinyl,
            v.cost,
            a.title,
            a.cover_img,
            a.genre,
            ar.name AS artist,
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
                $query = $query . " WHERE a.title = " . $params->album;
                break;
            case "genre":
                $query = $query . " WHERE v.genre = " . $params->album;
                break;
            case "track":
                $query = $query . " JOIN inside_album ia
                    ON a.id_album = ia.id_album JOIN tracks t
                    ON t.id_track = ia.id_track WHERE t.title = ". $params->track;
                    break;
            case "artist":
                $query = $query . " WHERE ar.name = " . $params->artist;
                break;
        }
        // in case it need a limitation
        if ($n > 0) {
            $query = $query . " LIMIT ?;";
        } else {
            $query = $query . ";";
        }
        // prepared statement
        $stmt = $this->conn->prepare($query);
        if ($n > 0) {
            $stmt->bind_params("i", $n);
        }
        $result = $stmt->execute();

        foreach ($result->fetch_all() as $row) {
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
        }
        return json_encode($vinyls);
    }

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
            ar.name AS artist,
            FROM 
            vinyls v
            JOIN albums a ON v.id_vinyl = a.id_album
            JOIN inside_album ia ON a.id_album = ia.id_album
            JOIN artists ar ON ar.id_artist = a.id_artist
            WHERE v.id_vinyl = ?";
        // query to get the tracks from a vinyl [needs id_album from previous query]
        $tracks = "SELECT
            t.title
            t.duration
            FROM
            albums a
            JOIN inside_album ia ON ia.id_album = a.id_album
            JOIN tracks t ON t.id_track = ia.id_track
            WHERE a.id_album = ?";
        // prepare statement
        $stmt = $this->conn->prepare($vinyl);
        $stmt->bind_params("i", $id);
        $result = $stmt->execute();
        $result = $result->fetch();
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
        // prepare second statement
        $stmt = $this->conn->prepare($tracks);
        $stmt->bind_params("i", $album);
        $result = $stmt->execute();
        // create a list to store all (title, duration) tracks
        $track_list = [];
        foreach ($result->fetch_all() as $row) {
            array_push($track_list, [$row->title, $row->duration]);
        }
        // also add tracks to details
        $details->tracks = $track_list;
        return json_encode($details);
    }
}
?>