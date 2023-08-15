<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property string $created_at
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                // This is a new record, set the created_at attribute
                $this->created_at = date('Y-m-d H:i:s');
            }

            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'price', 'created_at'], 'required'],
            [['description'], 'string'],
            [['price'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
        ];
    }
}
