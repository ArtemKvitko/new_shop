<?php
    class Products {

        public function getCategories(){

//            $db = new Db();
//            $db->getInstance()->getConnection();

            $db = Db::getInstance()->getConnection() ;
            $stmt=$db->prepare("SELECT * FROM category");
            $stmt->execute();
            $categories = $stmt->fetchAll();
            $result=array();
            foreach ($categories as $category){
               array_push($result, (object)$category);
            }

        return $result;
        }
        public function getProducts($cat){
            $db = Db::getInstance()->getConnection() ;
            $stmt=$db->prepare("SELECT * FROM products WHERE category='".(int)$cat."'");
            $stmt->execute();
            $allproducts = $stmt->fetchAll();

            $result=array();
            foreach ($allproducts as $product){
                array_push($result, (object)$product);
            }

               return $result;
        }

        public function printProducts($products){

            if (!$products){
                echo '<h1>Sorry, no products in this category </h1>';
            } else {
                foreach ($products as $item){
                    echo "

                    <div id='product'>
                     <a href='index.php?page=product&productId=".$item->id."'>
                     <h2> ".$item->brand."  </h2> <h3> ".$item->name." </h3></a> <br>
                     <div id='imgitem'><img src='img/".$item->pic."' id='imgitem' ></div>

                       <div id='specyfication'> <h4>".$item->specyfication."</h4></div>


                     </div>

                    ";


                }
              }
        }

        public  function showProduct($id){
            $db = Db::getInstance()->getConnection() ;
            $stmt=$db->prepare("SELECT * FROM products WHERE id='".(int)$id."'");
            $stmt->execute();
            $item = (object)$stmt->fetch();
            if ($item){

                //$pieces = explode(",", $item->specyfication);

                echo "

                     <div id='showName'> <img src='img/icon/".$item->brand.".png' height='24px' id='justLeft'>

                     <h2> ".$item->brand." - </h2> <h2> ".$item->name." </h2> </div><br>
                     <div id='cen'><img src='img/".$item->pic."' id='imgBig' ></div>

                      <div id='specyfication'> <h4>";


                $res = json_decode($item->specyfication);

                foreach($res as $k=>$v){
                    $result[$k]['value'] = $v;
                    if(empty($v)){
                        $result[$k]['img'] = "img/icon/empty.png";
                        $result[$k]['value']= 'Not available';
                    }else{
                        $result[$k]['img'] = 'img/icon/'.$k.".png";
                    }

                   echo '<p><img src="'. $result[$k]['img'].'" id="speclogo"> '.$k.' : '.$result[$k]['value'] ;
                }



                 echo   "</h4></div>";
                if (isset($_SESSION['user'])){
                      if ($item->available_count>0 ){
                        echo "  <div id='available'><form action='' name='buyForm' method='post'>
                Purchase count: <input type=number name='count' required value='1' min='1' max='".$item->available_count."' ></input>
                        <button name='buy' id='buyButton'> Add to bucket </button> </form>";
                      } else {
                         echo  " Sorry, this model is not available at this moment. <br><div id='available'> <button id='buyButton' disabled> Add to bucket </button> ";
                      }



                } else {
                    echo '<div><h2 id="err"> Please log in </h2> ';
                }
                echo " </div><div id='detail'>";
                echo $item->detail.'</div> <div id="clr"></div>';
            }

        }



    }