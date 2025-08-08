<?php

class TagEntity {
    public $id;
    public $name;
    public $category;

    public function __construct($id = null, $name = '', $category='') {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
    }
}

?>