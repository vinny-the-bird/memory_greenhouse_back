<?php
class PaperEntity {
    public $id_paper;
    public $paper_type;
    public $title;
    public $content;
    public $overview;
    public $is_outdated;
    public $parent_id;
    public $creation_date;
    public $created_by;
    public $edit_date;
    public $edited_by;

    public $comments = [];

    public function __construct(array $data = []) {
        $this->id_paper = $data['id_paper'] ?? null;
        $this->paper_type = $data['paper_type'] ?? 'note';
        $this->title = $data['title'] ?? null;
        $this->content = $data['content'] ?? '';
        $this->overview = $data['overview'] ?? null;
        $this->is_outdated = $data['is_outdated'] ?? 0;
        $this->parent_id = $data['parent_id'] ?? null;
        $this->creation_date = $data['creation_date'];
        $this->created_by = $data['created_by'];
        $this->edit_date = $data['edit_date'] ?? null;
        $this->edited_by = $data['edited_by'] ?? null;
    }
}

?>