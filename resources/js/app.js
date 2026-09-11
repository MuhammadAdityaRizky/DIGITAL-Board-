document.addEventListener('DOMContentLoaded', function() {
    // Global Form Submit Loading & Logout Animation Handler
    document.querySelectorAll('form').forEach(function(form) {
        if (form.method.toUpperCase() === 'GET' || form.classList.contains('no-loading')) {
            return;
        }

        form.addEventListener('submit', function(e) {
            if (e.defaultPrevented) {
                return;
            }

            // If the form has an onsubmit confirmation and has not been confirmed yet, do not trigger loading spinner
            const hasConfirm = (form.getAttribute('onsubmit') && form.getAttribute('onsubmit').includes('confirmAction')) ||
                               form.classList.contains('confirm-action') ||
                               (form.dataset.needsConfirm === "true");
            if (hasConfirm && form.dataset.confirmed !== "true") {
                return;
            }

            if (form.checkValidity && !form.checkValidity()) {
                return;
            }

            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.required && fileInput.files && fileInput.files.length === 0) {
                return;
            }

            const isLogout = (form.action && form.action.includes('logout')) || form.classList.contains('logout-form');
            const isImport = form.getAttribute('enctype') === 'multipart/form-data';
            const methodInput = form.querySelector('input[name="_method"]');
            const isDelete = (methodInput && methodInput.value.toUpperCase() === 'DELETE') ||
                             form.method.toUpperCase() === 'DELETE' ||
                             (form.action && form.action.includes('delete'));

            let loadingTitle = 'Menyimpan Data...';
            let loadingText = 'Sedang memproses dan menyimpan data ke sistem.';

            if (isLogout) {
                loadingTitle = 'Sedang Keluar...';
                loadingText = 'Menutup sesi akun Anda dengan aman.';
            } else if (isImport) {
                loadingTitle = 'Mengimpor Data...';
                loadingText = 'Sistem sedang membaca dan memproses file Excel/CSV.';
            } else if (isDelete) {
                loadingTitle = 'Menghapus Data...';
                loadingText = 'Sedang memproses penghapusan data dari sistem.';
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

// Global Confirmation Action Handler
window.confirmAction = function(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
    const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
    if (form && form.dataset.confirmed === "true") {
        return true;
    }

    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    if (typeof Swal === 'undefined') {
        if (confirm(title + "\n" + text)) {
            if (form) {
                form.dataset.confirmed = "true";
                form.submit();
            }
        }
        return false;
    }

    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-3xl p-6 shadow-2xl',
            title: 'text-lg font-extrabold text-slate-800',
            htmlContainer: 'text-xs text-slate-600 font-medium',
            confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
            cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
        }
    }).then((result) => {
        if (result.isConfirmed && form) {
            form.dataset.confirmed = "true";

            Swal.fire({
                title: 'Menghapus Data...',
                text: 'Sedang memproses penghapusan data dari sistem.',
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

            form.submit();
        }
    });
    return false;
};
