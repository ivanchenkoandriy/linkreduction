<?php

namespace app\actions;

use app\models\AddLinkForm;
use Yii;
use yii\base\Action;
use yii\helpers\Url;

class AddLinkAction extends Action
{
    public function run()
    {
        $adder = new AddLinkForm();
        $adder->load(Yii::$app->request->post());
        if (!$adder->execute()) {
            Yii::$app->session->setFlash('form-danger', Yii::t('app', 'Can`t add the link. Error: "{error}".', [
                'error' => current($adder->getFirstErrors()),
            ]));

            return $this->controller->redirect(['site/index']);
        }

        Yii::$app->session->setFlash('form-success', Yii::t('app', 'Your link has been added successfully: {link}.', [
            'link' => Url::toRoute(['site/link', 'short' => $adder->getShort()], true),
        ]));

        return $this->controller->redirect(['site/index']);
    }
}
