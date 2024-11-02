function getPembelian(id) {
    $.ajax({
        url: `/pembayaran/ambil/${id}`, // URL untuk mengambil data
        type: 'GET',
        success: function(response) {
            showCart(response.pembeli, response.detail, response.total_harga, response.pembelian_id);
        },
        error: function(xhr) {
            // Menangani error jika pembelian tidak ditemukan
            if (xhr.status === 404) {
                alert('Pembelian tidak ditemukan.');
            } else {
                alert('Terjadi kesalahan saat mengambil data pembelian.');
            }
        }
    });
}

function showCart(customerName, details, totalHarga, pembelian_id) {
    document.getElementById('customer-name').innerText = customerName;
    document.getElementById('pembelian-id').value = pembelian_id;
    const cartItemsContainer = document.getElementById('cart-items');
    cartItemsContainer.innerHTML = '';  

    let totalDetailHarga = 0; 
    details.forEach(detail => {
        const itemElement = document.createElement('div');
        itemElement.classList.add('cart-item', 'd-flex', 'justify-content-between', 'mb-2');
        itemElement.innerHTML = `
            <span><strong>${detail.produk.nama_produk}</strong> (${detail.jumlah})</span>
            <span>Rp ${numberWithCommas(detail.harga_satuan)} x ${detail.jumlah} = Rp ${numberWithCommas(detail.total_harga)}</span>
        `;
        cartItemsContainer.appendChild(itemElement);
        
        totalDetailHarga += detail.total_harga;
    });

    const pajak = totalDetailHarga * 0.10;  
    const totalAkhir = totalDetailHarga + pajak;

    document.getElementById('total-price').innerText = `Rp ${numberWithCommas(totalDetailHarga)}`;
    document.getElementById('tax-price').innerText = `Rp ${numberWithCommas(pajak)}`;
    
    const finalPriceElement = document.getElementById('final-price');
    finalPriceElement.innerHTML = `<strong style="font-size: 1.2rem;">Rp ${numberWithCommas(totalAkhir)}</strong>`;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

document.getElementById('pay-btn').addEventListener('click', function() {
    $('#paymentModal').modal('show');
    
    const totalAkhir = document.getElementById('final-price').innerText;
    document.getElementById('final-price-modal').innerText = totalAkhir;
    
    document.getElementById('amount-paid').value = '';
    document.getElementById('change-amount').innerText = 'Rp 0';
});

document.getElementById('amount-paid').addEventListener('input', function() {
    const totalAkhir = parseFloat(document.getElementById('final-price').innerText.replace(/[Rp. ]/g, "").replace(",", ".")); // Ambil total akhir
    const amountPaid = parseFloat(this.value.replace(/[Rp. ]/g, "").replace(",", ".")) || 0;  
    const change = amountPaid - totalAkhir;
    document.getElementById('change-amount').innerText = `Rp ${numberWithCommas(change < 0 ? 0 : change)}`;  
});

// document.getElementById('print-receipt').addEventListener('click', function() {
//     const totalAkhir = parseFloat(document.getElementById('final-price').innerText.replace(/[Rp. ]/g, "").replace(",", "."));
//     const amountPaid = parseFloat(document.getElementById('amount-paid').value.replace(/[Rp. ]/g, "").replace(",", ".")) || 0;
//     const change = amountPaid - totalAkhir;

//     window.location.href = `/print-receipt?pembelianId=${pembelianId}&amountPaid=${amountPaid}&change=${change}`;
// });
