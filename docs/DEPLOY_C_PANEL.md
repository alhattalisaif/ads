# دليل النشر على استضافة cPanel (عربي)

هذا المستند يشرح خطوات تجهيز ونشر المشروع على استضافة تعمل بنظام cPanel (مشتركة أو VPS مع cPanel).

الافتراضات:
- لديك نطاق مرتبط بالاستضافة.
- ستقوم برفع الملفات إلى مجلد عام (document root) الذي يشير إلى مجلد backend/public.

خطوات النشر:

1) تجهيز الملفات محليًا
- شغّل السكريبت الموجود في repo: scripts/prepare_cpanel.sh
  - يقوم ببناء واجهة المستخدم (frontend) ونسخ ملفات الـ dist إلى backend/public/spa
  - يجمع ملفات الـ backend في أرشيف جاهز للرفع

2) رفع الملفات إلى الاستضافة
- ادخل إلى cPanel → File Manager
- ارفع محتويات المجلد الناتج (أو الارشيف ads-cpanel-deploy.zip) واستخرجها
- تأكد أن جذر الوثائق (Document Root) للنطاق يشير إلى `backend/public`

3) إعداد composer
- ادخل إلى مجلد المشروع في cPanel Terminal أو استخدم SSH (إن أمكن)
- شغّل:
  composer install --no-dev --optimize-autoloader

4) إعداد ملف البيئة (.env)
- أنشئ ملف `.env` في مجلد `backend` بناءً على `backend/.env.production.example`
- عيّن القيم الحقيقية: APP_KEY (يمكن إنشاؤه محليًا عبر php artisan key:generate)، DB_*، GOOGLE_CLIENT_ID/SECRET، TELEGRAM_BOT_TOKEN/CHAT_ID

5) الأذونات
- امنح أذونات الكتابة للمجلدات:
  - storage
  - bootstrap/cache

6) قواعد البيانات
- أنشئ قاعدة بيانات في cPanel (MySQL أو استخدم PostgreSQL إذا كانت مدعومة)
- عدّل إعدادات DB في .env
- شغّل الهجرات:
  php artisan migrate --force
  php artisan db:seed --force

7) إعداد الوظائف المجدولة والصفوف (Queues)
- إذا كنت تعتمد على Queue (QUEUE_CONNECTION=database):
  - إعداد cron job لتشغيل: php /path-to-project/artisan queue:work --sleep=3 --tries=3 --daemon
  - أو استخدم Supervisor إن كان متاحًا
- يمكنك استخدام cron لتشغيل المهام المجدولة: php /path-to-project/artisan schedule:run

8) إعداد OAuth (Google)
- في Google Cloud Console، اضف Redirect URI:
  https://your-domain.example/api/auth/google/callback
- اضبط GOOGLE_CLIENT_ID و GOOGLE_CLIENT_SECRET في ملف .env

9) اختبارات سريعة
- تأكد من أن الموقع يعمل بزيارة النطاق
- تحقق من تسجيل الدخول عبر Google
- جرب إنشاء إعلان وإيداع في المحفظة

ملاحظات إضافية
- إذا كانت الاستضافة لا تدعم PostgreSQL، غيّر DB_CONNECTION إلى mysql واضبط الهجرات accordingly.
- تأكد من ضبط APP_DEBUG=false في البيئة الإنتاجية.

في حال واجهت مشاكل أثناء النشر، أرسل لي تفاصيل الخطأ وسأساعدك خطوة بخطوة.