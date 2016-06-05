<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array();
        public $layout = 'home';

    public $show_goods_list = 0;

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *    or MissingViewException in debug mode.
 */
    public function display_ori() {
        $path = func_get_args();

        var_dump($path);
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        var_dump($page);
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        var_dump($subpage);
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        var_dump(compact('page', 'subpage', 'title_for_layout'));

        var_dump(implode('/', $path));
        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
    public function display_new() {
        //return $this->redirect('/users/register');
        $this->set('page', 'homme');
        $this->set('title_for_layout', 'titlexxxxx');
        $this->render('home');
//var_dump(CakeSession::read('uid'));
    $this->log(sprintf('request for homepage, %s,uid=%s', 'webroot/', CakeSession::read('uid')), 'debug');
        //return $this->redirect('/orders');
    }

    public function display() {
        $this->view = 'empty';
        $this->layout = 'home';
        $this->set('title', '倚天剑shadow|shadowsocks账号|免费shadowsocks账号');
        $this->set("show_goods_list", $this->show_goods_list);
        $log_str = sprintf('[%s/%s:%s]in homepage, client ip:%s', 
                __CLASS__, __FUNCTION__, __LINE__,
                $this->request->clientIp());
        $refer = 'not set';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $refer = $_SERVER['HTTP_REFERER'];
        }
        $log_str = sprintf('%s, refer:%s', $log_str, $refer);
        CakeLog::write('debug', $log_str);
        //$this->log(sprintf('request for homepage, %s,uid=%s', 'webroot/', CakeSession::read('uid')), 'debug');

    }
}
