<?php

class User {
    public $id;
    public $email,$name,$sname,$phone,$adress='';

    public function __construct($p_id,$p_email,$p_name,$p_sname,$p_phone,$p_adress){
       $this->id=$p_id;
        $this->email=$p_email;
        $this->name=$p_name;
        $this->sname=$p_sname;
        $this->phone=$p_phone;
        $this->adress=$p_adress;
    }

    public function purchase($prod_id,$count){

        $db = Db::getInstance()->getConnection() ;
        $stmt=$db->prepare("SELECT * FROM products
                            WHERE id=".$prod_id." LIMIT 1");
        $stmt->execute();
        $res = (object)$stmt->fetch();
      //  echo var_dump($res);exit;
        $available_count = $res->available_count;

        if ($count <= $available_count){
            $left=$available_count-$count;
            $stmt=  $db->prepare("UPDATE `products` SET `available_count` = '$left' WHERE `products`.`id` = ".$prod_id);
            $stmt->execute();

            $stmt=  $db->prepare("INSERT INTO `bucket` (`user_id`, `product_id`, `purchase_count`)
            VALUES (".$this->id." , ".$prod_id." , ".$count.") ");

            $stmt->execute();


            $ret = 'purchased';
        } else {
            $ret = 'too many';
        }
    return $ret;
    }

}


?>