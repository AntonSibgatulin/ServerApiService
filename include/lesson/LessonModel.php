<?php




class LessonModel extends UserExt
{

    public $lessons = null;


    public function __construct(array $lessons)
    {
        $this->lessons = $lessons;
    }

}



?>