<?php


class SubjectModel{

    public $id,$name,$description,$type;


    public function __construct($id,$name,$description,$type)
    {   

        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->type= $type;
        
    }
    


    public function __toString()
    {
        return "[SUBJECT]: id ".$this->id." name ".$this->name." description ".$this->description;
    }



}



?>