<?php

namespace app\actions;

use app\models\Link;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class LinkAction extends Action
{
    public function run(string $short)
    {
        /** @var Link $link */
        $link = Link::find()->where(['short' => $short])
            ->andWhere(['>=', 'timeout', time()])
            ->andWhere([
                'or',
                ['usage_limit' => 0],
                ['>', 'reverse_counter', 0],
            ])
            ->one();

        if (!$link) {
            throw new NotFoundHttpException(Yii::t('app', 'No link'));
        }

        $decreased = $link->decreaseUsageLimit();
        if ($decreased && false === $link->update(true, ['reverse_counter'])) {
            Yii::error($link->getErrors());

            throw new ServerErrorHttpException(Yii::t('app', 'Sorry. We are unable to follow the link at this time. Please try again later.'));
        }

        return $this->controller->redirect($link->link);
    }
}
