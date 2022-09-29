window.onbeforeunload = function () { window.scrollTo(0,0); };

// Toggle sidebar
$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal-dark"
    });
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    $(this).scrollTop(0);

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('#content .fm-navbar .btn').attr('data-toggle', "tooltip").attr('data-placement', "bottom")
    
    $('#content .fm-navbar .row').children().first().children().last().remove()
    
    $('#content .fm-navbar .row').children().last().children().last().css({'padding-right': '0px', 'margin': '0'})

    $('#content .fm-navbar .row').children().first().children().first().children().first().html("<i class='fas fa-chevron-left'></i>")
    $('#content .fm-navbar .row').children().first().children().first().children().first().next().html("<i class='fas fa-chevron-right'></i>")
    $('#content .fm-navbar .row').children().first().children().first().children().last().html("<span class='material-icons-outlined refresh'>refresh</span>")
    $('#content .fm-navbar .row').children().first().children().first().next().children().last().html("<span class='material-icons-outlined delete'>delete</span>")
    $('#content .fm-navbar .row').children().first().children().first().next().children().last().prev().html("<span class='material-icons-outlined upload'>file_upload</span>")
    $('#content .fm-navbar .row').children().first().children().last().children().first().html("<span class='material-icons-outlined copy-paste'>file_copy</span>")
    $('#content .fm-navbar .row').children().first().children().last().children().first().next().html("<span class='material-icons-outlined copy-paste'>content_cut</span>")
    $('#content .fm-navbar .row').children().first().children().last().children().last().html("<span class='material-icons-outlined copy-paste'>content_paste</span>")
    $('#content span.text-success').html("<span class='material-icons-outlined info'>info</span>")
});

$(window).resize(function () {
    var widthWindow = $(window).width();
    if (widthWindow <= '1000') {
        $('table').addClass('table-responsive');
        $('#content .nav-header').addClass('mr-auto');
        $('#sidebar').addClass('active');
        $('#content .username').addClass('hide');
        $('#sidebarCollapse').on('click', function () {
            // fade in the overlay
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
        $('.overlay').on('click', function () {
            // hide sidebar
            $('#sidebar').addClass('active');
            // hide overlay
            $('.overlay').removeClass('active');
        });
    }
    else
    {
        $('table').removeClass('table-responsive');
        $('#sidebar').removeClass('active');
        $('#content').removeClass('active');
        $('#content .username').removeClass('hide');
        $('.overlay').removeClass('active');
    }
});
$(window).trigger('resize');

$('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
});
