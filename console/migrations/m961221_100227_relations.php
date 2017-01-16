<?php

use yii\db\Migration;

class m961221_100227_relations extends Migration
{
    public function up()
    {
        //topic-section
        $this->createIndex('fk_topic_section_idx', '{{%topic}}', 'section_id');
        $this->addForeignKey('fk_topic_section', '{{%topic}}', 'section_id', '{{%section}}', 'id');

        //video-topic
        $this->createIndex('fk_video_topic_idx', '{{%video}}', 'topic_id');
        $this->addForeignKey('fk_video_topic', '{{%video}}', 'topic_id', '{{%topic}}', 'id');

        //video-image
        $this->createIndex('fk_video_image_idx', '{{%video}}', 'preview_image');
        $this->addForeignKey('fk_video_image', '{{%video}}', 'preview_image', '{{%image}}', 'id');

        //like-user
        $this->createIndex('fk_like_user_idx', '{{%like}}', 'user_id');
        $this->addForeignKey('fk_like_user', '{{%like}}', 'user_id', '{{%user}}', 'id');

        //like-video
        $this->createIndex('fk_like_video_idx', '{{%like}}', 'video_id');
        $this->addForeignKey('fk_like_video', '{{%like}}', 'video_id', '{{%video}}', 'id');

        //subscription-user
        $this->createIndex('fk_subscription_user_idx', '{{%subscription}}', 'user_id');
        $this->addForeignKey('fk_subscription_user', '{{%subscription}}', 'user_id', '{{%user}}', 'id');

        //subscription-section
        $this->createIndex('fk_subscription_section_idx', '{{%subscription}}', 'section_id');
        $this->addForeignKey('fk_subscription_section', '{{%subscription}}', 'section_id', '{{%section}}', 'id');

        //section-image
        $this->createIndex('fk_section_image_idx', '{{%section}}', 'image_id');
        $this->addForeignKey('fk_section_image', '{{%section}}', 'image_id', '{{%image}}', 'id');
    }

    public function down()
    {
        //like-user
        $this->dropForeignKey('fk_like_user_idx', '{{%like}}');
        $this->dropIndex('fk_like_user_idx', '{{%like}}');

        //like-video
        $this->dropForeignKey('fk_like_video_idx', '{{%like}}');
        $this->dropIndex('fk_like_video_idx', '{{%like}}');

        //video-image
        $this->dropForeignKey('fk_video_image_idx', '{{%video}}');
        $this->dropIndex('fk_video_image_idx', '{{%video}}');

        //video-topic
        $this->dropForeignKey('fk_video_topic_idx', '{{%video}}');
        $this->dropIndex('fk_video_topic_idx', '{{%video}}');

        //topic-section
        $this->dropForeignKey('fk_topic_section_idx', '{{%topic}}');
        $this->dropIndex('fk_topic_section_idx', '{{%topic}}');

        //section-image
        $this->dropForeignKey('fk_section_image_idx', '{{%section}}');
        $this->dropIndex('fk_section_image_idx', '{{%section}}');

        //subscription-user
        $this->dropForeignKey('fk_subscription_user_idx', '{{%subscription}}');
        $this->dropIndex('fk_subscription_user_idx', '{{%subscription}}');

        //subscription-section
        $this->dropForeignKey('fk_subscription_section_idx', '{{%subscription}}');
        $this->dropIndex('fk_subscription_section_idx', '{{%subscription}}');

        echo("the DB relations downgrade is completed\n");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
