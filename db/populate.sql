-- Insert artits
INSERT IGNORE INTO `VinylsShop`.`Artists` (`id_artist`, `name`)
VALUES 
(1, 'Various Artists'),
(2, 'My Chemical Romance'),
(3, 'Billie Eilish'),
(4, 'Palaye Royale'),
(5, 'Bring Me The Horizon'),
(6, 'Toby Fox');

-- Insert albums
INSERT IGNORE INTO `VinylsShop`.`Albums` (`id_album`, `title`, `genre`, `cover_img`, `release_date`, `id_artist`)
VALUES
(1, 'The Black Parade', 'Rock', 'blackparade.webp', '2006-10-23', 2),
(2, 'Dont Smile at Me', 'Pop', 'dontsmileatme.webp', '2017-08-11', 3),
(3, 'When We All Fall Asleep, Where Do We Go?', 'Pop', 'fallasleep.webp', '2019-03-29', 3),
(4, 'Hit Me Hard And Soft', 'Pop', 'hitmehardandsoft.webp', '2024-05-17', 3),
(5, 'Fever Dream', 'Rock', 'feverdream.webp', '2022-10-28', 4),
(6, 'Post Human: Survival Horror', 'Rock', 'posthuman.webp', '2020-10-30', 5),
(7, 'Sempiternal', 'Metal', 'sempiternal.webp', '2013-04-01', 5),
(8, 'Undertale Soundtrack', 'Soundtrack', 'undertale.webp', '2015-09-15', 6);

-- Insert tracks
-- Insert multiple tracks for each album in the Tracks table
INSERT IGNORE INTO `VinylsShop`.`Tracks` (`id_track`, `title`, `duration`)
VALUES
-- Tracks for "The Black Parade" by My Chemical Romance (2006)
(1, 'Welcome to the Black Parade', '5:11'),
(2, 'I Don’t Love You', '3:59'),
(3, 'Cancer', '2:23'),
(4, 'Famous Last Words', '4:59'),
(5, 'Dead!', '3:15'),

-- Tracks for "Dont Smile at Me" by Billie Eilish (2017)
(6, 'Copycat', '3:14'),
(7, 'Ocean Eyes', '3:20'),
(8, 'Idontwannabeyouanymore', '3:23'),
(9, 'My Boy', '2:51'),
(10, 'Watch', '2:57'),

-- Tracks for "When We All Fall Asleep, Where Do We Go?" by Billie Eilish (2019)
(11, 'Bad Guy', '3:14'),
(12, 'Bury a Friend', '3:13'),
(13, 'When the Party’s Over', '3:16'),
(14, 'All the Good Girls Go to Hell', '2:48'),
(15, 'You Should See Me in a Crown', '3:00'),

-- Tracks for "Fever Dream" by Palaye Royale (2022)
(16, 'Fever Dream', '4:21'),
(17, 'No Love in LA', '3:39'),
(18, 'Broken', '3:10'),
(19, 'Paranoid', '3:31'),
(20, 'Eternal Life', '3:18'),

-- Tracks for "Post Human: Survival Horror" by Bring Me The Horizon (2020)
(21, 'Parasite Eve', '4:51'),
(22, 'Teardrops', '3:35'),
(23, 'Dear Diary,', '2:45'),
(24, 'Obey', '3:41'),
(25, 'Kingslayer', '4:09'),

-- Tracks for "Sempiternal" by Bring Me The Horizon (2013)
(26, 'Shadow Moses', '3:46'),
(27, 'Sleepwalking', '3:50'),
(28, 'Can You Feel My Heart', '3:48'),
(29, 'Go to Hell, for Heaven’s Sake', '4:03'),
(30, 'Empire (Let Them Sing)', '3:45'),

-- Tracks for "Undertale Soundtrack" by Toby Fox (2015)
(31, 'Undertale', '3:45'),
(32, 'His Theme', '2:05'),
(33, 'Megalovania', '2:36'),
(34, 'Hopes and Dreams', '3:00'),
(35, 'Asgore', '3:27');


-- Insert tracks in album
-- Associate tracks with corresponding albums in the AlbumsTracks table
INSERT IGNORE INTO `VinylsShop`.`AlbumsTracks` (`id_album`, `id_track`)
VALUES
-- The Black Parade (2006) by My Chemical Romance
(1, 1), -- Welcome to the Black Parade
(1, 2), -- I Don’t Love You
(1, 3), -- Cancer
(1, 4), -- Famous Last Words
(1, 5), -- Dead!

-- Dont Smile at Me (2017) by Billie Eilish
(2, 6), -- Copycat
(2, 7), -- Ocean Eyes
(2, 8), -- Idontwannabeyouanymore
(2, 9), -- My Boy
(2, 10), -- Watch

-- When We All Fall Asleep, Where Do We Go? (2019) by Billie Eilish
(3, 11), -- Bad Guy
(3, 12), -- Bury a Friend
(3, 13), -- When the Party’s Over
(3, 14), -- All the Good Girls Go to Hell
(3, 15), -- You Should See Me in a Crown

-- Fever Dream (2022) by Palaye Royale
(5, 16), -- Fever Dream
(5, 17), -- No Love in LA
(5, 18), -- Broken
(5, 19), -- Paranoid
(5, 20), -- Eternal Life

-- Post Human: Survival Horror (2020) by Bring Me The Horizon
(6, 21), -- Parasite Eve
(6, 22), -- Teardrops
(6, 23), -- Dear Diary,
(6, 24), -- Obey
(6, 25), -- Kingslayer

-- Sempiternal (2013) by Bring Me The Horizon
(7, 26), -- Shadow Moses
(7, 27), -- Sleepwalking
(7, 28), -- Can You Feel My Heart
(7, 29), -- Go to Hell, for Heaven’s Sake
(7, 30), -- Empire (Let Them Sing)

-- Undertale Soundtrack (2015) by Toby Fox
(8, 31), -- Undertale
(8, 32), -- His Theme
(8, 33), -- Megalovania
(8, 34), -- Hopes and Dreams
(8, 35); -- Asgore

-- Insert vinyls
INSERT IGNORE INTO `VinylsShop`.`Vinyls` (`id_vinyl`, `cost`, `rpm`, `inch`, `quantity`, `type`, `id_album`)
VALUES
(1, 20.00, 33, 12, 10, 'LP', 1),
(2, 20.00, 33, 12, 10, 'LP', 2),
(3, 20.00, 33, 12, 10, 'LP', 3),
(4, 20.00, 33, 12, 10, 'LP', 4),
(5, 20.00, 33, 12, 10, 'LP', 5),
(6, 20.00, 33, 12, 10, 'LP', 6),
(7, 20.00, 33, 12, 10, 'LP', 7),
(8, 20.00, 33, 12, 10, 'LP', 8);

-- Insert Coupons
INSERT IGNORE INTO `VinylsShop`.`Coupons` (`discount_code`, `percentage`, `valid_from`, `valid_until`)
VALUES
('HALLOWEEN10', 0.1, '2024-10-01', '2024-10-31'),
('BLACKFRIDAY70', 0.7, '2024-11-20', '2024-11-30'),
('CHRISTMAS20', 0.2, '2024-12-01', '2025-01-31'),
('LOVE100', 1, '2025-02-01', '2025-02-14');

-- USER 2 
-- Insert addresses
INSERT IGNORE INTO `VinylsShop`.`Addresses` (`name`, `city`, `postal_code`, `street_number`, `id_user`)
VALUES
('Home', 'Milan', '20100', 'Via Roma 1', 2),
('Work', 'Milan', '20100', 'Via Milano 2', 2);

-- Insert cards
INSERT IGNORE INTO `VinylsShop`.`Cards` (`card_number`, `cvc`, `expiration_date`, `id_user`)
VALUES
('1234567812345678', '123', '2027-12-31', 2),
('8765432187654321', '321', '2027-12-31', 2);

INSERT IGNORE INTO `VinylsShop`.`UserPreferences` (`id_user`, `default_card`, `default_address`)
VALUES
(2, 2, 1);

-- Insert carts
INSERT IGNORE INTO `VinylsShop`.`Carts` (`id_vinyl`, `id_user`, `quantity`)
VALUES
(5, 2, 10),
(6, 2, 3);

-- Insert orders
INSERT IGNORE INTO `VinylsShop`.`Orders` (`order_date`, `total_cost`, `id_card`, `order_status`, `discount_code`, `id_user`)
VALUES
('2024-10-29', 74.00, 1, 'Completed', 'HALLOWEEN10', 2),
('2024-11-21', 34.00, NULL, 'Completed', 'BLACKFRIDAY70', 2),
('2024-12-06', 85.00, 2, 'Paid', 'CHRISTMAS20', 2);


-- Insert Checkouts
INSERT IGNORE INTO `VinylsShop`.`Checkouts` (`id_order`, `id_vinyl`, `quantity`)
VALUES
(1, 1, 1),
(1, 2, 2),
(2, 3, 4),
(3, 4, 2),
(3, 1, 3);

-- Insert shipments
INSERT IGNORE INTO `VinylsShop`.`Shipments` (`tracking_number`, `shipment_date`, `delivery_date`, `shipment_status`, `carrier`, `notes`, `cost`, `id_order`, `id_address`)
VALUES
('1234567890', '2024-10-29', '2024-11-02', 'Delivered', 'UPS', 'attenti al lupo', 20.00, 1, 1),
('0987654321', '2024-11-21', '2024-11-24', 'Delivered', 'DHL', 'da consegnare sul pianerottolo', 10.00, 2, 1),
('1357924680', '2024-12-06', NULL, 'In transit', 'FedEx', NULL, 5.00, 3, 1);