<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= $this->fetch('meta') ?>
        <title>
            <?= h($projectName);?> <?= __('Management');?>
        </title>
        <?= $this->Html->meta('icon'); ?>

        <!-- bootstrap -->
        <?= $this->Html->css('../node_modules/admin-lte/bootstrap/css/bootstrap.min.css'); ?>
        <!-- font awesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- adminLTE style -->
        <?= $this->Html->css('../node_modules/admin-lte/plugins/select2/select2.min.css'); ?>
        <?= $this->Html->css('../node_modules/admin-lte/dist/css/AdminLTE.min.css'); ?>
        <?= $this->Html->css('../node_modules/admin-lte/dist/css/skins/skin-blue-light.min.css'); ?>

        <?= $this->Html->css('../node_modules/admin-lte/plugins/daterangepicker/daterangepicker.css'); ?>
        <?= $this->Html->css('../node_modules/admin-lte/plugins/datepicker/datepicker3.css'); ?>
        <?= $this->Html->css('../node_modules/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css'); ?>
        <?= $this->Html->css('../node_modules/admin-lte/plugins/select2/select2.min.css'); ?>
        <?= $this->Html->css('../node_modules/jquery-ui-dist/jquery-ui.theme.min.css'); ?>
        <?= $this->Html->css('common.css'); ?>
        <?= $this->fetch('css') ?>

        <?= $this->Pack->render();?>
        <?= $this->element('admin_common_script');?>

        <?= $this->Html->script('../node_modules/moment/min/moment.min'); ?>
        <?= $this->Html->script('../node_modules/moment/locale/ja'); ?>
        <?php //コンテンツデザイナはjquery1系のみ動作する?>
        <?= $this->Html->script('../node_modules/jquery/dist/jquery.min.js');?>
        <?= $this->Html->script('../node_modules/jquery-ui-dist/jquery-ui.min.js');?>

        <?= $this->Html->script('../node_modules/admin-lte/bootstrap/js/bootstrap.min'); ?>
        <?= $this->Html->script('../node_modules/admin-lte/dist/js/app.min.js'); ?>

        <?php //adminlte plugin内のdaterangepickerだとDeprecation warningが出続けるので最新のものを取得?>
        <?= $this->Html->script('../node_modules/bootstrap-daterangepicker/daterangepicker'); ?>
        <?= $this->Html->script('../node_modules/admin-lte/plugins/datepicker/bootstrap-datepicker'); ?>
        <?= $this->Html->script('../node_modules/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.ja.js'); ?>
        <?= $this->Html->script('../node_modules/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js'); ?>
        <?= $this->Html->script('../node_modules/admin-lte/plugins/select2/select2.full.min.js'); ?>
        <?= $this->Html->script('../node_modules/jsrender/jsrender'); ?>
        <?= $this->fetch('script'); ?>
    </head>
    <body class="hold-transition skin-blue-light sidebar-mini">
        <?= $this->Flash->render(); ?>
            <?= $this->element('header'); ?>
            <div class="body_div">
                <?= $this->fetch('content') ?>
            </div>
    </body>
</html>
