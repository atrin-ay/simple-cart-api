<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فروشگاه ساده</title>
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
            max-width: 960px;
            margin: 1.5rem auto 2rem;
            padding: 0 1rem;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }
        .card {
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
        }
        .card-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .card-desc {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }
        .price {
            font-weight: 700;
            color: #111827;
        }
        .btn {
            border: none;
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            background: #111827;
            color: #f9fafb;
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: default;
        }
        .btn:hover:not(:disabled) {
            background: #1f2937;
        }
        .status {
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: #6b7280;
        }
        .status.error {
            color: #b91c1c;
        }
        .status.success {
            color: #15803d;
        }
        .empty {
            text-align: center;
            color: #9ca3af;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
<header class="navbar">
    <div class="navbar-title">فروشگاه تستی</div>
    <div class="nav-links">
        <a href="/products/create">افزودن محصول</a>
        <a href="/cart">سبد خرید</a>
    </div>
</header>

<main class="container">
    <div id="status" class="status">در حال بارگذاری محصولات...</div>

    <section id="products-section">
        <div id="products" class="products-grid"></div>
        <div id="empty" class="empty" style="display:none;">محصولی پیدا نشد.</div>
    </section>
</main>

<script>
    async function fetchProducts() {
        const status = document.getElementById('status');
        const productsContainer = document.getElementById('products');
        const emptyEl = document.getElementById('empty');

        status.textContent = 'در حال بارگذاری محصولات...';
        status.className = 'status';

        try {
            const res = await fetch('/products');
            if (!res.ok) {
                throw new Error('خطا در دریافت لیست محصولات');
            }
            const data = await res.json();

            productsContainer.innerHTML = '';

            if (!data || data.length === 0) {
                emptyEl.style.display = 'block';
            } else {
                emptyEl.style.display = 'none';
                data.forEach(p => {
                    const card = document.createElement('article');
                    card.className = 'card';
                    card.innerHTML = `
                        <div>
                            <h2 class="card-title">${p.name ?? 'بدون نام'}</h2>
                            <p class="card-desc">${p.description ?? ''}</p>
                        </div>
                        <div class="card-footer">
                            <span class="price">${(p.price ?? 0).toLocaleString()} تومان</span>
                            <button class="btn" type="button" onclick="addToCart(${p.id})" ${(p.quantity ?? 0) <= 0 ? 'disabled' : ''}>
                                ${(p.quantity ?? 0) > 0 ? 'افزودن به سبد' : 'ناموجود'}
                            </button>
                        </div>
                    `;
                    productsContainer.appendChild(card);
                });
            }

            status.textContent = 'لیست محصولات از API لاراویل خوانده شد.';
            status.className = 'status success';
        } catch (e) {
            console.error(e);
            status.textContent = 'خطا در ارتباط با سرور یا API محصولات.';
            status.className = 'status error';
        }
    }

    async function addToCart(productId) {
        const btn = event.target;
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'در حال افزودن...';
        
        try {
            const res = await fetch(`/cart/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            if (res.ok) {
                btn.textContent = '✓ افزوده شد';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.disabled = false;
                }, 2000);
            } else {
                throw new Error('خطا در افزودن به سبد');
            }
        } catch (error) {
            console.error(error);
            btn.textContent = 'خطا';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.disabled = false;
            }, 2000);
        }
    }
    
    fetchProducts();
</script>
</body>
</html>


