<section class="cards">
    <?php for ($i = 1; $i <= 20; $i++): ?>
        <?php
        $order = [
                'id_order' => $i,
                'order_status' => 'In attesa',
                'tracking_number' => round(rand(), 8),
                'courier' => 'PosteItaliane',
                'price' => round(log($i) * 10, 2),
                'shipment_date' => date('d M Y'),
                'delivery_date' => date('d M Y'),
                'shipment_status' => 'Non spedito',
                'shipment_cost' => 5,
                'notes' => 'Il mio ordine va consegnato sotto la finestra',
                'shipment_address' => 'Via Milano 1 - Milan (00231)',
                'vinyls' => [
                    [
                        'id_vinyl' => 1,
                        'album_title' => 'The Dark Side of the Moon',
                        'artist_name' => 'Pink Floyd',
                        'price' => 20,
                        'quantity' => 1,
                        'album_cover' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Dark_Side_of_the_Moon.png'
                    ],
                    [
                        'id_vinyl' => 2,
                        'album_title' => 'The Wall',
                        'artist_name' => 'Pink Floyd',
                        'price' => 25,
                        'quantity' => 1,
                        'album_cover' => 'https://upload.wikimedia.org/wikipedia/en/3/3b/Dark_Side_of_the_Moon.png'
                    ],
                    [
                        'id_vinyl' => 3,
                        'album_title' => 'Wish You Were Here',
                        'artist_name' => 'Pink Floyd',
                        'price' => 15,
                        'quantity' => 1,
                        'album_cover' => ''
                    ]
                ]
            ];
        ?>
        <?include COMPONENTS . '/cards/order.php'?>
    <?php endfor; ?>
</section>
