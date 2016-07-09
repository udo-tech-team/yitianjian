<?php
class OrdersController extends AppController
{
    var $layout = "order"; //if not assign, will be "default"
    var $name = "Orders";  // relative to class name
    public $monthly_price = 9.9;
    public $NOT_PAID_ORDER_LIMIT = 10; // if exceed limit, deny create order
    public $CENT_PER_YUAN = 100; // convert yuan to cent
    var $components = array(
            'Session',
            'Security' => array(
                        'csrfUseOnce' => false
                            ),
    );

    private $NOT_PAID = 0;      // user just created an order
    private $ORDER_ALREADY_PAID = 1;  // user paid in alipay, port 2b updated
    private $PORT_UPDATE_INPROGRESS = 2; // port info in updating status, in progress
    private $PORT_UPDATED = 3;  // port info updated success 

    private $ORDER_USE_VOUCHER = 1;

    private $USER_LINE_ID_FRONT_NAME = 'line_id';
    private $VOUCHER_VALID = 1;
    private $VOUCHER_INVALID = 0;

    private $OLD_CONTINUE = 'old_continue';
    private $USER_BUY_NEW = 'user_buy_new';

    private $DOMAINS_SEPERATOR  = ',';

    private $PORT_AVAILABLE = 0;
    private $PORT_IN_USE = 1;
    private $PORT_ERROR = 2;

    //add security xx=>false to allow cross controller session
    //add beforeFilter to allow post register data
    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Security)) { //&& isset($this->Auth)) 
            //$this->Auth->allow('index', 'register');
            //$this->Security->config('unlockedActions', 'register');
            $this->Security->validatePost = false;
            $this->Security->enabled = false;
            $this->Security->csrfCheck = false;
        }
    }

    function ss_ali_notify_url() {
        $this->view = 'empty';
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'alipay.config.php');
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . 
            DS . 'lib' . DS . 'alipay_notify.class.php'); 
        $ali_config = new AlipayConfig();
        $alipayNotify = new AlipayNotify($ali_config->alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        // out of ordered code begin
        $ali_verify_info = 'not set';

if($verify_result) {//验证成功
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //请在这里加上商户的业务逻辑程序代

    
    //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
    
    //商户订单号
    $out_trade_no = $_POST['out_trade_no'];

    //支付宝交易号
    $trade_no = $_POST['trade_no'];

    //交易状态
    $trade_status = $_POST['trade_status'];

    $ali_verify_info = sprintf('out_trade_no[%s] trade_no[%s] trade_status[%s]',
            $out_trade_no, $trade_no, $trade_status);

    if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
    //该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
    
        //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            
        echo "success";        //请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("wait_buyer_pay.这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
    //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
    
        //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            
        $updateFields = array(
            'is_paid' => $this->ORDER_ALREADY_PAID ,
            'trade_no' => $trade_no,
            'trade_status' => '"' . $trade_status . '"',
        );
        $updateConditions = array(
            'out_trade_no' => $out_trade_no,
            'is_paid' => $this->NOT_PAID,
        );

        $up_res = $this->Order->updateAll(
            $updateFields,
            $updateConditions
        );
        $update_result = sprintf('alipay notify, out_trade_no[%s] update result[%s]',
             $out_trade_no, $up_res);
        CakeLog::write('info', $update_result);

                // [alloc port for buy_new user] or [renew port for old user]
                do {
                    if (Configure::read('new_user_center') == 0) {
                        break;
                    }

                    if ($this->update_user_port($trade_no) < 0) {
                        $log_str = sprintf('update user port failed. trade_no[%s]',
                            $trade_no);
                        CakeLog::write('critical', $log_str);
                        break;
                    }
                } while (0);

        echo "success";        //请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("wait_seller_send_goods.这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
    //该判断表示卖家已经发了货，但买家还没有做确认收货的操作
    
        //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            
        echo "success";        //请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("wait_buyer_confirm_goods.这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else if($_POST['trade_status'] == 'TRADE_FINISHED') {
    //该判断表示买家已经确认收货，这笔交易完成
    
        //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
            
        echo "success";        //请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("trade_finished.这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else {
        //其他状态判断
        echo "success";

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult ("other_status.这里写入想要调试的代码变量值，或其他运行的结果记录");
    }

    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";
    $ali_verify_info = ' verify fail.';

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("fail.这里写入想要调试的代码变量值，或其他运行的结果记录");
}
    CakeLog::write('info', $ali_verify_info);

    }

    function create() {
        $this->set("title_for_layout", "test title");
        //var_dump($_SERVER);
        if (!empty($this->params['form'])) {
            // var_dump($this->params['form']);
            $this->flash("hello",'create');
        } else {
            //$this->flash("empty",'create');
            if ($this->request->is('post')) {
                $arr = array('id'=>'test');
                // var_dump($arr);
                // var_dump($this->request->controller);
                // var_dump($this->request->data);
            }
        }
    }

    function index() {
        $this->layout = "alipay";
    $order_no = "";
    $char_arr = array('af','dc','xy','mn','op','rd','pm');
    for ($i=0; $i < 3; ++$i) {
        $idx = rand(0,6);
        $order_no .= $char_arr[$idx];
    }
    $order_no .= rand(100000,999999);
    $this->set('trade_no', $order_no);
        $this->set('monthly_price', Configure::read('order.monthly_price'));
        //var_dump(Configure::read('order.monthly_price'));
        //$this->monthly_price = Configure::read('order.monthly_price');
    }

    private function setMessage($htext = '', $detail_info = '') {
        $this->set('htext', $htext);
        $this->set('detail_info', $detail_info);
    }

    private function get_not_paid_order_count() {
        $uid = CakeSession::read('uid');
        // user not login, return limit to deny
        if (empty($uid)) {
            return $this->NOT_PAID_ORDER_LIMIT;
        }
        // read db records
        $conditions = array(
            'created >' => date('Y-m-d 00:00:00', time()),
            'uid' => $uid,
            'is_paid' => 0,
        );
        // var_dump($conditions);
        $fields = array(
            'id',
        );
        $users_order_today = $this->Order->find('all', array(
            'fields' => $fields,
            'conditions' => $conditions,
        ));
        $users_order_count_today = count($users_order_today);
        return $users_order_count_today;
    }

    function show() {
        // simple version: read trade_no from session and get 
        // related record from db
        $this->layout = 'order_detail';
        $this->view = 'empty';
        $uid = CakeSession::read('uid');
        $out_trade_no = CakeSession::read('out_trade_no');
        // var_dump($uid);
        $errNo = 0;
        if (empty($uid)) {
            $errNo = 1;
        }
        if (empty($out_trade_no)) {
            $errNo = 2;
        }
        $this->set('errNo', $errNo);
        $trade_record = array();
        if ($errNo > 0) {
            $htext = '出错啦！';
            $detail_info = '未获取到您的订单信息，请确认已经登录！';
            $this->setMessage($htext, $detail_info);
            $errLogInfo = 'in order/show, uid=' . $uid
                    . ', errNo=' . $errNo;
            CakeLog::write('error', $errLogInfo);
        } else {
            // read trade record from db
            $trade_record = $this->Order->find('first',
                array('conditions' => array('out_trade_no' => $out_trade_no),
                )
            );
            $this->set('trade_record', $trade_record['Order']);
            // var_dump($trade_record);
        }
        // already log in
    }

    private function use_voucher_price($uid, $total, $voucher_id) {
        // validate voucher_id with uid, recalculate total price 
        // @in: $total -> RBM Cent unit, 
        //          'amount' field in record is RMB cent unit
        // @return: new total price, in RMB cent unit
        $uid = (int)($uid);
        $total = (int) $total;
        $voucher_id = (int) $voucher_id;

        if ($uid <= 0 || $total < 0 || $voucher_id < 0) {
            $log_str = sprintf('get invalid param. uid[%d] total[%d] voucher[%d]', 
                $uid, $total, $voucher_id);
            CakeLog::write('warning', $log_str);
            return $total;
        }

        // validate voucher is correct
        $this->loadModel('Voucher');
        $time_now = date('Y-m-d H:i:s', time());
        $conditions = array(
            'uid' => $uid,
            'is_valid' => $this->VOUCHER_VALID,
            'expire >=' => $time_now,
        );

        $voucher_info = $this->Voucher->find('first',
            array(
            'conditions' => $conditions,
            )
        );

        if (empty($voucher_info)) {
            $log_str = sprintf('get empty voucher. uid[%d] total[%d] voucher[%d]', 
                $uid, $total, $voucher_id);
            CakeLog::write('warning', $log_str);
            return $total;
        }

        $voucher_item = $voucher_info['Voucher'];
        // var_dump($voucher_item);
        // total / new_total in Yuan while amount in Cent unit
        $new_total = ($total - $voucher_item['amount']);

        if ($new_total <= 0) {
            $log_str = sprintf('error. uid[%d] total[%d] voucher[%d] new_total[%d]', 
                $uid, $total, $voucher_id, $new_total);
            CakeLog::write('warning', $log_str);
            return $total;
        }

        // update voucher is_valid to invalid status
        $this->Voucher->id = $voucher_id;
        $is_valid = $this->VOUCHER_INVALID;
        $this->Voucher->saveField('is_valid', $is_valid);

        $log_str = sprintf('success. uid[%d] total[%d] voucher_id[%d] discount[%d] new_total[%d]', 
            $uid, $total, $voucher_id, $voucher_item['amount'], $new_total);
        CakeLog::write('info', $log_str);

        return $new_total;
    }

    private function calc_price_by_line_info($line_id, $months) {
        // NOTICE:  monthly_price field in table is in RMB cent unit!!!
        // @return: total_price, in RMB cent unit!!!
        $line_id = (int)$line_id;
        $months = (int)$months;

        if ($line_id <= 0 || $months <= 0) {
            $log_str = sprintf('uid[%s] line_id[%s] months[%s] param err', 
                CakeSession::read('uid'), $line_id, $months);
            CakeLog::write('warning', $log_str);

            return -1;
        }

        $this->loadModel('Line');
        $conditions = array(
            'id' => $line_id,
        );
        $line_info = $this->Line->find('first',
            array(
            'conditions' => $conditions,
            )
        );

        if (empty($line_info)) {
            $log_str = sprintf('uid[%s] line_id[%s] months[%s] get empty line record', 
                CakeSession::read('uid'), $line_id, $months);
            CakeLog::write('warning', $log_str);

            return -1;
        }

        $monthly_price = (int)($line_info['Line']['monthly_price']);
        $total_price = $monthly_price * $months ;

        return $total_price;
    }

    // get post data and send payment request to alipay
    function alicreate() {
        // 1. check data valid
        // 2. collect data and send to alipay

        $rdata = $this->request->data;
        // to check if user choosed use_voucher
        if (array_key_exists('use_voucher', $rdata)) {
            $check_box = $rdata['use_voucher'][0];
            // var_dump($check_box);
            // var_dump($check_box > 0);
        }
        // var_dump($this->request->data);
        $this->view = 'empty';
        $uid = CakeSession::read('uid');
        if (empty($uid)) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
        $errNo = 0;
        $htext = '';
        $detail_info = '';
        $months = 1;
        $monthly_price = 0;
        $monthly_netflow = 0;
        $acctype = '';
        do {
            // if refer unexpected
            $refer = 'empty';
            if (isset($_SERVER['HTTP_REFERER'])) {
                $refer = $_SERVER['HTTP_REFERER'];
            }
            $log_str = sprintf("alicreate. refer=[%s]", $refer);
            CakeLog::write('info', $log_str);

            $domain = Configure::read('domain_name');
            if (strpos($refer, $domain) === false) {
                $errNo = 4;
                $htext = '出错啦！';
                $detail_info = '请在ashadowsocks账号页面购买';
                $log_str = sprintf("domain_name[%s] refer[%s] unmatch",
                        $domain, $refer);
                CakeLog::write('warning', $log_str);
                break;
            }
            // if not post request, return
            if (!$this->request->is('post')) {
                // var_dump(Configure::read('order'));
                // var_dump(array_key_exists('yearly_price',Configure::read('order')));
                $htext = '出错啦！';
                $detail_info = '请直接在shadowsocks账号页面购买';
                $errNo = 1;
                break;
            }
            $rdata = $this->request->data;

            // check account_types passed from front end
            $account_types = Configure::read('account_types');
            // var_dump($account_types);
            // var_dump($account_types['basic']['monthly_price']);
            // var_dump($account_types['basic']['monthly_netflow']);
            if (!array_key_exists($rdata['acctype'], $account_types)) {
                $htext = '参数出错啦！';
                $detail_info = '请将此错误反馈给我们！';
                $errNo = 2;
                $errInfo = 'user acctype error,uid=' . $uid 
                    . ", acctype=" . $rdata['acctype'];
                CakeLog::write('error', $errInfo);
                break;
            }
            $acctype = $rdata['acctype'];

            // check months value
            if ($rdata['months'] <= 0) {
                $errNo = 3;
                $errInfo = 'user months error,uid=' . $uid
                    . ", months=" . $rdata['months'];
                CakeLog::write('error', $errInfo);
                break;
            }
            $months = $rdata['months'];
            $monthly_price = $account_types[$acctype]['monthly_price'];
            $monthly_netflow = $account_types[$acctype]['monthly_netflow'];
            $not_paid_order_count = $this->get_not_paid_order_count();
            if ($not_paid_order_count >= $this->NOT_PAID_ORDER_LIMIT) {
                $errNo = 5;
                $errInfo = 'user exists not paid order,uid=' . $uid
                    . ", not paid order count=" . $this->NOT_PAID_ORDER_LIMIT;
                $htext = '出错啦！';
                $detail_info = '您一天内创建的未支付的订单太多了~';
                CakeLog::write('error', $errInfo);
                break;
            }
            // var_dump($monthly_netflow);
            // var_dump($not_paid_order_count);
            // var_dump($this->NOT_PAID_ORDER_LIMIT);
            //var_dump($rdata);
        } while (0);

        if ($errNo > 0) {
            $this->layout = 'message';
            $this->setMessage($htext, $detail_info);
            $errInfo = 'errNo=' . $errNo . ', htext:'
                . $htext . ', detail:' . $detail_info;
            CakeLog::write('error', $errInfo);
            return;
        }
        //var_dump($months * $monthly_price);
        // price * 100, set to cent
        $total_price = $months * $monthly_price * 100;
        $uid_hash = md5($uid);
        // var_dump($uid_hash);
        // out_trade_no format: datetime(14) + userid_md5(frist 4 char)
        // + rand(8 char) + userid_md5(last 4 char) 
        $out_trade_no = date('YmdHis') . substr($uid_hash, 0, 4) 
            . rand(10000000,99999999) . substr($uid_hash, -4);  // '201511142349jjdiei';
        // $show_url = 'http://www.ashadowsocks.com/'; //$_POST['WIDshow_url'];
        $show_url = Router::url(array('controller'=>'orders', 'action'=>'show'), true);

        if (Configure::read('new_user_center') > 0) {
            // remember the line to alloc
            $line_id = 0;
            if (array_key_exists($this->USER_LINE_ID_FRONT_NAME,
                    $rdata)) {
                $line_id = (int)($rdata[$this->USER_LINE_ID_FRONT_NAME]);
                $dataRow['line_id'] = $line_id;
            }

            if ($line_id > 0 && Configure::read('get_price_from_line_info') != 0) {
                // line_id valid and get from price from line info enabled
                $total_price = $this->calc_price_by_line_info($line_id, $months);
                $log_str = sprintf('uid[%s] get total price[%s], lineid[%s] months[%s]',
                    $uid, $total_price, $line_id, $months);
                CakeLog::write('info', $log_str);
            }
            //  remember the renewing port
            if (array_key_exists('port_id', $rdata)) {
                $dataRow['port_id'] = (int)($rdata['port_id']);
            }
            // record voucher, disable related voucher once order created
            do {
                if (Configure::read('enable_voucher_use') == 0) {
                    break;
                }
                if (!array_key_exists('use_voucher', $rdata)) {
                    // use didn't have voucher or didn't choose use voucher
                    break;
                }
                if ((int)($rdata['use_voucher'][0]) == $this->ORDER_USE_VOUCHER) {
                    // user has voucher and choose to use it
                    $voucher_id = (int)$rdata['voucher_id'];
                    $new_total = $this->use_voucher_price($uid, 
                        $total_price, $voucher_id);

                    if ($new_total == $total_price) {
                        $log_str = sprintf('user[%d] total_price[%d] no change' . 
                            ' after use voucher[%d]', 
                            $uid, $total_price, $voucher_id);
                        CakeLog::write('warning', $log_str);
                        break;
                    }
                    // voucher valid, change total price, and record voucher_id 
                    $total_price = $new_total;
                    $dataRow['voucher_id'] = $voucher_id;
                    $dataRow['discount_desc'] = 'voucher ticket';
                }
            } while (0);
            // record discount description
            // var_dump($dataRow);
            // return;
        }

        $order_subject = '倚天剑shadow购买';
        if ($acctype == $this->OLD_CONTINUE) {
            $order_subject = '倚天剑shadow续费';
        }  

        //return;
        // volatile fields: show_url, out_trade_no, price, subject
        $order_param = array(
            'out_trade_no' => $out_trade_no,
            'subject' => $order_subject,
            'price' => $total_price / 100,
            'show_url' => $show_url,
        );

        // create db order record
        $rdata = $this->request->data;
        $dataRowAppend = array(
            'out_trade_no' => $out_trade_no,
            'uid' => $uid,
            'acctype' => $acctype,
            'price' => $total_price,
            'months' => $months,
            'month_flow' => $monthly_netflow,
        );
        $dataRow = array_merge($dataRow, $dataRowAppend);

        $save_res = $this->Order->save($dataRow);
        // var_dump($save_res);

        $submit_html = $this->create_and_send2ali($order_param);
        echo $submit_html;

        // var_dump($submit_html);
    } // alicreate end

    /*
     * @param order fields array
     *   // including fields: show_url, out_trade_no, price, subject
     * @return html string
     * called when create new order or user pay an old order
     */
    private function create_and_send2ali($order_param) {
        // var_dump($order_param);
        // App::import('Vendor', 'lib', array('file'=>'lib' . DS . 'alipay_submit.class.hp'));

        // App::import('vendor', 'alipay.config');
        // App::uses('alipay.config', 'Vendor');
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'alipay.config.php');
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . 
            DS . 'lib' . DS . 'alipay_submit.class.php');
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . 
            DS . 'lib' . DS . 'alipay_core.function.php'); 
        //logResult("test");

/**************************请求参数**************************/

    {
        // volatile fields: show_url, out_trade_no, price, subject
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        //$notify_url = "http://www.gso.hk/crtorder/notify_url.php";
        $notify_url = Router::url(array('controller'=>'orders', 'action'=>'ss_ali_notify_url'), true);
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        //Router::url(array(controller,action), true); true will generate full url.
        //$return_url = Router::url(array('controller'=>'orders', 'action'=>'return_url'), true);
        $return_url = Router::url(array('controller'=>'orders', 'action'=>'ss_ali_return_url'), true);
        CakeLog::write('debug', $return_url);
        //$return_url = "http://www.gso.hk/crtorder/return_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
        $out_trade_no = $order_param['out_trade_no']; // '8192930291xjaido'; //rand(10000000,99999999);//$_POST['WIDout_trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $order_param['subject']; // 'testOrderName' . $out_trade_no ;//$_POST['WIDsubject'];
        //必填
        //付款金额
        $price = $order_param['price']; // 0.01;//$total_price; //$_POST['WIDprice'];
        //必填
        //商品数量
        $quantity = "1";
        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
        //物流费用
        $logistics_fee = "0.00";
        //必填，即运费
        //物流类型
        $logistics_type = "EXPRESS";
        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
        //物流支付方式
        $logistics_payment = "SELLER_PAY";
        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        //订单描述
        $body = 'description'; //$_POST['WIDbody'];
        //商品展示地址
        $show_url = $order_param['show_url']; // 'http://www.ashadowsocks.com/'; //$_POST['WIDshow_url'];
        //需以http://开头的完整路径，如：http://www.商户网站.com/myorder.html
        //收货人姓名
        $receive_name = 'xiaohua'; //$_POST['WIDreceive_name'];
        //如：张三
        //收货人地址
        $receive_address = 'st Street, rd Road'; //$_POST['WIDreceive_address'];
        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
        //收货人邮编
        $receive_zip = '208109'; //$_POST['WIDreceive_zip'];
        //如：123456
        //收货人电话号码
        $receive_phone = '0571-88158090'; //$_POST['WIDreceive_phone'];
        //如：0571-88158090
        //收货人手机号码
        $receive_mobile = '13300992930'; //$_POST['WIDreceive_mobile'];
        //如：13312341234

    }

/************************************************************/
        $ali_config = new AlipayConfig();

//构造要请求的参数数组，无需改动
$parameter = array(
        "service" => "create_partner_trade_by_buyer",
        "partner" => trim($ali_config->alipay_config['partner']),
        "seller_email" => trim($ali_config->alipay_config['seller_email']),
        "payment_type" => $payment_type,
        "notify_url" => $notify_url,
        "return_url" => $return_url,
        "out_trade_no" => $out_trade_no,
        "subject" => $subject,
        "price" => $price,
        "quantity" => $quantity,
        "logistics_fee" => $logistics_fee,
        "logistics_type" => $logistics_type,
        "logistics_payment" => $logistics_payment,
        "body" => $body,
        "show_url" => $show_url,
        "receive_name" => $receive_name,
        "receive_address" => $receive_address,
        "receive_zip" => $receive_zip,
        "receive_phone" => $receive_phone,
        "receive_mobile" => $receive_mobile,
        "_input_charset" => trim(strtolower($ali_config->alipay_config['input_charset']))
);

        // var_dump($parameter);
//建立请求
$alipaySubmit = new AlipaySubmit($ali_config->alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
// var_dump($html_text);
// store out_trade_no into session
CakeSession::write('out_trade_no',$out_trade_no);
// var_dump(CakeSession::read('out_trade_no'));
return $html_text;

    } // create_and_send2ali end

    private function get_domains($line_id) {
        // @in: line_id 
        // @return: domains string, related with line_id

        if ($line_id < 0) {
            $log_str = sprintf('line_id[%d] err when try to get related domains!',
                $line_id);
            CakeLog::write('critical', $log_str);
            return array();
        }

        $this->loadModel('Line');
        $conditions = array(
            'id' => $line_id,
        );
        $line_info = $this->Line->find('first',
            array(
            'conditions' => $conditions,
            )
        );
        if (empty($line_info)) {
            $log_str = sprintf('line_id[%d] get empty record!',
                $line_id);
            CakeLog::write('critical', $log_str);
            return array();
        }

        return $line_info;

    }

    private function split2domain_arr($domains) {
        // @in: domains string, coma seperated
        // @return: single domain string array
        $domains_arr = array();
        if (empty($domains)) {
            return $domains_arr;
        }

        $domains_arr = split($this->DOMAINS_SEPERATOR, $domains);

        $dlen = count($domains_arr);
        for($idx = 0; $idx < $dlen; $idx++) {
            $domains_arr[$idx] = trim($domains_arr[$idx]);
        }

        return $domains_arr;
    }

    private function alloc_port($order_item) {
        // @return: 0 for success, -1 for failure

        $acctype = $order_item['acctype'];
        $uid = $order_item['uid'];
        $trade_no = $order_item['trade_no'];
        $is_paid = $order_item['is_paid'];
        $line_id = $order_item['line_id'];
        $months = $order_item['months'];

        if ($acctype != $this->USER_BUY_NEW 
                || $is_paid != $this->PORT_UPDATE_INPROGRESS) {
            $log_str = sprintf('acctype[%s] is_paid[%d] unexpected for ' .
                'trade_no[%s] in alloc_port()',
                $acctype, $is_paid, $trade_no);
            CakeLog::write('critical', $log_str);
            return -1;
        }

        // get line_id related domains
        $line_info = $this->get_domains($line_id);
        if (empty($line_info)) {
            $log_str = sprintf('unexpected err. line_id[%d] get empty record!', 
                $line_id);
            CakeLog::write('critical', $log_str);
            return -1;
        }
        $domains = $line_info['Line']['domains'];   // string like 'gso.hk,uwill.pw'
        $domains_arr = $this->split2domain_arr($domains);

        if (empty($domains_arr)) {
            $log_str = sprintf('line_id[%d] domains_arr empty! original str[%s]', 
                $line_id, $domains);
            CakeLog::write('critical', $log_str);
            return -1;
        }

        // do the port booking logic with table locked
        $errno = 0;   // default no err

        $this->loadModel('Port');
        $dbo = $this->Port->getDataSource();
        $lock_query = sprintf('LOCK TABLES %s AS %s WRITE;', 
                $this->Port->tablePrefix . $this->Port->table, $this->Port->alias);
        $unlock_query = "UNLOCK TABLES";

        do {
              if (!$dbo->execute($lock_query)) {
                  $unlock_res = $dbo->execute($unlock_query);
                  $log_str = sprintf('uid[%s], unlock_res[%s], ' . 
                      'trade_no[%s]. lock table failed', 
                        $uid, $unlock_res, $trade_no);
                  CakeLog::write('critical', $log_str);
                  $errno = 1;
                  break;
              }
              //find first available port
              $conditions = array(
                  'sshost' => $domains_arr,
                  'status' => $this->PORT_AVAILABLE,
                  'uid' => 0,
                  'mtid' => 0,
              );
              $avail_port = $this->Port->find('first',
                  array(
                      'conditions'=> $conditions,
                    )
                );

              if (!$avail_port) {
                  $unlock_res = $dbo->execute($unlock_query);
                  $log_str = sprintf('uid[%s], trade_no[%s] unlock_res[%s] empty avail_port', 
                        $uid, $trade_no, $unlock_res);
                  CakeLog::write('critical', $log_str);
                  $errno = 2;
                  break;
              }

              $duration = $months;
              $expire = date('Y-m-d H:i:s', strtotime("+$duration month"));
              $up_data = array(
                  'status' => $this->PORT_IN_USE,
                  'uid' => $uid,
                  'modified' => 'now()',
                  'expire' => '"' . $expire . '"',
              );
              $up_cond = array('id' => $avail_port['Port']['id']);
              $up_res = $this->Port->updateAll($up_data, $up_cond);
  
              $unlock_res = $dbo->execute($unlock_query); // if success returns true
              $log_str = sprintf('uid[%s] trade_no[%s] unlock_res[%s]',
                    $uid, $trade_no, $unlock_res);
              CakeLog::write('info', $log_str);

        } while (0);

        if ($errno > 0) {
            $log_str = sprintf('uid[%d] trade_no[%s] alloc port failed. err no[%d]', 
                    $uid, $trade_no, $errno);
            CakeLog::write('critical', $log_str);
            // unlock tables
            $unlock_res = $dbo->execute($unlock_query); // if success returns true
            return -1;
        }

        return 0;
    }

    private function renew_port($order_item) {
        // @return: 0 for success, -1 for failure

        $acctype = $order_item['acctype'];
        $uid = $order_item['uid'];
        $trade_no = $order_item['trade_no'];
        $is_paid = $order_item['is_paid'];
        $port_id = $order_item['port_id'];

        if ($acctype != $this->OLD_CONTINUE
                || $is_paid != $this->PORT_UPDATE_INPROGRESS) {
            $log_str = sprintf('acctype[%s] is_paid[%d] unexpected for ' .
                'trade_no[%s] in renew_port()',
                $acctype, $is_paid, $trade_no);
            CakeLog::write('debug', $log_str);
            return -1;
        }

        $this->loadModel('Port');
        $conditions = array(
            'id' => $port_id,
            'status' => $this->PORT_IN_USE,
            'uid' => $uid,
        );
        $port_info = $this->Port->find('first',
            array(
            'conditions' => $conditions,
            )
        );

        if (empty($port_info)) {
            $log_str = sprintf('uid[%d] port_id[%d] unexpected for ' .
                'trade_no[%s] in alloc_port()',
                $uid, $port_id, $trade_no);
            CakeLog::write('debug', $log_str);
            return -1;
        }
        $port_item  = $port_info['Port'];

        $old_expire = $port_item['expire'];
        $add_month = $order_item['months'];
        $new_expire = date('Y-m-d H:i:s', 
                strtotime("$old_expire + $add_month month"));

        $this->Port->id = $port_id;
        $up_res = $this->Port->saveField('expire', $new_expire);
        $log_info = sprintf('uid[%d] port_id[%d] trade_no[%s] update res[%d]',
            $uid, $port_id, $trade_no, $up_res);

        // update expire field according to port_id
        return 0;
    }

    //@function: update user's port
    //      1. user_buy_new, alloc a new port
    //      2. old_continue, change expire time of related port
    //@return: non zero : success, -1 : failed.
    private function update_user_port($trade_no) {
        // 1.get trade_no related paid but not_updated records,
        //      not_updated means not update port info
        // 2.update to port_update_inprogress, 
        //      to avoid another request modify at the same time
        // 3.update the port
        //      a. user_buy_new, alloc a new port
        //      b. old_continue, reset expire date
        $conditions = array(
            'trade_no' => $trade_no,
            'is_paid' => $this->ORDER_ALREADY_PAID,
        );
        $order_info = $this->Order->find('first',
            array(
            'conditions' => $conditions,
            )
        );

        if (empty($order_info)) {
            $log_str = sprintf('get empty paid order for trade_no[%s]' .
                ', port info maybe already updated.',
                $trade_no);
            CakeLog::write('debug', $log_str);
            return 1;
        }

        // update is_paid field as soon as possible, as table is not locked.
        $updateFields = array(
            'is_paid' => $this->PORT_UPDATE_INPROGRESS,
        );
        $up_res = $this->Order->updateAll(
            $updateFields,
            $conditions
        );

        if (!$up_res) {
            $log_str = sprintf('update is_paid field failed. trade_no[%s]' .
                ', this may occur by concurrent write db.',
                $trade_no);
            CakeLog::write('critical', $log_str);
            return -1;
        }

        // order_info has already changed !!!
        // is_paid successfully updated in db, this record update relatively
        $order_info['Order']['is_paid'] = $this->PORT_UPDATE_INPROGRESS;

        // update order is_paid to paid_and_updated, then update user's port info
        //      acctype may in (user_buy_new, old_continue)
        //          1. user_buy_new, alloc a port to uid according to line_id
        //              param: uid, months, line_id
        //          2. old_continue, update expire field according to months
        //              param: uid, months, port_id
        $order_item = $order_info['Order'];
        $acctype = $order_item['acctype'];

        $ret = -1;
        if ($acctype == $this->USER_BUY_NEW) {
            $ret = $this->alloc_port($order_item);
        } else if ($acctype == $this->OLD_CONTINUE) {
            $ret = $this->renew_port($order_item);
        } else {
            $log_str = sprintf('update order but acctype[%s] unknow.' . 
                ' trade_no[%s] acctype[%s]',
                $acctype, $trade_no, $acctype);
            CakeLog::write('critical', $log_str);
        }

        if ($ret < 0) {
            $log_str = sprintf('update user port or alloc port failed.' . 
                ' trade_no[%s] acctype[%s]',
                $trade_no, $acctype);
            CakeLog::write('critical', $log_str);
            return -1;
        }

        // port updated success, update is_paid to port_udpated
        $up_conditions = array(
            'trade_no' => $trade_no,
            'is_paid' => $this->PORT_UPDATE_INPROGRESS,
        );
        $up_fields = array(
            'is_paid' => $this->PORT_UPDATED,
        );
        $up_res = $this->Order->updateAll(
            $up_fields,
            $up_conditions
        );

        if (!$up_res) {
            $log_str = sprintf('update is_paid field failed. trade_no[%s]' .
                ', this means order is_paid still in port updating progress ' . 
                'while actually port is already succ updated',
                $trade_no);
            CakeLog::write('critical', $log_str);
            return -1;
        }
        
        return 0;
    }


    // soon after user paid, alipay redirect to this page(action)
    function ss_ali_return_url() {
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'alipay.config.php');
        require_once(ROOT . DS . 'app' . DS . 'Vendor' . 
            DS . 'lib' . DS . 'alipay_notify.class.php');
        $ali_config = new AlipayConfig();
    //计算得出通知验证结果
    $alipayNotify = new AlipayNotify($ali_config->alipay_config);
    $verify_result = $alipayNotify->verifyReturn();
    $uid = CakeSession::read('uid');
    if($verify_result) {//验证成功
        //请在这里加上商户的业务逻辑程序代码
        
        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
        //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
    
        //商户订单号
        $out_trade_no = $_GET['out_trade_no'];
    
        //支付宝交易号
        $trade_no = $_GET['trade_no'];
    
        //交易状态
        $trade_status = $_GET['trade_status'];
        $ali_return_info = 'in alipay_return_url, out_trade_no='
                . $out_trade_no . ', trade_no=' . $trade_no
                . ', trade_status=' . $trade_status
                . ', uid=' . CakeSession::read('uid');
        CakeLog::write('info', $ali_return_info);
    
    
        if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
            //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $updateFields = array(
                    'is_paid' => $this->ORDER_ALREADY_PAID ,
                    'trade_no' => $trade_no,
                    'trade_status' => '"' . $trade_status . '"',
                );
                $updateConditions = array(
                    'out_trade_no' => $out_trade_no,
                    'is_paid' => $this->NOT_PAID,
                    // 'uid' => $uid,
                );
                $up_res = $this->Order->updateAll(
                    $updateFields,
                    $updateConditions
                );
                $update_result = 'alipay return, out_trade_no=' . $out_trade_no
                        . ', update result=' . $up_res;
                CakeLog::write('info', $update_result);

                // [alloc port for buy_new user] or [renew port for old user]
                do {
                    if (Configure::read('new_user_center') == 0) {
                        break;
                    }

                    if ($this->update_user_port($trade_no) < 0) {
                        $log_str = sprintf('update user port failed. trade_no[%s]',
                            $trade_no);
                        CakeLog::write('critical', $log_str);
                        break;
                    }
                } while (0);

                $this->redirect(
                        array("controller" => "users", "action" => "ucenter")
                );
            }
            else {
              $ali_info = "trade_status=".$_GET['trade_status'];
            }
                
            $ali_info = "验证成功<br />";
            $ali_info = "trade_no=".$trade_no;
        
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
    } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            $out_trade_no = $_GET['out_trade_no'];
            $ali_return_error = 'uid=' . $uid . ', out_trade_no='
                    . $out_trade_no . ",验证失败";
            CakeLog::write('error', $ali_return_error);
    }
    // CakeLog::write('info', $ali_info);
    $this->redirect(
            array("controller" => "users", "action" => "ucenter")
    );
    }
}
