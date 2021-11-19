<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property int $usage_limit
 * @property int $reverse_counter
 * @property int $timeout
 * @property int $created_at
 * @property string $short
 * @property string $link
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%links}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamps' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usage_limit', 'timeout', 'short', 'link', 'reverse_counter'], 'required'],
            [['usage_limit', 'timeout', 'created_at', 'reverse_counter'], 'integer'],
            [['short'], 'string', 'max' => 8],
            [['link'], 'string', 'max' => 2048],
            [['short'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'usage_limit' => Yii::t('app', 'Usage Limit'),
            'reverse_counter' => Yii::t('app', 'Reverse Counter'),
            'timeout' => Yii::t('app', 'Timeout'),
            'created_at' => Yii::t('app', 'Created At'),
            'short' => Yii::t('app', 'Short'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    public function decreaseUsageLimit(): bool
    {
        if (!$this->usage_limit) {
            return false;
        }

        $counter = (int)$this->reverse_counter;
        if (0 >= $counter) {
            return false;
        }

        $counter--;
        $this->reverse_counter = $counter;

        return true;
    }
}
