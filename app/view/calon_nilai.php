<div class="page-header">
    <h1 class="page-title">Calon Nilai</h1>
</div>

<div class="card">
    <div class="card-header d-md-flex flex-row justify-content-between">
        <h3 class="card-title">Daftar Calon</h3>
    </div>
    <div class="card-body" id="table"></div>
</div>

<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="ModalMain" tabindex="-1" aria-labelledby="ModalMainLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalMainLabel">Nilai Calon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="MainForm"></form>
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
    $(document).ready(function() {

        // insertForm ===================================================================================
        $('#MainForm').submit(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show");
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: '<?= route('calon_nilai.simpan') ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#ModalMain").modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    renderData();
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
                }
            });
        });

        // render ===================================================================================
        renderData();
    });

    function renderData() {
        $.LoadingOverlay("show");
        $.ajax({
            type: "GET",
            url: `<?= route('calon_nilai.calon_list') ?>`,
            success: (data) => {
                renderTable(data);
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

    function renderTable(data) {
        const container = $('#table');
        let table_header = '';
        let table_body = '';

        data.tahapans.forEach(tahapan => {
            table_header += `<th class="text-center align-middle">${tahapan.nama}</th>`;
        });

        data.calons.forEach(calon => {
            let tahapan_nilai = '';
            calon.tahapans.forEach(tahapan => {
                if (tahapan.nilai == null) {
                    tahapan_nilai += `<td></td>`;
                } else {
                    const nilai = tahapan.nilai;
                    tahapan_nilai += `<td><b>${nilai.nilai}</b> ${nilai.nilai_nama}</td>`;
                }
            });

            table_body += `<tr>
                    <td>${calon.kecamatan}</td>
                    <td>
                        ${calon.nama}<br>
                        <small>${calon.nomor_pendaftaran}</small>
                    </td>
                    ${tahapan_nilai}
                    <td>
                        <button type="button" class="btn btn-rounded btn-primary btn-sm me-1" title="Input Nilai" onClick="setNilai('${calon.id}')">
                            <i class="fas fa-edit"></i> Nilai
                        </button>
                    </td>
                </tr>`;
        });

        container.html(`
            <table class="table table-hover" id="table_main">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Kecamatan</th>
                        <th class="text-center align-middle">Calon</th>
                        ${table_header}
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                ${table_body}
                </tbody>
            </table>`);

        $('#table_main').DataTable();
    }

    function setNilai(id) {
        $.LoadingOverlay("show");
        $.ajax({
            type: "GET",
            url: `<?= route('calon_nilai.nilai') ?>`,
            data: {
                id
            },
            success: (data) => {
                renderFrom(data);
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


    function renderFrom(data) {
        console.log(data);
        $('#ModalMain').modal('show');
        const container = $('#MainForm');

        const cekNilai = (id) => {
            let result = false;
            data.nilais.forEach(nilai => {
                if (nilai.nilai != null) {
                    if (nilai.nilai.id == id) {
                        console.log(nilai);
                        result = true;
                    }
                }
            });
            return result;
        }

        let list_nilai = ``;
        data.tahapans.forEach(tahapan => {
            let option_list = '';
            tahapan.nilais.forEach(nilai => {
                option_list += `<option value="${nilai.id}" ${cekNilai(nilai.id) ? 'selected':''}>${nilai.nilai} | ${nilai.nilai_nama}</option>`;
            });

            list_nilai += `<div class="row mb-3">
                    <label for="tahapan${ tahapan.id }" class="col-sm-2 col-form-label">${ tahapan.nama }</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tahapan${ tahapan.id }" name="tahapans[${ tahapan.id }]">
                            <option value="">Pilih Nilai</option>
                            ${option_list}
                        </select>
                    </div>
                </div>`;
        });


        container.html(`
            <input type="hidden" id="calon_id" name="calon_id" value="${data.calon.id}">
            <div class="row mb-3">
                <label for="nama" class="col-sm-2 col-form-label">Calon</label>
                <div class="col-sm-10"><b>${data.calon.nama}</b><br>
                <small>${data.calon.nomor_pendaftaran}</small></div>
            </div>
            ${list_nilai}
        `);
    }
</script>