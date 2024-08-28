@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row" id="kelompok">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">kelompok<span class="text-danger"></span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="kelompok_id">
                                            <input type="text" name="kelompok" class="form-control kelompok-lookup">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-12 col-sm-3  col-form-label mt-2">status reuse<span class="text-danger"></span></label>
                                    <div class="col-sm-9 mt-2">
                                        <!-- offset-sm-1 -->
                                        <div class="input-group">
                                            <select name="statusreuse" id="statusreuse" class="form-select select2bs4" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row" id="kelompok">
                                    <label class="col-12 col-sm-3  col-form-label mt-2">status ban<span class="text-danger"></span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <select name="statusban" id="statusban" class="form-select select2bs4" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-12 col-sm-3  col-form-label mt-2">FILTER<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <select name="filter" id="filter" class="form-select select2bs4" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="row">
                                    <label class="col-12 col-sm-3  col-form-label mt-2">jenis tgl Tampil<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <select name="jenistgltampil" id="jenistgltampil" class="form-select select2bs4" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="text" name="priode" class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row" id="gudang">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">GUDANG<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="gudang_id">
                                            <input type="text" name="gudang" class="form-control gudang-lookup">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="trado">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">TRADO<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="trado_id">
                                            <input type="text" name="trado" class="form-control trado-lookup">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="gandengan">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">GANDENGAN<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="gandengan_id">
                                            <input type="text" name="gandengan" class="form-control gandengan-lookup">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class=" row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">Stok<span class="text-danger"></span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="stokdari_id">
                                            <input type="text" id="stokdari" name="stokdari" class="form-control stokdari-lookup">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <label class="col-12 col-sm-3 col-form-label mt-2">Periode<span class="text-danger"></span></label> --}}
                            <div class="col-md-6">
                                <div class="row">
                                    <h5 class="col-12 col-sm-3 text-center mt-2">s/d</h5>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="stoksampai_id">
                                            <input type="text" id="stoksampai" name="stoksampai" class="form-control stoksampai-lookup">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" row">
                            <!-- <div class="col-md-6">
                                <div class="row">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="text" name="priode" class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="row" id="kelompok">
                                    <label class="col-12 col-sm-3  col-form-label mt-2">JENIS LAPORAN<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <select name="jenislaporan" id="jenislaporan" class="form-select select2bs4" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" row">
                            <div class="col-md-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </button>
                                <button type="button" id="btnExport" class="btn btn-warning mr-2 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </button>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let indexRow = 0;
    let id = "";
    let triggerClick = true;
    $(document).ready(function() {
        initLookup()
        initDatepicker()
        initSelect2($('#crudForm').find('[name=filter]'), false)
        initSelect2($('#crudForm').find('[name=statusban]'), false)
        initSelect2($('#crudForm').find('[name=jenislaporan]'), false)
        initSelect2($('#crudForm').find('[name=statusreuse]'), false)
        initSelect2($('#crudForm').find('[name=jenistgltampil]'), false)

        let form = $("#crudForm");
        $('#crudForm').find('[name=priode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        // $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        setFilterOptions(form)
        setStatusBanOptions(form)
        setJenisLaporanOptions(form)
        setStatusReuseOptions(form)
        setJenisTglTampilOptions(form)
    })

    $(document).on('click', `#btnPreview`, function(event) {

        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let statusreuse = $('#crudForm').find('[name=statusreuse]').val()
        let statusban = $('#crudForm').find('[name=statusban]').val()
        let jenislaporan = $('#crudForm').find('[name=jenislaporan]').val()
        let filter = $('#crudForm').find('[name=filter]').val()
        let jenistgltampil = $('#crudForm').find('[name=jenistgltampil]').val()
        let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        let trado_id = $('#crudForm').find('[name=trado_id]').val()
        let gandengan_id = $('#crudForm').find('[name=gandengan_id]').val()
        let priode = $('#crudForm').find('[name=priode]').val()
        // let sampai = $('#crudForm').find('[name=sampai]').val()
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let dataFilter = ''
        if (filter == '186') {
            dataFilter = gudang_id
        }
        if (filter == '187') {
            dataFilter = trado_id
        }
        if (filter == '188') {
            dataFilter = gandengan_id
        }

        if (
            // (kelompok_id != '') &&
            // (statusreuse != '') &&
            // (statusban != '') &&
            // (filter != '') &&
            (jenislaporan != '') &&
            (priode != '')
            // (stokdari_id != '') &&
            // (stoksampai_id != '') &&
            // (dataFilter != '')
        ) {
            window.open(`{{ route('laporansaldoinventory.report') }}?kelompok_id=${kelompok_id}&statusreuse=${statusreuse}&statusban=${statusban}&jenislaporan=${jenislaporan}&filter=${filter}&jenistgltampil=${jenistgltampil}&priode=${priode}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&dataFilter=${dataFilter}`)

        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    $(document).on('click', `#btnExport`, function(event) {
        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let kelompok = $('#crudForm').find('[name=kelompok]').val()
        let statusreuse = $('#crudForm').find('[name=statusreuse]').val()
        let statusban = $('#crudForm').find('[name=statusban]').val()
        let jenislaporan = $('#crudForm').find('[name=jenislaporan]').val()
        let filter = $('#crudForm').find('[name=filter]').val()
        let jenistgltampil = $('#crudForm').find('[name=jenistgltampil]').val()
        let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        let trado_id = $('#crudForm').find('[name=trado_id]').val()
        let gandengan_id = $('#crudForm').find('[name=gandengan_id]').val()
        let priode = $('#crudForm').find('[name=priode]').val()
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let dataFilter = ''
        if (filter == '186') {
            dataFilter = gudang_id
        }
        if (filter == '187') {
            dataFilter = trado_id
        }
        if (filter == '188') {
            dataFilter = gandengan_id
        }

        if (
            //(kelompok_id != '') &&
            // (statusreuse != '') &&
            // (statusban != '') &&
            // (filter != '') &&
            // (jenistgltampil != '') &&
            (priode != '')
            // (stokdari_id != '') &&
            // (stoksampai_id != '') &&
            // (dataFilter != '')
        ) {
            window.open(`{{ route('laporansaldoinventory.export') }}?kelompok_id=${kelompok_id}&kelompok=${kelompok}&statusreuse=${statusreuse}&statusban=${statusban}&jenislaporan=${jenislaporan}&filter=${filter}&jenistgltampil=${jenistgltampil}&priode=${priode}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&dataFilter=${dataFilter}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {

        $('.stokdari-lookup').lookup({
            title: 'stok dari lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stokdari_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stokdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        // $('.stokdari-lookup').lookupMaster({
        //     title: 'stok dari Lookup',
        //     fileName: 'stokMaster',
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: 'stokdari_id',
        //             searchText: 'stokdari-lookup',
        //             title: 'Stok',
        //             typeSearch: 'ALL',
        //         }
        //     },
        //     onSelectRow: (stok, element) => {
        //         $('#crudForm [name=stokdari_id]').first().val(stok.id)
        //         element.val(stok.namastok)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=stokdari_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })

        $('.stoksampai-lookup').lookup({
            title: 'stok sampai dari lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stoksampai_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stoksampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        // $('.stoksampai-lookup').lookupMaster({
        //     title: 'stok sampai dari Lookup',
        //     fileName: 'stokMaster',
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: 'stoksampai_id',
        //             searchText: 'stoksampai-lookup',
        //             title: 'Stok',
        //             typeSearch: 'ALL',
        //             roleInput: 'role',
        //             isLookup: true
        //         }
        //     },
        //     onSelectRow: (stok, element) => {
        //         $('#crudForm [name=stoksampai_id]').first().val(stok.id)
        //         element.val(stok.namastok)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=stoksampai_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })

        $('.kelompok-lookup').lookup({
            title: 'kelompok dari lookup',
            fileName: 'kelompok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kelompok, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
                element.val(kelompok.kodekelompok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=kelompok_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.gudang-lookup').lookup({
            title: 'gudang dari lookup',
            fileName: 'gudang',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gudang, element) => {
                $('#crudForm [name=gudang_id]').first().val(gudang.id)
                element.val(gudang.gudang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gudang_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.trado-lookup').lookup({
            title: 'Trado lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.gandengan-lookup').lookup({
            title: 'Gandengan lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
                element.val(gandengan.kodegandengan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gandengan_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    $(document).on('change', `#crudForm [name="filter"]`, function(event) {
        let filter = $(this).val();

        if (filter == '186') {
            $('#gudang').show()
            $('#trado').hide()
            $('#gandengan').hide()
        } else if (filter == '187') {
            $('#trado').show()
            $('#gudang').hide()
            $('#gandengan').hide()
        } else if (filter == '188') {
            $('#gandengan').show()
            $('#gudang').hide()
            $('#trado').hide()
        } else {
            $('#trado').hide()
            $('#gandengan').hide()
            $('#gudang').hide()
        }
    })


    const setFilterOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=filter]').empty()
            relatedForm.find('[name=filter]').append(
                new Option('-- SEMUA --', '0', false, true)
            ).trigger('change')

            let data = [];
            data.push({
                name: 'grp',
                value: 'STOK PERSEDIAAN'
            })
            data.push({
                name: 'subgrp',
                value: 'STOK PERSEDIAAN'
            })
            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    response.data.forEach(stokPersediaan => {
                        let option = new Option(stokPersediaan.text, stokPersediaan.id)
                        relatedForm.find('[name=filter]').append(option).trigger(
                            'change')
                    });

                }
            })
        })
    }

    const setStatusBanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusban]').empty()
            relatedForm.find('[name=statusban]').append(
                new Option('-- PILIH STATUS BAN --', '', false, true)
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
                            "data": "STATUS KONDISI BAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusReuse => {
                        let option = new Option(statusReuse.text, statusReuse.id)

                        relatedForm.find('[name=statusban]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setJenisLaporanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=jenislaporan]').empty()
            relatedForm.find('[name=jenislaporan]').append(
                new Option('-- PILIH JENIS LAPORAN --', '', false, true)
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
                            "data": "JENIS LAPORAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusReuse => {
                        let option = new Option(statusReuse.text, statusReuse.id)

                        relatedForm.find('[name=jenislaporan]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }    

    const setJenisTglTampilOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=jenistgltampil]').empty()
            relatedForm.find('[name=jenistgltampil]').append(
                new Option('-- PILIH jenis tgl tampil --', '', false, true)
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
                            "data": "LAPORAN STOK INVENTORI"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusReuse => {
                        let option = new Option(statusReuse.text, statusReuse.id)

                        relatedForm.find('[name=jenistgltampil]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusReuseOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusreuse]').empty()
            relatedForm.find('[name=statusreuse]').append(
                new Option('-- PILIH STATUS REUSE --', '', false, true)
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
                            "data": "STATUS REUSE"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach((statusReuse, index) => {
                        // dataReuse[index] = statusReuse
                        // dataReuse[index]['text'] =  statusReuse.text

                        let option = new Option(statusReuse.text, statusReuse.id)

                        relatedForm.find('[name=statusreuse]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }
</script>
@endpush()
@endsection