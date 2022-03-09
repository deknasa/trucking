<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">Form {{ $title }}</div>
                <form action="" method="post">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
                        <input type="hidden" name="sortname" value="{{ $_GET['sidx'] ?? 'id' }}">
                        <input type="hidden" name="sortorder" value="{{ $_GET['sord'] ?? 'asc' }}">
                        <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
                        <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">

                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">ID <span class="text-danger"></span></label>
                            <div class="col-sm-2">
                                <input type="text" name="id" class="form-control" value="{{ $container['id'] ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Keterangan <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="keterangan" class="form-control" value="{{ $container['keterangan'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Status Aktif<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
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
    let fieldLengthUrl = "{{ route('container.field_length') }}"
    let action = "{{ $action }}"
    let actionUrl = "{{ route('container.store') }}"
    let method = "POST"
    let csrfToken = "{{ csrf_token() }}"

    /* Set action url */
    <?php if ($action == 'edit') : ?>
        actionUrl = "{{ route('container.update', $container['id']) }}"
        method = "PATCH"
    <?php elseif ($action == 'delete') : ?>
        actionUrl = "{{ route('container.destroy', $container['id']) }}"
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