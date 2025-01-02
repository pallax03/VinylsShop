<?php
final class UserModel {

    /**
     * Get all the users from the database. (⭐️ only for super users).
     *
     * @return array the users if the query is successful, false otherwise.
     */
    public function getUsers() {
        if (!Session::isSuperUser()) {
        return [];
        }

        return Database::getInstance()->executeResults(
            "SELECT id_user, mail, balance, newsletter  FROM `vinylsshop`.`users`"
        );
    }

    /**
     * This function returns the user info from the database.
     * infos: id_user, mail, balance, newsletter, default_card, card_number, default_address, street_number, city, postal_code
     * a super user can get any user
     * Cannot get a user if:
     * - the user is not logged
     * 
     * @param int|null $id_user if null, the logged user
     * 
     * @return array the user if exists, false if the query failed.
     */
    public function getUser($id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
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
                    a.name, a.street_number, a.city, a.postal_code
                FROM `vinylsshop`.`users` u
                LEFT JOIN `vinylsshop`.`userpreferences` up ON u.id_user = up.id_user
                LEFT JOIN `vinylsshop`.`cards` c ON up.default_card = c.id_card
                LEFT JOIN `vinylsshop`.`addresses` a ON up.default_address = a.id_address
                WHERE u.id_user = ?;",
            'i',
            $id_user ?? Session::getUser()
        )[0];
    }


    /**
     * Update the user in the database.
     * A super user can update any user, and his balance.
     * A user can update only himself, but not is balance.
     *
     * @param int|null $id_user the user to update, if null, the logged user
     * @param string|null $newsletter the newsletter value
     * @return bool true if the user is updated, false otherwise
     */
    public function updateUser($id_user = null, $newsletter = null, $balance = null) {
        if (!Session::haveAdminUserRights($id_user) || ($balance && Session::isSuperUser())) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "UPDATE `vinylsshop`.`users` SET"
                . ($newsletter ? "newsletter = ?, " : "")
                . ($balance ? "balance = ?, " : "")
                . " WHERE id_user = ?;",
            'ii',
            $id_user ?? Session::getUser(),
            $newsletter,
            $balance
        );
    }


    /**
     * Deletes a user from the database.
     * A super user can delete any user except himself.
     * A user can delete only himself.
     *
     * @param int|null $id_user the user to delete, if null, the logged user
     * @return bool true if the user is deleted, false otherwise
     */
    public function deleteUser($id_user = null) {
        if (Session::isSuperUser() ? Session::isHim($id_user) : !Session::isHim($id_user)) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `users` WHERE id_user = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }


    /**
     * Get the address of a user specific user or the logged user.
     * a super user can get any user's addresses
     * 
     * @param int|null $id_user if null, the logged user
     * @param int|null $id_address if null, all the addresses
     * @return array the addresses of the user, false if query failed.
     */
    public function getAddress($id_user = null, $id_address = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return [];
        }

        return Database::getInstance()->executeResults(
            "SELECT a.id_address,
                    a.name,
                    a.street_number, 
                    a.city, 
                    a.postal_code
                FROM `vinylsshop`.`addresses` a
                WHERE a.id_user = ? " . ($id_address ? "AND a.id_address = ?" : "") . ";",
            'ii',
            $id_user ?? Session::getUser(),
            $id_address
        );
    }

    /**
     * Set the address for the logged user.
     * 
     * @param string $name the name of the address
     * @param string $street_number the street number of the address
     * @param string $city the city of the address
     * @param string $postal_code the postal code of the address
     * @return bool the addresses of the user, false if query failed.
     */
    public function setAddress($name, $street_number, $city, $postal_code) {
        if (!Session::isLogged()) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`addresses` (`id_user`, `name`, `street_number`, `city`, `postal_code`) VALUES (?, ?, ?, ?, ?);",
            'issss',
            $id_user ?? Session::getUser(),
            $name, $street_number, $city, $postal_code
        );
    }

    /**
     * Delete an address from the database.
     * A super user can delete any address of any user, but not his addresses.
     * A user can delete only his addresses.
     *
     * @param int $id_address the address to delete
     * @param int|null $id_user if null, the logged user
     * @return bool true if the address is deleted, false otherwise
     */
    public function deleteAddress($id_address, $id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return false;
        }

        if ($id_address == $this->getUser($id_user)['default_address']) {
            $this->setDefaultAddress(id_address: '');
        }

        Database::getInstance()->setHandler(null); // reset the handler to avoid the error
        $result = Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `addresses` WHERE id_user = ? AND id_address = ?",
            'ii',
            $id_user ?? Session::getUser(),
            $id_address
        );
        if (!$result) {
            $result = Database::getInstance()->executeQueryAffectRows(
                "UPDATE `vinylsshop`.`addresses`
                    SET `id_user` = NULL
                    WHERE `id_user` = ? AND `id_address` = ?;",
                'ii',
                $id_user ?? Session::getUser(),
                $id_address,
            );
        }
        return $result;
    }


    /**
     * Get the cards of a specific user or the logged user.
     * a super user can get any user's cards
     *
     * @param int|null $id_user null if the logged user 
     * @param int|null $id_card null if all the cards
     * @return array the cards of the user, false if query failed.
     */
    public function getCard($id_user = null, $id_card = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return [];
        }

        return Database::getInstance()->executeResults(
            "SELECT c.id_card, 
                    c.card_number
                FROM `vinylsshop`.`cards` c
                WHERE c.id_user = ? " . ($id_card ? "AND c.id_card = ?" : "") . ";",
            'ii',
            $id_user ?? Session::getUser(),
            $id_card
        );
    }

    /**
     * Set the card for the logged user.
     * 
     * @param string $card_number the card number
     * @param string $exp_date the expiration date
     * @param string $cvc the cvc
     * @return bool the cards of the user, false if query failed.
     */
    public function setCard($card_number, $exp_date, $cvc) {
        if (!Session::isLogged()) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`cards` (`id_user`, `card_number`, `exp_date`, `cvc`) VALUES (?, ?, ?, ?);",
            'isss',
            Session::getUser(),
            $card_number, $exp_date, $cvc
        );
    }

    /**
     * Delete a card from the database.
     * A super user can delete any card.
     * A user can delete only his cards.
     *
     * @param int $id_card the card to delete
     * @param int|null $id_user if null, the logged user
     * @return bool true if the card is deleted, false otherwise
     */
    public function deleteCard($id_card, $id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return false;
        }

        // if the card is the default card, set the default card to null
        if ($id_card == $this->getUser($id_user)['default_card']) {
            $this->setDefaultCard(id_card: '');
        }

        Database::getInstance()->setHandler(null); // reset the handler to avoid the error
        $result = Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM `cards` WHERE id_user = ? AND id_card = ?",
            'ii',
            $id_user ?? Session::getUser(),
            $id_card
        );

        if (!$result) {
            $result = Database::getInstance()->executeQueryAffectRows(
                "UPDATE `vinylsshop`.`cards`
                    SET `id_user` = NULL
                    WHERE `id_user` = ? AND `id_card` = ?;",
                'ii',
                $id_user ?? Session::getUser(),
                $id_card,
            );
        }
        return $result;
    }

    /**
     * Create the default preferences for a user if do not exists.
     *
     * @param int|null $id_user if null, the logged user
     * @return bool true if the preferences are created, false otherwise
     */
    private function createDefaults($id_user = null) {
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT IGNORE INTO `vinylsshop`.`userpreferences` (`id_user`) VALUES (?)",
            'i',
            $id_user ?? Session::getUser()
        );
    }

    /**
     * Set the default card for the logged user.
     * 
     * @param int $id_card the id of the card
     * @return bool the cards of the user, false if query failed.
     */
    private function setDefaultCard($id_card) {
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`userpreferences` (`id_user`, `default_card`)
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE
                `default_card` = VALUES(`default_card`);",
            'ii',
            $id_user ?? Session::getUser(),
            $id_card ?? ''
        );
    }

    /**
     * Set the default address for the logged user.
     * 
     * @param int $id_address the id of the address
     * @return bool true if the address is set, false otherwise
     */
    private function setDefaultAddress($id_address) {
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `vinylsshop`.`userpreferences` (`id_user`, `default_address`)
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE
                `default_address` = VALUES(`default_address`);",
            'ii',
            $id_user ?? Session::getUser(),
            $id_address ?? ''
        );
    }

    /**
     * Set the default address and card for the logged user.
     *
     * @param int|null $id_card
     * @param int|null $id_address
     * @return bool true if the address and card are set, false otherwise
     */
    public function setDefaults($id_card = null, $id_address = null) {
        if (!Session::isLogged()) {
            return false;
        }

        if ($id_card !== null && $id_address !== null) {
            return Database::getInstance()->executeQueryAffectRows(
                "INSERT INTO `vinylsshop`.`userpreferences` (`id_user`, `default_card`, `default_address`)
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    `default_card` = VALUES(`default_card`),
                    `default_address` = VALUES(`default_address`);",
                'iii',
                Session::getUser(),
                $id_card ?? '',
                $id_address ?? ''
            );
        }

        if ($id_card !== null) {
            return $this->setDefaultCard($id_card);
        }

        if ($id_address !== null) {
            return $this->setDefaultAddress($id_address);
        }
        
        return $this->createDefaults(Session::getUser());
    }
}
