<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_product}}`.
 */
class m230815_125212_create_order_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_product', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ]);

        // Add foreign keys for order_id and product_id
        $this->addForeignKey('fk-order-product-order', 'order_product', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-order-product-product', 'order_product', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_product');
    }
}
