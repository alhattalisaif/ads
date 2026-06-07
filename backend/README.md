# Backend (Laravel) - Quick Start

مطلوبات:
- Docker & docker-compose
- PHP 8.1+
- Composer

تشغيل محلي (باستخدام Docker):

1. انسخ الملف `.env.example` إلى `.env` واضبط إعدادات قاعدة البيانات.
2. شغّل الحاويات:
   docker-compose up -d --build
3. ثبت التبعيات:
   docker exec -it ads_backend_1 composer install
4. أنشئ المفتاح:
   docker exec -it ads_backend_1 php artisan key:generate
5. شغّل الهجرات:
   docker exec -it ads_backend_1 php artisan migrate --seed

ملاحظات:
- سنستخدم Passport أو Sanctum لتأمين الـ API.
- أدوات: Queues (Redis)، Storage (S3 compatible)، Notifications (Telegram).