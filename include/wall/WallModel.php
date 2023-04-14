<?php


class WallModel{

    public $id,$name,$description,$price,$maxprice,$typeWall,$countOffer,$timeCreate,$time,$userId,$deleted,$block;


    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->name = $param['name'];
        $this->description = $param['description'];
        $this->price = $param['price'];
        $this->maxprice = $param['maxprice'];
        $this->typeWall = $param['typeWall'];
        $this->countOffer = $param['countOffer'];
        $this->timeCreate = $param['timeCreate'];
        $this->time = $param['time'];
        $this->userId = $param['userId'];
        $this->deleted = $param['deleted'];
        $this->block = $param['block'];


    }



    public function toArray(){
        $param = array();
        $param['id'] = $this->id;
        $param['name'] =$this->name;
        $param['description'] = $this->description;
        $param['price'] = $this->price;
        $param['maxprice'] = $this->maxprice;
        $param['typeWall'] = $this->typeWall;
        $param['countOffer'] = $this->countOffer;
        $param['timeCreate'] = $this->timeCreate;
        $param['time'] = $this->time;
        $param['userId'] = $this->userId;
        $param['deleted'] = $this->deleted;
        $param['block']  = $this->block;


        return ($param);
    }

    public function toQuery(){
        return "(NULL,'{$this->name}','{$this->description}',{$this->price},{$this->maxprice},{$this->typeWall},{$this->countOffer},{$this->timeCreate},{$this->time},{$this->userId},{$this->deleted},{$this->block})";

    }
}