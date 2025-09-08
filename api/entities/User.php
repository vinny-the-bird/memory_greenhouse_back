<?php

class UserEntity {
    public $id_user;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $id_tag;

    public function __construct(
        $id_user = null, 
        $username = '', 
        $first_name ='',
        $last_name = '',
        $password = '',
        $id_tag = null
        ) 
        {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->password = $password;
        $this->id_tag = $id_tag;
    }
}

?>