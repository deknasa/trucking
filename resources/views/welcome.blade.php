@extends('layouts.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <!-- Info boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$data['tradoaktif']}}</h3>
                            <h5>Trado Aktif</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="trado?status=AKTIF" class="small-box-footer trado">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-green-slate">
                        <div class="inner">
                            <h3>{{$data['supiraktif']}}</h3>
                            <h5>Supir Aktif</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="supir?status=AKTIF" class="small-box-footer supir">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$data['tradononaktif']}}</h3>
                            <h5>Trado Non Aktif</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="trado?status=NON%20AKTIF" class="small-box-footer trado">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark-orange">
                        <div class="inner">
                            <h3>{{$data['supirnonaktif']}}</h3>
                            <h5>Supir Non Aktif</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="supir?status=NON%20AKTIF" class="small-box-footer supir">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow-light">
                        <div class="inner">
                            <h5>Reminder Stok</h5>
                        </div>
                        <a href="reminderstok" id="reminderstok" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5>Reminder SPK</h5>
                        </div>
                        <a href="reminderspk" id="reminderspk" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h5>SPK harian</h5>
                        </div>
                        <a href="spkharian" id="spkharian" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-lightblue">
                        <div class="inner">
                            <h5>EXP SIM</h5>
                        </div>
                        <a href="expsim" id="expsim" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h5>EXP STNK</h5>
                        </div>
                        <a href="expstnk" id="expstnk" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h5>EXP ASURANSI</h5>
                        </div>
                        <a href="expasuransi" id="expasuransi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-pink">
                        <div class="inner">
                            <h5>Reminder Penggantian Oli</h5>
                        </div>
                        <a href="reminderoli" id="reminderoli" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h5>STATUS OLI TRADO</h5>
                        </div>
                        <a href="statusolitrado" id="statusolitrado" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
</div>
</section>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        pleaseSelectARow = `<?php echo $data['error']; ?>`;
        var from_login = "{{ session()->has('from_login') }}"

        if (!`{{ $myAuth->hasPermission('reminderoli', 'index') }}`) {
            $('#reminderoli').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('supir', 'index') }}`) {
            $('.supir').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('trado', 'index') }}`) {
            $('.trado').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('reminderstok', 'index') }}`) {
            $('#reminderstok').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('reminderspk', 'index') }}`) {
            $('#reminderspk').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('spkharian', 'index') }}`) {
            $('#spkharian').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('expsim', 'index') }}`) {
            $('#expsim').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('expstnk', 'index') }}`) {
            $('#expstnk').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('expasuransi', 'index') }}`) {
            $('#expasuransi').attr('href', '#')
        }
        if (!`{{ $myAuth->hasPermission('statusolitrado', 'index') }}`) {
            $('#statusolitrado').attr('href', '#')
        }
        if (from_login) {
            showLoginModal()
        }
    })

    function showLoginModal() {
        let show = `<?php echo $reminder['show']; ?>`;
        if (show == 1) {
            let dataApprovalFinal = `<?php echo $reminder['data']; ?>`;
            showDialog('Ada Absensi Belum Approval Final, Tanggal : ' + dataApprovalFinal);
        }
    }
</script>
@endpush
@endsection