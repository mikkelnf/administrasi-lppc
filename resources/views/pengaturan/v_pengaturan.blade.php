@extends('layout.v_template')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
@endsection 

@section('title-window','Pengaturan')
@section('title','Pengaturan')
       
@section('content')
<div class="page-content">
    @include('pengaturan.v_semesterberjalan')
    <hr class="page-divider">
    @include('pengaturan.v_administrator')
    <hr class="page-divider">
    @include('pengaturan.v_angkatan')
    <hr class="page-divider">
    @include('pengaturan.v_semesterperiode')
    <hr class="page-divider">
    @include('pengaturan.v_skema')
</div>
@endsection  

@section('js')
<script type="text/javascript" src="{{ asset('js') }}/pengaturan.js"></script>
<script type="text/javascript">
@foreach ($semua_angkatan as $data)
    var sel{{ $data->id }} = document.getElementById('status-angkatan{{ $data->id }}');
    sel{{ $data->id }}.onchange = function(){
        sel{{ $data->id }}.classList.remove("merah", "hijau");
        sel{{ $data->id }}.classList.add(this.options[this.selectedIndex].className);
    };
@endforeach
@foreach ($semua_semesterperiode as $data)
    var sel{{ $data->id }} = document.getElementById('status-semester{{ $data->id }}');
    sel{{ $data->id }}.onchange = function(){
        sel{{ $data->id }}.classList.remove("merah", "hijau");
        sel{{ $data->id }}.classList.add(this.options[this.selectedIndex].className);
    };
@endforeach
@foreach ($skema as $data)
    $("#form-editskema{{ $data->id }}").on('submit', function(e){
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
                        $('#form-editskema{{ $data->id }} span.'+prefix+'_error').text(val[0]);
                    });
                    $(document).find('span.success-text').text('');
                    $('#success-alert-skema').hide();
                }
                else{
                    localStorage.setItem("Status-editskema",data.OperationStatus)
                    window.location.reload(); 
                }
            }
        })
    })

    if(localStorage.getItem("Status-editskema"))
    {
        $('#success-alert-skema').show();
        $(document).find('span.tambah-sukses-skema').text('Skema berhasil diedit');
        localStorage.clear();
    }
@endforeach
</script>
@endsection