<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$strSQL = "SELECT count(*) numberOfStg, alt_stage
          FROM dsw1_alert
          WHERE 1 GROUP BY alt_stage";
$resultQuery = $db->select($strSQL,false,true);

$return = '';
for($i=0;$i<count($resultQuery);$i++){
  $return[$i]['numberOfStg'] = $resultQuery[$i]['numberOfStg'];
  $return[$i]['alt_stage'] = $resultQuery[$i]['alt_stage'];
}


echo json_encode($return);
$db->disconnect();

?>
