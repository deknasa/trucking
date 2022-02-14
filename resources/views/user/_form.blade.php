<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">Form {{ $title }}</div>
                <form action="" method="post">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
                        <input type="hidden" name="sortname" value="{{ $_GET['sortname'] ?? 'id' }}">
                        <input type="hidden" name="sortorder" value="{{ $_GET['sortorder'] ?? 'asc' }}">
                        <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
                        <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">


                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">ID <span class="text-danger"></span></label>
                            <div class="col-sm-2">
                                <input type="text" name="id" class="form-control" value="{{ $user['id'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">User<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="user" class="form-control" value="{{ $user['user'] ?? '' }}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama User<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" value="{{ $user['name'] ?? '' }}">
                            </div>
                        </div>
                        @if($action == 'add')
                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Password<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control" value="{{ $user['password'] ?? '' }}">
                            </div>
                        </div>
                        @endif


                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Cabang<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="cabang_id" id="cabang_id">
                                    <?php foreach ($data['combocabang'] as $status) : ?>;
                                    <option value="<?= $status['id'] ?>" <?= $status['id'] == @$user['cabang_id'] ? 'selected' : '' ?>><?= $status['namacabang'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>




                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Karyawan ID<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="karyawan_id" class="form-control" value="{{ $user['karyawan_id'] ?? 0 }}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Dashboard<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="dashboard" class="form-control" value="{{ $user['dashboard'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Status Aktif<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="statusaktif" id="statusaktif">
                                    <?php foreach ($data['combo'] as $status) : ?>;
                                    <option value="<?= $status['id'] ?>" <?= $status['id'] == @$user['statusaktif'] ? 'selected' : '' ?>><?= $status['keterangan'] ?></option>
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
                        <a href="{{ route('user.index') }}" class="btn btn-danger">
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
    let indexUrl = "{{ route('user.index') }}"
    let fieldLengthUrl = "{{ route('user.field_length') }}"
    let action = "{{ $action }}"
    let actionUrl = "{{ route('user.store') }}"
    let method = "POST"
    let csrfToken = "{{ csrf_token() }}"

    /* Set action url */
    <?php if ($action == 'edit') : ?>
        actionUrl = "{{ route('user.update', $user['id']) }}"
        method = "PATCH"
    <?php elseif ($action == 'delete') : ?>
        actionUrl = "{{ route('user.destroy', $user['id']) }}"
        method = "DELETE"
    <?php endif; ?>

    if (action == 'delete') {
        $('[name]').addClass('disabled')
        $('#statusaktif').prop("disabled", true)
        $('#cabang_id').prop("disabled", true)
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
                    alert(`${error.statusText} | ${error.responseText}`)
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