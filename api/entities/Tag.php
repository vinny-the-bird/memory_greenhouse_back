<?php

class TagEntity {
    public $id;
    public $name;
    public $category;
    //TODO: change id to id_tag, global harmonisation
    public function __construct($id = null, $name = '', $category='') {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
    }
}

?>