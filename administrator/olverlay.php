<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DMISmap: A Prototype of Disaster Data Management System in the U-Tapao Cathment using Google Map</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

    <!-- Include JS file -->
    <script type="text/javascript" src="../libraries/jquery/jquery.js"></script>
    <script type="text/javascript" src="../libraries/bootstrap/js/bootstrap.js"></script>
    <script src="../libraries/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../libraries/jquery/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="../libraries/jquery/jquery-ui.js" type="text/javascript"></script>
    <!-- Include CSS file -->
    <link rel="stylesheet" type="text/css" href="../libraries/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../libraries/wizn/css/wizn.css" />
    <link rel="stylesheet" href="../libraries/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../libraries/sweetalert/dist/sweetalert.css">
    <link href="../libraries/bootstrap/css/simple-sidebar.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css" charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,200&subset=thai,latin' rel='stylesheet' type='text/css'>
  </head>
  <nav class="navbar navbar-default navbar-fix-top" style="margin-bottom: 0px; z-index: 99999;">
    <div class="container-fluid">
      <div class="navbar-header" style="font-size: 0.6em;">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand link-a" href="#" style="font-weight: 400; font-size: 3.3em;"><img src="../images/RTIlogo.png" alt="" style="height: 40px; margin-top: -10px;"/></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li><a class="link-a" href="./"><i class="fa fa-home"></i> หน้าหลัก</a></li>
          <li><a class="link-a" href="#" id="about">เกี่ยวกับโครงการ</a></li>
          <!-- <li><a class="link-a" href="#" id="about">คู่มือการใช้งาน</a></li> -->
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a class="link-a" href="#" id="about">นายฐากูร ปราบปรี</a></li>
          <li id="login"><a href="#" class="link-a" ><i class="fa fa-lock"></i> ออกจากระบบ</a>
        </ul>

      </div><!--/.nav-collapse -->
    </div>
  </nav>
  <body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" style="margin-top: -5px;">
            <div class="" style="padding: 8px; position: relative; padding-top: 16px; color: red; border: solid; border-width: 0px 0px 1px 0px; border-color: #ccc;">
              <i class="fa fa-gear"></i> จัดการข้อมูล
            </div>
            <div class="" style="padding: 0px 10px; padding-top: 15px; position: relative;">
              <ul>
                <li>บัญชีผู้ใช้</li>
                <ul>
                  <li style="list-style-type: disc;"><a href="manage.php">ผู้ใช้งานระบบ</a></li>
                  <li style="list-style-type: disc;"><a href="register_account.php">ผู้ใช้ลงทะเบียน</a></li>
                </ul>
                <li>หมุดอื่นๆ</li>
                <ul>
                  <!-- <li style="list-style-type: disc;">ศูนย์ประสานงาน</li>
                  <li style="list-style-type: disc;">บ้านพี่เลี้ยง</li> -->
                  <?php
                  $strSQL = sprintf("SELECT * FROM dsw1_overlaytype WHERE 1");
                  $resultOvl = $db->select($strSQL,false,true);
                  if($resultOvl){
                    foreach ($resultOvl as $value) {
                      ?>
                      <li style="list-style-type: disc;"><a href="overlay_manage.php?ovl_id=<?php print $value['ovl_id']; ?>"><?php print $value['ovl_detail']; ?></a></li>
                      <?php
                    }
                  }
                  ?>
                  <li style="list-style-type: disc;"><a href="olverlay.php"><i class="fa fa-plus"></i> <i><u>เพิ่มประเภทหมุดอื่นๆ</u></i> </a> </li>
                </ul>
              </ul>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="z-index: 99999; padding-left: 15px; padding-top: 0px; width: 300px; padding-bottom: 0px;">
            <div class="container-fluid" style="padding: 0px;">
              <div class="row">
                  <div class="col-lg-12"  style="padding: 0px; margin: 0px;">
                    <button type="button" name="button" id="menu-toggle" class="btn btn-danger" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-gear"></i></button>
                    <!-- <button type="button" name="button" id="menu-list-toggle" class="btn btn-primary" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-list"></i></button> -->
                    <button type="button" name="button" id="menu-map" class="btn btn-info" style="border-radius: 0px; outline: none; font-size: 1.3em; padding-left: 15px; padding-right: 15px;"> <i class="fa fa-map-marker"></i> </button>
                    <button type="button" name="button" id="menu-management" class="btn btn-info" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-wrench"></i></button>
                    <button type="button" name="button" id="menu-report" class="btn btn-primary" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-bar-chart-o"></i></button>
                  </div>
              </div>

            </div>
        </div>
        <div class="" style="background: ; padding: 0px 10px;">
          <h3 style="padding: 10px; background: #06c; color: #fff;">เพิ่มประเภทหมุด</h3>
          <form id="overlayForm" action="core/insert-overlay.php" method="post" enctype="multipart/form-data">
            <div class="row" >
              <div class="col-sm-4" style="padding-top: 5px; padding-left: 20px;">
                ชื่อประเภทหมุด <span class="req" style="color: red;">**</span>
              </div>
              <div class="col-sm-8" id="r1">
                <input type="text" name="txtOvelayname" id="txtOvelayname" class="form-control" placeholder="กรอกชื่อของประเภทหมุด">
              </div>
            </div>
            <div class="row" style="padding-top: 5px;">
              <div class="col-sm-4" style="padding-top: 5px; padding-left: 20px;">
                อัพโหลดไอคอน <span class="req" style="color: red;">**</span>
              </div>
              <div class="col-sm-8" id="r2">
                <input type="file" name="txtOvelayicon" id="txtOvelayicon" name="name"  class="form-control" placeholder="เลือกภาพไอคอน">
                <p style="font-weight: 300; padding-top: 5px;">
                  รูปภาพนามสกุล .png และมีขนาด 40 x 40 pixel
                </p>
              </div>
            </div>
            <div class="row" style="padding-top: 5px;">
              <div class="col-sm-4" style="padding-top: 5px; padding-left: 20px;">
                &nbsp;
              </div>
              <div class="col-sm-8">
                <button type="submit" id="btnSubmitoverlay" name="btnSubmitoverlay" class="btn btn-info">บันทึก</button>
                <button type="reset" name="btnResetoverlay" id="btnResetoverlay" class="btn btn-info">รีเซ้ต</button>
              </div>
            </div>
          </form>

          <h3 style="padding: 10px; background: #06c; color: #fff;">รายการประเภทหมุด</h3>
          <div class="row">
            <div class="col-sm-12">
              <table class="table">
                <thead>
                  <tr>
                    <th class="col-sm-1">#</th>
                    <th>ชื่อประเภทหมุด</th>
                    <th>
                      สัญลักษณ์หมุด
                    </th>
                    <th class="col-sm-2"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $strSQL = sprintf("SELECT * FROM dsw1_overlaytype WHERE 1 ORDER BY ovl_detail");
                  $resultOvl = $db->select($strSQL,false,true);
                  if($resultOvl){
                    $c = 1;
                    foreach ($resultOvl as $value) {
                      ?>
                      <tr>
                        <td style="padding-top: 17px;">
                          <?php print $c; ?>
                        </td>
                        <td style="padding-top: 17px;">
                          <?php print $value['ovl_detail']; ?>
                        </td>
                        <td>
                          <img src="../images/marker/<?php print $value['ovl_imagename']; ?>" alt="" />
                        </td>
                        <td style="padding-top: 17px;">
                          <?php
                          switch ($value['ovl_status']) {
                            case 'Yes': ?><span class="label label-success">เปิดใช้งานแล้ว</span><?php
                              # code...
                              break;

                            default: ?><span class="label label-danger">ปิดใช้งานอยู่</span><?php
                              # code...
                              break;
                          }
                          ?>
                        </td>
                      </tr>
                      <?php
                      $c++;
                    }
                  }else{
                    ?>
                    <tr>
                      <td colspan="3">
                        ไม่พบข้อมูล
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>


    <div class="doctor_show">
      <div class="msg_data">
        <!--เนื้อหาใน popup message-->
      </div>
    </div>

    <div id="overlay"></div>


  </body>
  <div class="alertList" >
    <div style="background: url('../images/bg1.png'); height: 43px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-5">
            <div class="row">
              <div class="col-sm-4">
                <div class="text-right" style="color: #fff; font-size: 20px; font-weight: 300; margin-top: 7px;">
                  เหตุการณ์ :
                </div>
              </div>
              <div class="col-sm-8">
                <div class="" style="margin-top: 5px;">
                  <select class="form-control" name="txtStageList" id="txtStageList" style="width: 250px; border-radius: 0px; font-size: 14px; ">
                    <option value="0" selected="">ทั้งหมด</option>
                    <option value="1">การร้องขอ  </option>
                    <option value="2">กำลังดำเนินการ  </option>
                    <option value="3">ช่วยเหลือแล้ว  </option>
                    <option value="4">ช่วยเหลือแล้ว (มากกว่า 4 ชั่วโมง)  </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="text-center" style="font-size: 24px; color: #fff; margin-top: 5px;">
              <i class="fa fa-angle-double-down" aria-hidden="true" id="minimizeList" style="cursor: pointer;"></i>
            </div>
          </div>
          <div class="col-sm-5">

          </div>
        </div>
      </div>
    </div>
    <div style="background: url('../images/bg2.png');">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="" style="color: #fff; font-size: 16px; padding: 5px 0px; font-weight: 300; padding-right: 5px;">
              <table class="table"  style="font-weight: 300; margin-bottom: 0px;">
                <thead style="border:none; padding: 0px; margin: 0px;">
                  <th class="col-sm-1" style="border:none; padding: 0px; margin: 0px; font-weight: 300;">
                    การแจ้ง
                  </th>
                  <th class="col-sm-2" style="border:none; padding: 0px; margin: 0px; font-weight: 300;">
                    วัน-เวลา
                  </th>
                  <th class="col-sm-2" style="border:none; padding: 0px; margin: 0px; font-weight: 300;">
                    หมายเลขโทรศัพท์
                  </th>
                  <th class="col-sm-2" style="border:none; padding: 0px; margin: 0px; font-weight: 300; padding-left: 5px;">
                    ผู้แจ้ง
                  </th>
                  <th style="border:none; padding: 0px; margin: 0px; font-weight: 300; padding-left: 10px;">
                    ข้อความ
                  </th>
                  <th class="col-sm-2" style="border:none; padding: 0px; margin: 0px; font-weight: 300; padding-left: 15px;">
                    ระดับความต้องการ
                  </th>
                  <th class="col-sm-1" style="border:none; padding: 0px; margin: 0px; font-weight: 300; padding-left: 18px;">
                    ช่องทาง
                  </th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div style="background: #fff;" class="listContent" id="style-3">
      <div class="container-fluid" style="padding: 0px;">
        <div class="row">
          <div class="col-sm-12">
            <div class="alertListContent" style=" font-size: 14px; padding: 0px 0px; font-weight: 300;">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</html>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/map.js"></script>
<script type="text/javascript" src="js/manage.js"></script>
<script>
    $("#menu-toggle").click(function(e) {
      $("#menu-toggle").blur();
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
