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
                            <p>Trado Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="trado" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$data['tradononaktif']}}</h3>
                            <p>Trado Non Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="trado" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$data['supiraktif']}}</h3>
                            <p>Supir Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="supir" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$data['supirnonaktif']}}</h3>
                            <p>Supir Non Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="supir" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <!-- LEFT -->
                <div class="col-md-4">
                    <!-- SERVICE -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row form-group">
                                <label class="col-sm-2 col-form-label">STATUS <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select name="statusservice" class="form-control select2bs4">
                                        <option value="all">-- SEMUA --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">

                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" id="btnService">Refresh</button>
                                </div>
                            </div>
                            <table id="tableService"></table>
                        </div>
                    </div>
                    <!-- STOK MINIMUM -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row form-group">

                                <div class="col-3">
                                    <button type="button" class="btn btn-secondary" id="btnStokMinimum">Refresh</button>
                                </div>
                                <div class="col-9">
                                    <h5>STOK DIBAWAH MINIMUM QTY</h5>
                                </div>
                            </div>
                            <table id="tableStokMinimum"></table>
                        </div>
                    </div>
                </div>

                <!-- CENTER -->
                <div class="col-md-3">
                    <!-- EXP SIM -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row form-group">

                                <div class="col-12">
                                    <button type="button" class="btn btn-block btn-secondary" id="btnExpSIM">Refresh</button>
                                </div>
                            </div>
                            <table id="tableExpSIM"></table>
                        </div>
                    </div>
                    <!-- EXP STNK -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row form-group">
                                <div class="col-12">
                                    <button type="button" class="btn btn-block btn-secondary" id="btnExpSTNK">Refresh</button>
                                </div>
                            </div>
                            <table id="tableExpSTNK"></table>
                        </div>
                    </div>
                    <!-- EXP ASURANSI -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row form-group">

                                <div class="col-12">
                                    <button type="button" class="btn btn-block btn-secondary" id="btnExpAsuransi">Refresh</button>
                                </div>
                            </div>
                            <table id="tableExpAsuransi"></table>
                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-md-5">
                    <!-- STATUS OLI -->
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="tgldarioli" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-sm-1 mt-2">
                                    <h5 class="text-center mt-2">s/d</h5>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="tglsampaioli" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-2 col-form-label mt-2">No Pol<span class="text-danger">*</span></label>
                                <div class="col-sm-6 mt-2">
                                    <input type="hidden" name="tradooli_id">
                                    <input type="text" name="tradooli" class="form-control trado-lookup">
                                </div>
                            </div>
                            <div class="row form-group">

                                <label class="col-sm-2 col-form-label mt-2">Status Oli<span class="text-danger">*</span></label>
                                <div class="col-sm-6 mt-2">
                                    <select name="statusoli" class="form-control select2bs4">
                                        <option value="all">-- SEMUA --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">

                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" id="btnCekOli">Refresh</button>
                                </div>
                            </div>
                            <table id="tableStatusOli"></table>
                        </div>
                    </div>

                    <!-- REMINDER -->
                    <div class="card">
                        <div class="card-body">
                            <div id="tabs">
                                <ul class="dejavu">
                                    <li><a href="#reminder-tab">Reminder SPK</a></li>
                                    <li><a href="#spk-tab">SPK Harian</a></li>
                                </ul>
                                <div id="reminder-tab">
                                    <table id="tableReminderSPK"></table>
                                    <table id="tableReminderSPKDetail"></table>
                                </div>
                                <div id="spk-tab">
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-2 col-form-label mb-2">Periode<span class="text-danger">*</span></label>
                                        <div class="col-sm-4 mt-2">
                                            <div class="input-group">
                                                <input type="text" name="periode" class="form-control datepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <table id="tableSPKHarian"></table>
                                    <table id="tableSPKHarianDetail"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
</div>
</section>
</div>

@include('dashboard._service')
@include('dashboard._oli')
@include('dashboard._expsim')
@include('dashboard._expstnk')
@include('dashboard._expasuransi')
@include('dashboard._stokminimum')
@include('dashboard._reminderspk')
@include('dashboard._spkharian')
@include('dashboard._reminderspkdetail')
@push('scripts')
<script>
    let indexRow = 0;
    $(document).ready(function() {

        initDatepicker()
        initLookup()
        let today = new Date();
        let formattedLastDay;

        // mendapatkan tanggal pertama di bulan ini
        let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        let formattedFirstDay = $.datepicker.formatDate('dd-mm-yy', firstDay);
        let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        formattedLastDay = $.datepicker.formatDate('dd-mm-yy', lastDay);
        $(`[name="tgldarioli"]`).val(formattedFirstDay).trigger('change');
        $(`[name="tglsampaioli"]`).val(formattedLastDay).trigger('change');
        $('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        initSelect2($('.select2bs4'), false)
        $("#tabs").tabs()
        Promise
            .all([
                setStatusServiceOptions(),
            ]).then(() => {
                loadServiceGrid()
                loadStokMinimumGrid()
                loadExpSimGrid()
                loadExpStnkGrid()
                loadExpAsuransiGrid()
                loadOliGrid()
                loadReminderSpkGrid()
                loadReminderSpkDetailGrid()
                loadSPKHarianGrid()
            }).catch((error) => {
                showDialog(error.responseJSON)
            })
    })

    function showDashboard() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}dashboard`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function initLookup() {
        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (trado, element) => {
                $('[name=tradooli_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`[name="tradooli_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
    const setStatusServiceOptions = function() {
        return new Promise((resolve, reject) => {
            $('[name=statusservice]').empty()
            $('[name=statusservice]').append(
                new Option('-- SEMUA --', 'all', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS SERVICE RUTIN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusService => {
                        let option = new Option(statusService.text, statusService.id)

                        $('[name=statusservice]').append(option).trigger('change')
                    });
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    // var donutData = {
    //     labels: [
    //         'Chrome',
    //         'IE',
    //         'FireFox',
    //         'Safari',
    //         'Opera',
    //         'Navigator',
    //     ],
    //     datasets: [{
    //         data: [700, 500, 400, 600, 300, 100],
    //         backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
    //     }]
    // }
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    // var pieData = donutData;
    // var pieOptions = {
    //     maintainAspectRatio: false,
    //     responsive: true,
    // }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // new Chart(pieChartCanvas, {
    //     type: 'pie',
    //     data: pieData,
    //     options: pieOptions
    // })
</script>
@endpush
@endsection