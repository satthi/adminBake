<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use EntityColumnCheck\Model\Entity\EntityColumnCheckTrait;

/**
 * AppEntity
 *
 * @author hagiwara
 */
class AppEntity extends Entity
{
    use EntityColumnCheckTrait;

    /**
     * get
     * ContentsFile設定用
     * @author hagiwara
     * @return string
     */
    public function &get($property)
    {
        $value = parent::get($property);
        $this->getEntityColumnCheck($property);
        return $value;
    }
}
