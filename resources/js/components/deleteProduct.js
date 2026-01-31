export function initDeleteProduct() {
    document.addEventListener('click', function (e) {
        const button = e.target.closest('.delete-product-btn');
        if (!button) return;

        const productId = button.getAttribute('data-id');
        const productCard = button.closest('.product-card');

        if (confirm('Hapus produk ini?')) {
            axios({
                method: 'delete',
                url: `/admin/products/${productId}`, 
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })

            .then(response => {
                if (response.data.success) {
                window.location.reload(); 
                } else {
                alert('Gagal: ' + response.data.message);
                }
             })
            
            .catch(error => {
                console.error('Error Detail:', error.response);
                alert('Terjadi kesalahan pada server.');
            });
        }
    });
}