<?php
final class OrderModel {

    public function getOrders($id_user) {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM Orders WHERE id_user = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
