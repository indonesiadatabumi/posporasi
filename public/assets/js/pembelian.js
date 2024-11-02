document.addEventListener('DOMContentLoaded', function () {
    updateCartDisplay();

    // Tambahkan produk ke dalam keranjang
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const produkId = this.dataset.produkId;
            const produkName = this.dataset.produkName;
            const produkPrice = parseInt(this.dataset.produkPrice, 10);

            let cart = getCart();
            let existingItem = cart.find(item => item.id === produkId);

            if (existingItem) {
                existingItem.quantity++;
                existingItem.total = existingItem.quantity * produkPrice;
            } else {
                cart.push({
                    id: produkId,
                    name: produkName,
                    price: produkPrice,
                    quantity: 1,
                    total: produkPrice
                });
            }

            setCart(cart);
            updateCartDisplay();
        });
    });

    // Fungsi untuk mengambil data keranjang dari localStorage
    function getCart() {
        let cart = localStorage.getItem('cart');
        return cart ? JSON.parse(cart) : [];
    }

    // Fungsi untuk menyimpan data keranjang ke localStorage
    function setCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // Fungsi untuk memperbarui tampilan keranjang di halaman
    function updateCartDisplay() {
        let cart = getCart();
        let cartContainer = document.getElementById('cart-items');
        let totalPriceDiv = document.getElementById('total-price');
        let taxPriceDiv = document.getElementById('tax-price');
        let finalPriceDiv = document.getElementById('final-price');
        let totalPrice = 0;

        cartContainer.innerHTML = '';

        if (cart.length > 0) {
            cart.forEach(item => {
                totalPrice += item.total;

                let cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <div>${item.name} (${item.quantity})</div>
                    <div>Rp ${item.total.toLocaleString()}</div>
                `;
                cartContainer.appendChild(cartItem);
            });
        }

        const tax = totalPrice * 0.1; // Hitung pajak 10%
        const finalPrice = totalPrice + tax;

        totalPriceDiv.innerText = totalPrice.toLocaleString();
        taxPriceDiv.innerText = tax.toLocaleString();
        finalPriceDiv.innerText = finalPrice.toLocaleString();
    }

    document.getElementById('pay-btn').addEventListener('click', function() {
        const customerName = document.getElementById('customer-name').value; // Ambil nama pelanggan
        const selectedMeja = document.getElementById('meja').value; // Ambil ID meja yang dipilih
        const cart = getCart(); // Ambil keranjang
        const checkoutButton = this; // Menyimpan referensi ke tombol checkout
    
        // Validasi
        if (!customerName || selectedMeja === '') {
            alert('Silakan masukkan nama pembeli dan pilih meja.');
            return;
        }
        if (cart.length === 0) {
            alert('Keranjang pembelian kosong.');
            return;
        }
    
        const checkoutData = {
            customer_name: customerName,
            items: cart.map(item => ({
                id: item.id,
                quantity: item.quantity,
                price: item.price
            })),
            total_price: parseInt(document.getElementById('final-price').innerText.replace(/\./g, ''), 10),
            meja_id: selectedMeja // Tambahkan ID meja
        };
    
        console.log('Checkout Data:', checkoutData); // Log data checkout
    
        checkoutButton.disabled = true; // Menonaktifkan tombol checkout saat proses
        fetch('/pembelian/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(checkoutData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Response not OK'); // Menangkap kesalahan jika respons tidak OK
            }
            return response.json();
        })
        .then(data => {
            console.log('Data:', data); // Log data dari server
            if (data.message) {
                Swal.fire({
                    icon: 'success',
                    title: 'Checkout Berhasil',
                    footer: '<a href="/pembayaran">Lanjut ke pembayaran?</a>'
                }).then(() => {
                    location.reload(); // Refresh halaman setelah checkout
                });
            } else {
                alert('Terjadi kesalahan saat melakukan checkout.'); // Pesan jika tidak ada message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`Terjadi kesalahan: ${error.message}`); // Pesan kesalahan
            checkoutButton.disabled = false; // Mengaktifkan kembali tombol checkout
        });
    });
    
    // Fungsi untuk memperbarui input keranjang sebelum submit
    window.updateCartInput = function () {
        let cart = getCart();
        document.getElementById('cart-input').value = JSON.stringify(cart);
    }

    // Mengirim form pembelian
    const form = document.getElementById("pembelian-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Mencegah submit default
        updateCartInput(); // Memperbarui input keranjang

        const formData = new FormData(form);

        // Kirim data menggunakan fetch
        fetch('/pembelian/store', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Pembelian berhasil disimpan.");
                // Reset form dan keranjang
                form.reset();
                setCart([]); // Mengosongkan keranjang
                updateCartDisplay(); // Memperbarui tampilan keranjang
            } else {
                alert("Terjadi kesalahan saat menyimpan pembelian.");
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
