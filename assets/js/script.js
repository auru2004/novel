// JavaScript untuk aplikasi Koleksi Buku Novel

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk konfirmasi sebelum menghapus
    const deleteLinks = document.querySelectorAll('a[href*="delete.php"]');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const confirmed = confirm('Apakah Anda yakin ingin menghapus data ini?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
    
    // Fungsi untuk menampilkan preview gambar sebelum upload
    const imageInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
    imageInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    // Di sini Anda bisa menambahkan logika untuk menampilkan preview gambar
                    console.log('File ready for preview:', event.target.result);
                }
                
                reader.readAsDataURL(file);
            }
        });
    });
});