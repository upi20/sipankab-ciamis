<div class="page-header">
    <h1 class="page-title">Kecamatan</h1>
</div>

<div class="card">
    <div class="card-header d-md-flex flex-row justify-content-between">
        <h3 class="card-title">Daftar Kecamatan</h3>
        <div>
            <button class="btn btn-primary btn-sm" id="btn-tambah"><i class="fas fa-plus me-1"></i>Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover" id="table_main">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalMain" tabindex="-1" aria-labelledby="ModalMainLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalMainLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="MainForm">
                    <input type="hidden" id="id" name="id">

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nama Kecamatan" id="nama" name="nama" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="MainForm">
                    <li class="fas fa-save me-1"></li> Simpan
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <li class="fas fa-times me-1"></li>Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const table_html = $('#table_main');
    let form_is_edit = true;

    $(document).ready(function() {
        // datatable ====================================================================================
        const new_table = table_html.DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            aAutoWidth: false,
            bAutoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= route('kecamatan') ?>"
            },
            columns: [{
                    data: null,
                    name: null,
                    orderable: false,
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'id',
                    name: 'id',
                    render(data, type, full, meta) {
                        const btn_update = `<button type="button" class="btn btn-rounded btn-primary btn-sm me-1" title="Edit Data" onClick="editFunc('${data}')">
                                <i class="fas fa-edit"></i> Ubah
                                </button>`;
                        const btn_delete = `<button type="button" class="btn btn-rounded btn-danger btn-sm me-1" title="Delete Data" onClick="deleteFunc('${data}')">
                                <i class="fas fa-trash"></i> Hapus
                                </button>`;
                        return btn_update + btn_delete;
                    },
                    orderable: false,
                    className: 'text-nowrap'
                }
            ],
            order: [
                [1, 'asc']
            ]
        });

        new_table.on('draw.dt', function() {
            var PageInfo = table_html.DataTable().page.info();
            new_table.column(0, {
                page: 'current'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });

        $('#btn-tambah').click(() => {
            $('#ModalMain').modal('show');
            $('#ModalMainLabel').text('Tambah Kecamatan');
            if (!form_is_edit) return false;
            reset_form();
            return true;
        });

        // insertForm ===================================================================================
        $('#MainForm').submit(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show");
            var formData = new FormData(this);
            setBtnLoading('#btn-save', 'Simpan');
            const route = ($('#id').val() == '') ?
                "<?= route('kecamatan.insert') ?>" :
                "<?= route('kecamatan.update') ?>";
            $.ajax({
                type: "POST",
                url: route,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#ModalMain").modal('hide');
                    // terdapat perubahan data
                    var oTable = table_html.dataTable();
                    oTable.fnDraw(false);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    form_is_edit = true;
                },
                error: function(data) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: ((data.responseJSON) ? data.responseJSON.message : 'Something went wrong'),
                        showConfirmButton: false,
                        timer: 1500
                    })
                },
                complete: function() {
                    $.LoadingOverlay("hide");
                    setBtnLoading('#btn-save', '<li class="fas fa-save me-1"></li> Simpan', false);
                }
            });
        });

        $('#FilterForm').submit(function(e) {
            var oTable = table_html.dataTable();
            oTable.fnDraw(false);
        });
    });

    function editFunc(id) {
        $.LoadingOverlay("show");
        $.ajax({
            type: "GET",
            url: `<?= route('kecamatan.find') ?>`,
            data: {
                id
            },
            success: (kecamatan) => {
                if (kecamatan == null) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Gagal Mendapatkan Data',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return;
                }

                // show modal
                $('#ModalMain').modal('show');
                $('#ModalMainLabel').html('Ubah Kecamatan');

                // isi data kecamatan
                $('#id').val(kecamatan.id);
                $('#nama').val(kecamatan.nama);

                form_is_edit = true;
            },
            error: function(data) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Something went wrong',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            complete: function() {
                $.LoadingOverlay("hide");
            }
        });
    }

    function deleteFunc(id) {
        swal.fire({
            title: 'Apakah anda yakin?',
            text: "Akan Menghapus data ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: `<?= route('kecamatan.delete') ?>`,
                    type: 'POST',
                    data: {
                        id
                    },
                    beforeSend: function() {
                        swal.fire({
                            title: 'Tunggu sebentar..!',
                            text: 'Sedang memproses..',
                            onOpen: function() {
                                Swal.showLoading()
                            }
                        })
                    },
                    success: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil menghapus data',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        var oTable = table_html.dataTable();
                        oTable.fnDraw(false);
                    },
                    complete: function() {
                        swal.hideLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal.hideLoading();
                        swal.fire("!Opps ", "Something went wrong, try again later", "error");
                    }
                });
            }
        });
    }

    function reset_form() {
        $('#MainForm').trigger("reset");
        $('#id').val('');
        $('#nama').val('');
        form_is_edit = false;
    }
</script>