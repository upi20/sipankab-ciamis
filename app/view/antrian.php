<div class="page-header">
    <h1 class="page-title">Antrian Pasien</h1>
    <?php if ($jml_dokter > 0) : ?>
        <div>
            <button class="btn btn-cyan ms-md-2 mb-1" id="btn-registrasi">
                <i class="fas fa-edit me-1"></i>Pasien Baru
            </button>
        </div>
    <?php endif ?>
</div>

<?php if ($jml_dokter > 0) : ?>
    <div class="card" id="tambah-antrian-select2">
        <div class="card-header flex-column">
            <div class="row w-100 mb-3" <?= $jml_dokter > 1 ? '' : 'style="display:none"' ?>>
                <label for="dokter_id" class="col-sm-2 col-form-label">Dokter</label>
                <div class="col-sm-10">
                    <select class="form-control" id="dokter_id" name="dokter_id">
                        <?php foreach ($dokters as $dokter) : ?>
                            <option value="<?= $dokter['dokter_id'] ?>"><?= $dokter['nama'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="d-md-flex flex-row justify-content-between w-100">
                <div class="me-3 text-center">
                    <h3 class="h3 m-0 no-antrian">1</h3>
                    <span>Selanjutnya</span>
                    <!-- <input type="text" class="form-control no-antrian fw-bold h4 px-0" readonly style="max-width: 85px; background: none; border: 0;"> -->
                </div>
                <div class="mb-1" style="width: 100%;">
                    <select class="form-control" id="pasien_mr" name="pasien_mr" style="width: 100%;"></select>
                </div>
                <div>
                    <button class="btn btn-primary ms-md-2 mb-1" id="btn-tambah">
                        <i class="fas fa-plus me-1"></i>Antri
                    </button>
                </div>
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
                                    <label for="filter_status">Status</label>
                                    <select class="form-control" id="filter_status" name="filter_status" style="max-width: 200px">
                                        <option value="">Semua Status</option>
                                        <option value="1" selected>Menunggu Antrian</option>
                                        <option value="2">Masuk</option>
                                        <option value="3">Selesai</option>
                                        <option value="4">Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="form-group float-start me-2">
                                    <label for="filter_ktp_ada">KTP Ada</label>
                                    <select class="form-control" id="filter_ktp_ada" name="filter_ktp_ada" style="max-width: 200px">
                                        <option value="" selected>Semua</option>
                                        <option value="1">Ada</option>
                                        <option value="0">Tidak Ada</option>
                                    </select>
                                </div>
                                <div class="form-group float-start me-2">
                                    <label for="filter_tanggal">Tanggal</label>
                                    <input type="date" class="form-control date-input-str" id="filter_tanggal" name="filter_tanggal" style="max-width: 200px" value="<?= date('Y-m-d') ?>">
                                </div>
                            </form>
                            <div style="clear: both"></div>
                            <button type="submit" form="FilterForm" class="btn btn-rounded btn-md btn-info" data-toggle="tooltip" title="Refresh Filter Table">
                                <i class="fas fa-sync"></i> Refresh Antrian
                            </button>
                            <button type="submit" onclick="reset_filter()" class="btn btn-rounded btn-md btn-success" data-toggle="tooltip" title="Reset Filter">
                                <i class="fas fa-times"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <label class="custom-switch form-switch me-5 my-2">
                <input type="checkbox" name="refresh-otomatis" checked class="custom-switch-input" id="refresh-otomatis">
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">Ringkas Tombol Aksi</span>
            </label>
            <table class="table table-hover" id="table_main">
                <thead>
                    <tr>
                        <th style="max-width: 100px;">No</th>
                        <th style="max-width: 100px;">Antrian</th>
                        <th>Nama</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody> </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="ModalMain" tabindex="-1" aria-labelledby="ModalMainLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalMainLabel">Form Registrasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="MainForm">
                        <div class=" row mb-2">
                            <label for="nama" class="col-md-3 col-6 form-label">No Antrian</label>
                            <div class="col-md-9 col-6">
                                <input type="text" class="form-control no-antrian fw-bold h4" readonly style="max-width: 75px; background: none; border: 0;">
                            </div>
                        </div>

                        <div class=" row mb-2">
                            <label for="nama" class="col-md-3 form-label">Nama Lengkap</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama" name="nama" required>
                            </div>
                        </div>

                        <div class=" row mb-2">
                            <label for="foto_ktp" class="col-md-3 form-label">Foto KTP</label>
                            <div class="col-md-9">
                                <input type="file" accept="image/*" class="form-control foto_upload" id="foto_ktp" name="foto_ktp">
                            </div>
                        </div>

                        <div class=" row mb-2">
                            <label for="foto_ktp" class="col-md-3 form-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <div class="custom-controls-stacked d-flex flex-row">
                                    <label class="custom-control custom-radio-md" style="display: set">
                                        <input type="radio" class="custom-control-input" name="jenis_kelamin" value="l">
                                        <span class="custom-control-label">Laki-Laki</span>
                                    </label>
                                    <label class="custom-control custom-radio-md ms-3" style="display: unset">
                                        <input type="radio" class="custom-control-input" name="jenis_kelamin" value="p">
                                        <span class="custom-control-label">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class=" row mb-2">
                            <label for="alamat" class="col-md-3 form-label">Alamat Lengkap</label>
                            <div class="col-md-9">
                                <textarea class="form-control" placeholder="Alamat Lengkap" name="alamat" id="alamat" rows="3" required></textarea>
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

    <div class="modal fade" id="KTPUpload" tabindex="-1" aria-labelledby="KTPUploadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalMainLabel">Form Upload KTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="UploadKTPForm">
                        <input type="hidden" name="pasien_mr" id="upload_foto_pasien_mr">
                        <div class=" row mb-2">
                            <label for="upload_foto_ktp" class="col-md-3 form-label">Foto KTP</label>
                            <div class="col-md-9">
                                <input type="file" accept="image/*" class="form-control foto_upload" id="upload_foto_ktp" name="foto_ktp" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="UploadKTPForm">
                        <li class="fas fa-save me-1"></li> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <li class="fas fa-times me-1"></li>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . "/antiran_suara.php" ?>

    <script>
        const table_html = $('#table_main');
        let form_is_edit = true;
        let no_antrian_baru = 0;

        let foto64_temp = '';
        let foto64_ext = '';

        $(document).ready(function() {
            $('#refresh-otomatis').change(() => {
                reload_table();
            });

            // upload foto ktp
            $('.foto_upload').change(evt => {
                $.LoadingOverlay("show");
                var target = evt.target;
                var files = target.files;
                var max_size = target.dataset.max_size ?? 6291456;
                var file = files[0];
                foto64_temp = '';
                foto64_ext = '';
                if (files && file) {
                    // cek ukuran
                    if (file.size > max_size) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: `Ukuran maksimal file ${Math.round(Number(max_size)/1000000)} MB`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        target.value = '';
                        return;
                    }

                    // cek ektensi
                    if (file.type.split("/")[0] != 'image') {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'File yang dipilih bukan foto !',
                            showConfirmButton: true,
                            timer: 3000
                        });
                        target.value = '';
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = function(readerEvt) {
                        var binaryString = readerEvt.target.result;
                        var result = btoa(binaryString);

                        foto64_temp = result;
                        foto64_ext = file.type.split("/")[1];

                        $.LoadingOverlay("hide");
                    };

                    reader.readAsBinaryString(file);
                    reader.onerror = function(error) {
                        console.log(error);
                        $.LoadingOverlay("hide");
                    };
                } else {
                    $.LoadingOverlay("hide");
                }
            });

            // clear error
            setTimeout(() => {
                console.clear();
            }, 1000);
            // Tambah pasien ==============================================================================================
            $('#pasien_mr').select2({
                ajax: {
                    url: "<?= base_url() ?>",
                    type: "GET",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            <?= e('r') ?>: '<?= e('antrian.select2') ?>'
                        }
                        return query;
                    }
                },
                placeholder: "Masukan nama atau alamat pasien",
                dropdownParent: $('#tambah-antrian-select2'),
            });

            $('#pasien_mr').on('select2:open', function(e) {
                document.querySelector("#tambah-antrian-select2 > span > span > span.select2-search.select2-search--dropdown > input").focus();
            });

            $('#btn-tambah').click(() => {
                const pasien_mr = $('#pasien_mr').val();
                if (pasien_mr == null || pasien_mr == '') {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Pasien belum dipilih',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    return false;
                }
                $('#tambah-antrian-select2').LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "<?= route('antrian.tambah') ?>",
                    data: {
                        pasien_mr,
                        dokter_id: $('#dokter_id').val()
                    },
                    success: (data) => {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data saved successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#pasien_mr')
                            .append((new Option('', '', true, true)))
                            .trigger('change');
                        reload_table();
                        refresh_antrian_terbaru(data.antrian_terbaru);
                    },
                    error: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: ((data.responseJSON) ? data.responseJSON.message : 'Something went wrong'),
                            showConfirmButton: false,
                            timer: 3000
                        })
                    },
                    complete: function() {
                        $('#tambah-antrian-select2').LoadingOverlay("hide");
                    }
                });
            })

            // Antrian ====================================================================================================
            const new_table = table_html.DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                // responsive: true,
                scrollX: true,
                aAutoWidth: false,
                bAutoWidth: false,
                pageLength: 50,
                ajax: {
                    type: 'POST',
                    url: "<?= route('antrian') ?>",
                    data: function(d) {
                        d['filter[tanggal]'] = $('#filter_tanggal').val();
                        d['filter[status]'] = $('#filter_status').val();
                        d['filter[dipanggil]'] = $('#filter_dipanggil').val();
                        d['filter[ktp_ada]'] = $('#filter_ktp_ada').val();
                    },
                    complete: (res) => {
                        if (res.status == 200) {
                            const data = res.responseJSON;
                            refresh_antrian_terbaru(data.antrian_terbaru);
                        }
                    }
                },
                columns: [{
                        data: null,
                        name: 'antrian_id',
                        orderable: false,
                    },
                    {
                        data: 'no_antrian',
                        name: 'no_antrian',
                        render(data, type, full, meta) {
                            const ringkas_tombol = $('#refresh-otomatis').prop("checked");
                            // upload foto ktp
                            const ktp_upload = full.ktp_ada == 0 ?
                                (ringkas_tombol ?
                                    `<a class="list-group-item text-nowrap" href="javascript:void(0)" onclick="uploadKTP('${full.pasien_mr}')">
                                        <li><i class="fas fa-file-upload me-1"></i>Upload KTP</li>
                                    </a>` :
                                    `<a class="btn btn-primary btn-sm mt-1 text-nowrap" href="javascript:void(0)" onclick="uploadKTP('${full.pasien_mr}')">
                                        <i class="fas fa-file-upload me-1"></i>Upload KTP
                                    </a>`
                                ) : '';

                            const tombol_ringkas = `
                                <div class="card mt-1" style="display:none" id="ddm${full.antrian_id}" data-show="0">
                                    <ul class="list-group list-group-flush">
                                        <a class="list-group-item text-nowrap" href="javascript:void(0)" data-antrian_id="${full.antrian_id}" data-no_antrian="${data}" onclick="dipanggil(this)"><li><i class="fas fas fa-volume-up me-1"></i>Panggil</li></a>
                                        ${full.dipanggil ? `<a class="list-group-item text-nowrap" href="javascript:void(0)" onclick="masuk('${full.antrian_id}')"><li><i class="fas fa-sign-in-alt me-1"></i></i>Masuk</li></a>` : ''}
                                        ${ktp_upload}
                                        <a class="list-group-item text-nowrap" target="_blank" href="<?= route('antrian.cetak_mr') ?>&id=${full.antrian_id}"><li><i class="fas fa-file-alt me-1"></i>Cetak HR</li></a>
                                        <a class="list-group-item text-nowrap" target="_blank" href="<?= route('antrian.print') ?>&no_rm=${escapeHtml(full.pasien_mr)}&waktu=${escapeHtml(full.tanggal_full)}&antrian=${escapeHtml(full.no_antrian)}"><li><i class="fas fa-print me-1"></i>Print Antrian</li></a>
                                        <a class="list-group-item text-nowrap" href="javascript:void(0)" onclick="batalkan('${full.antrian_id}')"><li><i class="fas fa-times me-1"></i></i>Batalkan</li></a>
                                    </ul>
                                </div>
                                `;

                            const tombol_full = `
                            <a class="btn btn-primary btn-sm mt-1 text-nowrap" href="javascript:void(0)" data-antrian_id="${full.antrian_id}" data-no_antrian="${data}" onclick="dipanggil(this)">
                                <i class="fas fas fa-volume-up me-1"></i>Panggil
                            </a>
                            ${full.dipanggil ? `<a class="btn btn-success btn-sm mt-1 text-nowrap" href="javascript:void(0)" onclick="masuk('${full.antrian_id}')">
                                <i class="fas fa-sign-in-alt me-1"></i></i>Masuk
                            </a>` : ''}
                            ${ktp_upload}
                            <a class="btn btn-warning btn-sm mt-1 text-nowrap" target="_blank" href="<?= route('antrian.cetak_mr') ?>&id=${full.antrian_id}">
                                <i class="fas fa-file-alt me-1"></i>Cetak HR
                            </a>
                            <a class="btn btn-secondary btn-sm mt-1 text-nowrap" target="_blank" href="<?= route('antrian.print') ?>&no_rm=${escapeHtml(full.pasien_mr)}&waktu=${escapeHtml(full.tanggal_full)}&antrian=${escapeHtml(full.no_antrian)}">
                                <i class="fas fa-print me-1"></i>Print Antrian
                            </a>
                            <a class="btn btn-danger btn-sm mt-1 text-nowrap" href="javascript:void(0)" onclick="batalkan('${full.antrian_id}')">
                                <i class="fas fa-times me-1"></i></i>Batalkan
                            </a>
                            `;
                            return full.status == 1 ? (`
                                <div class="text-center">
                                    <h1 class="h2 my-0">${data}</h1>
                                    ${ringkas_tombol ? `<button class="btn btn-secondary btn-sm" onclick="dropDownnToggle('ddm${full.antrian_id}')"type="button">Aksi</button>`:''}
                                </div>
                            ` + (ringkas_tombol ? tombol_ringkas : tombol_full)) : `<h1>${data}</h1>`;
                        }
                    },
                    {
                        data: 'pasien_nama',
                        name: 'pasien_nama',
                        render(data, type, full, meta) {
                            return `<span class="fw-bold">${data}</span><br><small>${full.pasien_alamat}</small>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render(data, type, full, meta) {
                            let color = '';
                            let status = '';
                            let tanggal = '';
                            if (data == 1) {
                                color = 'primary';
                                status = 'Mengantri';
                                tanggal = full.tanggal_str;
                            }

                            if (full.dipanggil != null) {
                                color = 'warning';
                                status = 'Dipanggil';
                                tanggal = full.dipanggil_str;
                            }

                            if (data == 2) {
                                color = 'info';
                                status = 'Masuk';
                                tanggal = full.dipanggil_str;
                            } else if (data == 3) {
                                color = 'success';
                                status = 'Selesai';
                                tanggal = full.dipanggil_str;
                            } else if (data == 4) {
                                color = 'danger';
                                status = 'Dibatalkan';
                                tanggal = full.dipanggil_str ?? full.tanggal_str;
                            }

                            // status ktp
                            const ktp_status = full.ktp_ada == 1 ?
                                `<i class="far fa-check-circle text-success me-1"></i>KTP Ada` :
                                `<i class="far fa-times-circle text-danger me-1"></i>KTP Tidak Ada`;

                            return `<i class="fas fa-circle text-${color}"></i> ${status}<br><small>${tanggal}</small><br>${ktp_status}`;
                        }
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            table_html_global = table_html;

            new_table.on('draw.dt', function() {
                var PageInfo = table_html.DataTable().page.info();
                new_table.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            });

            $('#FilterForm').submit(function(e) {
                reload_table();
            });

            $('#btn-registrasi').click(() => {
                $('#ModalMain').modal('show');
                $('#MainForm').trigger("reset");
                $('#foto_ktp').val('');
                $('.no-antrian').val(no_antrian_baru);
                $('.no-antrian').html(no_antrian_baru);
            });

            $('#MainForm').submit(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var formData = new FormData(this);
                formData.delete('foto_ktp');

                // set form data
                formData.append('foto_ktp', foto64_temp);
                formData.append('foto_ktp_ext', foto64_ext);
                $.ajax({
                    type: "POST",
                    url: "<?= route('pasien.insert') ?>",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Registrasi Berhasil',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#MainForm').trigger("reset");
                        $('#ModalMain').modal('hide');
                        $('#foto_ktp').val('');
                        reload_table();
                        // refresh_antrian_terbaru(data.antrian_terbaru);
                    },
                    error: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: ((data.responseJSON) ? data.responseJSON.message : 'Something went wrong'),
                            showConfirmButton: false,
                            timer: 3000
                        })
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

            $('#UploadKTPForm').submit(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var formData = new FormData(this);
                formData.delete('foto_ktp');

                // set form data
                formData.append('foto_ktp', foto64_temp);
                formData.append('foto_ktp_ext', foto64_ext);
                $.ajax({
                    type: "POST",
                    url: "<?= route('pasien.upload_ktp') ?>",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#KTPUpload').modal('hide');
                        $('#upload_foto_ktp').val('');
                        $('#upload_foto_pasien_mr').val('');
                        foto64_temp = '';
                        foto64_ext = '';
                        reload_table();
                    },
                    error: function(data) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: ((data.responseJSON) ? data.responseJSON.message : 'Something went wrong'),
                            showConfirmButton: false,
                            timer: 3000
                        })
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

        });

        // Antrian ========================================================================================================
        function reload_table() {
            var oTable = table_html.dataTable();
            oTable.fnDraw(false);
        }

        function dipanggil(ele) {
            const data = ele.dataset;
            const antrian_id = data.antrian_id;
            const no_antrian = data.no_antrian;
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Nomor antrian akan ditampilkan di display untuk memanggil pasien.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: `<?= route('antrian.dipanggil') ?>`,
                        type: 'POST',
                        data: {
                            antrian_id
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
                                title: 'Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            reload_table();
                            panggil_suara(no_antrian);
                            refresh_antrian_terbaru(data.antrian_terbaru);
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

        function masuk(antrian_id) {
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Pastikan pasien sudah ada, Karena setelah ini data tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: `<?= route('antrian.masuk') ?>`,
                        type: 'POST',
                        data: {
                            antrian_id
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
                                title: 'Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            reload_table();
                            refresh_antrian_terbaru(data.antrian_terbaru);
                            // window.open(`<?= route('antrian.cetak_mr', ['id' => '']) ?>${id}`, '_blank');
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

        function batalkan(antrian_id) {
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Setelah dibatalkan data tidak bisa diubah kembali.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: `<?= route('antrian.batalkan') ?>`,
                        type: 'POST',
                        data: {
                            antrian_id
                        },
                        beforeSend: function() {
                            reload_table();
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
                                title: 'Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            reload_table();
                            reload_table();
                            refresh_antrian_terbaru(data.antrian_terbaru);
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

        function kartu_berobat(nama, tanggal_lahir, jenis_kelamin, alamat, no_rm) {
            const kartu = $('#kartu-container');
            $('#kartu_nama').html(nama);
            $('#kartu_tanggal_lahir').html(tanggal_lahir);
            $('#kartu_jenis_kelamin').html(jenis_kelamin);
            $('#kartu_alamat').html(alamat);
            $('#kode_no_rm').html(no_rm);
            $('#kartu_qrcode').attr('src', `<?= qrcode() ?>${encodeURIComponent(escapeHtml(no_rm))}`);
            kartu.show();
            capture(() => {
                kartu.hide();
            }, `${no_rm} - ${nama}`);
        }

        function capture(finish, filename = 'filename') {
            filename = String(filename)
                .replace('/', '')
                .replace('\\', '')
                .replace(':', '')
                .replace('*', '')
                .replace('?', '')
                .replace('<', '')
                .replace('>', '')
                .replace('"', '');
            html2canvas(document.getElementById("kartu-berobat")).then(function(canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                document.getElementById("kartu_preview").appendChild(canvas);
                anchorTag.download = `${filename}.jpg`;
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            }).then(() => {
                finish();
            });
        }

        function escapeHtml(str) {
            return String(str).replace("'", "\\'").replace('"', '\\"');
        }

        function refresh_antrian_terbaru(no) {
            no_antrian_baru = no;
            $('.no-antrian').val(no);
            $('.no-antrian').html(no);
        }

        function uploadKTP(pasien_mr) {
            $('#KTPUpload').modal('show');
            $('#upload_foto_ktp').val('');
            $('#upload_foto_pasien_mr').val(pasien_mr);
            foto64_temp = '';
            foto64_ext = '';
        }

        function reset_filter() {
            $('#filter_tanggal').val('<?= date('Y-m-d') ?>');
            $('#filter_status').val('1');
            $('#filter_dipanggil').val('');
            $('#filter_ktp_ada').val('');
            reload_table();
        }

        function dropDownnToggle(id) {
            const ele = $(`#${id}`);
            if (ele.data('show') == 1) {
                ele.hide();
                ele.data('show', 0);
            } else {
                ele.fadeIn();
                ele.data('show', 1);
            }
        }
    </script>
<?php else : ?>
    <div class="card">
        <div class="card-body">
            <h1>Tidak ada data dokter</h1>
        </div>
    </div>
<?php endif ?>