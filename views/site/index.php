<?php

/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Link reduction');
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= Yii::t('app', 'Add a short link'); ?></h1>
    </div>

    <div class="body-content">
        <?php
        $form = ActiveForm::begin([
            'id' => 'addLinkForm',
            'action' => Url::toRoute(['site/add-link']),
            'method' => 'post',
        ]);
        ?>

        <div class="row">
            <div class="col-12">
                <?= $form->field($adder, 'link')->textInput(); ?>
            </div>
            <div class="col-6">
                <?= $form->field($adder, 'timeout')->dropdownList([
                    1 => Yii::t('app', '1 hour'),
                    2 => Yii::t('app', '2 hours'),
                    4 => Yii::t('app', '4 hours'),
                    12 => Yii::t('app', '12 hours'),
                    24 => Yii::t('app', '24 hours'),
                ]); ?>
            </div>
            <div class="col-6">
                <?= $form->field($adder, 'limit')->dropdownList([
                    0 => Yii::t('app', 'unlimit'),
                    1 => Yii::t('app', 'time'),
                    2 => Yii::t('app', '2 times'),
                    4 => Yii::t('app', '4 times'),
                    10 => Yii::t('app', '10 times'),
                    40 => Yii::t('app', '40 times'),
                ]); ?>
            </div>
            <?php if (Yii::$app->session->hasFlash('form-success')) { ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::$app->session->getFlash('form-success'); ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (Yii::$app->session->hasFlash('form-danger')) { ?>
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::$app->session->getFlash('form-danger'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-12">
                <button type="submit" class="btn btn-success">
                    <?= Yii::t('app', 'Add'); ?>
                </button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>