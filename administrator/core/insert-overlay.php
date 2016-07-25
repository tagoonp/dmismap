<?php
date_default_timezone_set("Asia/Bangkok");
include "../../configuration/connect.class.php";
$db = new database();
$db->connect();

if($_FILES["txtOvelayicon"]){
  if(move_uploaded_file($_FILES["txtOvelayicon"]["tmp_name"],"../../images/marker/".date('Y-m-d')."_".$_FILES["txtOvelayicon"]["name"]))
  	{
  		//*** Insert Record ***//
      $strSQL = sprintf("INSERT INTO dsw1_overlaytype VALUE ('','".$_POST['txtOvelayname']."','".date('Y-m-d')."_".$_FILES["txtOvelayicon"]["name"]."','Yes')");
      $resultInsert = $db->insert($strSQL,false,true);

      if($resultInsert){
        $db->disconnect();
        header('Location: ../olverlay.php');
        exit();
      }else{
        $db->disconnect();
        header('Location: 404-error.php?url=olverlay.php');
        exit();
      }
  	}else{
      $db->disconnect();
      header('Location: 404-error.php?url=olverlay.php');
      exit();
    }
}else{
  $db->disconnect();
  header('Location: 404-error.php?url=olverlay.php');
  exit();
}
?>
