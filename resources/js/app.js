document.addEventListener('DOMContentLoaded', function() {
    // Global Form Submit Loading & Logout Animation Handler
    document.querySelectorAll('form').forEach(function(form) {
        if (form.method.toUpperCase() === 'GET' || form.classList.contains('no-loading')) {
            return;
        }

        form.addEventListener('submit', function(e) {
            if (form.checkValidity && !form.checkValidity()) {
                return;
            }

            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.required && fileInput.files && fileInput.files.length === 0) {
                return;
            }

            const isLogout = (form.action && form.action.includes('logout')) || form.classList.contains('logout-form');
            const isImport = form.getAttribute('enctype') === 'multipart/form-data';

            let loadingTitle = 'Menyimpan Data...';
            let loadingText = 'Sedang memproses dan menyimpan data ke sistem.';

            if (isLogout) {
                loadingTitle = 'Sedang Keluar...';
                loadingText = 'Menutup sesi akun Anda dengan aman.';
            } else if (isImport) {
                loadingTitle = 'Mengimpor Data...';
                loadingText = 'Sistem sedang membaca dan memproses file Excel/CSV.';
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: loadingTitle,
                    text: loadingText,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-3xl p-8 shadow-2xl border border-slate-100',
                        title: 'text-base font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-500 font-medium'
                    },
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            setTimeout(() => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }, 10);
        });
    });
});

// Global Profile Dropdown Toggle Handler
window.toggleProfileDropdown = function(event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById('profileDropdownMenu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
};

document.addEventListener('click', function(event) {
    const wrapper = document.getElementById('profileDropdownWrapper');
    const menu = document.getElementById('profileDropdownMenu');
    if (wrapper && menu && !wrapper.contains(event.target)) {
        menu.classList.add('hidden');
    }
});

window.addEventListener('pageshow', function() {
    if (typeof Swal !== 'undefined' && Swal.isVisible() && Swal.isLoading()) {
        Swal.close();
    }
});
