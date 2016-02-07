<?php
class OrdersController extends AppController
{
    var $layout = "order"; //if not assign, will be "default"
    var $name = "Orders";  // relative to class name
    public $monthly_price = 9.9;
    public $NOT_PAID_ORDER_LIMIT = 10; // if exceed limit, deny create order
    public $ORDER_ALREADY_PAID = 1;
    public $CENT_PER_YUAN = 100; // convert yuan to cent
    var $components = array(
            'Session',
            'Security' => array(
                        'csrfUseOnce' => false
                            ),
    );

    //add security xx=>false to allow cross controller session
    //add beforeFilter to allow post register data
    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Security)) { //&& isset($this->Auth)) {
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
    $ali_verify_info = 'out_trade_no:' . $out_trade_no 
        . ', trade_no:' . $trade_no . ', trade_status:'
        . $trade_status;


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
        // #TODO
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

    function alicreate() {
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
                $errNo = 4;
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
        $total_price = $months * $monthly_price;
        $uid_hash = md5($uid);
        // var_dump($uid_hash);
        // out_trade_no format: datetime(14) + userid_md5(frist 4 char)
        // + rand(8 char) + userid_md5(last 4 char) 
        $out_trade_no = date('YmdHis') . substr($uid_hash, 0, 4) 
            . rand(10000000,99999999) . substr($uid_hash, -4);  // '201511142349jjdiei';
        // $show_url = 'http://www.ashadowsocks.com/'; //$_POST['WIDshow_url'];
        $show_url = Router::url(array('controller'=>'orders', 'action'=>'show'), true);
        //return;
        // volatile fields: show_url, out_trade_no, price, subject
        $order_param = array(
            'out_trade_no' => $out_trade_no,
            'subject' => 'subject description',
            'price' => $total_price,
            'show_url' => $show_url,
        );

        // create db order record
        $rdata = $this->request->data;
        $dataRow = array(
            'out_trade_no' => $out_trade_no,
            'uid' => $uid,
            'acctype' => $acctype,
            'price' => $total_price * $this->CENT_PER_YUAN,
            'months' => $months,
            'month_flow' => $monthly_netflow,
        );
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
                    'uid' => $uid,
                );
                $up_res = $this->Order->updateAll(
                    $updateFields,
                    $updateConditions
                );
                $update_result = 'out_trade_no=' . $out_trade_no
                        . ', update result=' . $up_res;
                CakeLog::write('info', $update_result);
                $this->redirect(
                        array("controller" => "users", "action" => "apply_acc")
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
