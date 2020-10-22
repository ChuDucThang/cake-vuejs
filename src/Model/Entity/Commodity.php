<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Commodity Entity
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $img_path
 * @property string $date_export
 * @property float|null $amount
 * @property int|null $quantity
 * @property int|null $quantity_use
 * @property int|null $quantity_inventory
 * @property string|null $note
 * @property int $del_flg
 * @property string $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 *
 * @property \App\Model\Entity\Category $category
 */
class Commodity extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'category_id' => true,
        'name' => true,
        'img_path' => true,
        'date_export' => true,
        'amount' => true,
        'quantity' => true,
        'quantity_use' => true,
        'quantity_inventory' => true,
        'note' => true,
        'del_flg' => true,
        'created_at' => true,
        'updated_at' => true,
        'category' => true,
    ];
}
