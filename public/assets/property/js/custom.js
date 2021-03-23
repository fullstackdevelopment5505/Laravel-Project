//Copy Text To Clipboard
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}


// chat_detail_link4 Toggle bulb
$(".chat_detail_link4 .links ul li a").click(function(){
  $(this).find('img.bulb, img.bulb2').toggle();
});


// chat_detail_link4 Toggle fire
$(".chat_detail_link4 .links ul li a").click(function(){
  $(this).find('img.fire, img.fire2').toggle();
});


// chat_detail_link2 Toggle bulb
$(".chat_detail_link2 .links ul li a").click(function(){
  $(this).find('img.bulb, img.bulb2').toggle();
});


// chat_detail_link2 Toggle fire
$(".chat_detail_link2 .links ul li a").click(function(){
  $(this).find('img.fire, img.fire2').toggle();
});



// owl-crousel
$(".owl-carousel.crousel4").owlCarousel({
      margin: 20,
      lazyLoad:true,
      loop:true,
      autoplayTimeout:3000,
      animateOut: 'fadeOut',
      // autoplayHoverPause: true,
        autoplay:true,
        dots: false,
        nav: false,
        responsive:{
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1024: {
                items: 1
            },
            1200: {
                items: 1
        }
    }
}); 
$(".owl-carousel.crousel3").owlCarousel({
      margin: 20,
      loop: true,
        autoplay:true,
        dots: true,
        nav: false,
        responsive:{
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1024: {
                items: 3
            },
            1200: {
                items: 3
        }
    }
}); 

$(".owl-carousel.crousel2").owlCarousel({
      margin: 20,
      loop: true,
        autoplay:true,
        dots: true,
        nav: false,
        responsive:{
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1024: {
                items: 3
            },
            1200: {
                items: 4
        }
    }
}); 

$(".owl-carousel").owlCarousel({
      margin: 20,
      loop: true,
        autoplay:true,
        dots: true,
        nav: false,
        responsive:{
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1024: {
                items: 3
            },
            1200: {
                items: 3
        }
    }
}); 



// Grid View List
$("#listing_prop .listing_heading a.grid_btn").click(function(){
  $(".columns").addClass("grids_layout");
  $(this).addClass('active')
  $(this).siblings().removeClass('active')
});

$("#listing_prop .listing_heading a.list_view").click(function(){
  $(".columns").removeClass("grids_layout");
  $(this).addClass('active')
  $(this).siblings().removeClass('active')
});


$("#listing_prop .listing_heading a.four_list").click(function(){
  $(".columns").addClass("empty_view");
  $(this).addClass('active')
  $(this).siblings().removeClass('active')
});

$("#listing_prop .listing_heading a.grid_btn, #listing_prop .listing_heading a.list_view").click(function(){
  $(".columns").removeClass("empty_view");
  $(this).addClass('active')
  $(this).siblings().removeClass('active')
});







// profile slidtoggle
$(".profile_demo .profbox").click(function(){
  $(".dropside").slideToggle();
});
// click anywhere hide div
$(document).on('click', function(event) {
  if (!$(event.target).closest('.profile_demo').length) {
    $(".dropside").hide();
  }
});





// Edit Profile
$(document).ready(function() {
        var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
});





// Faq
$("#faqbg .accordian .accordian-heading").click(function(){
  $(this).next(".accordian_content").slideToggle();
  $(this).toggleClass("active_accordian");
  $(this).parent().prevAll(".accordian").find(".accordian_content").slideUp();
  $(this).parent().nextAll(".accordian").find(".accordian_content").slideUp();
  $(this).parent().prevAll(".accordian").find(".accordian-heading").removeClass("active_accordian");
  $(this).parent().nextAll(".accordian").find(".accordian-heading").removeClass("active_accordian");
});



// Faq2
$("#prop_content_part .accordian .accordian-heading").click(function(){
  $(this).next(".accordian_content").slideToggle();
  $(this).toggleClass("active_accordian");
  $(this).parent().prevAll(".accordian").find(".accordian_content").slideUp();
  $(this).parent().nextAll(".accordian").find(".accordian_content").slideUp();
  $(this).parent().prevAll(".accordian").find(".accordian-heading").removeClass("active_accordian");
  $(this).parent().nextAll(".accordian").find(".accordian-heading").removeClass("active_accordian");
});




// Advance search faq
$("#advance_search .accordian .accordian-heading").click(function(){
  $(this).next(".accordian_content").slideToggle();
  $(this).toggleClass("active_accordian");
});


// select2 Jquery
$(document).ready(
      function () {
          $('#multipleSelectExample, #multipleSelectExample2, #multipleSelectExample3, #multipleSelectExample4, #multipleSelectExample5, #multipleSelectExample6').select2();
          $('#multipleSelectExample7, #multipleSelectExample8, #multipleSelectExample9, #multipleSelectExample10, #multipleSelectExample11, #multipleSelectExample12').select2();
          $('#multipleSelectExample13, #multipleSelectExample14, #multipleSelectExample15, #multipleSelectExample16, #multipleSelectExample17, #multipleSelectExample18').select2();
          $('#multipleSelectExample19, #multipleSelectExample20, #multipleSelectExample21, #multipleSelectExample22, #multipleSelectExample23, #multipleSelectExample24, #multipleSelectExample25, #multipleSelectExample26, #multipleSelectExample27').select2();
          $('#multipleSelectExample28, #multipleSelectExample29').select2();
      }
);




// SmoothScroll and Select-Option
$('select.drops_scroll').on('change', function(){
    $('.left_box_modal .iner_box').animate({ scrollTop: $('#' + $(this).val()).position().top });
    
});




// Register profile
// profile picture
Dropzone.autoDiscover = false;
   $(document).ready(function () {
        $(".dropzone").dropzone({
            maxFiles: 1,
            addRemoveLinks: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            url: "http://creativebuffer.com/Pimcore/upload.php",  // Please use your own path
            success: function (file, response) {
                console.log(response);
            },
            maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        }
        });
   });
   $(".all_add_new_forms .single_box .add_product_image label > img").click(function(){
  $(".all_add_new_forms .single_box .add_product_image .dropzone").trigger("click");
});





// chat_tab
$(function() {
  var $a = $(".tabs li");
  $a.click(function() {
    $a.removeClass("active");
    $(this).addClass("active");
  });
});





// Property_detial3 Toggle Fire
$("#prop_detail_bg .favicons2 ul li a").click(function(){
  $(this).find('img.fire, img.fire2').toggle();
});

// Property_list Toggle bulb
$("#prop_detail_bg .favicons2 ul li a").click(function(){
  $(this).find('img.bulb, img.bulb2').toggle();
});

// Property_list Toggle bulb
$("#listing_prop .listing_content .chat_detail_link .links ul li a").click(function(){
  $(this).find('img.bulb, img.bulb2').toggle();
});


// Property_list Toggle fire
$("#listing_prop .listing_content .chat_detail_link .links ul li a").click(function(){
  $(this).find('img.fire, img.fire2').toggle();
});






$(".heart-icon i").click(function(){
  $(this).parents(".heart-icon").find("i").toggle();
});