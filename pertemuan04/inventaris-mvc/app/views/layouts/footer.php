</main>
<?php if (!empty($_SESSION['user'])): ?>
</section>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($_SESSION['user'])): ?>
<script>
(function () {
    var sidebar = document.querySelector('.sidebar');
    if (!sidebar) { return; }
    document.querySelectorAll('.sidebar .arrow').forEach(function (arrow) {
        arrow.addEventListener('click', function () {
            arrow.closest('li').classList.toggle('showMenu');
        });
    });
    var menuBtn = document.querySelector('.bx-menu');
    if (menuBtn) {
        menuBtn.addEventListener('click', function () {
            sidebar.classList.toggle('close');
        });
    }
    if (window.innerWidth <= 768) { sidebar.classList.add('close'); }
})();
</script>
<?php endif; ?>
</body></html>
