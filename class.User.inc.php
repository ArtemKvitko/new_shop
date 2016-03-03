<?php

class User
{
    public $id;
    public $email, $name, $sname, $phone, $adress = '';

    public function __construct($p_id, $p_email, $p_name, $p_sname, $p_phone, $p_adress)
    {
        $this->id = $p_id;
        $this->email = $p_email;
        $this->name = $p_name;
        $this->sname = $p_sname;
        $this->phone = $p_phone;
        $this->adress = $p_adress;
    }
//Purchasing selected product.
//Input product id and purchasing count
    public function purchase($prod_id, $count)
    {
        //getting available count of products
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM products
                            WHERE id=" . $prod_id . " LIMIT 1");
        $stmt->execute();
        $res = (object)$stmt->fetch();

        $available_count = $res->available_count;

        //  checking is there enough products available to purchase
        if ($count <= $available_count) {
            $left = $available_count - $count;

            //checkin is for curent user already purchased that product
            $check = $this->getBucket($prod_id);
            if ($check) {
                //updating bucket purchase count of product if product is in bucket
                $stmt = $db->prepare("UPDATE `bucket` SET `purchase_count` = `purchase_count`+'$count' WHERE `product_id` = " . $prod_id . " AND `user_id`=" . $this->id);
                $stmt->execute();
            } else {
                //adding to bucket purchase count of product
                $stmt = $db->prepare("INSERT INTO `bucket` (`user_id`, `product_id`, `purchase_count`)
            VALUES (" . $this->id . " , " . $prod_id . " , " . $count . ") ");
                $stmt->execute();
            }
            // subtracting from available count, the purchase count
            $stmt = $db->prepare("UPDATE `products` SET `available_count` = '$left' WHERE `products`.`id` = " . $prod_id);
            $stmt->execute();
            $ret = 'purchased';
        } else {
            $ret = 'too many';
        }
        return $ret;
    }

//getting info about products purchased by user
    public function getBucket($product_id = NULL)
    {
        $db = Db::getInstance()->getConnection();
        $product_id = isset($product_id) ? 'AND product_id=' . (int)$product_id : NULL;
        $stmt = $db->prepare("SELECT * FROM bucket WHERE user_id=" . $this->id . ' ' . $product_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $result = [];
        if (!empty($res)) {
            foreach ($res as $ob) {
                array_push($result, $ob);
            }
            return (object)$result;
        } else {
            return null;
        }
    }

//returning products that are in bucket
    public function returnAll($ret_id)
    {
        //checking in DB is there product to return
        (int)$ret_id;
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM bucket
                             WHERE id=" . $ret_id . " LIMIT 1");
        $stmt->execute();
        $temp_res = $stmt->fetch();
        $count = (int)$temp_res['purchase_count'];
        $product_id = (int)$temp_res['product_id'];

        //returning non buyed products and increasind available count
        if (isset($count) and isset($product_id)) {
            $stmt = $db->prepare("UPDATE products SET available_count=available_count+" . $count . "
                                  WHERE id=" . $product_id);
            $stmt->execute();
            //if operation succesful deleting purchase from a  bucket
            if ($stmt->rowCount() > 0) {
                $stmt = $db->prepare("DELETE FROM bucket
                             WHERE id=" . $ret_id);
                $stmt->execute();
                return $stmt->rowCount();
            } else return 0;
        } else return 0;


    }

//display user info
    public function userInfo()
    {
        if (isset($_SESSION['user'])) {

            echo " <h2>User information</h2><br><br>

            <div id='register'>

            <b> e-mail: </b> $this->email;  <br>
            <b> name: </b> $this->name; <br>
            <b> surname: </b> $this->sname; <br>
            <b> phone number : </b> $this->phone; <br>
            <b> delivery adress:</b> $this->adress; <br>

            </div>
            ";

        } else {
            echo '<h1 id="err"> Please logIn </h1>';
        }
    }

    public function confirmPurchase($purchase_id)
    {
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT bucket.*, products.price FROM bucket
                              JOIN products ON bucket.product_id=products.id
                              WHERE bucket.id=" . $purchase_id . " LIMIT 1");
        $stmt->execute();
        $temp_res = $stmt->fetch();


        if ($temp_res) {
            $count = $temp_res['purchase_count'];
            $product_id = $temp_res['product_id'];
            $user_id = $this->id;
            $bucketdate = $temp_res['purchase_date'];
            $paysum = $count * $temp_res['price'];

            //confirming buying products
            $stmt = $db->prepare("INSERT INTO `purchasehistory`
                      (`user_id`, `product_id`, `count`, `bucket_date`,`pay_sum`)
            VALUES (" . $user_id . " , " . $product_id . " , " . $count . " , '" . $bucketdate . "' , " . $paysum . ") ");
            $stmt->execute();


            //if operation succesful deleting purchase from a  bucket
            if ($stmt->rowCount() > 0) {
                $stmt = $db->prepare("DELETE FROM bucket
                             WHERE id=" . $purchase_id);
                $stmt->execute();
                $msg = $stmt->rowCount() > 0 ? null : 'error ocured. Cannot confirm purchase';

            } else {
                $msg = 'Some error ocured. Cannot confirm purchase';
            };


        } else {
            $msg = 'there is no selected product in bucket to confirm';
        }

        return $msg;
    }

    public function purchaseHistory()
    {
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT purchasehistory.* , products.brand, products.name FROM purchasehistory
                              JOIN products ON purchasehistory.product_id=products.id
                              WHERE user_id=" . $this->id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $result = '';

        $prod = new Products();
        foreach ($res as $itm) {
            $prod->printProductName($itm['brand'], $itm['name'], $itm['product_id']);

            $result .= "<div id='bucketItems'>";
            $result .= "<h2>Purchase date: " . $itm['confirm_date'] . "</h2><br/>";
            $result .= "<p><h3>You have purchased: " . $itm['count'] . " item(s)</h3></p><br/>";
            $result .= "<h3>You have paid: <b id='err'> " . $itm['pay_sum'] . "</b></h3><br/>";
            $result .= '</div>';

            echo $result;
            $result = '';
        }

    }
}


?>