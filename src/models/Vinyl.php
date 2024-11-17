<?php
class Vinyl {
    private $id;
    private $cost;
    private $quantity;
    private $colors;
    private $type;
    private $img;

    function __construct($id, $cost, $quantity, $colors, $type, $img)
    {
        $this->id = $id;
        $this->cost = $cost;
        /*
         * DB problem: every color-variant of a vinyl should
         * have its own related quantity.
         */
        $this->quantity = $quantity;
        $this->colors = $colors;
        $this->type = $type;
        $this->img = $img;
    }

    public function getId() {
        return $this->id;
    }

    public function getCost() {
        return $this->cost;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getColors() {
        return $this->colors;
    }

    public function getType() {
        return $this->type;
    }

    public function getImg() {
        return $this->img;
    } 
}
?>