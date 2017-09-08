<?php
namespace App\View\Helper;

use Cake\View\Helper\FormHelper;
use Cake\View\View;
use MultiStepForm\View\Helper\Traits\MultiStepFormHelperTrait;

class WebFormHelper extends FormHelper
{
    use MultiStepFormHelperTrait;
    /**
     * nextClass
     */
    protected $nextClass = '';
    /**
     * backClass
     */
    protected $backClass = '';

    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);
        $this->nextLabel = __('Confirm');
        $this->backLabel = __('Back');
    }
}
