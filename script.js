// script.js
// Fungsi tambahan untuk interaksi web

// 1. Konfirmasi Hapus
document.querySelectorAll('.btn-danger').forEach(button => {
    if (button.textContent.trim() === 'Hapus' || button.textContent.trim() === 'Hapus') {
        button.addEventListener('click', function (e) {
            const confirm = window.confirm("Anda yakin ingin menghapus item ini?");
            if (!confirm) {
                e.preventDefault();
            }
        });
    }
});

// 2. Tampilkan Alert Saat Produk Ditambahkan
if (window.location.search.includes('added')) {
    const productName = decodeURIComponent(window.location.search.split('added=')[1]);
    setTimeout(() => {
        alert(`🎉 Produk "${productName}" berhasil ditambahkan ke keranjang!`);
    }, 500);
}

// 3. Auto-hide Alert
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }, 3000);
});

// 4. Saat Halaman Load
document.addEventListener('DOMContentLoaded', function () {
    console.log("WarungSaya - Sistem Toko Online Siap Pakai!");
});