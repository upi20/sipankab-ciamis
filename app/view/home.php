<div class="page-header">
    <h1 class="page-title">Home</h1>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="<?= route('kecamatan') ?>">
            <div class="card bg-primary img-card box-primary-shadow card-main">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font"><?= $kecamatan ?></h2>
                            <p class="text-white mb-0">Kecamatan</p>
                        </div>
                        <div class="ms-auto">
                            <i class="fa-w-14 text-white fs-30 me-2 mt-2 fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="<?= route('calon') ?>">
            <div class="card bg-info img-card box-info-shadow card-main">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font"><?= $calon ?></h2>
                            <p class="text-white mb-0">Calon</p>
                        </div>
                        <div class="ms-auto">
                            <i class="fa-w-14 text-white fs-30 me-2 mt-2 fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="<?= route('tahapan') ?>">
            <div class="card bg-success img-card box-success-shadow card-main">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font"><?= $tahapan ?></h2>
                            <p class="text-white mb-0">Tahapan Penilaian</p>
                        </div>
                        <div class="ms-auto">
                            <i class="fa-w-14 text-white fs-30 me-2 mt-2 fas fa-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-md-flex flex-row justify-content-between">
        <h3 class="card-title">Daftar Nilai Calon</h3>
    </div>
    <div class="card-body" id="table"></div>
</div>

<script>
    $(document).ready(function() {
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
                </tr>`;
        });

        container.html(`
            <table class="table table-hover" id="table_main">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Kecamatan</th>
                        <th class="text-center align-middle">Calon</th>
                        ${table_header}
                    </tr>
                </thead>
                <tbody>
                ${table_body}
                </tbody>
            </table>`);

        $('#table_main').DataTable();
    }
</script>