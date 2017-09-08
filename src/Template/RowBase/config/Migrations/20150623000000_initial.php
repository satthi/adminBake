<?php

use Phinx\Migration\AbstractMigration;

/**
 * Initial
 *
 * @author hagiwara
 */
class Initial extends AbstractMigration
{
    /**
     * change
     *
     * @return void
     * @author hagiwara
     */
    public function change()
    {
        //admins
        $admins = $this->table('admins', [
            'id' => true,
            'primary_key' => ['id']
        ]);

        $admins
            ->addColumn('name', 'text', ['null' => true,'comment' => '表示名'])
            ->addColumn('loginid', 'text', ['null' => true,'comment' => 'ログインID'])
            ->addIndex('loginid')
            ->addColumn('password', 'text', ['null' => true,'comment' => 'ログインPASS'])
            ->addIndex('password')
            ->addColumn('deleted', 'boolean', ['default' => false,'comment' => '削除フラグ'])
            ->addColumn('deleted_date', 'datetime', ['null' => true,'comment' => '削除日時'])
            ->addColumn('created', 'datetime', ['null' => true,'comment' => '登録日時'])
            ->addColumn('modified', 'datetime', ['null' => true,'comment' => '更新日時'])
            ->create();

        //attachments
        $attachments = $this->table('attachments', [
            'id' => true,
            'primary_key' => ['id']
        ]);

        $attachments
            ->addColumn('model', 'text', ['null' => true,'comment' => 'モデル名'])
            ->addIndex('model')
            ->addColumn('model_id', 'integer', ['null' => true,'comment' => 'モデルID'])
            ->addIndex('model_id')
            ->addColumn('field_name', 'text', ['null' => true,'comment' => 'フィールド名'])
            ->addColumn('file_name', 'text', ['null' => true,'comment' => 'ファイル名'])
            ->addColumn('file_content_type', 'text', ['null' => true,'comment' => 'ファイルタイプ'])
            ->addColumn('file_size', 'text', ['null' => true,'comment' => 'ファイルサイズ'])
            ->addColumn('created', 'datetime', ['null' => true,'comment' => '登録日時'])
            ->addColumn('modified', 'datetime', ['null' => true,'comment' => '更新日時'])
            ->create();
    }
}
