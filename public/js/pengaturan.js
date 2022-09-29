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

    $("#form-tambahadministrator").on('submit', function(e){
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
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text').text('');
                    $('#success-alert-administrator').hide();
                }else{
                    $('#form-tambahadministrator')[0].reset();
                    $('#success-alert-administrator').show();
                    const $msg = (data.msg);
                    $(document).find('span.success-text').text($msg);
                    $('#tambah-administrator').on('hidden.bs.modal', function () {
                        location.reload();
                    })
                }
            }
        })
    })

    $("#form-tambahangkatan").on('submit', function(e){
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
                        $('#form-tambahangkatan span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text').text('');
                    $('#success-alert-angkatan').hide();
                }
                else{
                    localStorage.setItem("Status-tambahangkatan",data.OperationStatus)
                    window.location.reload(); 
                }
            }
        })
    })

    if(localStorage.getItem("Status-tambahangkatan"))
    {
        $('#success-alert-angkatan').show();
        $(document).find('span.tambah-sukses-angkatan').text('Angkatan berhasil ditambah');
        localStorage.clear();
    }

    $("#form-tambahsemester").on('submit', function(e){
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
                        $('#form-tambahsemester span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text').text('');
                    $('#success-alert-semester').hide();
                }
                else{
                    localStorage.setItem("Status-tambahsemester",data.OperationStatus)
                    window.location.reload(); 
                }
            }
        })
    })

    if(localStorage.getItem("Status-tambahsemester"))
    {
        $('#success-alert-semester').show();
        $(document).find('span.tambah-sukses-semester').text('Semester periode berhasil ditambah');
        localStorage.clear();
    }

    $("#form-tambahskema").on('submit', function(e){
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
                        $('#form-tambahskema span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text').text('');
                    $('#success-alert-skema').hide();
                }
                else{
                    localStorage.setItem("Status-tambahskema",data.OperationStatus)
                    window.location.reload(); 
                }
            }
        })
    })

    if(localStorage.getItem("Status-tambahskema"))
    {
        $('#success-alert-skema').show();
        $(document).find('span.tambah-sukses-skema').text('Skema berhasil ditambah');
        localStorage.clear();
    }
});

var selangkatan = document.getElementById('status-angkatan');
    selangkatan.onchange = function(){
    selangkatan.classList.remove("merah", "hijau");
    selangkatan.classList.add(this.options[this.selectedIndex].className);
};

var selsemester = document.getElementById('status-semester');
    selsemester.onchange = function(){
    selsemester.classList.remove("merah", "hijau");
    selsemester.classList.add(this.options[this.selectedIndex].className);
};

$('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
});

$('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
});

$('.daftar-administrator .list-button #button-bottom').on('click', function () {
    if($('.daftar-administrator .list-group-item.x').hasClass('hide')){
        $('.daftar-administrator .list-group-item').removeClass('hide')
        $('.daftar-administrator .list-group-item.x').addClass('unhide')
        $('.daftar-administrator .list-button #button-bottom').html('Tampilkan lebih sedikit <img class="arrowicon" src="/img/arrow.png">')
        $('.daftar-administrator .list-button').addClass('aktif')
        
    }
    else {
        $('.daftar-administrator .list-group-item.x').addClass('hide')
        $('.daftar-administrator .list-group-item').removeClass('unhide')
        $('.daftar-administrator .list-button #button-bottom').html('Tampilkan lebih banyak <img class="arrowicon" src="/img/arrow.png">')
        $('.daftar-administrator .list-button.aktif').removeClass('aktif')
    }
})

$('.daftar-angkatan .list-button #button-bottom').on('click', function () {
    if($('.daftar-angkatan .list-group-item.x').hasClass('hide')){
        $('.daftar-angkatan .list-group-item').removeClass('hide')
        $('.daftar-angkatan .list-group-item.x').addClass('unhide')
        $('.daftar-angkatan .list-button #button-bottom').html('Tampilkan lebih sedikit <img class="arrowicon" src="/img/arrow.png">')
        $('.daftar-angkatan .list-button').addClass('aktif')
        
    }
    else {
        $('.daftar-angkatan .list-group-item.x').addClass('hide')
        $('.daftar-angkatan .list-group-item').removeClass('unhide')
        $('.daftar-angkatan .list-button #button-bottom').html('Tampilkan lebih banyak <img class="arrowicon" src="/img/arrow.png">')
        $('.daftar-angkatan .list-button.aktif').removeClass('aktif')
    }
})

$('.daftar-semester .list-button #button-bottom').on('click', function () {
    if($('.daftar-semester .list-group-item.x').hasClass('hide')){
        $('.daftar-semester .list-group-item').removeClass('hide')
        $('.daftar-semester .list-group-item.x').addClass('unhide')
        $('.daftar-semester .list-button #button-bottom').html('Tampilkan lebih sedikit <img class="arrowicon" src="/img/arrow.png">')
        $('.daftar-semester .list-button').addClass('aktif')
        
    }
    else {
        $('.daftar-semester .list-group-item.x').addClass('hide')
        $('.daftar-semester .list-group-item').removeClass('unhide')
        $('.daftar-semester .list-button #button-bottom').html('Tampilkan lebih banyak <img class="arrowicon" src="/img/arrow.png">')
        $('.daftar-semester .list-button.aktif').removeClass('aktif')
    }
})

