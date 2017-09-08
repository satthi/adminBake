<?php

use Phinx\Seed\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

/**
 * <%= $className %>
 *
 * @author hagiwara
 */
class <%= $className %> extends AbstractSeed
{
    /**
     * run
     *
     * @author hagiwara
     * @return void
     */
    public function run()
    {
        $data = [];
        $now = date('Y-m-d H:i:s');
        $hasher = new DefaultPasswordHasher();

        $data[] = [
            'loginid'      => 'admin',
            'password'     => $hasher->hash('admin'),
            'name'         => '管理者1',
            'deleted'      => 0,
            'deleted_date' => null,
            'created'      => $now,
            'modified'     => $now,
        ];

        $table = $this->table('admins');
        $table->insert($data)->save();
    }
}
