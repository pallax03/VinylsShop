<?php
final class UserModel {

    /**
     * This function deletes a user from the database
     * Cannot delete a user if:
     * - the user is a super user
     * - the user is not logged and if $user_id check if isHim(id_user)
     * @param int $id_user
     * @return bool true if the user is deleted, false otherwise
     */
    public function deleteUser($id_user = null) {
        if (Session::isSuperUser() || !Session::isHim($id_user)) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `Users` WHERE id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }

    /**
     * This function returns the user info from the database
     * infos: id_user, mail, balance, newsletter, default_card, card_number, default_address, street_number, city, postal_code
     * a super user can get any user
     * Cannot get a user if:
     * - the user is not logged
     * @param int $id_user
     * @return array the user if exists, empty array otherwise
     */
    public function getUser($id_user = null) {
        if (!Session::isSuperUser() && !Session::isHim($id_user)) {
            return [];
        }

        return Database::getInstance()->executeResults(
            "SELECT u.id_user, 
                    u.mail, 
                    u.balance,
                    u.newsletter,
                    up.default_card, 
                    c.card_number, 
                    up.default_address, 
                    a.street_number, a.city, a.postal_code
                FROM `VinylsShop`.`Users` u
                LEFT JOIN `VinylsShop`.`UserPreferences` up ON u.id_user = up.id_user
                LEFT JOIN `VinylsShop`.`Cards` c ON up.default_card = c.id_card
                LEFT JOIN `VinylsShop`.`Addresses` a ON up.default_address = a.id_address
                WHERE u.id_user = ?;",
            'i',
            $id_user ?? Session::getUser()
        )[0];
    }

    public function getAddress($id_user = null, $id_address = null) {
        if (!Session::isSuperUser() && !Session::isHim($id_user)) {
            return [];
        }

        return Database::getInstance()->executeResults(
            "SELECT a.id_address, 
                    a.street_number, 
                    a.city, 
                    a.postal_code
                FROM `VinylsShop`.`Addresses` a
                WHERE a.id_user = ? " . ($id_address ? "AND a.id_address = ?" : "") . ";",
            'ii',
            $id_user ?? Session::getUser(),
            $id_address
        );
    }

    public function setDefaults($id_card = null, $id_address = null) {
        if (!Session::isLogged()) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `VinylsShop`.`UserPreferences` (`id_user`, `default_card`, `default_address`)
                VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE 
                    `default_card` = VALUES(`default_card`), 
                    `default_address` = VALUES(`default_address`);",
            'iii',
            Session::getUser(),
            $id_card == null || empty($id_user) ? -1 : $id_card,
            $id_address == null || empty($id_address) ? -1 : $id_address
        );
    }
}
