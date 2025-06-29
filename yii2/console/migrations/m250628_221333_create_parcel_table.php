<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parcel}}`.
 */
class m250628_221333_create_parcel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%parcel}}', [
            'id'           => $this->primaryKey()->comment('ID'),
            'track_number' => $this->string()->notNull()->unique()->comment('Номер трека'),
            'status'       => $this->tinyInteger()->notNull()->comment('Статус'),
            'created_at'   => 'timestamptz NOT NULL DEFAULT now()',
            'updated_at'   => 'timestamptz',
        ]);

        $this->addCommentOnColumn('{{%parcel}}', 'created_at', 'Дата создания');
        $this->addCommentOnColumn('{{%parcel}}', 'updated_at', 'Дата обновления');

        $this->addCommentOnTable('{{%parcel}}', 'Посылки');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%parcel}}');
    }
}
