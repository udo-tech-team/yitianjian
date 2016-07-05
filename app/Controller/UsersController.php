<?php
class UsersController extends AppController
{
    //TODO  trim users' input
    var $layout = "user"; //if not assign, will be "default"
    var $name = "Users";  // relative to class name
    var $components = array('Session', 
            'Security' => array(
                        'csrfUseOnce' => false
                            ),
            'Vcode');
    private $PORT_IN_USE = 1;
    private $PORT_AVAILABLE = 0;
    private $PORT_ERROR = 2;
    private $PORT_MAX_COUNT_PER_USER = 10;

    private $NOT_PAID = 0;  // alipay didn't return succ
    private $ALREADY_PAID = 1; // user paid but port not updated
    private $PAID_AND_UPDATED = 2; // user paid and port updated

    private $USER_BUY_NEW = 'user_buy_new';
    private $OLD_CONTINUE = 'old_continue';

    private $CONTACT_QQ_NUM = '';

    private $NORMAL_INFO_TYPE = 1;
    private $LINE_AVAILABLE_STATUS = 0;
    private $USER_VOUCHER_SELECT_LIMIT = 30;
    private $VOUCHER_VIA_REGISTER = 2;
    private $VOUCHER_VIA_INVITING = 2;
    private $VOUCHER_VALID = 1;

    // to avoid attach
    //      on average, every ip is allowed to visit n times 
    //      within a day via inviting page, see detail code
    private $VISIT_RATIO_THRESHOLD = 5;

    //add security xx=>false to allow cross controller session
    //add beforeFilter to allow post register data
    public function beforeFilter() {
        parent::beforeFilter();
        $this->CONTACT_QQ_NUM = Configure::read('kefu_qq');
        if (isset($this->Security)) { //&& isset($this->Auth)) {
            //$this->Auth->allow('index', 'register');
            //$this->Security->config('unlockedActions', 'register');
            $this->Security->validatePost = false;
            $this->Security->enabled = false;
            $this->Security->csrfCheck = false;
        }
    }

        // parent::__construct();

    function index() {
        $this->set('title_for_layout', "User::mypage");
        $this->log('request for user homepage. ip:' 
            . $this->request->clientIp(), 'debug');
        $this->redirect(
            array("controller" => "users", "action" => "ucenter")
        );
    }

    function register($invite_md5='') {
        //check if user logged in
        //session_start();  // this can't do, or the original session will b lost
        $log_info = 'in register, ip:' . $this->request->clientIp();
        $reg_refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'not set';
        $log_info .= ', refer:' . $reg_refer;
        CakeLog::write('info', $log_info);
        $log_info = '';
        if ($this->Session->read('uid')) {
            $this->redirect(
                array("controller" => "users", "action" => "ucenter")
            );
        }

        $money = $this->Session->read('money');
        if ($money) {
            $this->set('remindInfo','注册成功后￥' . $money . '将存入您的账户');
        }

        $inviting_user = array();
        if ($invite_md5 != '') {
            // user visit from shared inviting page
            // this code block writes log and insert db record,
            //      avoid attack !!!
          do {
            // check if invite_md5 correct
            $conditions = array(
                'uniq_md5' => $invite_md5,
            );
            $inviting_user = $this->User->find('first', 
                array(
                    'conditions' => $conditions,
                )
            );

            // not exists
            if (empty($inviting_user)) {
                $log_str = sprintf('ip[%s] invite_md5[%s] find '.
                    'no inviting user', 
                    $this->request->clientIp(), $invite_md5);
                Cakelog::write('warning', $log_str);

                // reset invite_md5 to avoid following process
                $invite_md5 = '';
                break;
            } 

            // if the distinct ip much more less than visit count, 
            //  we regard it as an attack.
            //    i.e. visit_count / ip_count > threshold in a day,
            //          disable insert
            $time_start = date('Y-m-d 00:00:00', time());
            $select_cond = array(
                'invite_md5' => $invite_md5,
                'created >=' => $time_start,
            );
            $this->loadModel('Ivisit');
            $visited_total = $this->Ivisit->find('count', 
                array(
                    'conditions' => $select_cond,
                )
            );
            $distinct_ip_total = $this->Ivisit->find('count', 
                array(
                    'fields' => 'distinct req_ip',
                    'conditions' => $select_cond,
                )
            );

            if ($distinct_ip_total > 0) {
                $ratio = $visited_total / $distinct_ip_total;
                $log_str = sprintf('daily visited/disctinct [%s], threshold[%s]', 
                        $ratio, $this->VISIT_RATIO_THRESHOLD);
                CakeLog::write('debug', $log_str);

                if ($ratio >= $this->VISIT_RATIO_THRESHOLD) {
                    break;
                }
            }

            // record this visit

            $data_row = array(
                'req_ip' => $this->request->clientIp(),
                'invite_md5' => $invite_md5,
            );
            $save_res = $this->Ivisit->save($data_row);

            $money = Configure::read('register_user_money') / 100;

            $this->Session->write('invite_md5', $invite_md5);
            $this->set('invite_info',
                '注册成功后￥' . $money . '将存入您的账户');

            $log_str = sprintf('ip[%s] invite_md5[%s] save to ivisit res[%s].', 
                $this->request->clientIp(), 
                $data_row['invite_md5'], 
                $save_res['Ivisit']['id']);
            CakeLog::write('debug', $log_str);
          } while (0);

        }
        $this->set('title_for_layout', "User::register|倚天剑shadow - 提供shadowsocks科学上（翻）网（墙）账号！倚天剑shadow|shadowsocks账号|免费shadowsocks账号");
        //var_dump($this->request->data);
        $err = 0; // no error 
        $msg = "";
        $isPost = $this->request->is('post');
        //var_dump(CakeSession::read('vcode'));
        //var_dump($_SESSION['vcode']);
        if ($isPost) {
          $rdata = $this->request->data;
          //verify check code
          if (empty($rdata['checkcode'])
              || 0 != strcasecmp($rdata['checkcode'], $this->Session->read('vcode'))) {
              $err = 4;
              $msg = '验证码错误！';
          }
          CakeSession::write('vcode', '');
          if ($rdata['password'] != $rdata['password2']) {
              $err = 1;
              $msg = "密码输入不一致！";
          }
          //$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
          $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,7}(\\.[a-z]{2})?)$/i";
          // allow user register with both email and telephone
          $tel_pattern = '#1[\d]{10}#';
          if (!preg_match($pattern, $rdata['email']) && !preg_match($tel_pattern, $rdata['email'])) {
              $err = 2;
              $msg = "邮箱格式或电话号码错误 ！";
          }
  
          if ( $err == 0) {
              $existEmail = $this->User->find('first',
                  array(
                      'conditions'=>array('email'=>$rdata['email'])));
             //var_dump($existEmail);
             //var_dump($existEmail['User']['uid']);
              $datetime =  date("Y-m-d H:i:s", time());
             //var_dump($datetime);
              if (count($existEmail) > 0) {
                  $err = 3;
                  $msg = "用户已注册！";
              }
          }
        }

        if ($isPost && $err == 0) {
            //data validated ok
            //insert into db, get user loged in
            $datetime =  date("Y-m-d H:i:s", time());
            $data_row = array(
                'email' => $rdata['email'],
                'password' => md5($rdata['password']),
            );

            if (Configure::read('open_invite') > 0) {
                $md5_field = sprintf('%d,%s,%s',
                    rand(1000, 9999), $this->request->clientIp(), $rdata['email']);

                $data_row['uniq_md5'] = md5($md5_field);
                $data_row['reg_ip'] = $this->request->clientIp();
            }
            //save_res is the whole data_row
            $save_res = $this->User->save($data_row); 
            //var_dump($save_res);
            //var_dump($data_row);
            if ($save_res) {
                //after save, cake return the id of the recored
                //table 'uid' while cake uses 'id' for prod env
                $uid = $save_res['User']['id'];
                if (empty($uid)) {
                    //Mac dev enviroment use uid
                    CakeLog::write('warning', 'get uid from save_res empty');
                    $uid = $save_res['User']['uid'];
                }

                //var_dump($uid); //null
                //var_dump($save_res['User']['uid']); //userid
                $this->Session->write('uid', $uid);
                $this->Session->write('username', $rdata['email']);
                //unset vcode to avoid attack
                $this->Session->write('vcode', '');
               //var_dump($this->Session->read('uid'));
               //var_dump($save_res);
                $this->log('register success,email=' . $rdata['email'], 'info');       

                // register ok. process inviting related logic
                //      1. add a voucher to registered user
                //      2. add invite_num to inviting user in cake_users
                $invite_md5 = $this->Session->read('invite_md5');
                if (Configure::read('open_invite') > 0 && $invite_md5 != '') {
                    $this->loadModel('Voucher');

                    $conditions = array(
                        'uniq_md5' => $invite_md5,
                    );
                    $inviting_user = $this->User->find('first', 
                        array(
                            'conditions' => $conditions,
                        )
                    );

                    $inviting_uid = $inviting_user['User']['uid'];

                    $date_time_now = date('Y-m-d H:i:s', time());
                    $md5_source = sprintf('%d-%s-%s-%s', 
                        $uid, $rdata['email'], 
                        $date_time_now, $this->request->clientIp());

                    // for registering user
                    $expire_after_k_months = 3;
                    $expire_datetime = date('Y-m-d H:i:s', 
                        strtotime("+$expire_after_k_months month"));
                    $data_row = array(
                        'md5str' => md5($md5_source),
                        'uid' => $uid,
                        'from_uid' => $inviting_uid,
                        'get_from' => $this->VOUCHER_VIA_REGISTER,
                        'expire' => $expire_datetime,
                        'amount' => Configure::read('register_user_money'),
                        'is_valid' => $this->VOUCHER_VALID,
                    );

                    $save_res = $this->Voucher->save($data_row);
                    if (empty($save_res)) {
                        $log_str = sprintf('save voucher failed, user[%d]',
                            $uid);
                        CakeLog::write('warning', $log_str);
                    }

                    // increase invite_num field.
                    $this->User->id = $inviting_user['User']['uid'];
                    $invite_num = $inviting_user['User']['invite_num'] + 1;
                    $this->User->saveField('invite_num', $invite_num);

                    $log_str = sprintf('invite success, new user[%d]',
                        $uid);
                    CakeLog::write('debug', $log_str);

                }


                $this->assign_money2user();
                return $this->redirect(
                 array("controller" => "users", "action" => "ucenter")
                );
            } else {
                $err = 5;
                $msg = "系统忙，注册失败！";
            }
//            return $this->redirect(
//                array("controller" => "users", "action" => "ucenter")
//            );
        }
        if ($err > 0) {
          $this->set('isError', $err);
          $this->set('errMsg', $msg);
          $this->log('in register, err:' . $err . ', msg:' . $msg, 'warn');
        }
    }

    private function assign_money2user() {
        $this->layout = "message";
        $this->view = "empty";
        $uid = $this->Session->read('uid');
        $money_id = $this->Session->read('money_id');
        if (empty($this->Session->read('uid'))) {
            CakeLog::write('warning','empty uid in assing_money2user');
            return;
        }
        if (empty($money_id)) {
            CakeLog::write('warning','empty money_id in assing_money2user');
            return;
        }
        $this->loadModel('Coupon');
        $update_data = array(
            'uid' => $uid
            );
        $condition = array(
            'timeipmd5' => $money_id
            );
        $up_res = $this->Coupon->updateAll($update_data, $condition);
        $log4up = 'in assign_money2user uid:' . $uid . ' get money res:' . $up_res;
        CakeSession::delete('money');

        CakeLog::write('info', $log4up);
    }

    function logout() {
        $this->set('title_for_layout', "User::logout");
        CakeLog::write('info', 'cakelog write: logout, uid:' . CakeSession::read('uid'));
        $this->log('logout, uid=' . CakeSession::read('uid'), 'info');
        $this->Session->delete('uid');
        CakeSession::destroy();
        $this->redirect('/');
    }

    private function update_user_port($paid_order) {
        // paid_order is an array with fields like acctype/uid/is_paid/months

        $uid = $this->Session->read('uid');
        if (!$paid_order) {
            $log_str = sprintf('uid[%s] empty paid_order', $uid);
            return false;
        }

        $this->loadModel('Port');
        $is_err = 0;   // default no err
        if ($paid_order['acctype'] == $this->USER_BUY_NEW) {
            // user buy new account
            do {
              $dbo = $this->Port->getDataSource();
              $lock_query = sprintf('LOCK TABLES %s AS %s WRITE;', $this->Port->tablePrefix . $this->Port->table, $this->Port->alias);
              $unlock_query = "UNLOCK TABLES";
  
              if (!$dbo->execute($lock_query)) {
                  $unlock_res = $dbo->execute($unlock_query);
                  $log_str = sprintf('uid[%s], unlock_res[%s], order_id[%s] lock failed', 
                        $uid, $unlock_res, $paid_order['id']);
                  CakeLog::write('warning', $log_str);
                  $is_err = 1;
                  break;
              }
              //find first available port
              $avail_port = $this->Port->find('first',
                    array('conditions'=>array('status' => 0, 'uid' => 0, 'mtid' => 0),
                        'fields' => array('id', 'ssport')
                    )
                );

              if (!$avail_port) {
                  $unlock_res = $dbo->execute($unlock_query);
                  $log_str = sprintf('uid[%s], order_id[%s] unlock_res[%s] empty avail_port', 
                        $uid, $paid_order['id'], $unlock_res);
                  CakeLog::write('warning', $log_str);
                  $is_err = 2;
                  break;
              }

              $duration = $paid_order['months'];
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
              $log_str = sprintf('uid[%s] order_id[%s] unlock_res[%s]',
                    $uid, $paid_order['id'], $unlock_res);
              CakeLog::write('info', $log_str);
            } while (0);

            if ($is_err > 0) {
                $log_str = sprintf('uid[%s] order_id[%s] update port failed.', 
                    $uid, $paid_order['id']);
                CakeLog::write('warning', $log_str);
                return false;
            }

            // update port succ, begin update order[is_paid]
            $this->loadModel('Order');
            $up_data = array('is_paid' => $this->PAID_AND_UPDATED);
            $up_cond = array('id' => $paid_order['id']);
            $up_res = $this->Order->updateAll($up_data, $up_cond);
            $log_str = sprintf('uid[%s] order_id[%s] is_paid[%s] up_res[%s]', 
                    $uid, $paid_order['id'], $this->PAID_AND_UPDATED, $up_res);
            CakeLog::write('info', $log_str);

            // user buy new account end
        } else if ($paid_order['acctype'] == $this->OLD_CONTINUE) {
            // old account renew
            // 1. update cake_ports expire filed
            // 2. update cake_orders is_paid field
            $username = CakeSession::read('username');
            $port_res = $this->get_current_port($uid, $username);
            $old_expire = $port_res['Port']['expire'];
            $add_month = $paid_order['months'];
            $new_expire = date('Y-m-d H:i:s', 
                    strtotime("$old_expire + $add_month month"));
            $up_data = array(
                'expire' => "'" . $new_expire . "'",
            );
            $up_cond = array('id' => $port_res['Port']['id']);

            $up_res = $this->Port->updateAll($up_data, $up_cond);
            $log_info = sprintf('uid[%s] order_id[%s] update expire[%s] up_res[%s]',
                    $uid, $paid_order['id'], $new_expire, $up_res);
            CakeLog::write('info', $log_info);

            $this->loadModel('Order');
            $up_data = array(
                'is_paid' => $this->PAID_AND_UPDATED,
            );
            $up_cond = array(
                'id' => $paid_order['id'],
            );
            $up_res = $this->Order->updateAll($up_data, $up_cond);

            $log_str = sprintf('uid[%s] order_id[%s] is_paid[%s] up_res[%s]', 
                    $uid, $paid_order['id'], $this->PAID_AND_UPDATED, $up_res);
            CakeLog::write('info', $log_str);
        } else {
            // unrecognized type
            $log_str = sprintf('uid[%s] order_id[%s] unrecognized acctype[%s]', 
                    $uid, $paid_order['id'], $paid_order['acctype']);
            CakeLog::write('warning', $log_str);
        }
        return true;
    }

    function ucenter() {
        //check if user logged in
        //var_dump(CakeSession::read('vcode'));
        if (empty($this->Session->read('uid'))) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
        // user already logged in
        $uid = CakeSession::read('uid');

        if (Configure::read('new_user_center') == 0) {
        // user buys an account or renews an account
        // update port info
        $this->loadModel('Order');
        $order_rec = $this->Order->find('first',
            array(
                'conditions' => array('uid' => $uid, 
                        'is_paid' => $this->ALREADY_PAID),
                'order' => array('id' => 'DESC'),
            )
        );

        // order record exists, user has paid for new account or renew old
        if ($order_rec) {
            $log_str = sprintf("uid[%s] has paid [%s] account",
                    $uid, $order_rec['Order']['acctype']);
            CakeLog::write('debug', $log_str);

            $up_succ = $this->update_user_port($order_rec['Order']);
            $log_str = sprintf("uid[%s] update [%s] account res[%s]",
                    $uid, $order_rec['Order']['acctype'], $up_succ);
            CakeLog::write('info', $log_str);
        }

        // fetch port info
        $this->loadModel('Port');
        $port_res = $this->Port->find('first',
            array(
                'conditions'=>array('status' => $this->PORT_IN_USE, 'uid' => $uid),
                'order' => array('id' => 'DESC'),
            )
        );

        // not exists in port table, retrieve in mtorder table
        $username = CakeSession::read('username');
        do {
            if ($port_res || !$username) {
                // already have port_res, or session[username] empty, quit
                break;
            }
            $this->loadModel('Mtorder');
            $mtorder_res = $this->Mtorder->find('first',
                array(
                    'conditions' => array('telephone' => $username),
                    'fields' => array('port_id'),
                )
            );

            // not found in mtorder table, quit
            if (!$mtorder_res) {
                break;
            }

            // var_dump($mtorder_res);
            $port_res = $this->Port->find('first',
                array(
                    'conditions'=>array(
                        'id' => $mtorder_res['Mtorder']['port_id'],
                        'status' => $this->PORT_IN_USE,
                        ),
                    )
            );
        } while (0);

        $this->set('user_port', $port_res);

        if ($port_res) {
            $expire_second = strtotime($port_res['Port']['expire']);
            $now_second = time();
            $remain_second = $expire_second - $now_second;
            $remain_day = (int)($remain_second / (60 * 60 * 24));
            $this->set('remain_day', $remain_day);
            $this->set('remain_second', $remain_second);
        }

        //fetch balance info
        $this->loadModel('Coupon');
        $conditions = array('uid' => $uid);
        $coupon_res = $this->Coupon->find('first',
            array('conditions' => $conditions)
            );
        $this->set('coupon_info', $coupon_res);

        $this->set('title_for_layout', "User::ucenter");
        $this->layout = "ucenter";

        $log_str = sprintf('uid[%s] ip[%s] in ucenter page', 
                $uid, $this->request->clientIp());
        CakeLog::write('info', $log_str);

        } else 


/********************************************************************/
        /*****
         * the entry to new style usercenter
         * depending on the conf switch
         *******/
        if (Configure::read('new_user_center')) {
            // get total user ss count
            $this->loadModel('Port');
            $port_conditions = array(
                'uid' => $uid,
                'status' => $this->PORT_IN_USE,
            );

            $user_ports = $this->Port->find('all',
                array(
                    'conditions' => $port_conditions,
                    'limit' => $this->PORT_MAX_COUNT_PER_USER,
                )
            );
            $total_ports_num = count($user_ports);

            // calculate each port remaining days
            $seconds_per_day = 60 * 60 * 24;
            $expire_in_one_month = 0;
            $expire_in_one_week = 0;
            for ($idx = 0; $idx < $total_ports_num; $idx++) {
                $expire_second = strtotime($user_ports[$idx]['Port']['expire']);
                $now_second = time();
                $remain_second = $expire_second - $now_second;
                $remain_days = (int)($remain_second / $seconds_per_day);
                $user_ports[$idx]['Port']['remain_days'] = $remain_days;

                $one_week_later_second = strtotime('+1 week');
                $one_month_later_second = strtotime('+1 month');
                if ($one_week_later_second > $expire_second) {
                    $expire_in_one_week += 1;
                }
                if ($one_month_later_second > $expire_second) {
                    $expire_in_one_month += 1;
                }
            }

            $this->set('user_ports', $user_ports);
            $this->set('total_ports_num', $total_ports_num);
            $this->set('expire_in_one_week', $expire_in_one_week);
            $this->set('expire_in_one_month', $expire_in_one_month);

            $this->layout = 'ucenter_new';
            $this->view = 'ucenter_new';

            $log_str = sprintf('from ip[%s] uid[%d] in new ucenter', 
                $this->request->clientIp(), $uid);
            CakeLog::write('info', $log_str);
        }
    }

    function invite() {
        $this->layout = 'ucenter_new';
        // check if user logged in
        if (empty($this->Session->read('uid'))) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
        // user already logged in
        $uid = CakeSession::read('uid');

        // cake_users related db begin
        $this->loadModel('User');
        $conditions = array(
            'uid' => $uid,
        );
        $user_rec = $this->User->find('first',
            array(
                'conditions' => $conditions,
            )
        );
        if (empty($user_rec)) {
            $log_str = sprintf('ip[%s] uid[%d] in invite, get user rec empty', 
                $this->request->clientIp(), $uid);
            CakeLog::write('warning', $log_str);
            return;
        }

        $uniq_md5 = $user_rec['User']['uniq_md5'];
        $this->set('uniq_md5', $uniq_md5);

        $this->set('user_info', $user_rec['User']);

        // get voucher recs, cake_vouchers related begin
        $this->loadModel('Voucher');
        $time_now = date('Y-m-d H:i:s', time());
        $conditions = array(
            'uid' => $uid,
            'expire >=' => $time_now,
        );
        $voucher_recs = $this->Voucher->find('all',
            array(
                'conditions' => $conditions,
                'limit' => $this->USER_VOUCHER_SELECT_LIMIT,
            )
        );

        $total_voucher_count = count($voucher_recs);

        for ($idx = 0; $idx < $total_voucher_count; ++$idx) {
            $remaining_days = $this->get_remaining_days(
                $voucher_recs[$idx]['Voucher']['expire']);
            $voucher_recs[$idx]['Voucher']['remaining_days'] = $remaining_days;
        }

        $this->set('total_voucher_count', $total_voucher_count);
        $this->set('voucher_recs', $voucher_recs);

        // cake_ivisits related begin
        $this->loadModel('Ivisit');
        $conditions = array(
            'invite_md5' => $uniq_md5,
        );
        $uniq_visit_count = $this->Ivisit->find('count',
            array(
                'fields' => 'distinct req_ip',
                'conditions' => $conditions,
            )
        );
        $this->set('uniq_visit_count', $uniq_visit_count);

        $total_visit_count = $this->Ivisit->find('count',
            array(
                'conditions' => $conditions,
            )
        );
        $this->set('total_visit_count', $total_visit_count);

        // log for page action
        $log_str = sprintf('uid[%s] ip[%s] in invite page', 
                $uid, $this->request->clientIp());
        CakeLog::write('info', $log_str);

    }

    private function get_remaining_days($expire_datetime) {
        $expire_second = strtotime($expire_datetime);
        $now_second = time();
        $remain_second = $expire_second - $now_second;
        $remain_day = (int)($remain_second / (60 * 60 * 24));

        if ($remain_day < 0) {
            return 0;
        }

        return $remain_day;
    }

    function buy_ss() {
        $this->layout = 'ucenter_new';
        //check if user logged in
        if (empty($this->Session->read('uid'))) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
        // user already logged in
        $uid = CakeSession::read('uid');

        // select basic line info from db
        $this->loadModel('Line');
        $conditions = array(
            'acclevel' => 'basic',
            'status' => $this->LINE_AVAILABLE_STATUS,
        );

        $basic_lines = $this->Line->find('all',
            array(
            'conditions' => $conditions,
            )
        );

        $this->set('basic_single_lines_arr', $basic_lines);
        $lines_count = count($basic_lines);
        $this->set('lines_count', $lines_count);

        $log_str = sprintf('from ip[%s] uid[%d] in buy_ss', 
            $this->request->clientIp(), $uid);
        CakeLog::write('info', $log_str);

//       redirect to url with function params
//        $this->redirect(
//            array(
//                'controller' => 'users',
//                'action' => 'info',
//                'Congratulations!',   // header
//                'Your order is in process.',  // detail
//                'success',  // style
//            )
//        );
        
    }

    function make_order($lineid=0) {
        // check if user logged in
        if (empty($this->Session->read('uid'))) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }

        // user already logged in
        $uid = CakeSession::read('uid');
        $lineid = (int)$lineid;
        $this->layout = 'ucenter_new';

        $conditions = array(
            'id' => $lineid,
            'status' => $this->LINE_AVAILABLE_STATUS,
        );

        $this->loadModel('Line');
        $line_info = $this->Line->find('first',
            array(
                'conditions' => $conditions,
            )
        );

        if (empty($line_info)) {
            $htext = '参数有误！';
            $detail_info = '请确认您的操作流程无误！或联系客服解决！';
            $style = 'negative';
            $this->set_info($htext, $detail_info, $style);
            $this->view = 'info';

            $log_str = sprintf('from ip[%s] uid[%d] make order but lineinfo empty', 
                $this->request->clientIp(), $uid);
            CakeLog::write('warning', $log_str);
            return;
        }

        $line_area = sprintf('%s / %s , %s / %s',
            $line_info['Line']['country'],
            $line_info['Line']['city'],
            $line_info['Line']['country_cn'],
            $line_info['Line']['city_cn']);

        $this->set('line_area', $line_area);
        $this->set('line_id', $line_info['Line']['id']);

        $monthly_price = $line_info['Line']['monthly_price'] / 100;
        $this->set('monthly_price', $monthly_price);

        $this->set('acctype', $this->USER_BUY_NEW);

        // get voucher info
        $voucher_info = $this->get_uid_first_voucher($uid);
        $this->set('voucher_info', $voucher_info);

        $log_str = sprintf('from ip[%s] uid[%d] in make order', 
            $this->request->clientIp(), $uid);
        CakeLog::write('info', $log_str);
    }

    private function get_uid_first_voucher($uid) {
        $voucher_info = '';
        do {
            if (Configure::read('enable_voucher_use') == 0) {
                break;
            }
            $this->loadModel('Voucher');
    
            $time_now = date('Y-m-d H:i:s', time());
            $voucher_conditions = array(
                'uid' => $uid,
                'is_valid' => $this->VOUCHER_VALID,
                'expire >=' => $time_now,
            );
    
            $voucher_info = $this->Voucher->find('first',
                array(
                    'conditions' => $voucher_conditions,
                )
            );

            if (empty($voucher_info)) {
                break;
            }

        } while (0);

        return $voucher_info;
    }

    function advice() {
        // check if user logged in
        if (empty($this->Session->read('uid'))) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }

        // user already logged in
        $uid = CakeSession::read('uid');
        $this->layout = 'ucenter_new';

        $log_str = sprintf('uid[%s], ip[%s] in advice',
             CakeSession::read('uid'), $this->request->clientIp());
        CakeLog::write('info', $log_str);

        if ($this->request->is('post')) {
            $rdata = $this->request->data;

            // to show save advice result, change view to 'info'
            $this->view = 'info';
            if (empty($rdata['vcode']) || strcasecmp($rdata['vcode'], $this->Session->read('vcode')) != 0) {
                $htext = '失败！';
                $detail_info = '验证码错误！';
                $style = 'negative';
                $this->set_info($htext, $detail_info, $style);
                return ;
            }

            // vcode correct
            $this->loadModel('Advice');
            $data_row = array('content'=>$rdata['content'],
                'uid' => $this->Session->read('uid')
            );

            $save_res = $this->Advice->save($data_row);
            if (empty($save_res)) {
                $htext = '失败！';
                $detail_info = '系统正忙，请稍候再试！';
                $style = 'negative';
                $this->set_info($htext, $detail_info, $style);
                return ;
            }

            // clear vcode to avoid attack
            $this->Session->write('vcode', '');
            $success_detail_info = "恭喜您提交建议成功！";
            $success_detail_info .= "需要更快回复请加QQ " . $this->CONTACT_QQ_NUM;

            $log_str = sprintf('uid[%s], ip[%s] save advice success.',
                CakeSession::read('uid'), $this->request->clientIp());
            CakeLog::write('info', $log_str);

            $htext = '成功！';
            $detail_info = $success_detail_info;
            $style = 'success';
            $this->set_info($htext, $detail_info, $style);
            return;

        }

        // not post, show uid related advice records
        $this->loadModel('Advice');
        $conditions = array(
            'uid' => $uid,
        );

        $advice_limit = 30;
        $user_advices = $this->Advice->find('all',
            array(
                'conditions' => $conditions,
                'order' => ' id desc ',
                'limit' => $advice_limit,
            )
        );
        // var_dump($user_advices);
        $this->set('user_advices', $user_advices);

        // for statistics
        $total_num = count($user_advices);
        $this->set('total_advices', $total_num);

        $last_month_time = date('Y-m-d 00:00:00', strtotime('-1 month'));
        $last_half_year_time = date('Y-m-d 00:00:00', strtotime('-6 month'));

        // fetch last month count
        $last_month_conditions = array(
            'uid' => $uid,
            'created >= ' => $last_month_time,
        );
        $last_month_count = $this->Advice->find('count',
            array(
                'conditions' => $last_month_conditions,
            )
        );
        $this->set('last_month_count', $last_month_count);

        // fetch last half year count
        $last_half_year_conditions = array(
            'uid' => $uid,
            'created >= ' => $last_half_year_time,
        );
        $last_half_year_count = $this->Advice->find('count',
            array(
                'conditions' => $last_half_year_conditions,
            )
        );
        $this->set('last_half_year_count', $last_half_year_count);

    }

    function buy_acc() {
        $this->layout = 'user_new';
        $this->set('title_for_layout', 'User::buy_acc');
        $this->set('acctype', $this->USER_BUY_NEW);

        $uid = $this->Session->read('uid');
        $log_str = sprintf('uid[%s] ip[%s] in buy_acc page', 
                $uid, $this->request->clientIp());
        CakeLog::write('info', $log_str);
        // if not logged in
        if (empty($uid)) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
    }

    function renew_ss($id = 0) {
        // @in: id->port_id
        $uid = $this->Session->read('uid');
        // if not logged in
        if (empty($uid)) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }

        // port id
        $id = (int)$id;

        if (!is_int($id) || $id <= 0) {
            $log_str = sprintf('param[%s] [%d] [%d] err when renew_ss', 
                $id, is_int($id), $id < 0);
            CakeLog::write('warning', $log_str);
            $htext = '参数错误';
            $detail_info = sprintf('参数%s非法！', $id);
            $style = 'negative';
            $this->redirect(
                array("controller" => "users", "action" => "info",
                $htext,
                $detail_info,
                $style,
                )
            );
        }

        // get id related records
        $conditions = array(
            'id' => $id,
            'uid' => $uid,
        );
        $this->loadModel('Port');
        $renew_port = $this->Port->find('first',
            array(
                'conditions' => $conditions,
            )
        );

        // get empty port for $id
        if (empty($renew_port)) {
            $log_str = sprintf('portid[%d] uid[%d] get empty port record', 
                $id, $uid);
            CakeLog::write('warning', $log_str);
            $htext = '数据错误!';
            $detail_info = '未找到相关数据记录！';
            $style = 'negative';
            $this->redirect(
                array("controller" => "users", "action" => "info",
                $htext,
                $detail_info,
                $style,
                )
            );
        }
        $this->set('port', $renew_port['Port']);
        $this->set('acctype', $this->OLD_CONTINUE);

        // get renew monthly price
        $this->loadModel('Line');
        $line_conditions = array(
            'id' => $renew_port['Port']['line_id'],
            'status' => $this->LINE_AVAILABLE_STATUS,
        );
        $line_info = $this->Line->find('first',
            array(
                'conditions' => $line_conditions,
            )
        );

        if (empty($line_info)) {
            $log_str = sprintf('portid[%d] uid[%d] line_id[%d] get empty line record', 
                $id, $uid, $renew_port['Port']['line_id']);
            CakeLog::write('warning', $log_str);
            $htext = '数据错误!';
            $detail_info = '抱歉！未找到线路相关数据记录！请联系客服解决。';
            $style = 'negative';
            $this->redirect(
                array("controller" => "users", "action" => "info",
                $htext,
                $detail_info,
                $style,
                )
            );
        }

        $renew_monthly_price = $line_info['Line']['monthly_price'] / 100;

        $this->set('renew_monthly_price', $renew_monthly_price);

        // get voucher info
        $voucher_info = $this->get_uid_first_voucher($uid);
        $this->set('voucher_info', $voucher_info);

        $this->layout = 'ucenter_new';
    }

    function renew_acc() {
        $this->layout = 'user_new';
        $this->set('title_for_layout', 'User::renew_acc');
        $this->set('acctype', $this->OLD_CONTINUE);

        $uid = $this->Session->read('uid');
        $username = $this->Session->read('username');

        $log_str = sprintf('uid[%s] username[%s] ip[%s] in renew_acc page', 
                $uid, $username, $this->request->clientIp());
        CakeLog::write('info', $log_str);
        // if not logged in
        if (empty($uid)) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }

        $port_res = $this->get_current_port($uid, $username);
        $this->set('port', $port_res['Port']);
    }

    private function get_current_port($uid, $username) {
        if (!$uid || !$username) {
            $log_str = sprintf('uid[%s] username[%s]', $uid, $username);
            CakeLog::write('debug', $log_str);
            return;
        }
        $this->loadModel('Port');

        // find user self bought port
        $port_res = $this->Port->find('first',
            array(
                'conditions'=>array('status' => $this->PORT_IN_USE, 'uid' => $uid),
                'order' => array('id' => 'DESC'),
            )
        );

        // port_res empty, find merchant delegated port
        do {
            if ($port_res || !$username) {
                // already have port_res, or session[username] empty, quit
                break;
            }
            $this->loadModel('Mtorder');
            $mtorder_res = $this->Mtorder->find('first',
                array(
                    'conditions' => array('telephone' => $username),
                    'fields' => array('port_id'),
                )
            );

            // not found in mtorder table, quit
            if (!$mtorder_res) {
                break;
            }

            // var_dump($mtorder_res);
            $port_res = $this->Port->find('first',
                array(
                    'conditions'=>array(
                        'id' => $mtorder_res['Mtorder']['port_id'],
                        'status' => $this->PORT_IN_USE,
                        ),
                    )
            );
        } while (0);

        return $port_res;
    }

    function apply_acc() {
        $this->layout = "message";
        $this->view = "empty";
        $this->set('title_for_layout', 'User::apply_acc');
        $message_arr = array();
        $uid = $this->Session->read('uid');
        $pay_info = '';
        $apply_success = 0;
        // if not logged in
        if (empty($uid)) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
        $htext = "系统忙！";
        $detail_info = "系统忙，请稍后再试！";

        $is_allow = Configure::read('user.allow_apply_account');
        if ($is_allow < 1) {
            $htext = '申请失败！';
            $detail_info = '对不起，系统暂不对外开放申请！';
            $this->set_message($htext, $detail_info);
            return;
        }
        // already logged in
        // 1. check if this uid already has an shadowsocks account, 
        //  if true return
        //  if false  assign one
        //

        $ports = $this->loadModel('Port');
        $port_res = $this->Port->find('first',
            array('conditions'=>array('status' => $this->PORT_IN_USE, 'uid' => $uid),
                'fields' => array('id', 'ssport', 'uid')
            )
        );
        if (!empty($port_res)) {
            $htext = "出错啦！";
            $detail_info = "您已经有了账户，不能重复申请！";
        } else {
            do {
              $dbo = $this->Port->getDataSource();
              //lock tables like a booking system
              //$this->Port->alias ==>>  Port
              $lock_query = sprintf('LOCK TABLES %s AS %s WRITE;', $this->Port->tablePrefix . $this->Port->table, $this->Port->alias);
              $unlock_query = "UNLOCK TABLES";
              //var_dump($lock_query); // LOCK TABLES cake_ports AS Port WRITE;
              
              //$this->Port->query($lock_query);
              $dbo = $this->Port->getDataSource();  // dbo is an object
              //var_dump($dbo);return;
              if (!$dbo->execute($lock_query)) { // if success returns true
                  $htext = "系统忙！";
                  $detail_info = "系统忙，请稍后再试！";
                  $dbo->execute($unlock_query); // if success returns true
                  break;
              }

              //find first available port
              $avail_port = $this->Port->find('first',
                    array('conditions'=>array('status' => 0, 'uid' => 0, 'mtid' => 0),
                        'fields' => array('id', 'ssport')
                    )
                );
              //var_dump($avail_port);
              // no available port
              if (empty($avail_port)) {
                  $htext = '失败！';
                  $detail_info = '可用的账号已经被抢光了，欢迎下次申请！';
                  CakeLog::write('critical', "user apply_acc, no port available!");
                  $dbo->execute($unlock_query); // if success returns true
                  break;
              }
              // get an available port
              // do the booking logic
              $up_res = $this->Port->updateAll(array('status' => $this->PORT_IN_USE, 
                  'uid' => $uid, 'modified' => 'now()'), 
                            array('id' => $avail_port['Port']['id']));
              $log_str = 'uid:'. $uid . ' apply port success. '  . 'update port:' 
                      . $avail_port['Port']['ssport'] . ', up_res:' . $up_res;
              CakeLog::write('info', $log_str);
              $htext = '恭喜您！';
              $detail_info = '申请账号成功！请至“我的主页”查看账号信息。';
              //
              //var_dump($port_res);
              //
              // unlock tables
              $apply_success = $dbo->execute($unlock_query); // if success returns true
            } while (0); //end do
            //apply port success, then update consume and balance table
            if ($apply_success) {
                //get balance and minus the cost to consume table
                $this->loadModel('Coupon');
                $ucoupon = $this->Coupon->find('first',
                        array('conditions' => array('uid' => $uid),
                        'fields' => array('id', 'timeipmd5', 'balance')
                    )
                );
                // if user get a coupon
                if (!empty($ucoupon)) {
                  do {
                    $this->loadModel('Consume');
                    $money_per_month = Configure::read('coupon.money_per_month');
                    $coupon_md5 = $ucoupon['Coupon']['timeipmd5'];
                    $balance = $ucoupon['Coupon']['balance'];
                    $new_balance = $balance - $money_per_month;

                    if ($new_balance < 0) {
                        $bwarning_log = 'uid:' . $uid . ', new_balance:' . $new_balance;
                        CakeLog::write('warning', $bwarning_log);
                        break;
                    }
                    $consume_data = array('timeipmd5' => $coupon_md5,
                        'consume' => $money_per_month,
                        'pinfo' => 'pay from coupon', 
                        'uid' => $uid
                          );
                    $save_consume_res = $this->Consume->save($consume_data);
                    $cpon_up_condition = array('timeipmd5' => $coupon_md5);
                    $cpon_up_fields = array('balance' => $new_balance);
                    $update_coupon_res = $this->Coupon->updateAll(
                          $cpon_up_fields, $cpon_up_condition);
  
                    //#TODO  judge the database operation result 
                    //
                    $coupon_log = 'uid:' . $uid 
                            . ',save consume res:' . $save_consume_res['Consume']['id']  
                            . ', update balance res:' . $update_coupon_res;
                    CakeLog::write('debug', $coupon_log);
                    $pay_info = '已从您账户扣款￥' . $money_per_month;
                  } while(0);
                }
            }
        } //end else
        $this->set_message($htext, $detail_info);
        $this->set('pay_info', $pay_info);
    }

    function save_advice() {
        $this->layout = "message";

//        var_dump($records);
        $log_str = sprintf('uid[%s], ip[%s] in save advice',
             CakeSession::read('uid'), $this->request->clientIp());
        CakeLog::write('info', $log_str);

        if ($this->request->is('post')) {
            $rdata = $this->request->data;
            if (empty($rdata['vcode']) || strcasecmp($rdata['vcode'], $this->Session->read('vcode')) != 0) {
                $this->set("htext", "失败！");
                $this->set("detail_info", "验证码错误！");
                return ;
            }
            //vcode correct
            $this->loadModel('Advice');
            $data_row = array('content'=>$rdata['content'],
                'uid' => $this->Session->read('uid')
            );
//            var_dump($data_row);
//            return ;
            $save_res = $this->Advice->save($data_row);
            if (empty($save_res)) {
                $this->set("htext", "失败！");
                $this->set("detail_info", "系统正忙，请稍候再试！");
                return ;
            }
            $this->Session->write('vcode', '');
            $this->set("htext", "成功！");
            $success_detail_info = "恭喜您提交建议成功！";
            $success_detail_info .= "需要更快回复请加QQ " . $this->CONTACT_QQ_NUM;
            $this->set("detail_info", $success_detail_info);
            return;

            //var_dump($rdata);
            //var_dump($this->Session->read('vcode'));
        }
        $this->set("htext", "乱入啦！");
        $this->set("detail_info","这个页面啥也没有耶！");

//        $this->redirect('/');
    }

    protected function set_message($htext, $detail_info) {
        $this->set('htext', $htext);
        $this->set('detail_info', $detail_info);
    }

    private function set_info($htext, $detail_info, $style) {
        $this->set_message($htext, $detail_info);
        $this->set('ui_style', $style);
    }

    function info($htext, $detail_info, $style, $type=1) {
        $this->layout = 'ucenter_new';
        //check if user logged in
        if (empty($this->Session->read('uid'))) {
            $this->redirect(
                array("controller" => "users", "action" => "login")
            );
        }
        // user already logged in
        $uid = CakeSession::read('uid');

//        $htext = '页面成功';
//        $detail_info = '恭喜你完成啦！';
//        $style = 'success';
        $this->set_info($htext, $detail_info, $style);

        if ($type != $this->NORMAL_INFO_TYPE) {
            // user like page, type=2
            $log_str = sprintf('get user support,' 
                . ' from ip[%s] uid[%d] like YTJ. type[%d]', 
                $this->request->clientIp(), $uid, $type);
            CakeLog::write('info', $log_str);
        }
    }

    function login() {
        CakeLog::write('info', 'in user login, client ip:' . $this->request->clientIp());
        $this->set('title_for_layout', "User::login|倚天剑shadow - 提供shadowsocks科学上（翻）网（墙）账号！倚天剑shadow|shadowsocks账号|免费shadowsocks账号");
        $err = 0;
        $msg = "";
        $uid = CakeSession::read('uid');
        // already logged in
        if (!empty($uid)) {
            return $this->redirect(
                array("controller" => "users", "action" => "ucenter")
                );
        }
        //perform user login action 
        //var_dump($this->request->data);
        if ($this->request->is('post')) {
            $rdata = $this->request->data;
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,7}(\\.[a-z]{2})?)$/i";
            $tel_pattern = '#1[\d]{10}#';
            if (!preg_match($pattern, $rdata['email']) && !preg_match($tel_pattern, $rdata['email'])) {
                $err = 1;
                $msg = "账户邮箱或电话格式错误！";
            }
            $log_user = $this->User->find('first',
                array(
                    'conditions' => array('email' => $rdata['email']),
                    //'fields' => array('uid', 'password', 'login_count')
                    'fields' => array('uid', 'password', 'login_count')
                ));
            if (!$log_user) {
                $err = 2;
                $msg = "用户不存在！";
            } else {
                //verify password
                if (md5($rdata['password']) != $log_user['User']['password']) {
                    $err = 3;
                    $msg = "用户名或密码错误！";
                } else {
                    //user exists, password correct
                    //1.write user session, 2.redirect
                    //3.update last_login
                    $uid = $log_user['User']['uid'];
                    $this->Session->write('uid', $uid);
                    $this->Session->write('username', $rdata['email']); // here email maybe a telephone
                    $login_count = $log_user['User']['login_count'] + 1;
                    $update_field = array('login_count' => $login_count, 'modified' => 'now()');
                    $conditions = array('uid' => $uid);
                    //$this->User->id = $uid;
                    //$this->User->saveField('last_login', $datetime);
                    $this->User->updateAll($update_field, $conditions);
                    CakeLog::write('info', 'user login success, uid='. CakeSession::read('uid'));
                    //update last_log
                    //var_dump($uid);
                    //var_dump($log_user);
                    // $this->redirect('/');
                    return $this->redirect(
                        array("controller" => "users", "action" => "ucenter")
                        );
                }

            }
        }
        //var_dump($this->view);   // output login
        $this->set('isError', $err);
        $this->set('errMsg', $msg);
        CakeLog::write('info', 'user login err:' . $err . ', msg:' . $msg);
    }

    function vcode() {
        $this->view = 'empty';
        $this->Vcode->render();
    }
}
?>
