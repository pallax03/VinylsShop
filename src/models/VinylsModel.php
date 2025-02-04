<?php
final class VinylsModel {

    private $notification_model = null;

    public function __construct() {
        require_once MODELS . 'NotificationModel.php';
        $this->notification_model = new NotificationModel();
    }

    private function notificateVinylQuantity($id_vinyl) {
        $vinyl = $this->getVinyl($id_vinyl);
        if ($vinyl['stock'] <= 0) {
            $this->notification_model->broadcastFor(
                Database::getInstance()->executeResults("SELECT id_user FROM users WHERE su = 1"),
                "Vinyl " . $vinyl['title'] . " is out of stock!",
                "/vinyl?id=" . $vinyl['id_vinyl']
            );
        }
    }

    private function broadcastCartVinyl($id_vinyl) {
        $this->notification_model->broadcastFor(
            Database::getInstance()->executeResults(
                "SELECT id_user FROM carts WHERE id_vinyl = ?",
                'i',
                $id_vinyl
            ),
            "A vinyl in your cart has been updated.",
            "/vinyl?id=" . $id_vinyl
        );
    }

    private function broadcastVinyl($id_vinyl) {
        $this->notification_model->broadcast(
            "A new Vinyl landed here!",
            "/vinyl?id=$id_vinyl"
        );
    }

    private function applyFilters($query, $filters = []) {
        $filtersMap = [
            "id_vinyl" => ["query" => fn($value) => " AND v.id_vinyl = ? ", "type" => 'i'],
            "stock" => ["query" => fn($value) => " AND v.stock = ? ", "type" => 'i'],
            "id_album" => ["query" => fn($value) => " AND a.id_album = ? ", "type" => 'i'],
            "title" => ["query" => fn($value) => " AND a.title LIKE ?", "type" => 's', "value" => fn($value) => "%$value%"],
            "genre" => ["query" => fn($value) => " AND a.genre LIKE ?", "type" => 's', "value" => fn($value) => "%$value%"],
            "id_artist" => ["query" => fn($value) => " AND ar.id_artist = ? ", "type" => 'i'],
            "artist_name" => ["query" => fn($value) => " AND ar.name LIKE ?", "type" => 's', "value" => fn($value) => "%$value%"],
            "id_track" => ["query" => fn($value) => " AND ta.id_track = ? ", "type" => 'i'],
            "track_title" => ["query" => fn($value) => " AND t.title LIKE ?", "type" => 's', "value" => fn($value) => "%$value%"]
        ];

        $types = 'i';
        $values = [1];
        foreach ($filters as $key => $value) {
            $query .= $filtersMap[$key]["query"]($value);
            $types .= $filtersMap[$key]["type"];
            $values[] = isset($filtersMap[$key]["value"]) ? $filtersMap[$key]["value"]($value) : $value;
        }
        
        return Database::getInstance()->executeResults($query. ' GROUP BY a.id_album;', $types, ...$values);
    }


    /**
     * get the vinyl details from the database
     * 
     * @param int $id_vinyl the id of the vinyl to get the details of
     * 
     * @return array containing the details of the vinyl with tracks
     */
    public function getVinyl($id_vinyl) {
        $vinyl = Database::getInstance()->executeResults(
            "SELECT 
                v.id_vinyl,
                v.stock,
                v.cost,
                v.rpm,
                v.inch,
                v.type,
                a.title,
                a.genre,
                a.cover,
                ar.name AS artist_name
                FROM vinyls v 
                JOIN albums a ON v.id_vinyl = a.id_album
                JOIN artists ar ON a.id_artist = ar.id_artist
                WHERE id_vinyl = ?",
            'i',
            $id_vinyl
        );
        if(!empty($vinyl)) {
            $vinyl = $vinyl[0];
            $vinyl['tracks'] = $this->getTracks($vinyl['id_album']);
        }
        return $vinyl; 
    }


    public function getSuggested($id) {
        $selected_vinyl = $this->getVinyl($id);
        return Database::getInstance()->executeResults(
            "SELECT 
                v.id_vinyl,
                v.stock,
                v.cost,
                v.rpm,
                v.inch,
                v.type,
                a.title,
                a.genre,
                a.cover,
                ar.name AS artist_name
                FROM vinyls v
                JOIN albums a ON v.id_album = a.id_album
                JOIN artists ar ON ar.id_artist = a.id_artist
                WHERE (a.genre = ? OR ar.name = ?)
                AND v.id_vinyl <> ?
                LIMIT 6", 
            "ssi", 
            $selected_vinyl["genre"], 
            $selected_vinyl["artist_name"],
            $id
        );
    }

    
    /**
     * Get the vinyls.
     *
     * @param array $filter the qury filter of the artist params to get the albums
     * filters can be:
     * - id_album
     * - title
     * - genre
     * - id_artist
     * - artist_name
     * - id_track
     * - track_title
     * 
     * @return array containing the albums 
     */
    public function getVinyls($filters) {
        Database::getInstance()->setHandler(Database::defaultHandler());
        $vinyls = $this->applyFilters(
            "SELECT
                    GROUP_CONCAT(DISTINCT v.id_vinyl ORDER BY v.id_vinyl ASC SEPARATOR ', ') AS id_vinyl, 
                    GROUP_CONCAT(DISTINCT v.cost ORDER BY v.cost ASC SEPARATOR ', ') AS vinyl_cost, 
                    GROUP_CONCAT(DISTINCT v.stock ORDER BY v.stock ASC SEPARATOR ', ') AS vinyl_stock, 
                    a.id_album, 
                    a.title, 
                    a.release_date, 
                    a.genre, 
                    a.cover, 
                    ar.id_artist, 
                    ar.name AS artist_name, 
                    GROUP_CONCAT(DISTINCT ta.id_track ORDER BY ta.id_track ASC SEPARATOR ', ') AS track_ids,
                    GROUP_CONCAT(DISTINCT t.title ORDER BY t.title ASC SEPARATOR ', ') AS track_titles
                FROM vinyls v
                JOIN albums a ON v.id_album = a.id_album 
                JOIN artists ar ON a.id_artist = ar.id_artist
                JOIN albumstracks ta ON a.id_album = ta.id_album
                JOIN tracks t ON t.id_track = ta.id_track
                WHERE 1 = ?", 
            $filters
        );
        return $vinyls;
    }


    /**
     * Get the albums of an artist.
     * @param array $filter the qury filter of the artist params to get the albums
     * filters can be:
     * - id_album
     * - title
     * - genre
     * - id_artist
     * - artist_name
     * - id_track
     * - track_title
     * 
     * @return array containing the albums 
     */
    public function getAlbums($filters) {
        return $this->applyFilters(
            "SELECT 
                    a.id_album,
                    a.title,
                    a.release_date,
                    a.genre,
                    a.cover,
                    ar.id_artist,
                    ar.name AS artist_name,
                    GROUP_CONCAT(DISTINCT ta.id_track ORDER BY ta.id_track ASC SEPARATOR ', ') AS track_ids,
                    GROUP_CONCAT(DISTINCT t.title ORDER BY t.title ASC SEPARATOR ', ') AS track_titles
                FROM albums a 
                JOIN artists ar ON a.id_artist = ar.id_artist
                JOIN albumstracks ta ON a.id_album = ta.id_album
                JOIN tracks t ON t.id_track = ta.id_track
                WHERE 1 = ?", 
            $filters
        );
    }

    /**
     * Get the tracks of an album.
     * @param int $id_album of the album to get the tracks of
     * 
     * @return array containing the tracks
     */
    public function getTracks($id_album) {
        return Database::getInstance()->executeResults(
            "SELECT 
                t.id_track,
                t.title,
                t.duration
                FROM tracks t
                JOIN albumstracks ta ON t.id_track = ta.id_track
                WHERE ta.id_album = ?",
            'i',
            $id_album
        );
    }

    /**
     * Add a track to the database.
     * @param int $id_album of the album to add the track to
     * @param string $title of the track
     * @param string $duration of the track
     * 
     * @return bool true if the track was added, false otherwise
     */
    public function addTrack($id_album, $title, $duration) {
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `tracks` (title, duration) VALUES (?, ?)",
            'ss',
            $title, $duration
        ) && Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO `albumstracks` (id_album, id_track) VALUES (?, ?)",
            'ii',
            $id_album, Database::getInstance()->getLastId()
        );
    }


    /**
     * Check if the artist exists in the database.
     * @param int $artist_id of the artist to check
     * 
     * @return bool true if the artist exists, false otherwise
     */
    private function checkArtist($artist_id) {
        return !empty(Database::getInstance()->executeResults(
            "SELECT * FROM artists WHERE id_artist = ?",
            'i',
            $artist_id
        ));
    }


    /**
     * Create an artist in the database.
     * @param string $name of the artist
     * 
     * @return bool true if the artist was created, false otherwise
     */ 
    public function createArtist($name) {
        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO artists (name) VALUES (?)",
            's',
            $name
        );
    }


    /**
     * Check if the album exists in the database.
     * @param int $album_id of the album to check
     * 
     * @return bool true if the album exists, false otherwise
     */
    private function checkAlbum($album_id) {
        return !empty(Database::getInstance()->executeResults(
            "SELECT * FROM albums WHERE id_album = ?",
            'i',
            $album_id
        ));
    }


    /**
     * Create an album in the database.
     * @param string $title of the album
     * @param string $release_date of the album
     * @param string $genre of the album
     * @param array $artist of the album
     * 
     * @return bool true if the album was created, false otherwise
     */
    public function createAlbum($title, $release_date, $genre, $artist, $tracks) {
        // check if the artist already exists if not add it to the database

        if (!isset($artist['id_artist'])) {
            $artist['id_artist'] = '';
        }

        if (empty($artist['id_artist']) || !$this->checkArtist($artist['id_artist'])) {
            $artist = $this->createArtist($artist["name"]);
            if (!$artist) {
                return false;
            }
            $artist = Database::getInstance()->getLastId();
        } else {
            $artist = $artist['id_artist'];
        }

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES['cover']['tmp_name'];
            $name = $_FILES['cover']['name']; 
            $destinationDir = '/var/www/html/resources/img/albums/';
            $destination = $destinationDir . $name;
        
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0775, true);
            }

            if (!move_uploaded_file($tmpPath, $destination)) {
                return false;
            }
        } else {
            return false;
        }

        
        $result = Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO albums (title, release_date, genre, cover, id_artist)
                VALUES (?, ?, ?, ?, ?)",
            'ssssi',
            $title, $release_date, $genre, $name, $artist
        );
        
        if ($result) {
            $last_id = Database::getInstance()->getLastId();    
            foreach ($tracks as $track) {
                $this->addTrack($last_id, $track['title'], $track['duration']);
            }
        }
        return $result ? $last_id : false;
    }


    /**
     * Add or update a vinyl to the database.
     * 
     * @param int $id_vinyl of the vinyl to update (null if adding)
     * @param array $album of the vinyl
     * @param array $artist of the vinyl's album
     * @param float $cost of the vinyl
     * @param int $stock of the vinyl
     * 
     * @return bool true if the vinyl was added, false otherwise
     */
    public function addVinyl($cost, $rpm, $inch, $type, $stock, $album, $id_vinyl = null) {
        // check if the album already exists if not add it to the database
        if($album ) {
            if(!isset($album['id_album']) && empty($album['id_album'])) {
                $album = $this->createAlbum($album["title"], $album["release_date"], $album["genre"], $album["artist"], $album['tracks']);
                if(!$album) {
                    return false;
                }
            } else {
                if(!$this->checkAlbum($album["id_album"])) {
                    return false;
                }
            }
        }
        
        $album = isset($album["id_album"]) ? $album['album_id'] : $album;
        if ($id_vinyl) {
            return $this->updateVinyl($id_vinyl, $cost, $rpm, $inch, $type, $stock, $album);
        }
        
        $result = Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO vinyls (`cost`, `rpm`, `inch`, `type`, `stock`, `id_album`)
                VALUES (?, ?, ?, ?, ?, ?)",
            'diisii',
            $cost, $rpm, $inch, $type, $stock, $album
        );

        if ($result) {
            $this->broadcastVinyl(Database::getInstance()->getLastId());
        }
        return $result;
    }


    /**
     * Update a vinyl in the database.
     * @param int $id_vinyl of the vinyl to update
     * @param float $cost of the vinyl
     * @param int $rpm of the vinyl
     * @param int $inch of the vinyl
     * @param string $type of the vinyl
     * @param int $stock of the vinyl
     * 
     * @return bool true if the vinyl was updated, false otherwise
     */
    public function updateVinyl($id_vinyl, $cost = null, $rpm = null, $inch = null, $type = null, $stock = null, $id_album = null) {
        $fields = [
            'cost' => ['type' => 'd', 'value' => $cost],
            'rpm' => ['type' => 'i', 'value' => $rpm],
            'inch' => ['type' => 'i', 'value' => $inch],
            'type' => ['type' => 's', 'value' => $type],
            'stock' => ['type' => 'i', 'value' => $stock],
            'id_album' => ['type' => 'i', 'value' => $id_album]
        ];

        $setClauses = [];
        $types = '';
        $values = [];

        foreach ($fields as $field => $data) {
            if ($data['value'] !== null) {
                $setClauses[] = "$field = ?";
                $types .= $data['type'];
                $values[] = $data['value'];
            }
        }

        if (empty($setClauses)) {
            return false; // No columns to update
        }

        $query = "UPDATE vinyls SET " . implode(', ', $setClauses) . " WHERE id_vinyl = ?";
        $types .= 'i';
        $values[] = $id_vinyl;

        $result = Database::getInstance()->executeQueryAffectRows($query, $types, ...$values);

        if ($result) {
            $this->broadcastCartVinyl($id_vinyl);
            $this->notificateVinylQuantity($id_vinyl);
        }

        return $result;
    }


    /**
     * Get the artists from the database.
     * 
     * @return array containing the artists
     */
    public function getArtists() {
        $query = "SELECT
            a.id_artist,
            a.name
            FROM artists a";
        $result['artists'] =  Database::getInstance()->executeResults($query);
        return $result;
    }


    /**
     * Delete a vinyl from the database.
     * @param int $id_vinyl of the vinyl to delete
     * 
     * @return bool true if the vinyl was deleted, false otherwise
     */
    function deleteVinyl($id_vinyl) {
        $result = Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM vinyls WHERE id_vinyl = ?",
            'i',
            $id_vinyl
        );

        if(!$result) {
            $result = Database::getInstance()->executeQueryAffectRows(
                "UPDATE vinyls SET is_deleted = 1 WHERE id_vinyl = ?",
                'i',
                $id_vinyl
            );
        }

        return $result;
    }
}