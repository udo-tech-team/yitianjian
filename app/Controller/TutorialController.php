<?php
class TutorialController extends AppController {
    var $layout = 'tutorial';
    var $view = 'intro'; // this is an empty view file
    var $name = 'Tutorial';
    var $TRIAL_PORT_STATUS = 3;
    var $INVALID_PORT_STATUS = 2;
    var $MAX_TRIAL_PORTS_SELECT_NUM = 3;

    function index() {
        $this->view = 'intro';
        $this->set('share_url', Router::url('/', true));
        CakeLog::write('info', 'in tutorial index, ip:' 
            . $this->request->clientIp()); 
    }

    function trial_port() {
        $this->view = 'intro';
        $this->layout = 'trialport';
        $this->loadModel('Port');
        // get ports status in (2, 3);
        $port_res = $this->Port->find('all',
            array(
                'conditions' => array('status' => array(
                    $this->TRIAL_PORT_STATUS,
                    $this->INVALID_PORT_STATUS)),
                'limit' => $this->MAX_TRIAL_PORTS_SELECT_NUM,
                'order' => array('id' => 'DESC'),
            )
        );

        // CakeLog::write('debug', " trial ports num:" . count($port_res));
        $this->set('all_trial_ports', $port_res);

        // var_dump($port_res);
        // $port = $port_res[0]['Port'];
        // $this->set('port', $port);

        CakeLog::write('info', 'in tutorial trial_port, ip:' 
            . $this->request->clientIp()); 
    }
}
?>
