<?php
class PaperEntity {
    public $id;
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

    public function __construct(array $data = []) {
        $this->id = null;
        $this->paper_type = $data['paper_type'] ?? 'note';
        $this->content = $data['content'] ?? '';
        $this->overview = $data['overview'] ?? null;
        $this->is_outdated = $data['is_outdated'] ?? 0;
        $this->creation_date = $data['creation_date'];
        $this->created_by = $data['created_by'];

        if ($this->paper_type === 'note') {
            $this->parent_id = null;
            $this->title = $data['title'];
        } else {
            $this->parent_id = $data['parent_id'];
            $this->title = null;
        }

        $this->edit_date = $data['edit_date'] ?? null;
        $this->edited_by = $data['edited_by'] ?? null;
    }
}

?>