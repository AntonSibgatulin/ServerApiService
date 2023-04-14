<?php


class UserWallModel
{
    public $id, $name, $description, $typeUserWall, $price, $typePayment;
    /*
    public function __construct($id,$name,$description,$typeUserWall,$price,$typePayment)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->typeUserWall = $typeUserWall;
        $this->price = $price;
        $this->typePayment = $typePayment;
    }
    */
    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->name =  $param['name'];
        $this->description =  $param['description'];
        $this->typeUserWall =  $param['typeUserWall'];
        $this->price =  $param['price'];
        $this->typePayment =  $param['typePayment'];
    }
}
