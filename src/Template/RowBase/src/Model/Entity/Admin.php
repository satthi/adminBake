<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity;

/**
 * Admin Entity.
 * @property int $id
 * @property string $name
 * @property string $loginid
 * @property string $password
 * @property bool $deleted
 * @property \Cake\I18n\FrozenTime $deleted_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @author hagiwara
 */
class Admin extends AppEntity
{
    /**
     * _accessible
     * @author hagiwara
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * _hidden
     * @author hagiwara
     */
    protected $_hidden = [
        'password'
    ];
}
