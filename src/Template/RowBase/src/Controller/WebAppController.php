<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Statics\User\UserInfo;
use Cake\Event\Event;

/**
 * WebAppController
 *
 * @author hagiwara
 */
abstract class WebAppController extends AppController
{
    /**
     * initialize
     *
     * @author hagiwara
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('WebCommon');
    }

    /**
     * beforeRender
     *
     * @author hagiwara
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }
}
