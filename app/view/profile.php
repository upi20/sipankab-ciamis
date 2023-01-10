<div class="container mt-5">
    <div class="page-header">
        <h1 class="page-title">Profil Admin</h1>
        <a href="<?= route(get('cr') ?? 'home') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="mainForm">

                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Nama Lengkap" value="<?= $person['nama'] ?>" id="nama" name="nama" required>
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
    $(document).ready(e => {
        $('#mainForm').submit(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show");
            var formData = new FormData(this);

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