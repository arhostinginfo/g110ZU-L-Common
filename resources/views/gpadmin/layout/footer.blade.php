    </div>{{-- /#page-body --}}
</div>{{-- /#page-main --}}

{{-- ── Global Image Preview Modal ─────────────────── --}}
<div id="img-preview-modal"
     style="display:none; position:fixed; inset:0; z-index:9999;
            background:rgba(0,0,0,.80); align-items:center; justify-content:center;"
     onclick="closeImgModal(event)">
    <div style="position:relative; max-width:720px; max-height:90vh; width:90%;">
        <button onclick="closeImgModalBtn()"
            style="position:absolute; top:-14px; right:-14px; z-index:10;
                   width:32px; height:32px; border-radius:50%; border:none; cursor:pointer;
                   background:#fff; color:#111; font-size:16px; line-height:1;
                   display:flex; align-items:center; justify-content:center;
                   box-shadow:0 2px 8px rgba(0,0,0,.3);">
            <i class="mdi mdi-close"></i>
        </button>
        <img id="img-preview-src"
             src=""
             alt="Preview"
             style="width:100%; max-height:80vh; object-fit:contain;
                    border-radius:12px; box-shadow:0 8px 40px rgba(0,0,0,.5);
                    display:block;">
    </div>
</div>

{{-- Fixed footer bar --}}
<footer class="fixed bottom-0 right-0 z-10 flex items-center justify-between px-6"
        style="left:256px; height:48px; background:#fff; border-top:1px solid #E5E7EB;
               font-size:12px; color:#6B7280; transition:left .25s;" id="page-footer">
    <span>&copy; {{ date('Y') }} ग्रामपंचायत Admin Panel. All rights reserved.</span>
    <span>Powered by GP CMS</span>
</footer>

{{-- Scripts --}}
<script src="{{ asset('asset/plugins/popper/popper.min.js') }}"></script>
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('asset/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('asset/js/waves.js') }}"></script>
<script src="{{ asset('asset/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset/plugins/sweetalert/sweetalert2@11.js') }}"></script>

<script>
/* ── Image preview modal ─────────────────────── */
function openImgModal(src) {
    const modal = document.getElementById('img-preview-modal');
    document.getElementById('img-preview-src').src = src;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeImgModal(e) {
    if (e.target === document.getElementById('img-preview-modal')) closeImgModalBtn();
}
function closeImgModalBtn() {
    document.getElementById('img-preview-modal').style.display = 'none';
    document.getElementById('img-preview-src').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeImgModalBtn(); });

/* ── Sidebar toggle ─────────────────────────── */
function toggleSidebar() {
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const open = sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === 'translateX(0)';
    if (open) {
        sidebar.style.transform = 'translateX(-256px)';
        overlay.classList.remove('active');
    } else {
        sidebar.style.transform = 'translateX(0)';
        overlay.classList.add('active');
    }
}

function closeSidebar() {
    document.getElementById('sidebar').style.transform = 'translateX(-256px)';
    document.getElementById('sidebar-overlay').classList.remove('active');
}

function toggleSidebarDesktop() {
    const sidebar  = document.getElementById('sidebar');
    const main     = document.getElementById('page-main');
    const topbar   = document.getElementById('topbar');
    const footer   = document.getElementById('page-footer');
    const collapsed = sidebar.style.width === '64px';

    if (collapsed) {
        sidebar.style.width = '256px';
        main.style.marginLeft   = '256px';
        topbar.style.left       = '256px';
        footer.style.left       = '256px';
        sidebar.querySelectorAll('.nav-label, .brand-text').forEach(el => el.style.display = '');
    } else {
        sidebar.style.width = '64px';
        main.style.marginLeft   = '64px';
        topbar.style.left       = '64px';
        footer.style.left       = '64px';
        sidebar.querySelectorAll('.nav-label, .brand-text').forEach(el => el.style.display = 'none');
    }
}

/* ── Profile dropdown ───────────────────────── */
function toggleProfile() {
    document.getElementById('profile-menu').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('profile-menu');
    if (menu && !menu.closest('.relative').contains(e.target)) {
        menu.classList.remove('open');
    }
});

/* ── Preloader ──────────────────────────────── */
window.addEventListener('load', function () {
    const loader = document.getElementById('gp-preloader');
    if (loader) { loader.style.opacity = '0'; setTimeout(() => loader.remove(), 400); }
});

/* ── DataTables ─────────────────────────────── */
$(document).ready(function () {
    $('.datatables').DataTable({
        responsive: true,
        pageLength: 10,
        ordering: true,
        language: {
            search: "",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ rows",
            paginate: { next: "Next →", previous: "← Prev" }
        }
    });

    /* SweetAlert delete confirmation */
    $(document).on('click', '.delete-btn', function () {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Delete this record?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E54545',
            cancelButtonColor: '#708090',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
        }).then((result) => { if (result.isConfirmed) form.submit(); });
    });
});
</script>

@stack('scripts')

</body>
</html>
