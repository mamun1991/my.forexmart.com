$(document).ready(function(){

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#payment-option').owlCarousel({
        loop:true,
        dots:false,
        autoplay:true,
        margin:10,
        autoWidth:true
    });
    $('.accordion-menu').click(function(){
        $('#sidebarNav').removeClass('sidebar-mobile');
    })
    $('.hamburger-menu').click(function(){
        $('.sidebar').show();
        $('.overlay').css('display','block');
    });
    $( ".toggle-drawer").click(function() {
        $('.sidebar').hide();
        $('.overlay').css('display','none');
    });

    // Responsive
    $('.secondary-menu').removeClass('show');
    $(window).on('resize', function() {
        var width = $(window).width();
        $('.overlay').css('display','none');
        if(width <=767){
            // header
            $('.nav-top-right').detach().insertBefore('.header');
            $('.header').addClass('mobile-header');
            $('#user-profile').addClass('invert-style');
            // sidebar
            $('#sidebarNav').removeClass('sidebar-mobile');
            $('overlay').addClass('overlay-mobile');
            $('.toggle-menu').off('click');
        }
        else if (width <=1665){
            // hedear
            $('.nav-top-right').detach().insertAfter('#primary-menu');
            $('.header').removeClass('mobile-header');
            $('#user-profile').removeClass('invert-style');
            // sidebar
            $('#sidebarNav').addClass('sidebar-mobile');
            $('.sidebar').show();
            $('.overlay').css('display','block');
            $('.secondary-menu').removeClass('show');
        }
        else{
            // header
            $('.nav-top-right').detach().insertAfter('#primary-menu');
            $('.header').removeClass('mobile-header');
            $('#user-profile').removeClass('invert-style');
            // sidebar
            $('#sidebarNav').removeClass('sidebar-mobile');
            $('.secondary-menu').removeClass('show');
            $('.sidebar').show();
            $('.overlay').css('display','block');
        }
    }).resize();

    // stop sidebar to toggle when search and logo clicked
    $(window).on('resize', function() {
        var width1 = $(window).width();
        if(width1 >=767){
            $('.toggle-menu').on("click", function(){
                $('#sidebarNav').toggleClass('sidebar-mobile');
                $('.secondary-menu').removeClass('show');
            });
        }
        else{
            $('.toggle-menu').off('click');
        }
    }).resize();
    $('#toggle-switch').click(function(){
        $('#authentication').toggle();
    });
    $('.nav-tab-link').each(function(){
        $(this).click(function(){
            $('.icon-tab').removeClass('active');
            $(this).find('.icon-tab').addClass('active');
        });
    });
    $('.secondary-menu li a').each(function(){
        $(this).click(function(e){
            $(this).parent('.overlay').css('display','none');
        });
    });

 
});