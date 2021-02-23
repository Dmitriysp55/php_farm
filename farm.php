<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP farm</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" />

  <style>
    #game-content{
      text-decoration: none;
    }
  </style>

</head>
<body>
<?php
$potatoe = './images/potatoes.png';
$pepper = './images/chili-pepper.png';
$corn = './images/corn.png';
$grass = './images/grass.png';

$price_corn = 10;
$price_potatoe = 5;
$price_pepper = 50;

$total = 0;

$get_index = 0;
$gather_option = "";
$seed_option = "";
$stock = json_decode(file_get_contents('./database/stock.json'), true);
$farm = json_decode(file_get_contents('./database/data.json'));

if (isset($_GET["seed"])){
  $seed_option = $_GET["seed"];
};
    if (isset($_GET["gather"]) and isset($_GET["index"]) ){
  $gather_option = $_GET["gather"];
  $get_index = $_GET["index"];
        if($gather_option == "potatoe"){
          $farm[$get_index] = str_replace($farm[$get_index], $grass, $farm[$get_index]);
          $stock["potatoe"] += 1;
          file_put_contents('./database/stock.json', json_encode($stock));
          file_put_contents('./database/data.json', json_encode($farm));
        };
        if($gather_option == "corn"){
          $farm[$get_index] = str_replace($farm[$get_index], $grass, $farm[$get_index]);
          $stock["corn"] += 1;
          file_put_contents('./database/stock.json', json_encode($stock));
          file_put_contents('./database/data.json', json_encode($farm));
        };
        if($gather_option == "pepper"){
          $farm[$get_index] = str_replace($farm[$get_index], $grass, $farm[$get_index]);
          $stock["pepper"] += 1;
          file_put_contents('./database/stock.json', json_encode($stock));
          file_put_contents('./database/data.json', json_encode($farm));
        };
};
$farm = json_decode(file_get_contents('./database/data.json'));
if (isset($_GET["seed"]) and isset($_GET["index"]) ){
  $get_index = $_GET["index"];
  $seed_option = $_GET["seed"];

        if($seed_option == "potatoe"){
          $farm[$get_index] = str_replace($farm[$get_index], $potatoe, $farm[$get_index]);
          $stock["money"] -= ($price_potatoe/100*10);
          file_put_contents('./database/stock.json', json_encode($stock));
          file_put_contents('./database/data.json', json_encode($farm));
        };
        if($seed_option == "corn"){
          $farm[$get_index] = str_replace($farm[$get_index], $corn, $farm[$get_index]);
          $stock["money"] -= ($price_corn/100*10);
          file_put_contents('./database/stock.json', json_encode($stock));
          file_put_contents('./database/data.json', json_encode($farm));
        };
        if($seed_option == "pepper"){
          $farm[$get_index] = str_replace($farm[$get_index], $pepper, $farm[$get_index]);
          $stock["money"] -= ($price_pepper/100*10);
          file_put_contents('./database/stock.json', json_encode($stock));
          file_put_contents('./database/data.json', json_encode($farm));
        };
};
$stock_value = $stock["potatoe"]*$price_potatoe+$stock["corn"]*$price_corn+$stock["pepper"]*$price_pepper;
if (isset($_GET["sell_all"])){
        if($_GET["sell_all"] == 1){
          $stock["money"] += $stock_value;
          $stock["pepper"] = 0;
          $stock["corn"] = 0;
          $stock["potatoe"] = 0;
          file_put_contents('./database/stock.json', json_encode($stock));
        };
};
$farm = json_decode(file_get_contents('./database/data.json'));
$stock = json_decode(file_get_contents('./database/stock.json'), true);

  ?>
  <?php
  // farm generator
  // for ($x=0;$x<=(122);$x++){
  //   if(mt_rand(0,3) == 1)
  //   array_push($farm, $potatoe);
  //   if(mt_rand(0,3) == 2)
  //     array_push($farm, $corn);
  //   if(mt_rand(0,3) == 3)
  //     array_push($farm, $pepper);
  //     if(mt_rand(0,3) == 0)
  //     array_push($farm, $grass);
  //   };
  //   file_put_contents('./database/data.json', json_encode($farm));
  $stock_value = $stock["potatoe"]*$price_potatoe+$stock["corn"]*$price_corn+$stock["pepper"]*$price_pepper;
?>
<div class="container "><h1 class="center-block"><a style="color:black; text-decoration: none;" href="">PHP FARM</a></h1></div>
<hr>
<div class="container">
  <div class="row">
  <div class="col-md-2">
  <div class="container"><h3>Your stock</h3></div>
    <ul>
      <li>Potatoes: <?php print $stock["potatoe"]?></li>
      <li>Corn: <?php print $stock["corn"]?></li>
      <li>Pepper: <?php print $stock["pepper"]?></li>
    </ul>
    <form method="get">
    <button class="btn btn-success" type="submit" value="<?php if($stock_value>0) print 1; else print 0?>" name="sell_all">Sell all <?php if($stock_value>0) print "$".$stock_value; ?></button></form>
  </div>
   <div id="game-content" class="col-md-7">
<?php
  foreach ($farm as $index => $product) {?>
    <?php if ($index%16 == 0 and $index != 0) print "</br>"; ?>
    <?php if ($product == $potatoe) {
    print "<a href=\"?gather=potatoe&index=".$index."\">"; ?>
    <img src="<?php print $product; ?>" alt=""/></a>
    <?php };?>
    <?php if ($product == $corn) {
    print "<a href=\"?gather=corn&index=".$index."\">"; ?>
    <img src="<?php print $product; ?>" alt=""/></a>
    <?php };?>
    <?php if ($product == $pepper) {
    print "<a href=\"?gather=pepper&index=".$index."\">"; ?>
    <img src="<?php print $product; ?>" alt=""/></a>
    <?php };?>
    <?php if ($product == $grass) {
    print "<a class=\"grass\" href=\"?seed=".$seed_option."&"."index=".$index."\">"; ?>
    <img src="<?php print $product; ?>" alt=""/></a>
    <?php };?>

  <?php }; ?>
  <div><h2>Buy seeds:</h2></div>
  <form method="get">
      <button type="submit" value="potatoe" name="seed"><?php print "<b>"."$".($price_potatoe/100*10)."</b>"?>  <img src="<?php print $potatoe?>"/></button>
      <button type="submit" value="corn" name="seed"><?php print "<b>"."$".($price_corn/100*10)."</b>"?>  <img src="<?php print $corn?>"/></button>
      <button type="submit" value="pepper" name="seed"><?php print "<b>"."$".($price_pepper/100*10)."</b>"?>  <img src="<?php print $pepper?>"/></button>
  </form>

    </div>
    <div class="col-md-2">
  <div class="container"><h3 style="color:green">Your money:</br><?php print "$".$stock["money"]?></h3></div>
  </div>
  </div>
</div>

</body>
</html>

