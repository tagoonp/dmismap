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
          <!-- <li><a class="link-a" href="#"><i class="fa fa-clock-o"></i> TimeMap</a></li> -->
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a class="link-a" href="#" id="about">นายฐากูร ปราบปรี</a></li>
          <li id="login"><a href="#" class="link-a" ><i class="fa fa-lock"></i> ออกจากระบบ</a>
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li id="userinfo"><a href="#"><i class="fa fa-user"></i> ข้อมูลส่วนตัว </a></li>
              <li id="logout"><a href="#"><i class="fa fa-lock"></i> ออกจากระบบ </a></li>
            </ul>
          </li> -->
        </ul>

      </div><!--/.nav-collapse -->
    </div>
  </nav>
  <body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" style="margin-top: -5px;">
            <div class="" style="padding: 8px; position: relative; padding-top: 16px; color: red; border: solid; border-width: 0px 0px 1px 0px; border-color: #ccc;">
              <i class="fa fa-gear"></i> ตั้งค่าการกรองข้อมูล
            </div>
            <!-- <div class="" style="padding: 0px 10px; padding-top: 15px; position: relative; ">
              <span style="font-size: 1.0em;">ระดับพื้นที่การแสดงผล : </span>
              <div class="row" style="padding-top: 5px;">
                <div class="col-sm-12">
                  <select class="form-control" name="">
                    <option value="1" selected="">จังหวัด</option>
                    <option value="2">อำเภอ</option>
                    <option value="3">ตำบล</option>
                    <option value="4">พิกัด</option>
                  </select>
                </div>
              </div>

            </div> -->
            <div class="" style="padding: 0px 10px; padding-top: 15px; position: relative;">
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
        <div id="page-content-wrapper" style="z-index: 99999; padding-left: 15px; padding-top: 0px; width: 200px;">
            <div class="container-fluid" style="padding: 0px;">
              <div class="row">
                  <div class="col-lg-12"  style="padding: 0px; margin: 0px;">
                    <button type="button" name="button" id="menu-toggle" class="btn btn-danger" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-gear"></i></button>
                    <button type="button" name="button" id="menu-list-toggle" class="btn btn-primary" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-list"></i></button>
                    <button type="button" name="button" id="menu-add-toggle" class="btn btn-info" style="border-radius: 0px; outline: none; font-size: 1.3em;"><i class="fa fa-plus"></i></button>
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
        <img src="../images/progressLoad.gif" alt="" width="100%" />
      </div>
    </div>

    <div class="info_show">
      <div class="msg_data">
        <!--เนื้อหาใน popup message-->
      </div>
    </div>

    <div id="overlay"></div>

    <div class="rightcontainer shadow1" style="display:none;" id="rightContent">
      <div class="" style="padding: 20px 20px 0px 20px;color: #155D87; border: none; border-width: 0px 0px 1px 0px; border-color: #ccc;  ">
        <div class="row" style="padding: 0px; margin: 0px;">
          <div class="col-sm-1" style="padding: 0px; margin: 0px;">

          </div>
          <div class="col-sm-10" style="padding: 0px; margin: 0px;">
            <div class="text-center">
              <h3 style="margin-top: 5px;">ข้อมูลการร้องขอรายพิกัด</h3>
            </div>
          </div>
          <div class="col-sm-1 text-right" style="padding: 0px; margin: 0px;">
            <!-- ข้อมูลการร้องขอรายพิกัด -->
            &nbsp;&nbsp;<button type="button" name="button" class="btn btn-danger" id="hdManager" ><i class="fa fa-close" style="cursor: pointer;"></i></button>
          </div>
        </div>

      </div>
      <div class="" style="padding: 10px 0px; color: #000;">
        <div class="row" style="margin: 0px;">
          <div class="col-sm-6">
            <div class="" style="padding: 10px 0px 10px 10px;">
              <div class="row" style="margin: 0px;">
                <div class="col-sm-9" style="margin: 0px; padding: 0px;">
                  <div class="">
                    ช่องทางการแจ้ง : <span style="color: #888;" id="markerChanel">-</span>
                  </div>
                </div>
                <div class="col-sm-3" style="margin: 0px; padding: 0px;">
                  <div class="text-right" style="padding-bottom: 5px;">
                    <span id="markerImg"></span>
                  </div>
                </div>
              </div>
              <div class="imgpanel">

              </div>
            </div>
            <div class="" style="padding: 0px 0px 5px 10px; ">
              ข้อมูลตำแหน่ง
            </div>
            <div class="" style="padding: 0px 0px 15px 10px;">
              <span id="markerAddress" style="color: #888;">N/A</span><br>
            </div>
            <div class="" style="padding: 0px 0px 15px 10px;">
              ชื่อตำแหน่งโดยสังเขป <span id="markerAddress2" style="color: #888;"></span>
            </div>
            <div class="" style="padding: 0px 0px 15px 10px;">
              ชื่อตำแหน่งจากข้อมูลผู้ใช้ <span id="markerAddress3" style="color: #888;"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="" style="padding: 10px 0px 10px 10px;">
              ID : <span id="markerID" style="color: #888;">N/A</span>
            </div>
            <div class="" style="padding: 0px 0px 10px 10px;">
              หมายเลขโทรศัพท์ : <span id="markerPhone" style="color: #888;">N/A</span>
            </div>
            <div class="" style="padding: 0px 0px 10px 10px;">
              ผู้แจ้ง : <span id="markerUser" style="color: #888;">N/A</span>
            </div>
            <div class="" style="padding: 0px 0px 10px 10px;">
              ระดับความต้องการ : <span id="markerLevel"></span>
            </div>
            <div class="" style="padding: 5px 10px;">
              <table class="table table-condensed" style="padding: 0px; margin: 0px; color: #888;">
                <thead style="background: #74A8C7; color: #fff;">
                  <th>
                    ปัจจัยพื้นฐาน
                  </th>
                  <th>

                  </th>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      อาหาร
                    </td>
                    <td>
                      <span id="markerFood"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      ยารักษาโรค
                    </td>
                    <td>
                      <span id="markerDrug"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="" style="padding: 0px 0px 5px 10px; ">
              ความต้องการ/รายละเอียดอื่นๆ
            </div>
            <div class="" style="padding: 0px 0px 15px 10px;">
              <span id="markerOther" style="color: #888;">N/A</span>
            </div>
          </div>
        </div>

      </div>
      <div class="" style="padding: 10px 20px 12px 20px;color: #155D87; border: solid; border-width: 1px 0px 1px 0px; border-color: #ccc;  ">
        การประสานงาน
      </div>

      <div class="" style="padding: 10px 0px;">
        <div class="row" style="margin: 0px;">
          <div class="col-sm-7 nst">
            <div class="nst" style="padding: 5px 0px 5px 10px; color: #000;">
              จัดการประสาน
            </div>
            <div class="nst" style="padding: 5px 0px 5px 10px;">
              <select class="form-control" name="" id="txtInstitute" >
                <option value="" selected="">-- เลือกศูนย์ประสานงาน --</option>
              </select>
            </div>
            <div class="nst" style="padding: 5px 0px 5px 10px; color: #000;">
              สถานะต่อไป
            </div>
            <div class="nst" style="padding: 5px 0px 5px 10px;">
              <select class="form-control" name="" id="txtNextstate" >
                <option value="1">รับแจ้งเหตุ</option>
                <option value="2">ประสานงาน/ช่วยเหลือ</option>
                <option value="3">ได้รับการช่วยเหลือแล้ว</option>
              </select>
            </div>
            <div class="nst" style="padding: 5px 0px 5px 10px; color: #000;">
              รายชื่อผู้ประสานงาน
            </div>
            <div class="nst" id="coList" style="padding: 5px 0px 5px 10px;">
              <table class="table table-condensed" style="padding: 0px; margin: 0px;">
                <thead style="background: #f3f3f3;">
                  <th>
                    ชื่อผู้ประสาน
                  </th>
                  <th>
                    ตำแหน่ง
                  </th>
                  <th>
                    หมายเลขโทรศัพท์
                  </th>
                  <th>
                    &nbsp;
                  </th>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      ไม่พบข้อมูล
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="" style="padding: 5px 0px 5px 0px; color: #000;">
              ประวัติการประสานงาน
            </div>
            <div class="" id="stageList" style="padding: 5px 0px 5px 0px;">
              <table class="table table-condensed" style="padding: 0px; margin: 0px;">
                <thead style="background: #f3f3f3;">
                  <th>
                    ชื่อผู้ประสาน
                  </th>
                  <th>
                    วันที่-เวลา
                  </th>
                  <th>
                    สถานะ
                  </th>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
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
<script>
    $("#menu-toggle").click(function(e) {
      $("#menu-toggle").blur();
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
