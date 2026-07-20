# فقط فایل readme.md توسط ai جنریت شده است.

# Product Management API

---

## 📦 روش اجرای پروژه

```bash
# ۱. نصب پکیج‌های PHP
composer install

# ۲. کپی فایل env و تنظیم مقادیر دیتابیس
cp .env.example .env
php artisan key:generate

# ۳. اجرای Migration ها
php artisan migrate

# ۴. ایجاد داده نمونه (Seeder)
php artisan db:seed

# ۵. اجرای پروژه
php artisan serve
```

پس از اجرا، پروژه روی آدرس زیر در دسترس خواهد بود:

```
http://localhost:8000
```

### Endpoint های اصلی

| Method | Endpoint                                 | توضیح                  |
|--------|------------------------------------------|------------------------|
| GET    | `/api/products`                          | دریافت لیست محصولات    |
| GET    | `/api/products/{id}`                     | دریافت جزئیات یک محصول |
| Post   | `/api/orders`                            | ثبت سفارش              |
| Post   | `/api/payments/{order_number}/pay`       | دریافت لینک پرداخت     |
| Post   | `/api/payments/{payment_token}/callback` | برگشت از درگاه پرداخت  |

> در صورت نیاز به تست، می‌توانید از Postman یا مشابه آن با آدرس‌های فوق استفاده کنید.
> داکیومنت Swagger در آدرس زیر در دسترس است:
> `http://localhost:8000/docs/api#/`
---

## 🏗 ساختار کلی پروژه

ساختار پروژه به‌صورت **ماژولار (Modular)** پیاده‌سازی شده است؛ به این معنا که هر بخش کاری (مثلاً Products) منطق مربوط به خودش (Controller، Model، Service،
Request، Resource و...) را در یک ماژول مجزا نگه می‌دارد، به‌جای پخش‌شدن کد در ساختار پیش‌فرض و متمرکز Laravel. مزیت این رویکرد:

- جداسازی بهتر مسئولیت‌ها (Separation of Concerns)
- افزودن قابلیت‌های جدید بدون درگیرشدن با سایر بخش‌ها
- خوانایی و نگه‌داری بهتر کد در پروژه‌های بزرگ‌تر

نمای کلی (نمونه):

```

Modules/
      └── Product/
           ├── Controllers/
           ├── Models/
           ├── Requests/
           database/
            ├── migrations/
            └── seeders/
           routes/
            └── api.php
```

---

## 🧩 فرضیات انجام‌شده

- فرض شده است که دسترسی به API نیازی به احراز هویت (Authentication) برای بخش نمایش محصولات ندارد.
- داده‌های نمونه صرفاً برای نمایش عملکرد API تولید شده‌اند و بازتاب‌دهنده داده واقعی نیستند.
- فرض شده محیط اجرا لوکال (Local) است و نیازی به تنظیمات خاص production (مثل HTTPS، Queue Worker و...) نبوده است.

---

## 🚀 تغییرات پیشنهادی برای استفاده در مقیاس بزرگ‌تر

- استفاده از **Caching** (مانند Redis) برای درخواست‌های پرتکرار روی محصولات.
- پیاده‌سازی **Queue** برای عملیات سنگین یا وابسته به سرویس‌های خارجی (مثل پرداخت).
- افزودن **Rate Limiting** و **Authentication/Authorization** کامل (مثلاً با Laravel Sanctum یا Passport).
- استفاده از **CI/CD Pipeline** برای اجرای خودکار تست‌ها و Deployment.
- مانیتورینگ و Logging متمرکز (مانند Sentry، ELK Stack) برای رصد خطاها در Production.

---

## 📌 نکته پایانی

این پروژه به‌عنوان تسک مصاحبه فنی (Technical Interview Task) و در بازه زمانی محدود پیاده‌سازی شده است. موارد ذکرشده در بخش «تغییرات پیشنهادی»
نشان‌دهنده آگاهی از نکاتی است که در یک محیط Production واقعی باید مدنظر قرار گیرد.
