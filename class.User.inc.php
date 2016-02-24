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



}


?>