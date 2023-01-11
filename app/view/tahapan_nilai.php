<div class="page-header">
    <h1 class="page-title">Nilai Tahapan <?= $tahapan['nama'] ?></h1>
</div>

<div class="card">
    <div class="card-header d-md-flex flex-row justify-content-between">
        <h3 class="card-title">Daftar Nilai</h3>
        <div>
            <button class="btn btn-primary btn-sm" id="btn-tambah"><i class="fas fa-plus me-1"></i>Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover" id="table_main">
            <thead>
                <tr>
                    <th rowspan="2" class="align-middle">No</th>
                    <th rowspan="2" class="align-middle">Urutan</th>
                    <th rowspan="2" class="align-middle">Nilai</th>
                    <th rowspan="2" class="align-middle">Nama</th>
                    <th colspan="2" class="align-middle text-center">Nilai</th>
                    <th rowspan="2" class="align-middle">Action</th>
                </tr>
                <tr>
                    <th>Dari</th>
                    <th>Sampai</th>
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
                    <input type="hidden" id="tahapan_id" name="tahapan_id" value="<?= $tahapan['id'] ?>">

                    <div class="row mb-3">
                        <label for="urutan" class="col-sm-2 col-form-label">Urutan</label>
                        <div class="col-sm-10">
                            <input type="number" min="1" class="form-control" placeholder="Urutan Penilaian" id="urutan" name="urutan" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nilai" class="col-sm-2 col-form-label">Nilai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Contoh: A,B,C" id="nilai" name="nilai" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nilai_nama" class="col-sm-2 col-form-label">Nama Nilai</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Contoh: Baik, Kurang, Sangat Kurang" id="nilai_nama" name="nilai_nama" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nilai_dari" class="col-sm-2 col-form-label">Nilai Dari</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" class="form-control" placeholder="Nilai Dari" id="nilai_dari" name="nilai_dari" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nilai_sampai" class="col-sm-2 col-form-label">Nilai Sampai</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" class="form-control" placeholder="Nilai Sampai" id="nilai_sampai" name="nilai_sampai" required>
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
                url: "<?= route('tahapan.nilai') ?>",
                data: function(d) {
                    d['filter[tahapan_id]'] = $('#tahapan_id').val();
                }
            },
            columns: [{
                    data: null,
                    name: null,
                    orderable: false,
                },
                {
                    data: 'urutan',
                    name: 'urutan'
                },
                {
                    data: 'nilai',
                    name: 'nilai'
                },
                {
                    data: 'nilai_nama',
                    name: 'nilai_nama'
                },
                {
                    data: 'nilai_dari',
                    name: 'nilai_dari'
                },
                {
                    data: 'nilai_sampai',
                    name: 'nilai_sampai'
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
            $('#ModalMainLabel').text('Tambah Nilai Tahapan');
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
                "<?= route('tahapan.nilai.insert') ?>" :
                "<?= route('tahapan.nilai.update') ?>";
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
            url: `<?= route('tahapan.nilai.find') ?>`,
            data: {
                id
            },
            success: (tahapan) => {
                if (tahapan == null) {
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
                $('#ModalMainLabel').html('Ubah Nilai Tahapan');

                // isi data tahapan
                $('#id').val(tahapan.id);
                $('#urutan').val(tahapan.urutan);
                $('#nilai').val(tahapan.nilai);
                $('#nilai_nama').val(tahapan.nilai_nama);
                $('#nilai_dari').val(tahapan.nilai_dari);
                $('#nilai_sampai').val(tahapan.nilai_sampai);

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
                    url: `<?= route('tahapan.nilai.delete') ?>`,
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
        form_is_edit = false;
    }
</script>