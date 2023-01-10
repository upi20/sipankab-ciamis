</div>
</div>
</div>
<!-- BACKGROUND-IMAGE CLOSED -->

<!-- BOOTSTRAP JS -->
<script src="<?= asset('assets/template/admin/plugins/bootstrap/js/popper.min.js') ?>"></script>
<script src="<?= asset('assets/template/admin/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>

<!-- SHOW PASSWORD JS -->
<script src="<?= asset('assets/template/admin/js/show-password.min.js') ?>"></script>

<!-- Color Theme js -->
<script src="<?= asset('assets/template/admin/js/themeColors.js') ?>"></script>

<!-- CUSTOM JS -->
<script src="<?= asset('assets/template/admin/js/custom.js') ?>"></script>

<script src="<?= asset("assets/template/admin/plugins/sweet-alert/sweetalert2.all.js") ?>"></script>
<script src="<?= asset("assets/template/admin/plugins/loading/loadingoverlay.min.js") ?>"></script>

<script>
    if (localStorage.getItem('lightMode') || localStorage.getItem('darkMode') == null) {
        $('#logo').attr('src', "<?= asset('assets/template/admin/logo.png') ?>");
    }
</script>
<script src="<?= asset("assets/js/app.js") ?>"></script>
</body>

</html>