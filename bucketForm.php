<form name='retProd' method='post'>
<?php

if (isset($_POST['retProd'])){

    $rres=$_SESSION['user']->returnAll($_POST['retProd']);
        if($rres>0) {
            echo '<script> alert(" You succesfuly canceled your order!")</script>';
            header('Refresh: 0; url=index.php?page=bucket');
        } else {
            echo '<script> alert(" Something is wrong! Please relogin")</script>';
            header('Refresh: 0; url=index.php?page=logOut');
        }
}



if (!empty( $_SESSION['bucket'])) {
    $buyed = new Products();
    foreach($_SESSION['bucket'] as $itm){
      $item= $buyed->showProduct($itm['product_id'],false);
      //  echo '<pre>'.var_dump($pr);

     echo"<div id='showName'> <img src='img/icon/".$item->brand.".png' height='24px' id='justLeft'>

                     <h2> ".$item->brand." - </h2> <h2> ".$item->name." </h2> </div><br>
                     <div id='bucketItems'>
                     <div id='justLeft'><img src='img/".$item->pic."' id='imgitem' ></div>

                      <div id='specyfication'> <h4>";


                $res = json_decode($item->specyfication);

                foreach($res as $k=>$v){
                    $result[$k]['value'] = $v;
                    if(empty($v)){
                        $result[$k]['value']= 'Not available';
                    }
                   echo $k.' : '.$result[$k]['value'].'<br>' ;
                }

                echo '</h4></div>You`ve purchased <b id="err">'.$itm['purchase_count'].'</b> items <br>';
                echo '<button type="submit" id="button" name="retProd" value="'.$itm['id'].'"> Return all </button>';

                 echo   "</div>";

    }


} else {
    echo '<center><h1> Nothing is added to cart yet </h1></center>';
}
?>
</form>