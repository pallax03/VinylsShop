<?php
final class CartModel {

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
    }

    /**
     * Set the cart of the user.
     * store in session, and try to sync.
     *
     * @param int $vinyl
     * @param int $quantity
     * @return bool true if the cart is set, false otherwise.
     */
    public function setCart($vinyl, $quantity) {
        // maybe check if the vinyl exists and can be shopped.
        if (!($vinyl && $quantity)) {
            return false;
        }
        
        Session::setToCart($vinyl, $quantity);
        $this->syncCart();
        return true;
    }


    private function syncCart() {
        if (!Session::isLogged()) {
            return false;
        }

        // if is empty, return true.
        if (Session::get('Cart')) {
            return true;
        }
    }


    private function checkVinyls($vinyl, $quantity) {
        // check if the vinyls are still available.
        // if not, remove them from the cart.
        throw new Exception('Not implemented');
    }
}
