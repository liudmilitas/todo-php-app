<?php

class Todo
{
    public $id;
    public $user_id;
    public $title;
    public $date;
    


    public function __construct($title, $date, $user_id, $id = 0)
    {
        if ($id > 0) {
            $this->id = $id;
        }

        $this->user_id = $user_id;

        $this->title = $title;

        $this->date = $date;
        
    }

    public function __toString()
    {
        return "{$this->title} ({$this->date})";
    }
}
