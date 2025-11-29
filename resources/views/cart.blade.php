<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سبد خرید - فروشگاه</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        .navbar {
            background: #111827;
            color: #f9fafb;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        .nav-links a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .nav-links a:hover {
            color: #f9fafb;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .card {
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08);
            margin-bottom: 1rem;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .item-info {
            flex: 1;
        }
        .item-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .item-details {
            font-size: 0.9rem;
            color: #6b7280;
        }
        .item-price {
            font-weight: 700;
            color: #111827;
            margin-left: 1rem;
        }
        .item-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-right: 1rem;
        }
        .btn {
            border: none;
            padding: 0.4rem 0.85rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .btn-danger:hover {
            background: #fecaca;
        }
        .empty {
            text-align: center;
            padding: 3rem 1rem;
            color: #9ca3af;
        }
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .summary {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .summary-total {
            font-size: 1.25rem;
            font-weight: 700;
            padding-top: 1rem;
            border-top: 2px solid #e5e7eb;
            margin-top: 1rem;
        }
        .status {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .status.success {
            background: #d1fae5;
            color: #065f46;
        }
        .status.error {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
<header class="navbar">
    <div class="navbar-title">فروشگاه تستی</div>
    <div class="nav-links">
        <a href="/">صفحه اصلی</a>
        <a href="/products/create">افزودن محصول</a>
    </div>
</header>

<main class="container">
    <div class="card">
        <h1 class="card-title">سبد خرید</h1>
        
        <div id="status"></div>
        
        <div id="cart-items"></div>
        
        <div id="empty" class="empty" style="display:none;">
            <div class="empty-icon">🛒</div>
            <p>سبد خرید شما خالی است</p>
            <a href="/" style="color: #111827; text-decoration: underline;">بازگشت به فروشگاه</a>
        </div>
        
        <div id="summary" class="summary" style="display:none;">
            <div class="summary-row">
                <span>تعداد کل:</span>
                <span id="total-items">0</span>
            </div>
            <div class="summary-row summary-total">
                <span>جمع کل:</span>
                <span id="total-price">0 تومان</span>
            </div>
        </div>
    </div>
</main>

<script>
    async function loadCart() {
        try {
            const res = await fetch('/cart/api');
            if (!res.ok) throw new Error('خطا در دریافت سبد خرید');
            
            const cart = await res.json();
            const cartItems = document.getElementById('cart-items');
            const emptyEl = document.getElementById('empty');
            const summaryEl = document.getElementById('summary');
            
            cartItems.innerHTML = '';
            
            if (!cart || Object.keys(cart).length === 0) {
                emptyEl.style.display = 'block';
                summaryEl.style.display = 'none';
            } else {
                emptyEl.style.display = 'none';
                summaryEl.style.display = 'block';
                
                let totalItems = 0;
                let totalPrice = 0;
                
                Object.entries(cart).forEach(([id, item]) => {
                    totalItems += item.quantity;
                    totalPrice += item.price * item.quantity;
                    
                    const itemEl = document.createElement('div');
                    itemEl.className = 'cart-item';
                    itemEl.innerHTML = `
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            <div class="item-details">تعداد: ${item.quantity} | قیمت واحد: ${item.price.toLocaleString()} تومان</div>
                        </div>
                        <div class="item-actions">
                            <span class="item-price">${(item.price * item.quantity).toLocaleString()} تومان</span>
                            <button class="btn btn-danger" onclick="removeItem(${id})">حذف</button>
                        </div>
                    `;
                    cartItems.appendChild(itemEl);
                });
                
                document.getElementById('total-items').textContent = totalItems;
                document.getElementById('total-price').textContent = totalPrice.toLocaleString() + ' تومان';
            }
        } catch (error) {
            console.error(error);
            const statusEl = document.getElementById('status');
            statusEl.textContent = 'خطا در بارگذاری سبد خرید';
            statusEl.className = 'status error';
        }
    }
    
    async function removeItem(id) {
        try {
            const res = await fetch(`/cart/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            if (res.ok) {
                const statusEl = document.getElementById('status');
                statusEl.textContent = 'محصول از سبد خرید حذف شد';
                statusEl.className = 'status success';
                setTimeout(() => {
                    statusEl.textContent = '';
                    statusEl.className = '';
                }, 2000);
                loadCart();
            }
        } catch (error) {
            console.error(error);
        }
    }
    
    loadCart();
</script>
</body>
</html>

