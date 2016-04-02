<?php
class ExpandmarketController extends AppController
{
    var $layout = 'hongbao';
    var $name = 'Expandmarket';
    var $view = 'empty';
    var $components = array(
            'Session',
            'Vcode',
            'Security' => array(
                    'csrfUseOnce' => false
                        )
            );
    //important !!!!!  solve this problem with costing hours
    //the Security in components must set when you want to use 
    //the same session cross pages/controllers;

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

    function house_policy() {
        $this->layout = 'housing';
        $this->view = 'userinfo';
        $this->set('title_for_layout', "身价测试");
    }

    function save_housing_singles_info() {
        $this->layout = 'empty';
        $this->view = 'save_housing_singles_info';
        $this->set('title_for_layout', "身价测试结果");

        $isPost = $this->request->is('post');
        $status = 'success';  // used in frontend
        $err = 0; // no error 
        $msg = "";
        $ip = $this->request->clientIp();

        if ($isPost) {
            $rdata = $this->request->data;

            $log_str = sprintf('checkcode[%s] vcode[%s]',
                    $rdata['checkcode'], $this->Session->read('vcode'));
            CakeLog::write('debug', $log_str);

            do {
              if (empty($rdata['checkcode'])
                  || 0 != strcasecmp($rdata['checkcode'], 
                  $this->Session->read('vcode'))) {
                $err = 4;
                $msg = '验证码错误！';
                $status = 'error';
                break;
              }

              // store data in db
              $log_str = sprintf('tel[%s],gender[%s],uname[%s],birth_year[%s],ip[%s]',
                  $rdata['telephone'], $rdata['gender'], 
                  $rdata['uname'], $rdata['birth_year'], $ip);
              CakeLog::write('info', $log_str);

            } while (0);
            // clear session to avoid attack
            CakeSession::write('vcode', '');
        }

        $log_str = sprintf('in housing_user_info client_ip:[%s]', $ip);
        CakeLog::write('debug', $log_str);

        $this->set('errNo', $err);
        $this->set('errMsg', $msg);
    }

    function vcode() {
        $this->view = 'empty';
        $this->Vcode->render();
    }
}
?>
