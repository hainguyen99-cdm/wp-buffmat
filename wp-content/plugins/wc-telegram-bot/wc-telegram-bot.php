<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
){
    if (!class_exists('Wctelegrambot_Class')) {
        class Wctelegrambot_Class
        {
            protected static $instance;
            public $_version = '1.5.0';
            public $_optionName = 'wctelegrambot_options';
            public $_optionGroup = 'wctelegrambot-options-group';
            public $_defaultOptions = array(
                'check_version' =>  '',
                'tokenbot'        =>  '',
                'mess_content'  =>  '',
                'account_creat_mess'    =>  '',
                'account_creat'    =>  '',
                'mess_content_list' => array(),
                'enable_woo'    =>  '',
                'order_creat'    =>  '',
                'order_creat_mess' =>  '',
                'woo_status_complete' =>  '',
                'woo_status_complete_mess' =>  '',
                'woo_status_cancelled' =>  '',
                'woo_status_cancelled_mess' =>  '',
                'woo_status_refunded' =>  '',
                'woo_status_refunded_mess' =>  ''
            );
            public static function init(){
                is_null(self::$instance) AND self::$instance = new self;
                return self::$instance;
            }
            public function __construct() 
            {
                $this->define_constants();
                global $wctelegrambot_settings;
                $wctelegrambot_settings = $this->get_options();
                
                add_filter('plugin_action_links_' . WCTELEGRAMBOT_BASENAME, array($this, 'add_action_links'), 10, 2);
                add_action('admin_menu', array($this, 'admin_menu'));
                add_action('admin_init', array($this, 'dvls_register_mysettings'));
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
                if($wctelegrambot_settings['enable_woo']) {
                    if (($wctelegrambot_settings['order_creat'] && $wctelegrambot_settings['order_creat_mess'])) {
                        add_action('woocommerce_thankyou', array($this, 'wctelegrambot_new_order'), 10, 1);}
                    if (
                        (
                            ($wctelegrambot_settings['woo_status_complete'] && $wctelegrambot_settings['woo_status_complete_mess']) ||
                            ($wctelegrambot_settings['woo_status_cancelled'] && $wctelegrambot_settings['woo_status_cancelled_mess']) ||
                            ($wctelegrambot_settings['woo_status_refunded'] && $wctelegrambot_settings['woo_status_refunded_mess'])
                        )
                    ) {
                        add_action('woocommerce_order_status_changed', array($this, 'wctelegrambot_order_status_changed'), 10, 3);
                    }
                }
            }
            public function define_constants(){
                if (!defined('WCTELEGRAMBOT_VERSION_NUM'))
                    define('WCTELEGRAMBOT_VERSION_NUM', $this->_version);
                if (!defined('WCTELEGRAMBOT_URL'))
                    define('WCTELEGRAMBOT_URL', plugin_dir_url(__FILE__));
                if (!defined('WCTELEGRAMBOT_BASENAME'))
                    define('WCTELEGRAMBOT_BASENAME', plugin_basename(__FILE__));
                if (!defined('WCTELEGRAMBOT_PLUGIN_DIR'))
                    define('WCTELEGRAMBOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
            }

            public function add_action_links($links, $file){
                if (strpos($file, 'wctelegrambot.php') !== false) {
                    $settings_link = '<a href="' . admin_url('options-general.php?page=setting-wctelegrambot') . '" title="' . __('C??i ?????t', 'wc-telegram-bot') . '">' . __('C??i ?????t', 'wc-telegram-bot') . '</a>';
                    array_unshift($links, $settings_link);
                }
                return $links;
            }
            function get_options(){
                return wp_parse_args(get_option($this->_optionName), $this->_defaultOptions);
            }
            function admin_menu(){
                add_options_page(
                    __('Woocommerce to Telegram', 'wc-telegram-bot'),
                    __('Woocommerce to Telegram', 'wc-telegram-bot'),
                    'manage_options',
                    'setting-wctelegrambot',
                    array( $this, 'wctelegrambot_settings_page')
                );
            }
            function dvls_register_mysettings() {
                register_setting($this->_optionGroup, $this->_optionName);
            }
            function wctelegrambot_settings_page() {
                global $wctelegrambot_settings;
                ?>
                <div class="wrap">
                    <h1>K???t N???i Woocommerce -> Telegram Bot</h1>
                     <form method="post" action="options.php" novalidate="novalidate">
            <?php settings_fields($this->_optionGroup); ?>
                        <table class="form-table">
                            <tbody>

                                <tr>
                                    <th scope="row"><label for="enable_woo"><?php _e('K??ch ho???t th??ng b??o', 'wc-telegram-bot') ?></label>
                                    </th>
                                    <td>
                                        <input type="checkbox" name="<?php echo $this->_optionName ?>[enable_woo]" id="enable_woo" value="1" <?php checked('1',intval($wctelegrambot_settings['enable_woo']), true) ; ?>/> K??ch ho???t g???i th??ng b??o ????n h??ng cho Telegram
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('N???i dung g???i', 'wc-telegram-bot') ?></th>
                                    <td>
                                        <table class="woo_setting_mess">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label><input type="checkbox" name="<?php echo $this->_optionName ?>[order_creat]" id="order_creat" value="1" <?php checked('1',intval($wctelegrambot_settings['order_creat']), true) ; ?>/> G???i th??ng b??o khi c?? ????n h??ng m???i.</label><br>
                                                        <textarea placeholder="N???i dung tin nh???n" name="<?php echo $this->_optionName ?>[order_creat_mess]"><?php echo sanitize_textarea_field($wctelegrambot_settings['order_creat_mess'])?></textarea>
                                                    </td>
                                                    <td>
                                                        <label><input type="checkbox" name="<?php echo $this->_optionName ?>[woo_status_complete]" id="woo_status_complete" value="1" <?php checked('1',intval($wctelegrambot_settings['woo_status_complete']), true) ;
                                                        ?>/> G???i th??ng b??o khi ????n h??ng ???? ho??n th??nh.</label><br>
                                                        <textarea placeholder="N???i dung tin nh???n" name="<?php echo $this->_optionName ?>[woo_status_complete_mess]"><?php echo sanitize_textarea_field($wctelegrambot_settings['woo_status_complete_mess'])?></textarea>
                                                    </td>
                                                    </tr>
                                                <tr>
                                                    <td>
                                                        <label><input type="checkbox" name="<?php echo $this->_optionName ?>[woo_status_cancelled]" id="woo_status_cancelled" value="1" <?php checked('1',intval($wctelegrambot_settings['woo_status_cancelled']), true) ; ?>/> G???i th??ng b??o khi h???y ????n h??ng.</label><br>
                                                        <textarea placeholder="N???i dung tin nh???n" name="<?php echo $this->_optionName ?>[woo_status_cancelled_mess]"><?php echo sanitize_textarea_field($wctelegrambot_settings['woo_status_cancelled_mess'])?></textarea>
                                                    </td>
                                                    <td>
                                                        <label><input type="checkbox" name="<?php echo $this->_optionName ?>[woo_status_refunded]" id="woo_status_refunded" value="1" <?php checked('1',intval($wctelegrambot_settings['woo_status_refunded']), true) ; ?>/> G???i th??ng b??o khi ho??n ti???n ????n h??ng.</label><br>
                                                        <textarea placeholder="N???i dung tin nh???n" name="<?php echo $this->_optionName ?>[woo_status_refunded_mess]"><?php echo sanitize_textarea_field($wctelegrambot_settings['woo_status_refunded_mess'])?></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="desc_wctelegrambot_bot">
                                            Hi???n th??? M?? ????n h??ng b???ng: <span style="color: blue;">%%order_id%%</span><br>
                                            Hi???n th??? T??n s???n ph???m b???ng: <span style="color: red;">%%product_name%%</span><br>
                                            Hi???n th??? H??? kh??ch h??ng b???ng: <span style="color: blue;">%%first_name%%</span><br>
                                            Hi???n th??? T??n kh??ch h??ng b???ng: <span style="color: red;">%%last_name%%</span><br>
                                            Hi???n th??? Email b???ng: <span style="color: blue;">%%billing_email%%</span><br>
                                            Hi???n th??? S??? ??i???n tho???i b???ng: <span style="color: red;">%%billing_phone%%</span><br>
                                            Hi???n th??? ?????a ch??? b???ng: <span style="color: blue;">%%billing_address%%</span><br>
                                            Hi???n th??? Ph????ng th????c thanh toa??n: <span style="color: red;">%%payment_method%%</span><br>
                                            Hi???n th??? Ph????ng th????c giao h??ng: <span style="color: blue;">%%shipping_method%%</span><br>
                                            Hi???n th??? Ng??y ?????t h??ng b???ng: <span style="color: red;">%%created_date%%</span><br>
                                            Hi???n th??? Ng??y ho??n th??nh ????n h??ng: <span style="color: blue;">%%completed_date%%</span><br>
                                            Hi???n th??? Ghi ch?? c???a kh??ch h??ng: <span style="color: red;">%%customer_note%%</span><br>
                                            Hi???n th??? T???ng ti???n b???ng: <span style="color: blue;">%%total%%</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="setting_typewctelegrambot">
                            <h2>C??i ?????t API</h2>
                        </div>
                        <div class="type_api_table" id="type_api_wctelegrambot">
                            <table class="form-table">
                                <tbody>
                                <tr>
                                    <th scope="row"><label for="tokenbot"><?php _e('Token BOT', 'wc-telegram-bot') ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="<?php echo $this->_optionName ?>[tokenbot]" id="tokenbot" value="<?php echo $wctelegrambot_settings['tokenbot'];?>"/>
                                    </td>
                                    <small><br>- <strong>Token BOT:</strong> M???? Telegram t??m BotFather, chat /newbot ????? t???o BOT v?? l???y th??ng tin Token.</span>
                                    <br>- <strong>ID Chat Telegram:</strong> B???n c?? th??? nh???p nhi???u ID chat, c??ch nhau b???i d???u ph???y (C?? nh??n ho???c Group).</small>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="idchat"><?php _e('ID Chat Telegram', 'wc-telegram-bot') ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="<?php echo $this->_optionName ?>[idchat]" id="idchat" value="<?php echo $wctelegrambot_settings['idchat'];?>"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php do_settings_fields('wctelegrambot-options-group', 'default'); ?>
                        <?php do_settings_sections('wctelegrambot-options-group', 'default'); ?>
                        <?php submit_button(); ?>
                    </form>
                </div>
                <?php
            }
            /*Start Woocommerce*/
            function wctelegrambot_string_replace($wctelegrambot_mess = '', $order = '', $order_id = ''){
                global $wctelegrambot_settings;
                if(!$wctelegrambot_mess || !$order) return $wctelegrambot_mess;
                if(!$order_id) $order_id = $order->get_id();
                $order = wc_get_order( $order_id );
                $items = $order->get_items();
                $productname = [];
                foreach ( $items as $item ) {
                $product = wc_get_product( $item['product_id'] );
                    $soluongsanpham = $item['quantity'];
                    $productname[] = $product->get_name().' ?? ('.$soluongsanpham.')';
                }
                $productname = implode(', ', $productname);
                $billing_first_name = $order->get_billing_first_name();
                $billing_last_name = $order->get_billing_last_name();
                $billing_phone = $order->get_billing_phone();
                $billing_email = $order->get_billing_email();
                $billing_address = $order->get_billing_address_1();
                $payment_method = $order->get_payment_method_title();
                $shipping_method = $order->get_shipping_method();
                $customer_note = $order->get_customer_note();
                $date_created = wp_date('d-m-Y H:i', strtotime($order->get_date_created()));
                $date_completed = wp_date('d-m-Y H:i', strtotime($order->get_date_completed()));
                $total =  $order->get_total();
                $formattedNum = number_format($total, 0, ',', '.');
                
                $str_replace['first_name'] = $billing_first_name;
                $str_replace['last_name'] = $billing_last_name;
                $str_replace['total'] = $formattedNum;
                $str_replace['billing_phone'] = $billing_phone;
                $str_replace['billing_email'] = $billing_email;
                $str_replace['order_id'] = $order_id;
                $str_replace['billing_address'] = $billing_address;
                $str_replace['product_name'] = $productname;
                $str_replace['payment_method'] = $payment_method;
                $str_replace['shipping_method'] = $shipping_method;
                $str_replace['customer_note'] = $customer_note;
                $str_replace['created_date'] = $date_created;
                $str_replace['completed_date'] = $date_completed;
                
                preg_match_all ( '/%%(\w*)\%%/' , $wctelegrambot_mess, $matches );
                foreach($matches[1] as $m){
                    $pattern = "/%%".$m."%%/";
                    $wctelegrambot_mess = preg_replace( $pattern, $str_replace[$m], $wctelegrambot_mess);
                } return $wctelegrambot_mess;
            }
            function wctelegrambot_new_order($order_id){
            if( ! get_post_meta( $order_id, '_thankyou_action_done', true ) ) {
                global $wctelegrambot_settings;
                $order = wc_get_order( $order_id );
                $admin_idchat = $wctelegrambot_settings['idchat'];
                $order_creat = $wctelegrambot_settings['order_creat'];
                if($order_creat && $wctelegrambot_settings['order_creat_mess']) {
                    $order_creat_mess = $this->wctelegrambot_string_replace($wctelegrambot_settings['order_creat_mess'], $order);
                    $this->send_wctelegrambot($admin_idchat, $order_creat_mess);
                }
                $order->update_meta_data( '_thankyou_action_done', true );
                $order->save();
            }}
            function wctelegrambot_order_status_changed($order_id, $tatus_from, $status_to){
                global $wctelegrambot_settings;
                $admin_idchat = $wctelegrambot_settings['idchat'];
                $order = wc_get_order( $order_id );
                if($order):
                    switch($status_to):
                        case 'completed':
                            if($wctelegrambot_settings['woo_status_complete'] && $wctelegrambot_settings['woo_status_complete_mess']){
                                $order_creat_mess = $this->wctelegrambot_string_replace($wctelegrambot_settings['woo_status_complete_mess'], $order);
                                $this->send_wctelegrambot($admin_idchat, $order_creat_mess);
                            }
                            break;
                        case 'cancelled':
                            if($wctelegrambot_settings['woo_status_cancelled'] && $wctelegrambot_settings['woo_status_cancelled_mess']){
                                $order_creat_mess = $this->wctelegrambot_string_replace($wctelegrambot_settings['woo_status_cancelled_mess'], $order);
                                $this->send_wctelegrambot($admin_idchat, $order_creat_mess);
                            }
                            break;
                        case 'refunded':
                            if($wctelegrambot_settings['woo_status_refunded'] && $wctelegrambot_settings['woo_status_refunded_mess']){
                                $order_creat_mess = $this->wctelegrambot_string_replace($wctelegrambot_settings['woo_status_refunded_mess'], $order);
                                $this->send_wctelegrambot($admin_idchat, $order_creat_mess);
                            }
                            break;
                    endswitch;
                endif;
            }
            /*#Start woo*/
            private function send_wctelegrambot($IdChat = '', $Content = '') {
                global $wctelegrambot_settings;
                if($IdChat) {
                    $IdChat = explode(",", $IdChat);
                    if(is_array($IdChat) && !empty($IdChat)) {
                        foreach($IdChat as $idchat){
                            $this->send_wctelegrambot_single($idchat, $Content);
                        }
                    }
                }
            }
            private function send_wctelegrambot_single($IdChat = '', $Content = '') {
                global $wctelegrambot_settings;
                $Token = $wctelegrambot_settings['tokenbot'];
                if(!$IdChat || !$Content || !$Token ) return false;
                $SendContent = urlencode($Content);
                $params = "chat_id=$IdChat&text=$SendContent&disable_web_page_preview=true";
                $data = "https://api.telegram.org/bot$Token/sendMessage?".$params;
                wp_remote_request($data);
            }
            public function admin_enqueue_scripts() {
                $current_screen = get_current_screen();
                if ( isset( $current_screen->base ) && $current_screen->base == 'settings_page_setting-wctelegrambot' ) {
                    wp_enqueue_style('wc-telegram-bot-admin-styles', plugins_url('/assets/css/admin-style.css', __FILE__), array(), $this->_version, 'all');
                }
            }
        }
        new Wctelegrambot_Class();
    }
}


