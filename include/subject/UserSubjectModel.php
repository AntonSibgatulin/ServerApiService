<?php

class UserSubjectModel extends UserExt
{

    public $id = null, $userId, $id_subject, $price_on_hour, $experience,
        $information, $online, $intramural, $block, $oplata;




    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->userId = $param['userId'];
        $this->id_subject = intval($param['id_subject']);
        $this->price_on_hour = intval($param['price_on_hour']);
        $this->experience = intval($param['experience']);
        $this->information = $param['information'];
        $this->online = $param['online'];
        $this->intramural = $param['intramural'];
        $this->oplata = intval($param['oplata']);
        $this->block = $param['block'];
    }



    public function __toString()
    {
        return "[USERSUBJECT]: id " . $this->id . " " . $this->information;
    }



    public function toArray()
    {
        $param = array();
        $param['id'] = $this->id;
        $param['userId'] = $this->userId;
        $param['id_subject'] = $this->id_subject;
        $param['price_on_hour'] = $this->price_on_hour;
        $param['experience'] = $this->experience;
        $param['information'] = $this->information;
        $param['online'] = $this->online;
        $param['intramural'] = $this->intramural;
        $param['oplata'] = $this->oplata;
        $param['block'] = $this->block;
        return $param;
    }


    public function toQuery($mysqli)
    {
        $id = "NULL";
        if ($this->id != null) {
            $id = $this->id;
        }
        $information = $mysqli->real_escape_string($this->information);


        return "({$id},{$this->userId},{$this->id_subject},{$this->price_on_hour},{$this->experience},'{$information}',{$this->online},{$this->intramural},{$this->oplata},0)";
    }
}
