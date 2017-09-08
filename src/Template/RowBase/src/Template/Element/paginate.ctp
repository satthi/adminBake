<?php if ($this->Paginator->params()['pageCount'] !== 1) :?>
    <div class="paging">
        <ul class="pagination">
        <?= $this->Paginator->prev('< 前') ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next('次 >') ?>
        </ul>
    </div>
<?php endif; ?>
<div>
    <?= $this->Paginator->counter('{{count}}件中{{start}}～{{end}}件を表示');?>
</div>
