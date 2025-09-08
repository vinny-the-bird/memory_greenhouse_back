<?php

class TagEntity {
    public $id_tag;
    public $name;
    public $category;
    //TODO: change id to id_tag, global harmonisation
    public function __construct($id_tag = null, $name = '', $category='') {
        $this->id_tag = $id_tag;
        $this->name = $name;
        $this->category = $category;
    }
}

?>