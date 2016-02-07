<?php
class TutorialController extends AppController {
    var $layout = 'tutorial';
    var $view = 'intro'; // this is an empty view file
    var $name = 'Tutorial';
    function index() {
        $this->view = 'intro';
        $this->set('share_url', Router::url('/', true));
        CakeLog::write('info', 'in tutorial index, ip:' 
            . $this->request->clientIp()); 
    }

    function trial_port() {
        $this->view = 'intro';
        $this->layout = 'trialport';
        CakeLog::write('info', 'in tutorial trial_port, ip:' 
            . $this->request->clientIp()); 
    }
}
?>
