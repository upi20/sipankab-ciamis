<div class="page-header">
    <h1 class="page-title">Profile Calon</h1>
</div>

<div class="card">
    <div class="card-header d-md-flex flex-row justify-content-between">
        <h3 class="card-title">Daftar Calon</h3>
        <div>
            <button class="btn btn-primary btn-sm" id="btn-tambah"><i class="fas fa-plus me-1"></i>Tambah</button>
        </div>
    </div>
    <div class="card-body">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default active mb-2">
                <div class="panel-heading " role="tab" id="headingOne1">
                    <h4 class="panel-title">
                        <a role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            Filter Data
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                    <div class="panel-body">
                        <form action="javascript:void(0)" class="ml-md-3 mb-md-3" id="FilterForm">
                            <div class="form-group float-start me-2">
                                <label for="filter_kecamatan_id">Kecamatan</label>
                                <select class="form-control" id="filter_kecamatan_id" name="filter_kecamatan_id" style="max-width: 200px">
                                    <option value="">Semua Kecamatan</option>
                                    <?php foreach ($kecamatans ?? [] as $kecamatan) : ?>
                                        <option value="<?= $kecamatan['id'] ?>"><?= $kecamatan['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group float-start me-2">
                                <label for="filter_jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="filter_jenis_kelamin" name="filter_jenis_kelamin">
                                    <option value="">Semua Jenis Kelamin</option>
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </div>
                        </form>
                        <div style="clear: both"></div>
                        <button type="submit" form="FilterForm" class="btn btn-rounded btn-md btn-info" data-toggle="tooltip" title="Refresh Filter Table">
                            <i class="fas fa-sync"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover" id="table_main">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kecamatan</th>
                    <th>No. Pend.</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No. Telepon</th>
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
                        <label for="kecamatan_id" class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kecamatan_id" name="kecamatan_id" required>
                                <option value="">Pilih Kecamatan</option>
                                <?php foreach ($kecamatans ?? [] as $kecamatan) : ?>
                                    <option value="<?= $kecamatan['id'] ?>"><?= $kecamatan['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nomor_pendaftaran" class="col-sm-2 col-form-label">No. Pendaftaran</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nomor Pendaftaran" id="nomor_pendaftaran" name="nomor_pendaftaran" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nama Calon" id="nama" name="nama" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="LAKI-LAKI">LAKI-LAKI</option>
                                <option value="PEREMPUAN">PEREMPUAN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" placeholder="Alamat" id="alamat" name="alamat"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nomor_telepon" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nomor Telepon" id="nomor_telepon" name="nomor_telepon">
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
                url: "<?= route('calon') ?>",
                data: function(d) {
                    d['filter[jenis_kelamin]'] = $('#filter_jenis_kelamin').val();
                    d['filter[kecamatan_id]'] = $('#filter_kecamatan_id').val();
                }
            },
            columns: [{
                    data: null,
                    name: null,
                    orderable: false,
                },
                {
                    data: 'kecamatan',
                    name: 'kecamatan'
                },
                {
                    data: 'nomor_pendaftaran',
                    name: 'nomor_pendaftaran'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'nomor_telepon',
                    name: 'nomor_telepon'
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
            $('#ModalMainLabel').text('Tambah Calon');
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
                "<?= route('calon.insert') ?>" :
                "<?= route('calon.update') ?>";
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
            url: `<?= route('calon.find') ?>`,
            data: {
                id
            },
            success: (calon) => {
                if (calon == null) {
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
                $('#ModalMainLabel').html('Ubah Calon');

                // isi data calon
                $('#id').val(calon.id);
                $('#kecamatan_id').val(calon.kecamatan_id);
                $('#nomor_pendaftaran').val(calon.nomor_pendaftaran);
                $('#nama').val(calon.nama);
                $('#jenis_kelamin').val(calon.jenis_kelamin);
                $('#alamat').val(calon.alamat);
                $('#nomor_telepon').val(calon.nomor_telepon);

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
                    url: `<?= route('calon.delete') ?>`,
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