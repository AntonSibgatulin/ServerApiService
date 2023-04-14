<?php



class Account{

    public $id,$userId,$minDescription,$description,$typePayment,$subject,$phoneTrue,$region,$city,$emailTrue;
    public $days,$start,$end;

    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->minDescription = $param['minDescription'];
        $this->description = $param['description'];
        $this->typePayment = $param['typePayment'];
        $this->phoneTrue = $param['phoneTrue'];
        $this->emailTrue = $param['emailTrue'];
        $this->city = $param['city'];
        $this->region = $param['region'];
        $this->userId = $param['userId'];
        $this->days = $param['days'];
        $this->start = $param['start'];
        $this->end = $param['end'];

        
    }

    public static function create($user){
        return new Account(array(

            "id"=>NULL,
            "minDescription"=>'',
            "description"=>'',
            "typePayment"=>0,
            "phoneTrue"=>0,
            "emailTrue"=>0,
            'city'=>0,
            'region'=>0,
            'userId'=>$user->id

        ));

    }

    public function createQuerry(){
        return "(NULL,{$this->userId},'{$this->minDescription}','{$this->description}',{$this->typePayment},{$this->phoneTrue},{$this->emailTrue},{$this->region},{$this->city},'1,2,3,4,5',8,20)";
    }

    public function toQuery(){
        return "({$this->id},{$this->userId},'{$this->minDescription}','{$this->description}',{$this->typePayment},{$this->phoneTrue},{$this->emailTrue},{$this->region},{$this->city},'1,2,3,4,5',8,20)";
    }

    public function toArray(){
        $param = array();
        $param['minDescription']=$this->minDescription;
        $param['description']=$this->description;
        $param['typePayment']=$this->typePayment;
        $param['phoneTrue']=$this->phoneTrue;
        $param['emailTrue']=$this->emailTrue;
        $param['city']=$this->city;
        $param['region']=$this->region;
        $param['days'] = $this->days;
        $param['start'] = $this->start;
        $param['end'] = $this->end;

        return $param;

    }
}