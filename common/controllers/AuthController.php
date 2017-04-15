<?

namespace common\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthController extends Controller{

    public function behaviors(){ // Стандартный метод и он содержит фильтры

        $behaviors = [
            'access' => [
                'class' => AccessControl::className(), // для того чтобы проверить аторизован пользователь или нет
                'rules' => [
                    [
                        'allow' => true, //доступ имеет только авторизованный пользователь
                        'roles' => ['@']
                    ]
                ]
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];


        return $behaviors;

    }


}