<?php

require_once "Vinyl.php";

final class VinylsModel {

    private $conn = Database::getInstance()->getConnection();

    public function getVinyls($n = -1) {
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
            JOIN artists ar ON a.id_artist = ar.id_artist;";
        if ($n > 0) {
            $query = $query . " LIMIT ?";
        }
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
            array_push($vinyls, json_encode($json));
        }
        return $vinyls;
    }
}
?>