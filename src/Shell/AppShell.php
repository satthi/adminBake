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

use Cake\Console\Shell;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Exception\InternalErrorException;

/**
 * AppShell
 *
 * @author hagiwara
 */
class AppShell extends Shell
{
    public $pluginRoot;
    public $adminRoot;

    /**
     * initialize
     *
     * @author hagiwara
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        // 全体で使用するプラグインパス
        $this->pluginRoot = dirname(__FILE__) . '/../../';
    }

    /**
     * fileCopy
     * ファイルのコピー
     * RowBaseに入ったパスのままコピーする
     * @author hagiwara
     * @param string $path
     * @return void
     */
    protected function fileCopy($oldPath, $newPath = '')
    {
        if ($newPath === '') {
            $newPath = $oldPath;
        }
        $old = $this->pluginRoot . '/src/Template/RowBase/' . $oldPath;
        $new = ROOT . '/' . $newPath;
        if (!is_dir(dirname($new))) {
            (new Folder())->create(dirname($new));
        }
        $fp = new File($old);
        if (!$fp->copy($new)) {
            throw new InternalErrorException($old . ' - ' . $new . ' error.');
        }
    }

    /**
     * setTemplate
     * ファイルのコピー(テンプレート付き)
     * bakeTemplateを利用してファイルを設置する
     * @author hagiwara
     * @param string $baseTemplate
     * @param string $exportTemplate
     * @param array $params
     * @return void
     */
    protected function setTemplate($baseTemplate, $exportTemplate, $params)
    {
        if (!Plugin::loaded('AdminBake')) {
            Plugin::load('AdminBake');
        }
        $this->BakeTemplate->set($params);
        $contents = $this->BakeTemplate->generate($baseTemplate);
        if (!is_dir(dirname($exportTemplate))) {
            (new Folder())->create(dirname($exportTemplate));
        }
        $fp = new File($exportTemplate);
        if (!$fp->write($contents)) {
            throw new InternalErrorException($baseTemplate . ' - ' . $exportTemplate . ' error.');
        }
    }

    /**
     * dirCopy
     * ディレクトリのコピー
     *
     * @author hagiwara
     * @param string $old
     * @param string $new
     * @return void
     */
    protected function dirCopy($old, $new)
    {
        $fp = new Folder();
        $option = [
            'to' => $new,
            'from' => $old,
        ];
        if (!$fp->copy($option)) {
            throw new InternalErrorException($old . ' - ' . $new . ' error.');
        }
    }

    /**
     * migrate
     * マイグレーションの実行
     *
     * @author hagiwara
     * @return void
     */
    protected function migrate()
    {
        exec('cd ' . ROOT . ';bin/cake migrations migrate;');
    }

    /**
     * menuAdd
     * 管理画面のメニュー追加
     *
     * @author hagiwara
     * @param string $modelName
     * @return void
     */
    protected function menuAdd($modelName)
    {
        $addText = '<li><?= $this->Html->link(__(\'' . $modelName . '\'), [\'controller\' => \'' . $modelName . '\', \'action\' => \'index\']);?></li>' . "\n";

        $fp = new File(APP . 'Template/Admin/Element/header_menu.ctp');
        $fp->write($addText, 'a');
    }

    /**
     * poAdd
     * poの追記
     *
     * @author hagiwara
     * @param string $modelName
     * @return void
     */
    protected function poAdd($modelName)
    {
        $params = [
            'modelName' => $modelName,
        ];
        $this->BakeTemplate->set($params);
        $contents = $this->BakeTemplate->generate('AdminBake.Locale/topics_template');

        $fp = new File(APP . 'Locale/ja/default.po');
        $fp->write($contents, 'a');
    }
}
