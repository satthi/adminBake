<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

/**
 * AppTable
 *
 * @author hagiwara
 */
class AppTable extends Table
{

    /**
     * Initialize method
     *
     * @author hagiwara
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->addBehavior('Reincarnation.SoftDelete');
    }

    /**
     * getListSort
     * 指定のオーダーでのリスト取得
     * @author hagiwara
     * @param string $sortKey
     * @param string $field
     * @param string $key
     * @return \Cake\ORM\Query
     */
    public function getListSort($sortKey = 'sort', $field = 'name', $key = 'id')
    {
        return $this->find('list', [
                'keyField' => $key,
                'valueField' => $field
            ])
            ->order([$this->getAlias() . '.' . $sortKey])
            ->order([$this->getAlias() . '.id'])
            ;
    }

    /**
     * getSortNo
     * 新規登録時のソート番号を取得する
     * @author hagiwara
     * @param array $conditions
     * @return int
     */
    protected function getSortNo($conditions = [])
    {
        $query = $this->find('all')
            ->order([$this->getAlias() . '.sort' => 'DESC'])
            ;
        if (!empty($conditions)) {
            $query = $query->where($conditions);
        }
        $maxSortInfo = $query->first();
        if (empty($maxSortInfo)) {
            return 1;
        }
        return $maxSortInfo->sort + 1;
    }

    /**
     * updateSort
     * ソート番号を更新する
     * @author hagiwara
     * @param array $sortDatas
     * @return bool
     */
    public function updateSort($sortDatas)
    {
        $saveFlag = true;
        $connection = ConnectionManager::get('default');
        $connection->begin();
        // ソート番号を更新
        foreach ($sortDatas as $sort => $articleId) {
            $entity = $this->get($articleId);
            $entity->sort = $sort;
            if (!$this->save($entity, ['atomic' => false])) {
                $saveFlag = false;
            }
        }
        if ($saveFlag === true) {
            $connection->commit();
        } else {
            $connection->rollback();
        }
        return $saveFlag;
    }
}
