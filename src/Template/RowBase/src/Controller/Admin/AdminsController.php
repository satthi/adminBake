<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AdminAppController;
use Cake\Event\Event;

/**
 * Admins Controller
 *
 * @author hagiwara
 */
class AdminsController extends AdminAppController
{

    /**
     * beforeFilter
     *
     * @author hagiwara
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * login
     *
     * @author hagiwara
     * @return void|\Cake\Network\Response
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect(['controller' => 'Tops', 'action' => 'index']);
            }

            $this->Flash->error(__('Invalid credentials, try again'));
        }
    }


    /**
     * logout
     *
     * @author hagiwara
     * @return null|\Cake\Network\Response
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
