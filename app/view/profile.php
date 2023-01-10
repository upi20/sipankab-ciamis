<div class="container mt-5">
    <div class="page-header">
        <h1 class="page-title">Profil Pengguna</h1>
        <a href="<?= route(get('cr') ?? 'antrian') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="mainForm">

                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" placeholder="Nomor Induk Kependudukan" value="<?= $person['nik'] ?>" id="nik" name="nik" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Nama Lengkap" value="<?= $person['nama'] ?>" id="nama" name="nama" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Tempat, Tanggal lahir</label>
                    <div class="col-sm-10 d-flex flex-row">
                        <input type="text" class="form-control d-inline me-lg-2" placeholder="Tempat Lahir" value="<?= $person['tempat_lahir'] ?>" id="tempat_lahir" name="tempat_lahir">
                        <input type="date" class="form-control d-inline" placeholder="Tanggal Lahir" value="<?= $person['tanggal_lahir'] ?>" id="tanggal_lahir" name="tanggal_lahir">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="l" <?= $person['jenis_kelamin'] == 'l' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="p" <?= $person['jenis_kelamin'] == 'p' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" placeholder="Alamat Lengkap" id="alamat" name="alamat" required><?= $person['alamat'] ?></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="foto_ktp" class="col-sm-2 col-form-label">Foto KTP</label>
                    <div class="col-sm-10 d-flex flex-row justify-content-between">
                        <div class="w-100">
                            <input type="hidden" id="old_foto_ktp" name="old_foto_ktp" value="<?= $person['foto_ktp'] ?>">
                            <input type="file" accept="image/*" data-max_size="6291456" class="form-control" placeholder="Foto KTP" value="" id="foto_ktp" name="foto_ktp">
                        </div>
                        <div class="ms-2" id="btn_reset_foto_container" style="display: none;"><button type="button" class="btn btn-danger" id="btn_reset_foto"><i class="fas fa-times me-2"></i>Batal</button></div>
                    </div>
                </div>
                <div class="row mb-3" id="foto_preview_container" style="<?= is_null($person['foto_ktp']) ? 'display:none' : '' ?>">
                    <label class="col-sm-2 col-form-label">Lihat Foto KTP</label>
                    <div class="col-sm-10">
                        <img id="foto_preview" src="<?= asset($person['foto_ktp']) ?>" alt="<?= $person['nama'] ?>" style="border-radius: 16px; max-height: 300px;">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" placeholder="Email" value="<?= $person['email'] ?>" id="email" name="email" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <a href="<?= route('ganti_password', ['cr' => get('r')]) ?>" type="submit" class="btn btn-danger">
                            Ganti Password
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" form="mainForm" class="btn btn-primary mt-4 mb-0">
                <li class="fas fa-save mr-1"></li> Simpan Profil
            </button>
        </div>
    </div>
</div>

<script>
    const asset = '<?= asset() ?>';
    let foto_default = '<?= $person['foto_ktp'] ? asset($person['foto_ktp']) : '' ?>';
    let foto = '';
    let foto_ext = '';


    $(document).ready(e => {
        var foto_set = (url = false) => {
            const container = $('#foto_preview_container');
            const foto_preview = $('#foto_preview');
            if (url) {
                container.fadeIn();
                foto_preview.attr('src', url);
            } else {
                // reset
                $('#btn_reset_foto_container').fadeOut();
                foto = '';
                foto_ext = '';
                if (foto_default != '') {
                    container.fadeIn();
                    foto_preview.attr('src', foto_default);
                } else {
                    container.fadeOut();
                    foto_preview.attr('src', foto_default);
                }
            }
        }

        $('#btn_reset_foto').click(() => {
            foto_set();
            $('#foto_ktp').val('');
        })

        var handleFileSelect = function(evt) {
            $.LoadingOverlay("show");
            var target = evt.target;
            var files = target.files;
            var max_size = target.dataset.max_size ?? 6291456;
            var file = files[0];
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
                    foto_set();
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
                    foto_set();
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var result = btoa(binaryString);
                    // console.log(result);
                    // preview
                    var src = `data:${file.type};base64, ${result}`;
                    foto_set(src);
                    $('#btn_reset_foto_container').fadeIn();

                    // set result
                    foto_ext = file.type.split("/")[1];
                    foto = result;

                    $.LoadingOverlay("hide");
                };

                reader.readAsBinaryString(file);
                reader.onerror = function(error) {
                    console.log(error);
                    $.LoadingOverlay("hide");
                    foto_set();
                };
            } else {
                $.LoadingOverlay("hide");
                foto_set();
            }
        };

        if (window.File && window.FileReader && window.FileList && window.Blob) {
            document.getElementById('foto_ktp')
                .addEventListener('change', handleFileSelect, false);
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }

        $('#mainForm').submit(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show");
            var formData = new FormData(this);
            formData.delete('foto_ktp');

            // set form data
            formData.append('foto_ktp', foto);
            formData.append('foto_ktp_ext', foto_ext);

            $.ajax({
                type: "POST",
                url: "<?= route('profile') ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (person) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    if (person.foto_ktp != null) {
                        // set foto ktp
                        let foto = '';
                        let foto_ext = '';
                        foto_default = person.foto_ktp;
                        foto_set();
                        $('#foto_ktp').val('');
                        $('#old_foto_ktp').val(person.old_foto_ktp);
                    }
                },
                error: function(data) {
                    $.LoadingOverlay("hide");
                    const res = data.responseJSON ?? {};
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: res.message ?? 'Something went wrong',
                        showConfirmButton: false,
                        timer: 4000
                    })
                },
                complete: function() {
                    $.LoadingOverlay("hide");
                }
            });
        });
    })
</script>