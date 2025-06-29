<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel_log}}`.
 */
class m250628_221343_create_parcel_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%parcel_log}}', [
            'id'         => $this->primaryKey()->comment('ID'),
            'parcel_id'  => $this->integer()->notNull()->comment('ID посылки'),
            'action'     => $this->tinyInteger()->notNull()->comment('Действие'),
            'old'        => 'jsonb NOT NULL',
            'new'        => 'jsonb NOT NULL',
            'created_at' => 'timestamptz NOT NULL DEFAULT now()',
        ]);

        $this->addCommentOnColumn('{{%parcel_log}}', 'old', 'Старые аттрибуты');
        $this->addCommentOnColumn('{{%parcel_log}}', 'new', 'Новые аттрибуты');
        $this->addCommentOnColumn('{{%parcel_log}}', 'created_at', 'Дата создания');

        $this->addCommentOnTable('{{%parcel_log}}', 'Логи изменения посылок');

        $this->addForeignKey(
            'FK-parcel_log-parcel_id-parcel-id',
            '{{%parcel_log}}',
            'parcel_id',
            '{{%parcel}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%parcel_log}}');
    }
}
