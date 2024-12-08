<?php
final class OrderModel {

    public function getOrders($id_user = null) {
        if (!Session::isSuperUser() || !Session::isHim($id_user)) {
            return [];
        }
        
        return Database::getInstance()->executeResults(
            "SELECT * FROM `Orders` WHERE id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }
}
