<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $birthdate
 * @property string $email
 */
class Client extends \yii\db\ActiveRecord
{

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function getOrderedProducts()
    {
        $sql = "
            SELECT *
            FROM `order`
            RIGHT JOIN order_product ON `order`.id = order_product.order_id
            LEFT JOIN product ON product.id = order_product.product_id
            WHERE `order`.client_id = :clientId
        ";


    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'birthdate', 'email'], 'required'],
            [['firstname', 'lastname', 'birthdate', 'email'], 'string', 'max' => 255],
            [['birthdate'], 'safe'],
            [['birthdate'], 'date', 'format' => 'php:Y-m-d', 'message'=>"The format of Birthdate is invalid. Y-m-d"],
            [['email'], 'email','message'=>"The email isn't correct"],
            [['email'], 'unique','message'=>'Email already exists!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'birthdate' => 'Birthdate',
            'email' => 'Email',
        ];
    }
}
