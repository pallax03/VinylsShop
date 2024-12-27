<?php
final class OrderModel
{

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
                FROM `VinylsShop`.`Orders` o
                JOIN `VinylsShop`.`Shipments` s ON o.id_order = s.id_order
                JOIN `VinylsShop`.`Addresses` ad ON s.id_address = ad.id_address
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
                    FROM `VinylsShop`.`Checkouts` co
                    JOIN `VinylsShop`.`Vinyls` v ON co.id_vinyl = v.id_vinyl
                    JOIN `VinylsShop`.`Albums` a ON v.id_album = a.id_album
                    WHERE co.id_order = ?;",
                'i',
                $order['id_order']
            );
        }
        return $orders;
    }
}
