$(document).ready(function(){
  var height = $('.leftcontainer').height();
  var displayPanelHeight = (height - 230);

  $('.displayPanel').css('height', displayPanelHeight + 'px');

  $("#overlay").fadeToggle("",function(){
    $('body').css('overflow-y','hidden');
    $(".loadingDiv").fadeToggle("",function(){ // แสดงส่วนของ เนื้อหา popup
      setTimeout(function(){
        initMap();
      },1000);
    });
  });

});

$(function(){
  $('#login').click(function(){
    $("#overlay").fadeToggle("",function(){ // แสดงส่วนของ overlay
            $('body').css('overflow-y','hidden');
            $(".doctor_show").slideToggle("",function(){ // แสดงส่วนของ เนื้อหา popup
                if($(this).css("display")=="block"){        // ถ้าเป็นกรณีแสดงข้อมูล
                 $.post("core/login-screen.php",{},function(data){
                     $(".msg_data").html(data);
                 });
                }
            });
    });
  });

  $('#about').click(function(){

  });

  $('.show_box').click(function(){

  });
});

function assignStaff(stfID){
  $("#overlay").fadeToggle();
  $(".doctor_show").slideToggle();
  $('#txtBAID').val(stfID);
  $('body').css('overflow-y','scroll');
}
