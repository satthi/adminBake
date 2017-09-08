<?php
namespace AdminBake\Shell\Task;

use AdminBake\Shell\AppShell;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Security;
use Cake\Network\Exception\InternalErrorException;
use Cake\I18n\FrozenTime;

/**
 * InitialTask
 *
 * @author hagiwara
 */
class InitialTask extends AppShell
{
    public $tasks = [
        'Bake.BakeTemplate',
    ];

    /**
     * baseSet
     * 基本設定
     * @author hagiwara
     * @return void
     */
    public function baseSet()
    {
        $this->setComposer();
        $this->updateComposerJson();
        $this->appSet();
        $this->bootstrapSet();
        $this->etcSet();
        $this->setMigration();
        $this->adminSet();

        $this->updatesh();
        $this->out('migrationを実行してください');
    }

    /**
     * setComposer
     * rootにcomposer.pharを設置
     * @author hagiwara
     * @return void
     */
    private function setComposer()
    {
        // composer.pharの取得
        if (!file_exists(ROOT . '/composer.phar')) {
            exec('cd ' . ROOT . ';curl -sS https://getcomposer.org/installer | php;');
        }
    }

    /**
     * updateComposerJson
     * composer.jsonのアップデート
     * @author hagiwara
     * @return void
     */
    private function updateComposerJson()
    {
        $composerJsonPath = ROOT . '/composer.json';
        if (!file_exists($composerJsonPath)) {
            $this->out(sprintf('<info>Main composer file %s not found</info>', $composerJsonPath));
            return false;
        }
        $fp = new File($composerJsonPath);
        $content = json_decode($fp->read(), true);

        $require = [
            'friendsofcake/bootstrap-ui' => 'v0.6.0',
            'friendsofcake/search' => '1.*',
            'fusic/apollon' => '1.*',
            'fusic/encount' => '2.*',
            'fusic/reincarnation' => '1.*',
            'kozo/partial' => '3.0.*@dev',
            'kozo/liberty-behavior' => '3.0.*@dev',
            'tutida/pack' => '*',
            'satthi/contents-file' => '*',
            'junkins/multi-step-form' => '3.5.*',
            'satthi/entity-column-check' => '*',
        ];
        $requireDev = [
            'phpmd/phpmd' => '*',
            'friendsofphp/php-cs-fixer' => '*',
            'cakephp/cakephp-codesniffer' => 'dev-master',
            'thomasbachem/php-short-array-syntax-converter' => 'dev-master'
        ];
        foreach ($require as $plugin => $version) {
            if (empty($content['require'][$plugin])) {
                $content['require'][$plugin] = $version;
            }
        }
        foreach ($requireDev as $plugin => $version) {
            if (empty($content['require-dev'][$plugin])) {
                $content['require-dev'][$plugin] = $version;
            }
        }
        $fp->write(json_encode($content, JSON_PRETTY_PRINT));
        // composer update
        exec('cd ' . ROOT . ';php composer.phar update;');
    }

    /**
     * appSet
     * app.phpの設置
     * @author hagiwara
     * @return void
     */
    private function appSet()
    {
        // app.phpの設置
        $hash = Security::hash(rand() . time(), 'sha256');
        $this->writeApp('development', $hash);
        $this->writeApp('staging', $hash);
        $this->writeApp('production', $hash);
    }

    /**
     * writeApp
     * app.phpの設置
     * @author hagiwara
     * @param string $stage
     * @param string $hash
     * @return void
     */
    private function writeApp($stage, $hash)
    {
        // development
        $appDir = ROOT . '/config/' . $stage;
        (new Folder())->create($appDir);

        $params = [
            'salthash' => $hash
        ];
        $this->setTemplate('AdminBake.config/' . $stage . '/app', $appDir . '/app.php', $params);
    }

    /**
     * bootstrapSet
     * bootstrap.phpの設置
     * @author hagiwara
     * @return void
     */
    private function bootstrapSet()
    {
        $bootstrapPath = ROOT . '/config/bootstrap.php';
        $bootstrapFp = new File($bootstrapPath);
        $bootstrapContent = $bootstrapFp->read();

        $bootstrapEnvBase = (new File($this->pluginRoot . 'src/Template/Bake/config/bootstrap_env_base.php'))->read();
        $bootstrapEnvReplace = (new File($this->pluginRoot . 'src/Template/Bake/config/bootstrap_env_replace.php'))->read();
        $bootstrapPluginSetting = (new File($this->pluginRoot . 'src/Template/Bake/config/bootstrap_plugin_setting.php'))->read();

        // bootstrap.phpの書き換え
        $newBootstrapContent = str_replace($bootstrapEnvBase, $bootstrapEnvReplace, $bootstrapContent) . $bootstrapPluginSetting;
        // timezoneなどの書き換え
        $newBootstrapContent = str_replace('date_default_timezone_set(\'UTC\');', 'date_default_timezone_set(\'Asia/Tokyo\');', $newBootstrapContent);
        $newBootstrapContent = str_replace('ini_set(\'intl.default_locale\', Configure::read(\'App.defaultLocale\'));', 'ini_set(\'intl.default_locale\', \'ja_JP\');', $newBootstrapContent);

        $bootstrapFp->write($newBootstrapContent);
    }

    /**
     * etcSet
     * その他ファイルの設置
     * @author hagiwara
     * @return void
     */
    private function etcSet()
    {
        // bowerとかphp_csとか関係の設定
        $files = [
            '.php_cs',
            '.phpmd.xml',
            'git-pre-commit',
            'package.json',
            'update.sh',
            'reset_db_for_development.sh',
            '.gitignore',
        ];
        foreach ($files as $file) {
            $this->fileCopy($file);
        }
    }

    /**
     * adminSet
     * 管理画面の設置
     * @author hagiwara
     * @return void
     */
    private function adminSet()
    {
        // routes.phpの設置
        $this->fileCopy('config/routes.php');

        // poの設置
        $this->fileCopy('src/Locale/ja/default.po');

        // app 関係の設置
        // modelの設置
        $this->fileCopy('src/Model/Table/AppTable.php');
        $this->fileCopy('src/Model/Entity/AppEntity.php');

        // controllerの設置
        $this->fileCopy('src/Controller/WebAppController.php');

        // View
        $this->fileCopy('src/View/AppView.php');

        // helper
        $this->fileCopy('src/View/Helper/AdminCustomHelper.php');

        $this->fileCopy('src/Template/Element/paginate.ctp');

        $this->fileCopy('src/Controller/Admin/AdminAppController.php');

        $this->fileCopy('src/Controller/Component/WebCommonComponent.php');

        // baseのControllerなど設置
        $this->fileCopy('src/Controller/TopsController.php');
        $this->fileCopy('src/Template/Layout/default.ctp');
        // 空のものをとりあえず
        $this->fileCopy('src/Template/Tops/index.ctp');

        // css
        $this->fileCopy('webroot/css/common.css');

        // js
        $this->fileCopy('webroot/js/datepicker.js');
        $this->fileCopy('webroot/js/datetimepicker.js');
        $this->fileCopy('webroot/js/index_sortable.js');
        $this->fileCopy('webroot/js/zipsearch.js');

        // admin関係
        $this->fileCopy('src/Statics/Admin/AdminInfo.php');
        $this->fileCopy('src/View/Helper/AdminFormHelper.php');

        $this->fileCopy('src/Template/Layout/Admin/default.ctp');

        $this->fileCopy('src/Template/Admin/Element/admin_common_script.ctp');
        $this->fileCopy('src/Template/Admin/Element/paginate.ctp');
        $this->fileCopy('src/Template/Admin/Element/header.ctp');
        $this->fileCopy('src/Template/Admin/Element/header_menu.ctp');

        $this->fileCopy('src/Consts/CommonConst.php');

        // admins関係
        $this->fileCopy('src/Model/Table/AdminsTable.php');
        $this->fileCopy('src/Model/Entity/Admin.php');
        $this->fileCopy('src/Controller/Admin/AdminsController.php');
        $this->fileCopy('src/Template/Admin/Admins/login.ctp');

        // admin/tops関係
        $this->fileCopy('src/Controller/Admin/TopsController.php');
        $this->fileCopy('src/Template/Admin/Tops/index.ctp');
    }

    /**
     * setMigration
     * マイグレーションファイルの設置
     * @author hagiwara
     * @return void
     */
    private function setMigration()
    {
        // ベースのマイグレーションセット
        $this->fileCopy('config/Migrations/20150623000000_initial.php');

        $className = 'DevSeed' . (new FrozenTime())->format('YmdHis') . 'Admins';
        $params = [
            'className' => $className,
        ];
        $this->setTemplate('AdminBake.config/Seeds/development/Admins', ROOT . '/config/Seeds/development/' . $className . '.php', $params);
    }

    /**
     * updatesh
     *
     * @author hagiwara
     * @return void
     */
    private function updatesh()
    {
        exec('cd ' . ROOT . ';sh update.sh;');
    }
}
