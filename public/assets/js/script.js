$(".nav-btn.pull-left").click(function() {
    $(".sidebar").toggleClass("active_sidebar");
    $(".main-sec").toggleClass("active_main");
    $(".solitude").toggleClass("active_solitude");
    $("body,html").toggleClass("active_body");
});

$(".overflow .cross_icon, .overflow").click(function() {
    $(".sidebar").removeClass("active_sidebar");
    $(".main-sec").removeClass("active_main");
    $(".solitude").removeClass("active_solitude");
    $("body,html").removeClass("active_body");
});


$( function() {
    $( "#datepicker, #datepicker2, .datepicker, .datepicker2, #datepicker4" ).datepicker();
  } );

