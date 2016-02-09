<?php
class ShangjiaController extends AppController
{
    var $layout = 'shangjia';
    var $components = array(
        'Vcode',
        'Session'
    );
    var $CENTS_PER_YUAN = 100;
    var $PORT_UID_PREFIX = 10000;

    public function index() {
        $this->layout = 'shangjia';
        $this->view = 'empty';
    }

    public function login() {
        $this->view = 'login';
        $suid = CakeSession::read('suid');
        $errNo = 0;
        $errMsg = 'non';

        // already logged in
        if (!empty($suid)) {
            return $this->redirect(
                array("controller" => "shangjia", "action" => "scenter")
                );
        }

        // process user login action
        if ($this->request->is('post')) {
            $rdata = $this->request->data;
            // var_dump($rdata);
            $this->loadModel('Merchant');

            $user_condition = array(
                'name' => $rdata['username'],
                'password' => md5($rdata['password']),
                );
            $log_user = $this->Merchant->find('first',
                array(
                    'conditions' => $user_condition,
                    'fields' => array('id'),
                )
                );

            if ($log_user) {
                    // var_dump($log_user);
                    $suid = $log_user['Merchant']['id'];
                    CakeSession::write('suid', $suid);
                    CakeLog::write('info', "merchant log in, id[". $suid . "]");

                    // update merchant record
                    $this->Merchant->id = $suid;
                    $this->Merchant->updateAll(
                        array('login_score' => 'login_score + 1'),
                        array('id' => $suid)
                        );

                    // update login record
                    $this->loadModel('Mtlogin');
                    $login_rec = array('login_ip' => $this->request->clientIp(),
                        // merchant id
                        'mt_id' => $suid,
                        );
                    $save_res = $this->Mtlogin->save($login_rec);
                    $log_str = "";
                    if ($save_res) {
                        $log_str = sprintf("save merchant login succ, mt_id[%s]", $suid);
                    } else {
                        $log_str = sprintf("save merchant login fail, mt_id[%s]", $suid);
                    }
                    CakeLog::write('debug', $log_str);

                    // redirect to scenter
                    $this->redirect(
                        array("controller" => "shangjia", "action" => "scenter")
                        );
                } else {
                    // #TODO username password not match process
                    $errNo = 1;
                    $errMsg = '用户名或密码错误！';
                    $wflog = sprintf("merchant log err,name[%s] ip[%s]", 
                        $rdata['username'], $this->request->clientIp());
                    CakeLog::write('warning', $wflog);
                }
        }
        $this->setErrMsg($errNo, $errMsg);
    }

    private function setErrMsg($eno, $emsg) {
        $this->set('errNo', $eno);
        $this->set('errMsg', $emsg);
    }

    function logout() {
        $log_str = sprintf("merchant logout, id[%s]", 
            CakeSession::read('suid'));
        CakeLog::write($log_str);
        CakeSession::destroy();
        return $this->redirect(
                array("controller" => "shangjia", "action" => "login")
                );
    }

    function scenter() {
        $this->view = 'scenter';
        $suid = CakeSession::read('suid');
        $this->set("scenter_active", 1);
        $this->set('CENTS_PER_YUAN', $this->CENTS_PER_YUAN);
        if (empty($suid)) {
            return $this->redirect(
                array("controller" => "shangjia", "action" => "login")
            );
        }

        $this->loadModel('Mtorder');

        // to get sum(field), the following way also works
        // $this->Mtorder->virtualFields['total'] = 'sum(Mtorder.charge_price)';
        // var_dump($this->Mtorder->find('all', array('fields' => array('total'))));

        // history total
        $history_total = $this->Mtorder->find('first', array(
            'fields' => array('sum(Mtorder.charge_price) as history_total'),
            'conditions' => array('mt_id' => $suid),
        ));
        // var_dump($history_total);
        $this->set('history_total', $history_total[0]['history_total']);

        // last month total
        $last_month_now = date('Y-m-d H:i:s', strtotime('last month'));
        // var_dump($last_month_now);
        $last_month_start = $this->get_month_first_day($last_month_now);
        $last_month_end = $this->get_month_last_day($last_month_now);
        // var_dump($last_month_start);
        // var_dump($last_month_end);
        $last_month_total = $this->Mtorder->find('first',
            array(
                'fields' => array('sum(Mtorder.charge_price) as last_month_total'),
                'conditions' => array(
                    'mt_id' => $suid,
                    'created between ? and ?' => array($last_month_start, $last_month_end),
                )
            )
            );
        $this->set('last_month_total', $last_month_total[0]['last_month_total']);

        // current month total
        $cur_month_now = date('Y-m-d H:i:s', time());
        // var_dump($cur_month_now);
        $cur_month_start = $this->get_month_first_day($cur_month_now);
        $cur_month_end = $this->get_month_last_day($cur_month_now);
        // var_dump($cur_month_start);
        // var_dump($cur_month_end);
        $cur_month_total = $this->Mtorder->find('first',
            array(
                'fields' => array('sum(Mtorder.charge_price) as cur_month_total'),
                'conditions' => array(
                    'mt_id' => $suid,
                    'created between ? and ?' => array($cur_month_start, $cur_month_end),
                )
            )
        );
        $this->set('cur_month_total', $cur_month_total[0]['cur_month_total']);

        // today total
        $today_now = date('Y-m-d H:i:s', time());
        // var_dump($today_now);
        $today_start = date('Y-m-d 00:00:00', time());
        $today_end = date('Y-m-d 23:59:59', time());
        // var_dump($today_start);
        // var_dump($today_end);
        $today_total = $this->Mtorder->find('first',
            array(
                'fields' => array('sum(Mtorder.charge_price) as today_total'),
                'conditions' => array(
                    'mt_id' => $suid,
                    'created between ? and ?' => array($today_start, $today_end),
                )
            )
        );
        $this->set('today_total', $today_total[0]['today_total']);

    }

    // delegate apply ip/port/pass for a user
    function release_account() {
        $this->view = 'release';
        $suid = CakeSession::read('suid');
        $this->set("release_active", 1);

        if (empty($suid)) {
            return $this->redirect(
                array("controller" => "shangjia", "action" => "login")
            );
        }

        if ($this->request->is('post')) {
            $rdata = $this->request->data;
            // var_dump($rdata);
            $this->view = 'account_info';

            // generate a record in mtorder table
            $monthly_price = Configure::read('merchant_delegate.monthly_price');
            $charge_price = $monthly_price * $rdata['ss_month'];
            $data_row = array(
                'mt_id' => $suid,
                'telephone' => $rdata['telephone'],
                'months' => $rdata['ss_month'],
                'charge_price' => $charge_price,
            );
            // var_dump($data_row);

            $this->loadModel('Mtorder');
            $save_res = $this->Mtorder->save($data_row);
            // var_dump($save_res);
            if ($save_res) {
                // apply ip/port/password/encrypt
                $this->loadModel('Port');
                $dbo = $this->Port->getDataSource();
                
                $lock_query = sprintf('LOCK TABLES %s AS %s WRITE;', $this->Port->tablePrefix . $this->Port->table, $this->Port->alias);
                $unlock_query = "UNLOCK TABLES";

                /****************** booking begin *******************/
                $dbo = $this->Port->getDataSource();  // dbo is an object
                if (!$dbo->execute($lock_query)) {
                    $unlock_res = $dbo->execute($unlock_query);
                    $wn_log = sprintf("execute lock_query[%s] failed. unlock_query[%s] unlock_result[%s]",
                        $lock_query, $unlock_query, $unlock_res);
                    CakeLog::write('warning', $wn_log);
                    return;
                }

                // get an available port
                $avail_port = $this->Port->find('first',
                    array(
                        'conditions' => array('status' => 0, 'uid' => 0),
                        'order' => array('id' => 'DESC'),
                    )
                );
                // var_dump($avail_port);
                if (!$avail_port) {
                    CakeLog::write('warning', "no available port!");
                    return;
                }

                // update port info
                $ss_month = $rdata['ss_month'];
                $expire_time = date('Y-m-d H:i:s', strtotime("+$ss_month month"));
                $update_fields = array(
                    'status' => 1,
                    'uid' => $this->PORT_UID_PREFIX + $suid,
                    'modified' => 'now()',
                    'expire' => "'" . $expire_time . "'",
                );
                $port_id = $avail_port['Port']['id'];
                $update_cond = array(
                    'id' => $port_id,
                );
                $up_res = $this->Port->updateAll(
                    $update_fields, $update_cond
                );

                $info_log = sprintf("mt_id[%s] update port id[%s] res[%s]",
                        $suid, $port_id, $up_res);
                CakeLog::write('info', $info_log);

                // finally unlock
                $apply_success = $dbo->execute($unlock_query);
                /****************** booking end *******************/

                // update mtorder info
                $order_id = $save_res['Mtorder']['id'];
                $up_fields = array(
                    'port_id' => $port_id,
                );
                $up_cond = array(
                    'id' => $order_id,
                );
                $up_res = $this->Mtorder->updateAll(
                    $up_fields, $up_cond
                );
                $info_log = sprintf("mt_id[%s] update order id[%s] res[%s]",
                        $suid, $order_id, $up_res);
                CakeLog::write('info', $info_log);

                $this->set('ssport', $avail_port['Port']['ssport']);
                $this->set('ssencrypt', $avail_port['Port']['ssencrypt']);
                $this->set('sspass', $avail_port['Port']['sspass']);
                $this->set('ssip', $avail_port['Port']['ssip']);

            } else {
                $wn_str = sprintf("save order failed, mt_id[%s] charge_price[%s]",
                        $suid, $charge_price);
                CakeLog::write('warning', $wn_str);
            }

            $this->set("charge_price", $charge_price / $this->CENTS_PER_YUAN);
            $this->set("ss_month", $rdata['ss_month']);
        }

    }

    // business orders statistics
    function borders_stat() {
        $this->view = 'borders_stat';

        $suid = CakeSession::read('suid');
        $this->set("order_stat_active", 1);

        if (empty($suid)) {
            return $this->redirect(
                array("controller" => "shangjia", "action" => "login")
            );
        }

        $this->loadModel('Mtorder');
        $today_start = date('Y-m-d 00:00:00', time());
        $today_end = date('Y-m-d 23:59:59', time());

        $today_conditions = array(
            'mt_id' => $suid,
            'created between ? and ?' => array($today_start, $today_end),
        );
        // var_dump($today_conditions);
        $today_orders = $this->Mtorder->find('all',
            array(
                'conditions' => $today_conditions,
            )
        );
        // var_dump($today_orders);

        $month_start = $this->get_month_first_day($today_start);
        $month_end = $this->get_month_last_day($today_start);
        $month_conditions = array(
            'mt_id' => $suid,
            'created between ? and ?' => array($month_start, $month_end),
        );
        $month_orders = $this->Mtorder->find('all',
            array(
                'conditions' => $month_conditions,
            )
        );

        $history_conditions = array(
            'mt_id' => $suid,
        );
        $history_orders = $this->Mtorder->find('all',
            array(
                'conditions' => $history_conditions,
            )
        );

        // var_dump($history_orders);
        $this->set("today_orders", $today_orders);
        $this->set("month_orders", $month_orders);
        $this->set('history_orders', $history_orders);
        $this->set("CENTS_PER_YUAN", $this->CENTS_PER_YUAN);
    }

    function merchant_info() {
        $this->view = 'merchant_info';

        $suid = CakeSession::read('suid');
        $this->set("merchant_info_active", 1);

        if (empty($suid)) {
            return $this->redirect(
                array("controller" => "shangjia", "action" => "login")
            );
        }

        // logged in, get merchant info
        $this->loadModel('Merchant');
        $user_condition = array(
            'id' => $suid,
            );

        $log_user = $this->Merchant->find('first',
            array(
                'conditions' => $user_condition,
            )
            );
        $this->set('merchant', $log_user['Merchant']);
        // var_dump($log_user['Merchant']);

        // get login history records from merchant login table
        $this->loadModel('Mtlogin');
        $mt_condition = array('mt_id' => $suid);
        $mt_logins = $this->Mtlogin->find('all',
            array('conditions' => $mt_condition)
            );

        $this->set('login_records', $mt_logins);
    }

    function change_pass() {
        $this->view = 'process_result';

        $suid = CakeSession::read('suid');
        $this->set("merchant_info_active", 1);

        if (empty($suid)) {
            return $this->redirect(
                array("controller" => "shangjia", "action" => "login")
            );
        }

        // already login
        if ($this->request->is('post')) {
            $rdata = $this->request->data;
            // var_dump($rdata);

            // default failure message
            $header = "失败";
            $content = "对不起，修改失败";
            $info_kind = "negative";

            $mt_condition = array(
                'id' => $suid,
            );
            $this->loadModel('Merchant');
            $log_user = $this->Merchant->find('first',
                array(
                    'condition' => $mt_condition,
                )
            );
            // var_dump($log_user);
            do {
                if (!$log_user) {
                    $content = "对不起，用户不存在！";
                    break;
                }
                if ($log_user['Merchant']['password'] != md5($rdata['ori_password'])) {
                    $content = "对不起，原密码输入错误！";
                    break;
                }
                if ($rdata['new_password'] != $rdata['repeat_password']) {
                    $content = "对不起，新密码两次输入不一致！";
                    break;
                }

                // update db record
                $this->Merchant->id = $suid;
                $new_password = md5($rdata['new_password']);
                $this->Merchant->updateAll(
                    array('password' => "'" . $new_password . "'"),
                    array('id' => $suid)
                    );

                $header = "成功";
                $content = "恭喜！修改成功！";
                $info_kind = "positive";
            } while (0);

            $this->set_message($header, $content, $info_kind);
        }
    }

    private function set_message($header, $content, $info_kind) {
        $this->set("header", $header);
        $this->set("content", $content);
        $this->set("info_kind", $info_kind);
    }

    private function get_month_first_day($date_time) {
        return date('Y-m-01 00:00:00', strtotime($date_time));
    }

    private function get_month_last_day($date_time) {
        $begin_date = $this->get_month_first_day($date_time);
        return date('Y-m-d 23:59:59', strtotime("$begin_date + 1 month - 1 day"));
    }
}
