<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AdminCustomHelper extends Helper
{
    /**
     * requireMark
     * 必須マーク
     *
     * @author hagiwara
     * @return string
     */
    public function requireMark()
    {
        return '<span class="require-block">*</span>';
    }
}
