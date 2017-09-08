<?php
namespace App\Controller;

use App\Consts\CommonConst;
use App\Consts\EconomistConst;
use App\Controller\WebAppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * TopsController
 *
 * @author hagiwara
 */
class TopsController extends WebAppController
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
     * index
     *
     * @author hagiwara
     * @return void
     */
    public function index()
    {
    }
}
