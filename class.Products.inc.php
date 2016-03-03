<?php

class Products
{

    //getting info about available categories in DB
    public function getCategories()
    {

        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM category");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        $result = array();
        foreach ($categories as $category) {
            array_push($result, (object)$category);
        }
        return $result;
    }

    //getting all products from choosen category
    //and choose sort type
    public function getProducts($cat, $orderby = '')
    {
        $db = Db::getInstance()->getConnection();

        switch ($orderby) {
            case 'brand':
                $orderby = 'ORDER BY brand';
                break;
            case 'price':
                $orderby = 'ORDER BY price';
                break;
            default:
                $orderby = 'ORDER BY id';
        }

        $stmt = $db->prepare("SELECT * FROM products WHERE category='" . (int)$cat . "' " . $orderby . " ");
        $stmt->execute();
        $allproducts = $stmt->fetchAll();

        $result = array();
        foreach ($allproducts as $product) {
            array_push($result, (object)$product);
        }

        return $result;
    }

    //printing short info about products
    //input object
    public function printProducts($products)
    {

        if (!$products) {
            echo '<h1>Sorry, no products in this category </h1>';
        } else {
            foreach ($products as $item) {

                echo "

                    <div id='product'>
                     <a href='index.php?page=product&productId=" . $item->id . "'>
                     <h2> " . $item->brand . "  </h2> <h3> " . $item->name . " </h3> <br>
                     <div id='imgitem'><img src='img/" . $item->pic . "' id='imgitem' ></a></div>
                       <h4 id='price'> Price:" . $item->price . " \$</h4>
                       <h4 id='justRight'> left:" . $item->available_count . "</h4>

                     </div>

                    ";


            }
            echo "<div id='clr'> </div>";
        }
    }

    //displaying full info about selected product
    //input product id, and parametr for printing ($pr=true, or just getting info $pr=false)
    public function showProduct($id, $pr = true)
    {
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE id='" . (int)$id . "'");
        $stmt->execute();
        $item = $stmt->fetch();

        if ($item) {
            $item = (object)$item;
            if ($pr) {

                $this->printProductName($item->brand, $item->name, $item->id);
                echo "

                     <div id='cen'><img src='img/" . $item->pic . "' id='imgBig' ></div>
                      <div id='specyfication'> <h4>";

                $this->printSpec($item->specyfication);
                echo "</h4></div>";
                echo " <h4> Current price: <b  style='color: green'> " . $item->price . " \$</b></h4>";
                if (isset($_SESSION['user'])) {
                    if ($item->available_count > 0) {
                        echo "  <div id='available'><form action='' name='buyForm' method='post'>
                Purchase count: <input type=number name='count' required value='1' min='1' max='" . $item->available_count . "' > </input>
                        <button name='buy' id='buyButton'> Add to bucket </button> </form>";
                    } else {
                        echo " Sorry, this model is not available at this moment. <br><div id='available'> <button id='buyButton' disabled> Add to bucket </button> ";
                    }
                } else {
                    echo '<div><h2 id="err"> Please log in </h2> ';
                }
                echo " </div><div id='detail'>";
                echo $item->detail . '</div> <div id="clr"></div>';
            } else {
                return $item;
            }
        } else {
            // if not found product with id
            echo '<h1 id="err"> Product with that id not found </h1>';
        }
    }

    public function printSpec($inp)
    {
        //decoding products specyfication from json
        $res = json_decode($inp);

        foreach ($res as $k => $v) {
            $result[$k]['value'] = $v;
            if ($v === false) {
                $result[$k]['img'] = "img/icon/empty.png";
                $result[$k]['value'] = 'Not available';
            } else {
                $result[$k]['img'] = 'img/icon/' . $k . ".png";
                if ($result[$k]['value'] === True) {
                    $result[$k]['value'] = 'Yes';
                }
            }
            if (!file_exists($result[$k]['img'])) {
                $result[$k]['img'] = 'img/icon/absent.png';
            }
            echo '<img src="' . $result[$k]['img'] . '" id="speclogo"> ' . $k . ' : ' . $result[$k]['value'] . '<br>';
        }

    }

    public function printProductName($brand, $name, $product_id)
    {
        echo "  <div id='showName'> <img src='img/icon/" . $brand . ".png' height='24px' id='justLeft'>

                     <h2><a href='index.php?page=product&productId=" . $product_id . "' id='astyle'> " . $brand . " - </h2><h2> " . $name . " </h2></a> </div><br>

                     ";

    }

    public function doSearch($what)
    {

        $what = htmlspecialchars($what, ENT_QUOTES);
        $db = Db::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT products.*, category.category_name FROM products
                              JOIN category ON products.category=category.id
                              WHERE name LIKE '%" . $what . "%' OR brand LIKE '%" . $what . "%'

                              ORDER BY category");
        $stmt->execute();
        $res = $stmt->fetchAll();
        $category = '';

        if (!empty($res)) {
            foreach ($res as $item) {
                if ($category != $item['category']) {
                    $category = $item['category'];

                    echo '<h2>' . $item['category_name'] . '</h2>';

                }
                $this->printProductName($item['brand'], $item['name'], $item['id']);

            }
        } else {
            echo 'Sorry. No product was founded';
        }

    }

}