<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DMISmap: A Prototype of Disaster Data Management System in the U-Tapao Cathment using Google Map</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

    <!-- Include JS file -->
    <script type="text/javascript" src="libraries/jquery/jquery.js"></script>
    <script type="text/javascript" src="libraries/bootstrap/js/bootstrap.js"></script>

    <!-- Include CSS file -->
    <link rel="stylesheet" type="text/css" href="libraries/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="libraries/wizn/css/wizn.css" />
    <link rel="stylesheet" href="libraries/font-awesome/css/font-awesome.min.css">
    <link href="libraries/bootstrap/css/simple-sidebar.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css" charset="utf-8">
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
        <a class="navbar-brand link-a" href="#" style="font-weight: 400; font-size: 3.3em;"><img src="images/RTIlogo.png" alt="" style="height: 40px; margin-top: -10px;"/></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li><a class="link-a" href="#"><i class="fa fa-home"></i> หน้าหลัก</a></li>
          <li><a class="link-a" href="./content/" id="about">เกี่ยวกับโครงการ</a></li>
          <!-- <li><a class="link-a" href="#"><i class="fa fa-clock-o"></i> TimeMap</a></li> -->
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li id="login"><a href="#" class="link-a" ><i class="fa fa-lock"></i> เข้าสู่ระบบ</a>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
  <body>
    <div id="wrapper" style="display:none;">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" style="margin-top: -5px;">
            <div class="" style="padding: 8px; position: relative; padding-top: 16px; color: red; border: solid; border-width: 0px 0px 1px 0px; border-color: #ccc;">
              <i class="fa fa-gear"></i> ตั้งค่าการกรองข้อมูล
            </div>
            <div class="" style="padding: 0px 10px; padding-top: 5px; position: relative;">
              <span style="font-size: 1.0em;">เหตุการณ์ : </span>
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12">
                  <span style="font-size: 0.8em;">
                    <input type="checkbox" name="chkStage0" id="chkStage0" value="0"> ทั้งหมด &nbsp;&nbsp;<br>
                    <input type="checkbox" name="chkStage1" id="chkStage1" class="cbAll" value="1" checked=""> การร้องขอ &nbsp;&nbsp;<br>
                    <input type="checkbox" name="chkStage2" id="chkStage2" class="cbAll" value="2" checked=""> กำลังดำเนินการ<br>
                    <input type="checkbox" name="chkStage3" id="chkStage3" class="cbAll" value="3"> ช่วยเหลือแล้ว<br>
                    <!-- <input type="checkbox" name="chkStage4" id="chkStage4" class="cbAll" value="4"> ช่วยเหลือแล้ว (มากกว่า 4 ชั่วโมง)<br> -->
                  </span>
                </div>
              </div>
              <br>
              <span style="font-size: 1.0em;">กลุ่มเหตุการณ์ : </span>
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12">
                  <span style="font-size: 0.8em;">
                    <input type="checkbox" name="chkBytype0" id="chkBytype0" value="0" > ทั้งหมด<br>
                    <input type="checkbox" name="chkBytype1" id="chkBytype1" value="1" > ไฟดับ/ไฟรั่ว<br>
                    <input type="checkbox" name="chkBytype2" id="chkBytype2" value="2" > น้ำไม่ไหล/น้ำรั่ว<br>
                    <input type="checkbox" name="chkBytype3" id="chkBytype3" value="3" > เจ็บป่วย<br>
                    <input type="checkbox" name="chkBytype4" id="chkBytype4" value="4" > อุบัติเหตุ<br>
                    <input type="checkbox" name="chkBytype5" id="chkBytype5" value="5" > ไฟไหม้<br>
                  </span>
                </div>
              </div>
              <br>
              <span style="font-size: 1.0em;">หมุดอื่นๆ : </span>
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12">
                  <span style="font-size: 0.8em;">
                    <input type="checkbox" name="chkOther1" id="chkOther1" value="1" > ศูนย์ประสานงาน<br>
                  </span>
                </div>
              </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="z-index: 99999; padding-left: 15px; padding-top: 0px; width: 100px;">
            <div class="container-fluid" style="padding: 0px;">
              <div class="row">
                  <div class="col-lg-12"  style="padding: 0px; margin: 0px;">
                    <button type="button" name="button" id="menu-toggle" class="btn btn-danger" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-gear"></i></button>
                  </div>
              </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <div id="map-canvas"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAewI1LswH0coZUPDe8Pvy39j4sbxmgCZU" async defer></script>
    <div class="doctor_show">
      <div class="msg_data">
        <!--เนื้อหาใน popup message-->
      </div>
    </div>

    <div class="loadingDiv">
      <div class="msg_data">
        <img src="images/progressLoad.gif" alt="" width="100%" />
      </div>
    </div>

    <div class="info_show">
      <div class="msg_data">
        <!--เนื้อหาใน popup message-->
      </div>
    </div>

    <div id="overlay"></div>
  </body>
</html>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/map.js"></script>
<script>
    $("#menu-toggle").click(function(e) {
      $("#menu-toggle").blur();
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
