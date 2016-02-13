<?php
class TutorialController extends AppController {
    var $layout = 'tutorial';
    var $view = 'intro'; // this is an empty view file
    var $name = 'Tutorial';
    var $TRIAL_PORT_STATUS = 3;
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
        $port_res = $this->Port->find('first',
            array(
                'conditions' => array('status' => $this->TRIAL_PORT_STATUS),
                'order' => array('id' => 'DESC'),
            )
        );

        $port = $port_res['Port'];
        $this->set('port', $port);

        CakeLog::write('info', 'in tutorial trial_port, ip:' 
            . $this->request->clientIp()); 
    }
}
?>
