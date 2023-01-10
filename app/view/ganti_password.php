<div class="container mt-5">
    <div class="page-header">
        <h1 class="page-title">Ganti Password</h1>
        <a href="<?= route('antrian') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="form_password">
                <label for="current_password">Password Lama</label>
                <div class="wrap-input100 validate-input input-group password-toggle">
                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted toggle">
                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                    </a>
                    <input class="input100 border-start-0 form-control ms-0" type="password" id="current_password" required="" name="current_password">
                </div>
                <label for="new_password">Password Baru</label>
                <div class="wrap-input100 validate-input input-group password-toggle">
                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted toggle">
                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                    </a>
                    <input class="input100 border-start-0 form-control ms-0" type="password" id="new_password" required="" name="new_password">
                </div>
                <label for="repeat_password">Ulangi Password Baru</label>
                <div class="wrap-input100 validate-input input-group password-toggle">
                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted toggle">
                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                    </a>
                    <input class="input100 border-start-0 form-control ms-0" type="password" id="repeat_password" required="" name="repeat_password">
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" form="form_password" class="btn btn-primary mt-4 mb-0">
                <li class="fas fa-save mr-1"></li> Simpan Password
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(e => {
        $(".password-toggle>.toggle").on('click', function(event) {
            const toogle = $(this).find('i');
            const pass_element = $(this).next();
            if (pass_element.attr("type") == "text") {
                pass_element.attr('type', 'password');
                toogle.addClass("zmdi-eye");
                toogle.removeClass("zmdi-eye-off");
            } else if (pass_element.attr("type") == "password") {
                pass_element.attr('type', 'text');
                toogle.removeClass("zmdi-eye");
                toogle.addClass("zmdi-eye-off");
            }
        });

        $('#form_password').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            if (formData.get('new_password') != formData.get('repeat_password')) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ulangi Password Baru harus sama dengan Password Baru.',
                    showConfirmButton: false,
                    timer: 1500
                })
                return;
            }

            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "<?= route('ganti_password') ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
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