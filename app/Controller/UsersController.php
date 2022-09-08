<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function login() {
        if ($this->request->is('post')) {

            // $user = $this->Auth->identify();

            // var_dump($user);
            // echo 'true';

            // $this->request->data['created_ip'] = $this->request->ClientIp();

            // $this->User->create();
            // if ($this->User->save($this->request->data)) {

            //     return $this->Auth->login();
            //     // return true;
            // }   

            // $this->Flash->error(
            //     __('The user could not be saved. Please, try again.')
            // );
        }
	}

	public function register() {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            // echo 'true';

            $this->request->data['created_ip'] = $this->request->ClientIp();

            $this->User->create();
            if ($this->User->save($this->request->data)) {

                return $this->Auth->login();
                // return true;
            }   

            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }
	}

    public function success()
    {
        
    }
	// public function post() {

	// 	if ($this->request->is('post')) {
 //            $this->request->data['created_ip'] = $this->request->ClientIp();
 //            $this->User->create();
 //            if ($this->User->save($this->request->data)) {
 //                // $this->Flash->success(__('The user has been saved'));
 //                return true;
 //                // return $this->redirect(array('action' => 'index'));
 //            }
 //            $this->Flash->error(
 //                __('The user could not be saved. Please, try again.')
 //            );
 //        }
		
	// }
}
