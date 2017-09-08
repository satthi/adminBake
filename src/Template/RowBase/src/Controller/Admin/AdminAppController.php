<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Statics\Admin\AdminInfo;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * AdminAppController
 *
 * @author hagiwara
 */
abstract class AdminAppController extends AppController
{
    public $helpers = [
        'Html' => [
            // BootstrapUI.Htmlに追加で共通設定を追加したもの
            'className' => 'BootstrapUI.Html'
        ],
        'Form' => [
            // BootstrapUI.Formに追加で共通設定を追加したもの
            'className' => 'AdminForm',
            //'templates' => 'form-templates'
        ],
        'Flash' => [
            'className' => 'BootstrapUI.Flash'
        ],
        'Paginator' => [
            'className' => 'BootstrapUI.Paginator'
        ],
        'Pack.Pack',
        'AdminCustom',
    ];

    /**
     * initialize
     *
     * @author hagiwara
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Admins',
                    'fields' => [
                        'username' => 'loginid',
                        'password' => 'password'
                    ],
                ]
            ],
            'flash' => [
                'key' => 'flash',
                'params' => [
                    'class' => 'alert alert-dismissible fade in alert-danger',
                ]
            ],
            'loginAction' => [
                'controller' => 'admins',
                'action'     => 'login',
                'prefix'     => 'admin',
            ],
            'loginRedirect' => [
                'controller' => 'tops',
                'action'     => 'index',
                'prefix'     => 'admin',
            ],
            'storage' => [
                'className' => 'Session',
                'key' => 'Auth.Admin'
            ],
            'checkAuthIn' => 'Controller.startup'
        ]);
        $this->loadComponent('Pack.Pack');
    }

    /**
     * beforeFilter
     * @author hagiwara
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // ログイン情報をStaticなクラスに挿入
        $loginUser = $this->Auth->user();
        AdminInfo::$id = $loginUser['id'];
        // 後で上書きしたい場合があるのでbeforeFilterでセット
        $this->viewBuilder()->layout('Admin/default');
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
        $this->set('projectName', __('Project Name'));
    }

    /**
     * contentsFileConfirmData
     * 確認画面でのContentsFileのフィールド整理
     * @author hagiwara
     * @param array $fields
     * @return void
     */
    protected function contentsFileConfirmData(array $fields)
    {
        foreach ($fields as $field) {
            // contents_file周りの実装
            if (
                array_key_exists($field, $this->request->getData()) &&
                array_key_exists('error', $this->request->getData($field)) &&
                $this->request->getData($field . '.error') == UPLOAD_ERR_OK
            ) {
                // 'contents_file_' . $fieldをunsetする
                $data = $this->request->getParsedBody();
                unset($data['contents_file_' . $field]);
                $this->request = $this->request->withParsedBody($data);
            }
        }
    }

    /**
     * sortUpdate
     * ソート番号更新
     * ajax method
     * @author hagiwara
     * @return void
     */
    protected function sortUpdate()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException(__('not found'));
        }
        $this->viewBuilder()->className('\Cake\View\JsonView');
        $this->viewBuilder()->layout('ajax');
        $message = '';
        if (!$this->{$this->modelName}->updateSort($this->request->getData())) {
            $message = __('This could not be updated. Please, try again.');
        }
        $this->set(compact('message'));
        $this->set('_serialize', ['message']);
    }
}
