<?php
include 'apps/connection.php';// connection string
//select products info
if(isset($_POST["action"])){
  $query = "SELECT * FROM inventory
  JOIN products ON inventory.productId = products.id";
  if(isset($_POST["min"]) and isset($_POST["max"])){
    $min = $_POST["min"];//35,36,40
    $max = $_POST["max"];//35,36,40
    $query.=" WHERE products.price BETWEEN '".$min."' AND '".$max."'";
  }
  if(isset($_POST["sale"])){
    $sale_filter = implode("','",$_POST["sale"]);//35,36,40
    if($sale_filter=='sale'){
    $query.=" AND off>0";

    }
  }

  if(isset($_POST["size"])){
    $size_filter = implode("','",$_POST["size"]);//35,36,40
    $query.=" AND inventory.productSize IN ('".$size_filter."')";
  }
  if(isset($_POST["color"])){
    $color_filter = implode("','",$_POST["color"]);//35,36,40
    $query.=" AND inventory.colorId IN ('".$color_filter."')";
  }
  if(isset($_POST["category"])){
    $category_filter = implode("','",$_POST["category"]);//35,36,40
    $query.=" AND products.categoryId IN ('".$category_filter."')";
  }
  $sort =   implode("','",$_POST["sort"]);
  switch ($sort) {
    case 'default':
      break;
      case 'pflh':
      $query.=" ORDER BY products.price ASC";
      break;
      case 'pfhl':
      $query.=" ORDER BY products.price DESC";
      break;
  }
  $sortByRate =   implode("','",$_POST["sortbyrate"]);
  switch ($sortByRate) {
    case 'default':
      break;
      case 'rflh':
      $query.=" ORDER BY products.rate ASC";
      if($sort=='pflh' or $sort='pfhl'){
      $query.=" AND products.rate ASC";
      }
      break;
      case 'rfhl':
      $query.=" ORDER BY products.rate DESC";
      if($sort=='pflh' or $sort='pfhl'){
      $query.=" AND products.rate DESC";
      }
      break;
  }
$query = $pdo->prepare($query);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_ASSOC);
$total_row = $query->rowCount();
$html_output = '';
if($total_row>0){
  $productCount = 0;
  foreach($results as $row){
    $rate = $row['rating'];
    $r = floor($rate);
    if ($productCount % 4 == 0){
      $html_output.='
      <div class="row clearfix">';
    }
    $html_output.='<div class="col-2-5-10">
          <div>
            <img class="img-responsive" src="images/'.$row['productPhoto'].'" alt="">
          </div>
          <h3><a href="single-product.php?id='.$row['id'].'">'.$row['productName'].'</a></h3>
          <span class="rating">';
          if($r==0){
            for($s=1;$s<=5;$s++){
              $html_output.= '<svg class="star-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>';
            }
          }
          else{
            for($s=1;$s<=$r;$s++){
              $html_output.= '<svg class="star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>';
            }
            if($rate>$r){
              $r = ceil($rate);
              $html_output.= '<svg class="star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><g><path fill="#aaa" d="M545.3 226L439.6 329l25 145.5c4.5 26.1-23 46-46.4 33.7l-130.7-68.6V0a31.62 31.62 0 0 1 28.7 17.8l65.3 132.4 146.1 21.2c26.2 3.8 36.7 36.1 17.7 54.6z"></path><path d="M110.4 474.5l25-145.5L29.7 226c-19-18.5-8.5-50.8 17.7-54.6l146.1-21.2 65.3-132.4A31.62 31.62 0 0 1 287.5 0v439.6l-130.7 68.6c-23.4 12.3-50.9-7.6-46.4-33.7z"></path></g></svg>';
            }
            if($r<5){
              for($s=$r+1;$s<=5;$s++){
                $html_output.= '<svg class="star-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>';
              }
            }
          }


      $html_output.=' </span><p class="price">';
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
echo $html_output;
}
 ?>
