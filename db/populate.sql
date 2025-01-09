-- Insert artits
INSERT IGNORE INTO `vinylsshop`.`artists` (`id_artist`, `name`)
VALUES 
(1, 'Various Artists'),
(2, 'My Chemical Romance'),
(3, 'Billie Eilish'),
(4, 'Palaye Royale'),
(5, 'Bring Me The Horizon'),
(6, 'Toby Fox'),
(7, 'Pinguini Tattici Nucleari');

-- Insert albums
INSERT IGNORE INTO `vinylsshop`.`albums` (`id_album`, `title`, `genre`, `cover`, `release_date`, `id_artist`)
VALUES
(1, 'The Black Parade', 'Rock', 'blackparade.webp', '2006-10-23', 2),
(2, 'Dont Smile at Me', 'Pop', 'dontsmileatme.webp', '2017-08-11', 3),
(3, 'When We All Fall Asleep, Where Do We Go?', 'Pop', 'fallasleep.webp', '2019-03-29', 3),
(4, 'Hit Me Hard And Soft', 'Pop', 'hitmehardandsoft.webp', '2024-05-17', 3),
(5, 'Fever Dream', 'Rock', 'feverdream.webp', '2022-10-28', 4),
(6, 'Post Human: Survival Horror', 'Rock', 'posthuman.webp', '2020-10-30', 5),
(7, 'Sempiternal', 'Metal', 'sempiternal.webp', '2013-04-01', 5),
(8, 'Undertale Soundtrack', 'Soundtrack', 'undertale.webp', '2015-09-15', 6),
(9, 'Hello World', 'Pop', 'helloworld.webp', '2024-12-06', 7);

-- Insert tracks
-- Insert multiple tracks for each album in the tracks table
INSERT IGNORE INTO `vinylsshop`.`tracks` (`id_track`, `title`, `duration`)
VALUES
-- tracks for "The Black Parade" by My Chemical Romance (2006)
(1, 'Welcome to the Black Parade', '5:11'),
(2, 'I Don’t Love You', '3:59'),
(3, 'Cancer', '2:23'),
(4, 'Famous Last Words', '4:59'),
(5, 'Dead!', '3:15'),

-- tracks for "Dont Smile at Me" by Billie Eilish (2017)
(6, 'Copycat', '3:14'),
(7, 'Ocean Eyes', '3:20'),
(8, 'Idontwannabeyouanymore', '3:23'),
(9, 'My Boy', '2:51'),
(10, 'Watch', '2:57'),

-- tracks for "When We All Fall Asleep, Where Do We Go?" by Billie Eilish (2019)
(11, 'Bad Guy', '3:14'),
(12, 'Bury a Friend', '3:13'),
(13, 'When the Party’s Over', '3:16'),
(14, 'All the Good Girls Go to Hell', '2:48'),
(15, 'You Should See Me in a Crown', '3:00'),

-- tracks for "Fever Dream" by Palaye Royale (2022)
(16, 'Fever Dream', '4:21'),
(17, 'No Love in LA', '3:39'),
(18, 'Broken', '3:10'),
(19, 'Paranoid', '3:31'),
(20, 'Eternal Life', '3:18'),

-- tracks for "Post Human: Survival Horror" by Bring Me The Horizon (2020)
(21, 'Parasite Eve', '4:51'),
(22, 'Teardrops', '3:35'),
(23, 'Dear Diary,', '2:45'),
(24, 'Obey', '3:41'),
(25, 'Kingslayer', '4:09'),

-- tracks for "Sempiternal" by Bring Me The Horizon (2013)
(26, 'Shadow Moses', '3:46'),
(27, 'Sleepwalking', '3:50'),
(28, 'Can You Feel My Heart', '3:48'),
(29, 'Go to Hell, for Heaven’s Sake', '4:03'),
(30, 'Empire (Let Them Sing)', '3:45'),

-- tracks for "Undertale Soundtrack" by Toby Fox (2015)
(31, 'Undertale', '3:45'),
(32, 'His Theme', '2:05'),
(33, 'Megalovania', '2:36'),
(34, 'Hopes and Dreams', '3:00'),
(35, 'Asgore', '3:27'),

-- tracks for "Hello World" by Pinguini Tattici Nucleari (2024)
(36, 'Hello World', '1:31'),
(37, 'Nativi Digitali', '4:04'),
(38, 'Piccola Volpe', '2:52'),
(39, 'Fuck You Vincenzo', '3:13'),
(40, 'Your Dog', '2:53');

-- Insert tracks in album
-- Associate tracks with corresponding albums in the albumstracks table
INSERT IGNORE INTO `vinylsshop`.`albumstracks` (`id_album`, `id_track`)
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
(8, 35), -- Asgore

-- Hello World (2024) by Pinguini Tattici Nucleari
(9, 36), -- Hello World
(9, 37), -- Nativi Digitali
(9, 38), -- Piccola Volpe
(9, 39), -- Fuck You Vincenzo
(9, 40); -- Your Dog

-- Insert vinyls
INSERT IGNORE INTO `vinylsshop`.`vinyls` (`id_vinyl`, `cost`, `rpm`, `inch`, `stock`, `type`, `id_album`)
VALUES
(1, 21.00, 33, 12, 10, 'EP', 1),
(2, 30.00, 33, 12, 10, 'LP', 2),
(3, 23.00, 33, 12, 10, 'EP', 3),
(4, 15.00, 33, 12, 10, 'LP', 4),
(5, 32.00, 33, 12, 10, 'LP', 5),
(6, 40.00, 33, 12, 10, 'LP', 6),
(7, 27.00, 33, 12, 10, 'EP', 7),
(8, 24.00, 33, 12, 10, 'LP', 8),
(9, 44.00, 33, 12, 10, 'EP', 9);

-- Insert coupons
INSERT IGNORE INTO `vinylsshop`.`coupons` (`discount_code`, `percentage`, `valid_from`, `valid_until`)
VALUES
('HALLOWEEN10', 0.1, '2024-10-01', '2025-10-31'),
('BLACKFRIDAY70', 0.7, '2024-11-20', '2025-11-30'),
('CHRISTMAS20', 0.2, '2024-12-01', '2025-01-31'),
('LOVE100', 1, '2024-02-01', '2025-02-14');

-- USER 2 
-- Insert addresses
INSERT IGNORE INTO `vinylsshop`.`addresses` (`name`, `city`, `postal_code`, `street_number`, `id_user`)
VALUES
('Alex Mazzoni', 'Milano', '20100', 'Parco della vittoria 200', 2),
('Samuele Casadei', 'Roma', '20100', 'Via Colazione 32', 2);

-- Insert cards
INSERT IGNORE INTO `vinylsshop`.`cards` (`card_number`, `cvc`, `exp_date`, `id_user`)
VALUES
('1234567812345678', '12/27', '123', 2),
('8765432187654321', '01/26', '321', 2);

INSERT IGNORE INTO `vinylsshop`.`userpreferences` (`id_user`, `default_card`, `default_address`)
VALUES
(2, 2, 1);

-- Insert carts
INSERT IGNORE INTO `vinylsshop`.`carts` (`id_vinyl`, `id_user`, `quantity`)
VALUES
(5, 2, 10),
(6, 2, 3),
(7, 2, 4),
(8, 2, 2),
(9, 2, 1);

-- Insert orders
INSERT IGNORE INTO `vinylsshop`.`orders` (`order_date`, `total_cost`, `id_card`, `discount_code`, `id_user`)
VALUES
('2024-10-29', 72.00, 1, 'HALLOWEEN10', 2),
('2024-11-21', 9.00, NULL, 'BLACKFRIDAY70', 2),
('2024-12-06', 36.00, 2, 'CHRISTMAS20', 2),
('2024-12-31', 29.00, 2, NULL, 2);

-- Insert checkouts
INSERT IGNORE INTO `vinylsshop`.`checkouts` (`id_order`, `id_vinyl`, `quantity`)
VALUES
(1, 1, 1),
(1, 3, 1),
(1, 2, 2),
(2, 3, 4),
(3, 4, 2),
(3, 1, 3),
(4, 8, 1);

-- Insert shipments
INSERT IGNORE INTO `vinylsshop`.`shipments` (`tracking_number`, `shipment_date`, `delivery_date`, `shipment_status`, `courier`, `notes`, `cost`, `id_order`, `id_address`, `id_user`)
VALUES
('1234567890', '2024-12-30', '2024-12-05', '', 'Poste Italiane', 'attenti al lupo', 5.00, 1, 1, 2),
('0987654321', '2025-01-02', '2025-01-09', '', 'Poste Italiane', 'da consegnare sul pianerottolo', 5.00, 2, 1, 2),
('1357924680', '2025-01-04', '2025-01-11', '', 'Poste Italiane', NULL, 5.00, 3, 1, 2),
('2468135790', '2025-01-08', '2025-01-15', '', 'Poste Italiane', 'Rosa rosso ciliegia', 5.00, 4, 2, 2);