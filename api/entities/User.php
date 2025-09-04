<?php

class UserEntity {
    public $id_user;
    public $username;
    public $first_name;
    public $last_name;
    public $password;

    public function __construct(
        $id_user = '', 
        $username = '', 
        $first_name ='',
        $last_name = '',
        $password = ''
        ) 
        {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->password = $password;
    }
}

?>