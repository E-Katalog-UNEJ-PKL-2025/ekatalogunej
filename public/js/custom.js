// public/js/custom.js

function confirmDelete(event) {
    // Mencegah form dikirim secara langsung
    event.preventDefault(); 

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#006633', // Warna hijau UNEJ
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        // Jika pengguna mengklik "Ya, hapus!"
        if (result.isConfirmed) {
            // Lanjutkan pengiriman form
            event.target.closest('form').submit();
        }
    });
}