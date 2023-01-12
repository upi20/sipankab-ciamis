<div class="container-login100">
    <div class="wrap-login100 p-6" style="border-radius: 24px; box-shadow: none">
        <div class="text-center">
            <img src="<?= asset($setting['logo_white_landscape']) ?>" altSrc="<?= asset('assets/template/admin/logo.png') ?>" onerror="this.src = $(this).attr('altSrc')" class="header-brand-img" alt="Logo" id="logo" style="max-height: 60px!important;">
        </div>
        <p class="text-center mt-5">
            <!-- SIPANKAB CIAMIS<br> -->
            <span class="fw-bold text-capitalize"> Sistem adminstrasi panwascam<br>kabupaten ciamis </span>
        </p>
        <div class="panel panel-primary">
            <div class="panel-body tabs-menu-body p-0">
                <div class="tab-content">
                    <form action="javascript:void(0)" id="Loginform" name="Loginform" method="POST" enctype="multipart/form-data" autocomplete="false">
                        <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted" style="border-radius: 24px 0 0 24px;">
                                <i class="zmdi zmdi-account-o text-muted ms-1" aria-hidden="true"></i>
                            </a>
                            <input class="input100 border-start-0 form-control ms-0 bg-white" type="email" placeholder="Email" id="email" required="" name="email" style="border-radius: 0 24px 24px 0;">
                        </div>
                        <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted" style="border-radius: 24px 0 0 24px;">
                                <i class="zmdi zmdi-eye text-muted ms-1" aria-hidden="true"></i>
                            </a>
                            <input class="input100 border-start-0 form-control ms-0 bg-white" type="password" placeholder="Password" id="password" required="" name="password" style="border-radius: 0 24px 24px 0;">
                        </div>
                        <div class="container-login100-form-btn">
                            <button type="submit" class="login100-form-btn btn-primary" style="border: 0; border-radius: 24px">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
<div class="col col-login mx-auto">
    <div class="text-center d-md-flex  justify-content-center">&#169; 2023 Vakrun Nisah</div>
</div>

<script>
    $(document).ready(function() {
        $('#Loginform').submit(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show");
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= route('login') ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Login Berhasil, Anda akan di arahkan ke halaman admin dalam 2 detik.',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    setTimeout(() => {
                        window.location.href = '<?= route('home') ?>';
                    }, 2000);

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
</script>