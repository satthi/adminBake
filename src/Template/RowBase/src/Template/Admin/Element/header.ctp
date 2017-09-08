<header class="main-header">
    <a href="<?= $this->Url->build('/admin'); ?>" class="logo">
        <?= h($projectName);?> <?= __('Management');?>
    </a>
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <?php if (!empty(App\Statics\Admin\AdminInfo::$id)):?>
                <ul class="nav navbar-nav" id="nav-menu">
                        <?= $this->element('header_menu');?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><?= $this->Html->link(__('Logout'), ['controller' => 'admins', 'action' => 'logout']); ?></li>
                </ul>
                <?php endif;?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
