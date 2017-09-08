<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminBake\Shell;

use AdminBake\Shell\AppShell;

/**
 * InitialShell
 *
 * @author hagiwara
 */
class InitialShell extends AppShell
{
    public $tasks = [
        'AdminBake.Initial',
    ];

    /**
     * main
     *
     * @author hagiwara
     * @return void
     */
    public function main()
    {
        //Adminディレクトリがない場合は初期設定
        if (!is_dir(APP . 'Controller/Admin')) {
            $this->out('初期設定。');
            $this->Initial->baseSet();

            $this->out('マイグレーションを実行してください');
            $this->out('sh reset_db_for_development.sh を実行するとマイグレーション及びテストデータが挿入されます');
            return false;
        } else {
            //お知らせとかの作成
            $this->out('instant contents テンプレート作成');
            $this->out('[M]新着作成');
            $this->out('[F]フォーム作成');
            $this->out('[Q]終了');
            $choice = strtoupper($this->in('メニューを選択してください。', ['M', 'F', 'Q']));
            switch ($choice) {
                case 'M':
                $this->Make->init();
                break;
                case 'F':
                $this->Form->make();
                break;
            case 'Q':
                return false;
                break;
            default:
                $this->out(__('You have made an invalid selection. Please choose a command to execute by entering L, D, C, N or Q.', true));
            }
            $this->hr();
            $this->main();
        }
    }

    /**
     * M
     *
     * @author hagiwara
     * @return void
     */
    public function M()
    {
        $this->Make->init();
    }

    /**
     * F
     *
     * @author hagiwara
     * @return void
     */
    public function F()
    {
        $this->Form->init();
    }
}
