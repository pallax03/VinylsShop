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


}
?>