function showSwal(status, message, isReload = false) {
    const swalOptions = {
        title: '',
        text: message,
        icon: '',
        timer: isReload ? 3000 : undefined,
        allowOutsideClick: false, // Prevent closing by clicking outside
    };

    switch (status) {
        case 'error':
            swalOptions.title = 'Upps!, Ada yang salah';
            swalOptions.icon = 'error';
            break;
        case 'success':
            swalOptions.title = 'Berhasil';
            swalOptions.icon = 'success';
            break;
        case 'warning':
            swalOptions.title = 'Peringatan';
            swalOptions.icon = 'warning';
            break;
        case 'info':
            swalOptions.title = 'Info';
            swalOptions.icon = 'info';
            break;
    }

    if (isReload) {
        swalOptions.timer = 2000;
        swalOptions.html = '<div>Please wait...</div>'; // Add custom text above loading icon
        swalOptions.didOpen = () => {
            Swal.showLoading(); // Show loading indicator
        };
        swalOptions.willClose = () => {
            location.reload(); // Reload the page
        };
    }

    Swal.fire(swalOptions); // Use Swal.fire instead of swal
}


function processFormWithBlocking(form) {
    $.blockUI({ 
        message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Please Wait...</span></div>', 
    }); 
    var btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Please Wait...';
    return true;
}

function processForm(form) {
    var btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Please Wait...';
    return true;
}

function deleteWithQuestion(e, form) {
    e.preventDefault();
    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang sudah dihapus tidak dapat dikembalikan lagi.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus!',
        cancelButtonText: 'Batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            var btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Please Wait...';
            form.submit();
        }
    });

    return false;
}

function updateWithQuestion(e, form) {
    e.preventDefault();
    Swal.fire({
        title: 'Merubah Data?',
        text: 'Data yang sudah diubah tidak dapat dikembalikan lagi.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            var btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Please Wait...';
            form.submit();
        }
    });

    return false;
}