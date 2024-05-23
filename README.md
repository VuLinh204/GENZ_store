Các bước để chạy đồ án
Bước 1: git clone <đường dẫn github>

    -   sau khi clone: - copy file .env.example -> đổi tên thành .env -> ở chỗ DB_DATABASE đổi tên thành "db_genz"
    
    ---Cấu Hình-----------------------------------
    <!-- env -->
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=linhlg2004@gmail.com
    MAIL_PASSWORD="xspi bfhl mcyk povm"
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=linhlg2004@gmail.com
    MAIL_FROM_NAME="${APP_NAME}" 
    
    - mở terminal chạy lệnh <composer update>

Bước 2: chạy lệnh <php artisan migrate> (chạy các cột vào database)
chạy lệnh <php artisan db:seed> (chạy dữ liệu vào database)
chạy lệnh <php artisan serve> (chạy serve laravel)

Admin: linhlg2004@gmail.com
pass: 123456

User 1: NhatTuan@gmail.com
pass: 1234567

User 2: Dinhdang@gmail.com
pass: 123456

---Cấu Hình-----------------------------------

<!-- env -->

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=linhlg2004@gmail.com
MAIL_PASSWORD="xspi bfhl mcyk povm"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=linhlg2004@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

<!-- Chạy lại lệnh -->

php artisan config:cache

----Tài Khoản ngân hàng test----------------
Tài khoản thanh toán:
Ngân hàng NCB
Số thẻ 9704198526191432198
Tên chủ thẻ NGUYEN VAN A
Ngày phát hành 07/15
Mật khẩu OTP 123456

<!-- cmt -->
