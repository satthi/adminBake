// 開発環境のみ
Plugin::load('BootstrapUI');
Plugin::load('ContentsFile', ['routes' => true]);
Configure::write('ContentsFile.Setting', [
    'type' => 'normal',
    'Normal' => [
        'tmpDir' => TMP . 'cache/files/',
        'fileDir' => ROOT . '/files/',
    ],
]);

use Encount\Error\EncountErrorHandler;
use Encount\Console\EncountConsoleErrorHandler;

// 開発環境は画面にエラー情報を出したいので
if ($developmentFlag === false) {
    // web
    (new EncountErrorHandler(Configure::read('Error')))->register();
    // shell
    (new EncountConsoleErrorHandler(Configure::read('Error')))->register();
}

// セッションtimeoutの設定
Configure::write('Session', [
    'defaults' => 'php',
    'timeout'  => 120 // セッション破棄時間
]);
