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

$(function(){
    $("#formtambahjadwal").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url:$(this).attr('action'),
            method:$(this).attr('method'),
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            beforeSend:function(){
                $(document).find('span.error-text').text('');
            },
            success:function(data){
                if(data.status==0){
                    $.each(data.error, function(prefix, val){
                        $('#formtambahjadwal span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text-tambah').text('');
                    $('#success-alerts-tambah').hide();
                }else if(data.status==1){
                    $('#formtambahjadwal')[0].reset();
                    $('#success-alerts-tambah').show();
                    const $msg = (data.msg);
                    $(document).find('span.success-text-tambah').text($msg);
                    $('#modaltambahjadwal').on('hidden.bs.modal', function () {
                        location.reload();
                    })
                }
            }
        })
    })
});

$('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
});