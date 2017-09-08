<?php
namespace App\View\Helper;

use BootstrapUI\View\Helper\FormHelper;
use Cake\View\View;
use MultiStepForm\View\Helper\Traits\MultiStepFormHelperTrait;

class AdminFormHelper extends FormHelper
{
    use MultiStepFormHelperTrait;
    /**
     * nextClass
     */
    protected $nextClass = 'btn_sizeM btn_Black';
    /**
     * backClass
     */
    protected $backClass = 'btn_sizeM btn_Blue';

    /**
     * __construct
     *
     * @author hagiwara
     * @param \Cake\View\View $View
     * @param array $config
     * @return string
     */
    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);
        $this->nextLabel = __('Confirm');
        $this->backLabel = __('Back');
    }
}
