<?php
final class UserModel {
    
    public function deleteUser($id_user = null) {
        if (Session::isSuperUser()) {
            return [];
        }

        if (!Session::isLogged() && !$id_user && !Session::getUser()) {
            return [];
        }

        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `Users` WHERE id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }

    public function getUser($id_user = null) {
        if (!Session::isLogged() && !$id_user && !Session::getUser()) {
            return [];
        }

        return Database::getInstance()->executeResults(
            "SELECT * FROM `Users` WHERE id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }
}
