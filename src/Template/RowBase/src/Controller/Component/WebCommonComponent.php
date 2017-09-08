<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * WebCommonComponent
 *
 * @author hagiwara
 */
class WebCommonComponent extends Component
{
    /**
     * $controller
     * @author hagiwara
     * @var \Cake\Controller\Controller|null $controller
     */
    protected $controller = null;

    /**
     * initialize
     * @author hagiwara
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controller = $this->_registry->getController();
    }

    /**
     * renderSet
     * 公開画面にて共通でセットするもの
     * @author hagiwara
     * @return void
     */
    public function renderSet()
    {
    }
}
