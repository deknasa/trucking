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

                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">ID <span class="text-danger"></span></label>
                            <div class="col-sm-2">
                                <input type="text" name="id" class="form-control" value="{{ $cabang['id'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Cabang<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="cabang" class="form-control" value="{{ $cabang['cabang'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Status Aktif<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="statusaktif" id="statusaktif">
                                    <?php foreach ($data['combo'] as $status) : ?>;
                                    <option value="<?= $status['id'] ?>" <?= $status['id'] == @$cabang['statusaktif'] ? 'selected' : '' ?>><?= $status['keterangan'] ?></option>
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
                        <a href="{{ route('cabang.index') }}" class="btn btn-danger">
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
    let indexUrl = "{{ route('cabang.index') }}"
    let fieldLengthUrl = "{{ route('cabang.field_length') }}"
    let action = "{{ $action }}"
    let actionUrl = "{{ route('cabang.store') }}"
    let method = "POST"
    let csrfToken = "{{ csrf_token() }}"

    /* Set action url */
    <?php if ($action == 'edit') : ?>
        actionUrl = "{{ route('cabang.update', $cabang['id']) }}"
        method = "PATCH"
    <?php elseif ($action == 'delete') : ?>
        actionUrl = "{{ route('cabang.destroy', $cabang['id']) }}"
        method = "DELETE"
    <?php endif; ?>

    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault()
        })

        /* Handle on click btnSimpan */
        $('#btnSimpan').click(function() {
            $.ajax({
                url: actionUrl,
                method: method,
                dataType: 'JSON',
                data: $('form').serializeArray(),
                success: response => {
                    if (response.status) {
                        alert(response.message)

                        if (action != 'delete') {
                            window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
                        } else {
                            window.location.href = `${indexUrl}?page={{ $_GET['page'] ?? '' }}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] ?? ''}}&indexRow={{ $_GET['indexRow'] ?? '' }}`
                        }
                    }

                    $.each(response.errors, (index, error) => {
                        // showErrorMessages()

                        $(`[name=${index}]`)
                            .addClass('is-invalid')
                            .after(`
                <div class="invalid-feedback">
                  ${error}
                </div>
              `)

                        console.log(error);
                    })
                },
                error: error => {
                    alert(error)
                }
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