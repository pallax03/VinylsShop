<?php
final class CartModel {

    private $vinyls_model = null;

    public function __construct() {
        require_once MODELS . 'VinylsModel.php';
        $this->vinyls_model = new VinylsModel();
    }

    /**
     * Get the cart of the user.
     * sync the session cart with the database.
     * of the logged user.
     *
     * @param int $id_user
     * @return array the cart of the user.
     */
    public function getCart($id_user = null) {
        // session cart. <--> database cart.
        // so sync and return it.
        if (Session::isLogged()) {
            $this->syncCart();
        }
        $cart = Session::get('Cart');
        $cart['total'] = $this->getTotal();
        return $cart;
    }

    /**
     * Set the cart of the user.
     * store in session, and try to sync.
     *
     * @param int $id_vinyl
     * @param int $quantity
     * @return bool true if the cart is set, false otherwise.
     */
    public function setCart($id_vinyl, $quantity) {
        // maybe check if the vinyl exists and can be shopped.
        if (!($id_vinyl && $quantity)) {
            return false;
        }
        Session::setToCart($this->vinyls_model->getVinyl($id_vinyl), $quantity);
        $this->syncCart();
        return true;
    }

    /**
     * Check if the vinyls are still available.
     * 
     * @param int $id_vinyl the id of the vinyl.
     *
     * @return bool true if the vinyl is still available, false otherwise.
     */
    private function checkVinyl($id_vinyl) {
        return $this->vinyls_model->getVinyl($id_vinyl)['quantity'] > 0;
    }


    private function syncSessionAndDB() {
        // get the cart from the database.
        $cart = Database::getInstance()->executeResults(
            "SELECT 
                v.id_vinyl,
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
                JOIN artists ar ON ar.id_artist = a.id_artist
                WHERE id_vinyl IN (?)",
            's',
            implode(',', array_keys(Session::get('Cart')))
        );

        // check if the vinyls are still available.
        
    }

    /**
     * Sync the session cart with the database.
     * Checking:
     * - if the user is logged.
     * - if the vinyl is still available.
     * - if the vinyl is still in the cart.
     *
     * @return bool true if the cart is synced, false otherwise.
     */
    public function syncCart() {
        if (!Session::isLogged()) {
            return false;
        }

        // if is empty, do not sync.
        if (Session::get('Cart')) {
            return true;
        }

        // get the cart from the database.
        $cart = Database::getInstance()->executeResults(
            "SELECT 
                v.id_vinyl,
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
                JOIN artists ar ON ar.id_artist = a.id_artist
                WHERE id_vinyl IN (?)",
            's',
            implode(',', array_keys(Session::get('Cart')))
        );
        return $cart;

        // check if the vinyls are still available.
        // if not, remove them from the cart.
        // foreach ($cart as $vinyl) {
        //     if (!$this->checkVinyl($vinyl['id_vinyl'])) {
        //         Session::removeFromCart($vinyl['id_vinyl']);
        //     }
        // }

    }

    public function getTotal() {
        return array_reduce(Session::get('Cart'), fn($total, $vinyl) => $total + $vinyl['price'] * $vinyl['quantity'], 0);
    }

    
}
