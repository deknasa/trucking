<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">Form {{ $title }}</div>
                <form action="" method="post">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
                        <input type="hidden" name="sortIndex" value="{{ $_GET['sidx'] ?? 'id' }}">
                        <input type="hidden" name="sortOrder" value="{{ $_GET['sord'] ?? 'asc' }}">
                        <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
                        <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">

                        <div class="row form-group">
                            <label for="staticEmail" class="col-12 col-md-2 col-form-label">ID <span class="text-danger"></span></label>
                            <div class="col-12 col-md-10">
                                <input type="text" name="id" class="form-control" value="{{ $container['id'] ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="staticEmail" class="col-12 col-md-2 col-form-label">Kode Container <span class="text-danger">*</span></label>
                            <div class="col-12 col-md-10">
                                <input type="text" name="kodecontainer" class="form-control" value="{{ $container['kodecontainer'] ?? '' }}">
                            </div>
                        </div>


                        <div class="row form-group">
                            <label for="staticEmail" class="col-12 col-md-2 col-form-label">Keterangan <span class="text-danger">*</span></label>
                            <div class="col-12 col-md-10">
                                <input type="text" name="keterangan" class="form-control" value="{{ $container['keterangan'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-12 col-md-2 col-form-label">Status Aktif<span class="text-danger">*</span></label>
                            <div class="col-12 col-md-10">
                                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="statusaktif" id="statusaktif">
                                    <?php foreach ($data['combo'] as $status) : ?>;
                                    <option value="<?= $status['id'] ?>" <?= $status['id'] == @$container['statusaktif'] ? 'selected' : '' ?>><?= $status['keterangan'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btnSimpan" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            @if(isset($action) && $action == 'delete')
                            Delete
                            @else
                            Simpan
                            @endif
                        </button>
                        <a href="{{ route('container.index') }}" class="btn btn-danger">
                            <i class="fa fa-window-close"></i>
                            BATAL
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let indexUrl = "{{ route('container.index') }}"
    let action = "{{ $action }}"
    let actionUrl = "{{ config('app.api_url') . 'container' }}"
    let method = "POST"
    let csrfToken = "{{ csrf_token() }}"

    
    /* Set action url */

    <?php if ($action !== 'add') : ?>
        actionUrl += `/{{ $container['id'] }}`

    <?php endif; ?>

    <?php if ($action == 'edit') : ?>
        method = "PATCH"
    <?php elseif ($action == 'delete') : ?>
        method = "DELETE"
    <?php endif; ?>

    if (action == 'delete') {
        $('[name]').addClass('disabled')
    }


    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault()
        })

        $('#btnSimpan').click(function() {
            $(this).attr('disabled', '')

            $.ajax({
                url: actionUrl,
                method: method,
                dataType: 'JSON',
                headers: {
                    'Authorization': `Bearer {{ session('access_token') }}`
                },
                data: $('form').serializeArray(),
                success: response => {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    if (response.status) {
                        window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
                    }

                    if (response.errors) {
                        setErrorMessages(response.errors)
                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(error.responseJSON.errors);
                      } else {
                        showDialog(error.statusText)
                      }
                },
            }).always(() => {
                $(this).removeAttr('disabled')
            })
        })

        /* Get field maxlength */
        $.ajax({
            url: fieldLengthUrl,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer {{ session('access_token') }}`
            },

            success: response => {
                $.each(response, (index, value) => {
                    if (value !== null && value !== 0 && value !== undefined) {
                        $(`[name=${index}]`).attr('maxlength', value)
                    }
                })
            },
            error: error => {
                alert(error)
            }
        })
    })
</script>
@endpush()