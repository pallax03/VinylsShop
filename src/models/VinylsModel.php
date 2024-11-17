<?php

require_once "Vinyl.php";

final class VinylsModel {

    private $conn = Database::getInstance()->getConnection();

    public function getVinyls($n = -1) {
        $vinyls = array();
        $query = "SELECT * FROM vinyl";

        if ($n > 0) {
            $query = $query . " LIMIT ?";
        }
        $stmt = $this->conn->prepare($query);
        if ($n > 0) {
            $stmt->bind_params("i", $n);
        }
        $result = $stmt->execute();

        foreach ($result->fetch_all() as $row) {
            // extract datas from record
            $id = $row["id_vinyl"];
            $cost = $row["cost"];
            $quantity = $row["quantity"];
            $colors = $row["colors"];
            $type = $row["type"];
            $img = $row["img"];
            // add new vinyl topo vinyls list
            array_push($vinyls, new Vinyl($id, $cost, $quantity,
                $colors, $type, $img));
        }
        return $vinyls;
    }
}
?>