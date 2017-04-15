<?php $form = \yii\bootstrap\ActiveForm::begin(); ?>

    <div class="row">
        <?

            echo $form->field($model, 'general_image')->widget(\kartik\file\FileInput::classname(), //Подключаем наш виджет . Тут мы привязываем к модеоли с помощью виджета.
                [

                    'options' => [ // здесь мы казываем данные которые будем загружать. Нас интересует картинка тип image . * - любой тип картинок
                        'accept' => 'image/*',
                    ],
                    'pluginOptions' => [
                        'uploadUrl' => \yii\helpers\Url::to(['file-upload-general']), // Url на который будут загружаться картинки
                        'uploadExtraData' => [ //Можем указывать дополнительные поля которые хотим передавать вместе с нашим Ajax  запросом
                            'advert_id' => $model->idadvert,
                        ],

                    'allowedFileExtensions' => ['jpg', 'png', 'gif'],//какие расширения разрешаются
                    'initialPreview' => $image, //Когда мы картинку загрузили она хранится на сервере, если мы хотим изменить картинку , то есть возможность подгружать превьюшку картинки
                        //которая была загружена. Сюда загружаем картинку в виде массива.
                    'showUpload' => true, // показывает кнопку удаления
                    'showRemove' => false, // кнупку удаления
                    'dropZoneEnabled' => false, // Куда можно перетащить картинку
                    ]
                ]);
        ?>
    </div>


    <div class="row">
        <?
        echo \yii\helpers\Html::label('Images'); //добавили название

        echo \kartik\file\FileInput::widget([ //Тут уже не используем модель.
            'name' => 'images', //Устанавливаем любое имя
            'options' => [
                'accept' => 'image/*',
                'multiple'=> true
            ],
            'pluginOptions' => [
                'uploadUrl' => \yii\helpers\Url::to(['file-upload-images']), //Тут другой адресс
                'uploadExtraData' => [
                    'advert_id' => $model->idadvert,
                ],
                'overwriteInitial' => false, //Чтобы не перезаписывать картинку а добавлять к существующей
                'allowedFileExtensions' =>  ['jpg', 'png','gif'],
                'initialPreview' => $images_add,
                'showUpload' => true,
                'showRemove' => false,
                'dropZoneEnabled' => false
            ]
        ]);
        ?>

    </div>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>
