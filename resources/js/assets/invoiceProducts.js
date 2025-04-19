document.addEventListener("DOMContentLoaded", function () {
    let productCount = 1;

    function addProduct() {
        const productList = document.querySelector("#product-list");
        const selectTemplate = document.querySelector(".product-select").innerHTML;

        const newProductHTML = `
            <div class="product-item flex space-x-4 mb-4" data-index="${productCount}">
                <div class="flex-1">
                    <label for="product_id_${productCount}" class="block text-sm font-medium text-gray-700">Producto ${productCount + 1}</label>
                    <select name="products[${productCount}][product_id]" id="product_id_${productCount}" class="w-full product-select border-gray-300 rounded-md" onchange="updatePrice(${productCount})">
                        ${selectTemplate}
                    </select>
                </div>
                <div class="flex-1">
                    <label for="sold_quantity_${productCount}" class="block text-sm font-medium text-gray-700">Cantidad</label>
                    <input type="number" id="sold_quantity_${productCount}" value="1" min="1" name="products[${productCount}][sold_quantity]" class="w-full border-gray-300 rounded-md sold-quantity" onchange="updatePrice(${productCount})">
                </div>
                <div class="flex-1">
                    <label for="sold_price_${productCount}" class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                    <input type="text" id="sold_price_${productCount}" name="products[${productCount}][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                </div>
                <div class="flex-1">
                    <label for="total_sold_price_${productCount}" class="block text-sm font-medium text-gray-700">Total Venta</label>
                    <input type="text" id="total_sold_price_${productCount}" name="products[${productCount}][total_sold_price]" value="0" class="w-full border-gray-300 rounded-md total-sold-price" readonly>
                </div>
                <div class="flex-1">
                    <label for="discount_${productCount}" class="block text-sm font-medium text-gray-700">Descuento</label>
                    <input type="text" id="discount_${productCount}" name="products[${productCount}][discount]" value="0" class="w-full border-gray-300 rounded-md discount" readonly>
                </div>
                <div class="flex justify-center items-end pb-2">
                    <button type="button" class="remove-product bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeProduct(${productCount})">Eliminar</button>
                </div>
            </div>
        `;

        productList.insertAdjacentHTML('beforeend', newProductHTML);
        updatePrice(productCount);
        productCount++;
        updateTotal();
    }

    // Function to update price and total price for each product
    function updatePrice(index) {
        const productSelect = document.getElementById(`product_id_${index}`);
        const selectedOption = productSelect?.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption?.getAttribute("data-price")) || 0;

        const priceInput = document.getElementById(`sold_price_${index}`);
        if (priceInput) {
            priceInput.value = price.toFixed(2);
        }

        const quantityInput = document.getElementById(`sold_quantity_${index}`);
        const quantity = parseFloat(quantityInput.value) || 1;

        const totalSoldPriceInput = document.getElementById(`total_sold_price_${index}`);
        if (totalSoldPriceInput) {
            totalSoldPriceInput.value = (price * quantity).toFixed(2);
        }

        applyDiscount(index);
        updateTotal();
    }

    function applyDiscount(index) {
        const quantityInput = document.getElementById(`sold_quantity_${index}`);
        const quantity = parseFloat(quantityInput.value) || 0;
        let discountRate = 0;

        if (quantity >= 12) {
            discountRate = 0.10; 
        }

        const priceInput = document.getElementById(`sold_price_${index}`);
        const discountInput = document.getElementById(`discount_${index}`);

        const price = parseFloat(priceInput.value) || 0;
        const discountAmount = price * discountRate;

        if (discountInput) {
            discountInput.value = (discountAmount * quantity).toFixed(2);
        }

        updateTotal();
    }

    // Function to update total amount and discount across all products
    function updateTotal() {
        let totalAmount = 0;
        let discountAmount = 0;

        document.querySelectorAll(".product-item").forEach(item => {
            const index = item.getAttribute("data-index");
            const quantity = parseFloat(document.getElementById(`sold_quantity_${index}`).value) || 0;
            const price = parseFloat(document.getElementById(`sold_price_${index}`).value) || 0;
            const discount = parseFloat(document.getElementById(`discount_${index}`).value) || 0;

            const totalProduct = (price * quantity) - discount;

            totalAmount += totalProduct;
            discountAmount += discount;
        });

        document.getElementById("total_amount").value = totalAmount.toFixed(2);
        document.getElementById("discount_amount").value = discountAmount.toFixed(2);
    }

    // Function to remove a product row
    function removeProduct(index) {
        document.querySelector(`.product-item[data-index="${index}"]`).remove();
        updateTotal();
    }

    // Event listener to handle remove button clicks
    document.querySelector("#product-list").addEventListener("click", function(event) {
        if (event.target && event.target.classList.contains("remove-product")) {
            const index = event.target.closest(".product-item").getAttribute("data-index");
            removeProduct(index);
        }
    });

    // Event listener to handle quantity or product select changes
    document.querySelector("#product-list").addEventListener("input", function(event) {
        if (event.target.classList.contains("sold-quantity") || event.target.classList.contains("product-select")) {
            const productIndex = event.target.closest(".product-item").getAttribute("data-index");
            updatePrice(productIndex);
        }
    });

    updatePrice(0);

    document.getElementById("invoiceProducts").addEventListener("click", function() {
        addProduct();
    });
});
