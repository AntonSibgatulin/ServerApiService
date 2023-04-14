<?php 



 class TokenUser{

    public $token,$userId;

    public function __construct($token,$userId)
    {
        $this->token=$token;
        $this->userId = $userId;
    }
    public function toArray(){
        $param= array();
        
        $param['userId'] = $this->userId;
        $param['token']=$this->token;

    }
}