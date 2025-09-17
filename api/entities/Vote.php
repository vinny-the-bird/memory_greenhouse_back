<?php

class VoteEntity {
    public $id_user;
    public $id_paper;
    public $vote;

    public function __construct($id_user = '', $id_paper = '', $vote='') {
        $this->id_user = $id_user;
        $this->id_paper = $id_paper;
        $this->vote = $vote;
    }
}

?>