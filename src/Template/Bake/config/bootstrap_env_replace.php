// 環境変数によって読み込むappファイルの切り替え
$developmentFlag = false;
try {
    Configure::config('default', new PhpConfig());
    $envDir = CONFIG . 'env/';
    $production  = 'production';
    $staging     = 'staging';
    $demo        = 'demo';
    $development = 'development';
    if (file_exists($envDir.$production)) {
        Configure::load($production . '/app', 'default', false);
    } elseif (file_exists($envDir . $staging)) {
        Configure::load($staging . '/app', 'default', false);
    } elseif (file_exists($envDir . $demo)) {
        Configure::load($demo . '/app', 'default', false);
    } elseif (file_exists($envDir . $development)) {
        Configure::load($development . '/app', 'default', false);
        $developmentFlag = true;
    } else {
        Configure::load($development . '/app', 'default', false);
        $developmentFlag = true;
    }
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}
