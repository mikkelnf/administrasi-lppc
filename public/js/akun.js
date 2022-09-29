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
        $('#content .list-group').removeClass('list-group-flush');
        $('#content .list-group').addClass('list-group-horizontal');
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
        $('#content .list-group').addClass('list-group-flush');
        $('#content .list-group').removeClass('list-group-horizontal');
    }
});
$(window).trigger('resize');

$(function(){

    $("#form-editprofil").on('submit', function(e){
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
                        $('#form-editprofil span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text').text('');
                    $('#success-alert-profil').hide();
                }
                else{
                    localStorage.setItem("Status-edit",data.OperationStatus)
                    window.location.reload(); 
                }
            }
        })
    })

    if(localStorage.getItem("Status-edit"))
    {
        $('#success-alert-profil').show();
        $(document).find('span.success-text').text('Profil berhasil diubah');
        localStorage.clear();
    }

});

$('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
});
