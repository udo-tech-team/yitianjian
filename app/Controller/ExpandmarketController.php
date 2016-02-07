<?php
class ExpandmarketController extends AppController
{
    var $layout = 'hongbao';
    var $name = 'Expandmarket';
    var $view = 'empty';
    var $components = array('Session',
            'Security' => array(
                    'csrfUseOnce' => false
                        )
            );
    //important !!!!!  solve this problem with costing hours
    //the Security in components must set when you want to use 
    //the same session cross pages/controllers;
    function index() {
        $clientIp = $this->request->clientIp();
        $log_str = 'a visitor in hongbaoPage';
        $log_str .= ', ip:' . $clientIp;
        //$this->Session->activate();
        //$refer = $this->request->session()->read('HTTP_REFERER');
        //$refer = CakeSession::read('HTTP_REFERER');
        $md5_str = date('YmdHis') . $clientIp;
        $money_id = md5($md5_str);
        $money_per_month = Configure::read('coupon.money_per_month');
        $this->set('money_per_month', $money_per_month);
        $base_multi = 2;
        $multi_minus_amount = 2;
        $base_add = 2;
        $rand_money = rand($money_per_month + $base_add, $money_per_month * $base_multi - $multi_minus_amount);

        //store in db
        $this->loadModel('Coupon');
        $data_row = array('timeipmd5' => $money_id,
                'balance' => $rand_money
                );
        //var_dump($data_row);
        //var_dump($this->Coupon);
        $save_res = $this->Coupon->save($data_row);
        //var_dump($save_res);
        if ($save_res) {
            $log_info = 'saved coupon succ,';
            $log_info .= 'info:id-' . $save_res['Coupon']['id'] . ', money-' 
                . $save_res['Coupon']['balance'];
            CakeLog::write('info', $log_info);
        }

        $_SESSION['money'] = $rand_money;
        $debug_str = 'money:' . $_SESSION['money'] . ', money_id:' . $money_id;
        CakeLog::write('debug', $debug_str);
        CakeSession::write('money_id', $money_id);
        //CakeSession::write('money', 1029); //$rand_money);  //will generate error if not set components
        //CakeSession::read('money'); //here will generate err if not set components
        $refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if (!empty($refer)) {
            $log_str .= ', refer:' . $refer;
        }
        $log_str .= ', user_agent:' . $_SERVER["HTTP_USER_AGENT"];
        CakeLog::write('info', $log_str);
        $this->view = 'empty';
    }
}
?>
