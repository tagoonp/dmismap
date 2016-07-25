<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$strSQL = "SELECT *
          FROM dsw1_institute
          WHERE inst_status = 'Yes'";
$resultQuery = $db->select($strSQL,false,true);

$return = '';
for($i=0;$i<count($resultQuery);$i++){
  $return[$i]['inst_id'] = $resultQuery[$i]['inst_id'];
  $return[$i]['inst_name'] = $resultQuery[$i]['inst_name'];
}

echo json_encode($return);
$db->disconnect();

?>
