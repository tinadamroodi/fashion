<?php
session_start();
if (isset($_POST['search'])){

include 'apps/connection.php';// connection string
//select products info

if($_POST['products']=='all'){
  $query = $pdo->prepare(
    "SELECT * FROM inventory INNER JOIN products ON inventory.productId=products.id WHERE products.productName LIKE '%{$_POST['search']}%'"
  );
  $query->execute();
}
else{
  $query = $pdo->prepare(
    "SELECT * FROM inventory INNER JOIN products ON inventory.productId=products.id WHERE products.categoryID = (SELECT id FROM category WHERE name=?) AND products.productName LIKE '%{$_POST['search']}%'"
  );
  $query->execute([$_POST['products']]);
}

$results=$query->fetchAll(PDO::FETCH_ASSOC);

$total_row = $query->rowCount();
$html_output = '';
if($total_row>0){
  $productCount = 0;
  foreach($results as $row){
    if ($productCount % 4 == 0){
      $html_output.='
      <div class="row clearfix">';
    }
    $html_output.='<div class="col-2-5-10">
          <div>
            <img class="img-responsive" src="images/'.$row['productPhoto'].'" alt="">
          </div>
          <h3><a href="single-product.php?id='.$row['id'].'">'.$row['productName'].'</a></h3>
          <p class="price">
      ';
      if($row['off']>0){
        $html_output.='<del><span class="sale">'.$row['price'].'$</span></del>';
      }
      else{
        $html_output.=$row['price'].'$';
      }
      if($row['off']>0){
        $priceAfterOff = $row['price']-(($row['price']*$row['off'])/100);
        $html_output.= $priceAfterOff.'$';
      }
      $html_output.='</p><a href="single-product.php?id='.$row['id'].'" class="add-to-cart-button">Add to cart</a></div>';
      if ($productCount % 4 == 3){
        $html_output.='
        </div>';
      }
      $productCount++;
    }
}
else{
  $html_output.='
  <div class="row clearfix">No products found</div>';
}


include'search.phtml';
}
else{
  header('Location:shop.php');
}
 ?>
