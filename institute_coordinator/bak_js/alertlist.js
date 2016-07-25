$(document).ready(function(){
  var height = $('.leftcontainer').height();
  var displayPanelHeight = (height - 270);
  $('.displayPanel').css('height', displayPanelHeight + 'px');

  $.post("../core/fetch-alert-list.php" ,function(data) {
    $('#recordPanel').html(data);
  });

});

$(function(){
  $('#txtInstitute').change(function(){
    $.post("../core/fetch-staff.php" , { instituteID : $('#txtInstitute').val() },function(data) {
      $('#coList').html(data);
    });
  });

  $('#login').click(function(){
    swal({
      title: "ยืนยันการออกจากระบบ?",
      text: "ต้องการออกจากระบบหรือไม่?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm){
      if (isConfirm) {
        window.location = '../signout.php';
      } else {
        // swal("Cancelled", "Your imaginary file is safe :)", "error");
      }
    });
  });

});

function assignStaff(stfID){
  $("#overlay").fadeToggle();
  $(".doctor_show").slideToggle();
  $('#txtBAID').val(stfID);
  $('body').css('overflow-y','scroll');
}
