<?php

class PaperEntity {
    public $id;
    public $type;
    public $title;
    public $content;
    public $overview;
    public $is_outdated;
    public $parent_id;
    public $creation_date;
    public $created_by;
    public $edit_date;
    public $edited_by;


    public function __construct(
            $id = null, 
            $type = '',
            $title = '', 
            $content = '',
            $overview = '',
            $is_outdated = '',
            $parent_id = '',
            $creation_date='',
            $created_by='',
            $edit_date='',
            $edited_by=''
            ) 
        {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->content = $content;
        $this->overview = $overview;
        $this->is_outdated = $is_outdated;
        $this->parent_id = $parent_id;
        $this->creation_date = $creation_date;
        $this->created_by = $created_by;
        $this->edit_date = $edit_date;
        $this->edited_by = $edited_by;
    }
}

?>