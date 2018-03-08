<?php

namespace backend\modules\v1\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class GoodsController extends ActiveController
{
    public $modelClass = 'api\models\Goods';

    public function behaviors() {
        return ArrayHelper::merge (parent::behaviors(), [
            'authenticator' => [
                'class' => QueryParamAuth::className()
            ]
        ] );
    }
}

