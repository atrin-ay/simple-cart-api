<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>افزودن محصول - فروشگاه</title>
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
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .card {
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08);
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #374151;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-family: inherit;
            box-sizing: border-box;
        }
        .form-input:focus {
            outline: none;
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
        }
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        .btn {
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary {
            background: #111827;
            color: #f9fafb;
        }
        .btn-primary:hover {
            background: #1f2937;
        }
        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
            margin-right: 0.5rem;
        }
        .btn-secondary:hover {
            background: #d1d5db;
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
        .error-text {
            color: #b91c1c;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
<header class="navbar">
    <div class="navbar-title">فروشگاه تستی</div>
    <div class="nav-links">
        <a href="/">صفحه اصلی</a>
        <a href="/cart">سبد خرید</a>
    </div>
</header>

<main class="container">
    <div class="card">
        <h1 class="card-title">افزودن محصول جدید</h1>
        
        <div id="status"></div>
        
        <form id="productForm">
            <div class="form-group">
                <label class="form-label" for="name">نام محصول *</label>
                <input type="text" id="name" name="name" class="form-input" required>
                <div id="name-error" class="error-text"></div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="description">توضیحات</label>
                <textarea id="description" name="description" class="form-input form-textarea"></textarea>
                <div id="description-error" class="error-text"></div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="price">قیمت (تومان) *</label>
                <input type="number" id="price" name="price" class="form-input" step="0.01" min="0" required>
                <div id="price-error" class="error-text"></div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="quantity">تعداد موجودی *</label>
                <input type="number" id="quantity" name="quantity" class="form-input" min="0" required>
                <div id="quantity-error" class="error-text"></div>
            </div>
            
            <div style="display: flex; gap: 0.5rem;">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='/'">انصراف</button>
                <button type="submit" class="btn btn-primary">افزودن محصول</button>
            </div>
        </form>
    </div>
</main>

<script>
    document.getElementById('productForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const statusEl = document.getElementById('status');
        statusEl.textContent = '';
        statusEl.className = '';
        
        // Clear previous errors
        document.querySelectorAll('.error-text').forEach(el => el.textContent = '');
        
        const formData = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            price: parseFloat(document.getElementById('price').value),
            quantity: parseInt(document.getElementById('quantity').value)
        };
        
        try {
            const res = await fetch('/products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(formData)
            });
            
            const data = await res.json();
            
            if (res.ok) {
                statusEl.textContent = 'محصول با موفقیت افزوده شد!';
                statusEl.className = 'status success';
                document.getElementById('productForm').reset();
                
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
            } else {
                // Handle validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.getElementById(key + '-error');
                        if (errorEl) {
                            errorEl.textContent = data.errors[key][0];
                        }
                    });
                }
                statusEl.textContent = data.message || 'خطا در افزودن محصول';
                statusEl.className = 'status error';
            }
        } catch (error) {
            statusEl.textContent = 'خطا در ارتباط با سرور';
            statusEl.className = 'status error';
            console.error(error);
        }
    });
</script>
</body>
</html>

