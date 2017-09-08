<div class="login-box">
    <div class="login-logo">
        <b>
            <?= $projectName;?> <?= __('Management');?>
        </b>
    </div>
    <div class="login-box-body">
        <?= $this->Form->create(); ?>
            <div class="form-group has-feedback">
                <?= $this->Form->input('loginid', ['label' => __('Login Id')]); ?>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <?= $this->Form->input('password', ['type' => 'password', 'label' => __('Password')]); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"><?= __('Login');?></button>
                </div>
            </div>

        <?= $this->Form->end(); ?>
  </div>
</div>
