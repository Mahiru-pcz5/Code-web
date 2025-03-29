document.addEventListener('DOMContentLoaded', function() {
    const cartTable = document.querySelector('.cart-table');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const shipping = parseFloat(cartTable.dataset.shipping); // Lấy giá trị shipping từ data attribute

    // Hàm tính lại tổng tiền
    function updateTotals() {
        let total = 0;
        cartTable.querySelectorAll('tbody tr').forEach(row => {
            const price = parseFloat(row.querySelector('.price').dataset.price);
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            const subtotal = price * quantity;
            row.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
            total += subtotal;
        });
        subtotalElement.textContent = `$${total.toFixed(2)}`;
        totalElement.textContent = `$${(total + shipping).toFixed(2)}`;
    }

    // Xử lý nút tăng số lượng
    cartTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('increase-btn')) {
            const row = e.target.closest('tr');
            const input = row.querySelector('.quantity-input');
            let quantity = parseInt(input.value);
            if (quantity < 10) {
                quantity++;
                input.value = quantity;
                updateTotals();
            }
        }
    });

    // Xử lý nút giảm số lượng
    cartTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('decrease-btn')) {
            const row = e.target.closest('tr');
            const input = row.querySelector('.quantity-input');
            let quantity = parseInt(input.value);
            if (quantity > 1) {
                quantity--;
                input.value = quantity;
                updateTotals();
            }
        }
    });
});