<?php
final class OrderModel
{

    /**
     * Get all orders of a user
     * An admin can get any user orders
     * A user can only get his own orders
     *
     * @param [int] $id_user, if null, return the logged user
     * @return Array of orders
     */
    public function getOrders($id_user = null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return [];
        }

        $orders = Database::getInstance()->executeResults(
            "SELECT 
                    o.id_order,
                    o.order_date,
                    o.total_cost,
                    o.order_status,
                    s.tracking_number,
                    s.shipment_date,
                    s.delivery_date,
                    s.shipment_status,
                    s.courier,
                    s.notes,
                    s.cost AS shipment_cost,
                    ad.name AS address_name,
                    ad.city AS address_city,
                    ad.postal_code AS address_postal_code,
                    ad.street_number AS address_street_number
                FROM `vinylsshop`.`orders` o
                JOIN `vinylsshop`.`shipments` s ON o.id_order = s.id_order
                JOIN `vinylsshop`.`addresses` ad ON s.id_address = ad.id_address
                WHERE o.id_user = ?
                ORDER BY o.order_date DESC;",
            'i',
            $id_user ?? Session::getUser()
        );

        foreach ($orders as $key => $order) {
            $orders[$key]['vinyls'] = Database::getInstance()->executeResults(
                "SELECT 
                        v.cost AS price,
                        a.title AS album_title,
                        a.cover AS album_cover
                    FROM `vinylsshop`.`checkouts` co
                    JOIN `vinylsshop`.`vinyls` v ON co.id_vinyl = v.id_vinyl
                    JOIN `vinylsshop`.`albums` a ON v.id_album = a.id_album
                    WHERE co.id_order = ?;",
                'i',
                $order['id_order']
            );
        }
        return $orders;
    }

    /**
     * Get a specific order by id
     * A user can only get his own orders
     * An admin can get any order
     *
     * @param [int] $id_user, if null, return the logged user
     * @param [int] $id_order, if null, return the last order
     * @return Array of order
     */
    public function getOrder($id_user=null, $id_order=null) {
        if (!Session::haveAdminUserRights($id_user)) {
            return [];
        }

        if ($id_order === null) {
            $id_order = Database::getInstance()->executeResults(
                "SELECT id_order FROM `vinylsshop`.`orders` WHERE id_user = ? ORDER BY order_date DESC LIMIT 1;",
                'i',
                $id_user ?? Session::getUser()
            )[0]['id_order'];
        }

        $order = Database::getInstance()->executeResults(
            "SELECT 
                    o.id_order,
                    o.order_date,
                    o.total_cost,
                    o.order_status,
                    o.id_card,
                    c.card_number,
                    o.discount_code,
                    p.percentage AS discount_percentage,
                    s.tracking_number,
                    s.shipment_date,
                    s.delivery_date,
                    s.shipment_status,
                    s.courier,
                    s.notes,
                    s.cost AS shipment_cost,
                    ad.name AS address_name,
                    ad.city AS address_city,
                    ad.postal_code AS address_postal_code,
                    ad.street_number AS address_street_number
                FROM `vinylsshop`.`orders` o
                JOIN `vinylsshop`.`shipments` s ON o.id_order = s.id_order
                JOIN `vinylsshop`.`addresses` ad ON s.id_address = ad.id_address
                LEFT JOIN `vinylsshop`.`cards` c ON o.id_card = c.id_card
                LEFT JOIN `vinylsshop`.`coupons` p ON o.discount_code = p.discount_code
                WHERE o.id_user = ? AND o.id_order = ?;",
            'ii',
            $id_user ?? Session::getUser(),
            $id_order
        )[0];

        $order['vinyls'] = Database::getInstance()->executeResults(
            "SELECT 
                    co.quantity,
                    v.cost AS price,
                    v.type
                    v.rpm
                    v.inch
                    a.genre
                    a.title
                    a.cover
                    t.name AS artist_name
                FROM `vinylsshop`.`checkouts` co
                JOIN `vinylsshop`.`vinyls` v ON co.id_vinyl = v.id_vinyl
                JOIN `vinylsshop`.`albums` a ON v.id_album = a.id_album
                JOIN `vinylsshop`.`artists` t ON v.id_artist = t.id_artist
                WHERE co.id_order = ?;",
            'i',
            $id_order
        );

        return $order;
    }
}
