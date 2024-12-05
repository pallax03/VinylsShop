-- Insert albums
INSERT IGNORE INTO `VinylsShop`.`Albums` (`id_album`, `title`, `genre`, `cover_img`, `release_date`)
VALUES
(1, 'The Black Parade', 'Rock', 'blackparade.webp', '2006-10-23'),
(2, 'Dont Smile at Me', 'Pop', 'dontsmileatme.webp', '2017-08-11'),
(3, 'When We All Fall Asleep, Where Do We Go?', 'Pop', 'fallasleep.webp', '2019-03-29'),
(4, 'Interscope', 'Various', 'interscope.webp', '2020-01-01'),
(5, 'Palaye Royale', 'Rock', 'palayeroyale.webp', '2016-06-24'),
(6, 'Post Human: Survival Horror', 'Rock', 'posthuman.webp', '2020-10-30'),
(7, 'Sempiternal', 'Metal', 'sempiternal.webp', '2013-04-01'),
(8, 'Undertale Soundtrack', 'Soundtrack', 'undertale.webp', '2015-09-15');

INSERT IGNORE INTO `VinylsShop`.`Tracks` (`id_track`, `title`, `duration`)
VALUES
(1, 'The End.', '00:01:52'),
(2, 'Dead!', '00:03:15'),
(3, 'This Is How I Disappear', '00:03:59'),
(4, 'The Sharpest Lives', '00:03:20'),
(5, 'Welcome to the Black Parade', '00:05:11'),
(6, 'I Dont Love You', '00:03:58'),
(7, 'House of Wolves', '00:03:04'),
(8, 'Cancer', '00:02:22'),
(9, 'Mama', '00:04:39'),
(10, 'Sleep', '00:04:43'),
(11, 'Teenagers', '00:02:41'),
(12, 'Disenchanted', '00:04:55'),
(13, 'Famous Last Words', '00:04:59'),
(14, 'Blood', '00:02:53'),
(15, 'Ocean Eyes', '00:03:20'),
(16, 'Bellyache', '00:03:00'),
(17, 'Copycat', '00:03:14'),
(18, 'Idontwannabeyouanymore', '00:03)24'),
-- The Black Parade
(19, 'The Ghost of You', '00:03:22'),
(20, 'Helena', '00:03:59'),

-- Dont Smile at Me
(21, 'Watch', '00:02:57'),
(22, 'My Boy', '00:02:50'),
(23, 'Party Favor', '00:03:24'),

-- When We All Fall Asleep, Where Do We Go?
(24, 'Bad Guy', '00:03:14'),
(25, 'Xanny', '00:04:03'),
(26, 'All the Good Girls Go to Hell', '00:02:48'),
(27, 'Bury a Friend', '00:03:13'),
(28, 'Ilomilo', '00:02:36'),

-- Interscope
(29, 'Song for Zula', '00:05:58'),
(30, 'The Knife', '00:04:20'),

-- Palaye Royale
(31, 'Mr. Doctor Man', '00:03:35'),
(32, 'Get Higher', '00:03:15'),
(33, 'Dying in a Hot Tub', '00:03:21'),

-- Post Human: Survival Horror
(34, 'Dear Diary', '00:02:44'),
(35, 'Parasite Eve', '00:04:52'),
(36, 'Teardrops', '00:03:35'),

-- Sempiternal
(37, 'Can You Feel My Heart', '00:03:48'),
(38, 'Sleepwalking', '00:03:50'),
(39, 'Go to Hell, for Heavens Sake', '00:04:02'),

-- Undertale Soundtrack
(40, 'Fallen Down', '00:02:01'),
(41, 'Megalovania', '00:02:36'),
(42, 'Hopes and Dreams', '00:03:03');

-- Insert inside_album entries to associate tracks with albums
INSERT IGNORE INTO `VinylsShop`.`inside_album` (`id_album`, `id_track`)
VALUES 
-- The Black Parade
(1, 1),  -- The End.
(1, 2),  -- Dead!
(1, 3),  -- This Is How I Disappear
(1, 4),  -- The Sharpest Lives
(1, 5),  -- Welcome to the Black Parade
(1, 6),  -- I Dont Love You
(1, 7),  -- House of Wolves
(1, 8),  -- Cancer
(1, 9),  -- Mama
(1, 10), -- Sleep
(1, 11), -- Teenagers
(1, 12), -- Disenchanted
(1, 13), -- Famous Last Words
(1, 14), -- Blood
(1, 19), -- The Ghost of You
(1, 20), -- Helena

-- Dont Smile at Me
(2, 15), -- Ocean Eyes
(2, 16), -- Bellyache
(2, 17), -- Copycat
(2, 18), -- Idontwannabeyouanymore
(2, 21), -- Watch
(2, 22), -- My Boy
(2, 23), -- Party Favor

-- When We All Fall Asleep, Where Do We Go?
(3, 24), -- Bad Guy
(3, 25), -- Xanny
(3, 26), -- All the Good Girls Go to Hell
(3, 27), -- Bury a Friend
(3, 28), -- Ilomilo

-- Interscope
(4, 29), -- Song for Zula
(4, 30), -- The Knife

-- Palaye Royale
(5, 31), -- Mr. Doctor Man
(5, 32), -- Get Higher
(5, 33), -- Dying in a Hot Tub

-- Post Human: Survival Horror
(6, 34), -- Dear Diary
(6, 35), -- Parasite Eve
(6, 36), -- Teardrops

-- Sempiternal
(7, 37), -- Can You Feel My Heart
(7, 38), -- Sleepwalking
(7, 39), -- Go to Hell, for Heaven's Sake

-- Undertale Soundtrack
(8, 40), -- Fallen Down
(8, 41), -- Megalovania
(8, 42); -- Hopes and Dreams

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

-- Insert cart items for user 1 "alexmaz03@hotmail.it"
INSERT IGNORE INTO `VinylsShop`.`Carts` (`id_vinyl`, `id_user`, `quantity`)
VALUES
(5, 2, 1),
(6, 2, 1);