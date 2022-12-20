<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<style>
.sub-box {
  height:auto;
  border:1px solid gray;
  border-radius:5px;
  margin:25px;
  padding:25px;
}
.sub-box-contant {
  margin:5px;
  padding:5px;
}
</style>
</head>
<body>
<?php
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
foreach($objMATDetail as $key=>$row_data){
?>
<div class="sub-box">
  <div class="sub-box-contant">
    <div><?php echo $generator->getBarcode($row_data->SERIALNUMBER, $generator::TYPE_CODE_128);?></div>
    <div style="margin-top:20px;"><b>Serial No</b>: <?php echo $row_data->SERIALNUMBER;?></div>
    <div><b>Item Code</b>: <?php echo $row_data->ICODE;?></div>
    <div><b>Item Name:</b> <?php echo $row_data->ITEM_NAME;?></div>
    <div><b>Item Group:</b> <?php echo $row_data->GROUPNAME;?></div>
  </div>
</div>
<?php } ?>
</body>
</html>