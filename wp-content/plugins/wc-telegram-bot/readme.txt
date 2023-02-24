=== Đẩy Thông Báo Woocommerce tới Telegram ===
Author: Tám Tinh Tế
Contributors: Tám Tinh Tế
Tags: woocommerce, telegram bot, woocommerce to telegram
Version: 1.0.1
Tested up to: 5.7.1
WC tested up to: 5.2.2
Author URI: https://tamtinhte.vn
Plugin URI: https://tamtinhte.vn/wc-telegram-bot
Donate link: https://tamtinhte.vn/wc-telegram-bot
Stable tag: 1.0.1
Requires PHP: 7.0
Requires at least: 5.0
License: GPLv3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Đây là plugin giúp đẩy thông báo đơn hàng Woocommerce qua Telegram BOT. Phát triển bởi Tám Tinh Tế.

== Description ==

### Plugin giúp đẩy thông báo đơn hàng Woocommerce qua Telegram BOT. Phát triển bởi [Tám Tinh Tế](https://tamtinhte.vn).

**Hướng dẫn sử dụng bằng video**

https://www.youtube.com/watch?v=b7ukshoILK4

Các trạng thái hỗ trợ:

- Gửi thông báo khi có đơn hàng mới.
- Gửi thông báo khi đơn hàng đã hoàn thành.
- Gửi thông báo khi hủy đơn hàng.
- Gửi thông báo khi hoàn tiền đơn hàng.

Có thể đẩy thông báo tới Telegram cá nhân hoặc Group.

### Các dữ liệu tuỳ chỉnh:

- Hiển thị Mã đơn hàng bằng: %%order_id%%
- Hiển thị Tên sản phẩm bằng: %%product_name%%
- Hiển thị Họ khách hàng bằng: %%first_name%%
- Hiển thị Tên khách hàng bằng: %%last_name%%
- Hiển thị Email bằng: %%billing_email%%
- Hiển thị Số điện thoại bằng: %%billing_phone%%
- Hiển thị Địa chỉ bằng: %%billing_address%%
- Hiển thị Phương thức thanh toán: %%payment_method%%
- Hiển thị Phương thức giao hàng: %%shipping_method%%
- Hiển thị Ngày đặt hàng bằng: %%created_date%%
- Hiển thị Ngày hoàn thành đơn hàng: %%completed_date%%
- Hiển thị Ghi chú của khách hàng: %%customer_note%%
- Hiển thị Tổng tiền bằng: %%total%%

### Cài đặt API

- Token BOT: Mở Telegram tìm BotFather, chat /newbot để tạo BOT và lấy thông tin Token.
- ID Chat Telegram: Bạn có thể nhập nhiều ID chat, cách nhau bởi dấu phẩy (Cá nhân hoặc Group).

== Installation ==

### Có 2 cách cài đặt:
- Tự động: `Truy cập Plugin > Cài mới > Tìm kiếm gói mở rộng > Nhập nội dung: "Đẩy Thông Báo Woocommerce tới Telegram"`. Sau đó ấn Cài đặt và Kích hoạt để sử dụng (khuyên dùng).
- Cài thủ công plugin:

1. Trước tiên download plugin này về và giải nén ra thư mục `wc-telegram-bot`.
2. Copy thư mục giải nén vào `/wp-content/plugins/`.
2. Sau đó vào phần `Quản lý plugins` và active plugin `Đẩy Thông Báo Woocommerce tới Telegram`.
3. Truy cập vào `Cài đặt > Woocommerce to Telegram` để tiến hành thiết lập.

### Các dữ liệu tuỳ chỉnh:

- Hiển thị Mã đơn hàng bằng: %%order_id%%
- Hiển thị Tên sản phẩm bằng: %%product_name%%
- Hiển thị Họ khách hàng bằng: %%first_name%%
- Hiển thị Tên khách hàng bằng: %%last_name%%
- Hiển thị Email bằng: %%billing_email%%
- Hiển thị Số điện thoại bằng: %%billing_phone%%
- Hiển thị Địa chỉ bằng: %%billing_address%%
- Hiển thị Phương thức thanh toán: %%payment_method%%
- Hiển thị Phương thức giao hàng: %%shipping_method%%
- Hiển thị Ngày đặt hàng bằng: %%created_date%%
- Hiển thị Ngày hoàn thành đơn hàng: %%completed_date%%
- Hiển thị Ghi chú của khách hàng: %%customer_note%%
- Hiển thị Tổng tiền bằng: %%total%%

### Cài đặt API

- Token BOT: Mở Telegram tìm BotFather, chat /newbot để tạo BOT và lấy thông tin Token.
- ID Chat Telegram: Bạn có thể nhập nhiều ID chat, cách nhau bởi dấu phẩy (Cá nhân hoặc Group).

== Screenshots ==

1. Giao diện trang cài đặt plugin

== Frequently Asked Questions ==

Tám Tinh Tế - contact@tamtinhte.vn

== Changelog ==

= 1.0.1 =
* Cập nhật disable_web_page_preview tránh tốn không gian khi gửi nội dung có link

= 1.0.0 =
 * Đăng tải phiên bản đầu tiên của plugin này.