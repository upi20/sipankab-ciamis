</div>
<!-- CONTAINER CLOSED -->

</div>
</div>
<!--app-content closed-->
</div>
<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 text-center">
                Copyright © <span id="year"></span> VidyaMedic
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER CLOSED -->
</div>

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top">
    <i class="fas fa-angle-up fs-30 mt-2"></i>
</a>

<!-- BOOTSTRAP JS -->
<script src="<?= asset('assets/template/admin/plugins/bootstrap/js/popper.min.js') ?>"></script>
<script src="<?= asset('assets/template/admin/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>

<!-- SIDE-MENU JS -->
<script src="<?= asset('assets/template/admin/plugins/sidemenu/sidemenu.js') ?>"></script>

<!-- DATA TABLE JS-->
<script src="<?= asset('assets/template/admin/plugins/datatable/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= asset('assets/template/admin/plugins/datatable/js/dataTables.bootstrap5.js') ?>"></script>

<!-- SIDEBAR JS -->
<script src="<?= asset('assets/template/admin/plugins/sidebar/sidebar.js') ?>"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="<?= asset('assets/template/admin/plugins/p-scroll/perfect-scrollbar.js') ?>"></script>
<script src="<?= asset('assets/template/admin/plugins/p-scroll/pscroll.js') ?>"></script>
<!-- <script src="<?= asset('assets/template/admin/plugins/p-scroll/pscroll-1.js') ?>"></script> -->
<!-- Color Theme js -->
<script src="<?= asset('assets/template/admin/js/themeColors.js') ?>"></script>
<!-- Sticky js -->
<script src="<?= asset('assets/template/admin/js/sticky.js') ?>"></script>
<!-- CUSTOM JS -->
<script src="<?= asset('assets/template/admin/js/custom.js') ?>"></script>
<script src="<?= asset('assets/template/admin/plugins/fontawesome-free-5.15.4-web/js/all.min.js') ?>"></script>
<script src="<?= asset("assets/template/admin/plugins/loading/loadingoverlay.min.js") ?>"></script>

<script src="<?= asset("assets/template/admin/plugins/sweet-alert/sweetalert2.all.js") ?>"></script>
<script src="<?= asset("assets/js/app.js") ?>"></script>
<script src="<?= asset("assets/js/html2canvas.js") ?>"></script>
<script src="<?= asset("assets/template/admin/plugins/select2/select2.full.min.js") ?>"></script>
<script>
    function setSpinner(set = false) {
        const ele = $('#global-spinner');
        if (set) {
            ele.fadeIn();
        } else {
            ele.fadeOut()
        }
    }

    $('.date-input-str').each((i, e) => {
        render_tanggal(e);
        $(e).change(function() {
            render_tanggal(this);
        });
        $(e).click(function() {
            render_tanggal(this);
        });
        $(e).keyup(function() {
            render_tanggal(this);
        });
    })
</script>
</body>

</html>