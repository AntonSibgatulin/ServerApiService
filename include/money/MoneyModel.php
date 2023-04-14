<?php



class MoneyModel
{
    public $id, $userId, $money;
    /*
    public function __construct($id,$userId,$money)
    {

        $this->id = $id;
        $this->userId = $userId;
        $this->money = $money;
                
    }
    */
    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->userId =  $param['userId'];
        $this->money =  $param['money'];
    }


    public function toQuery(){
        $id = "NULL";
        if($this->id !=null){
            $id = $this->id;
        }
       
        return "({$id},{$this->userId},{$this->money})";
    }

    public function toJSON(){
        $param=array();
        $param['money'] = $this->money;
        return json_encode($param);
    }
    public function toArray(){
        $param=array();
        $param['money'] = $this->money;
        return ($param);
    }
}
