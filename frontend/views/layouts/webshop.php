<?php


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\WebshopAsset;
use common\widgets\Alert;

WebshopAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="javascript">

        $(document).ready(function(){
            $(".a").click(function(){
                alert("The paragraph was clicked.");
            });
        });
    </script>
</head>
<body style="height: 33000px">
<?php $this->beginBody() ?>



<!-- Меню navbar -->
    <nav class="navbar navbar-default navbar-fixed-top ">
        <!-- Бренд и переключатель, который вызывает меню на мобильных устройствах -->
        <div class="container-fluid">
        <!-- Содержимое меню (коллекция навигационных ссылок, формы и др.) -->
        <div class="collapse navbar-collapse" id="main-menu" >
            <!-- Список ссылок, расположенных слева -->
            <ul class="nav navbar-nav">
                <!--Элемент с классом active отображает ссылку подсвеченной -->
                <li class="active"><a href="#">Главная <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Статьи</a></li>
                <li><a href="#">Новости</a></li>
             <!--   <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Новости <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#">Windows</a></li>
                        <li><a href="#">Mac OS</a></li>
                        <li><a href="#">Linux</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Другие системы</a></li>
                    </ul>
                </li>-->
            </ul>
            <!-- Список ссылок, расположенный справа -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Войти</a></li>
            </ul>

       <!--     <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="">
                </div>
                <button type="submit" class="btn btn-default">Найти</button>
            </form>

            <button type="button" class="btn btn-default navbar-btn">Войти</button>

            <p class="navbar-text">Вошёл под именем Jhon</p>

            <p class="navbar-text navbar-right">Вошёл как <a href="#" class="navbar-link">John</a></p>-->
        </div>
        </div>
    </nav>

<!--
<div class="avs">
<ul>

    <li><a>Главная</a><li>
    <li><a>Главная</a><li>
    <li><a>Главная</a><li>
    <li><a>Главная</a><li>

</ul>
-->



    <div class="col-lg-10 col-lg-offset-1" style="height:400px; background-color: whitesmoke; margin-top:0px;margin-bottom: 20px">
       ываываываываываыва
    </div>
    <form class="input-group col-lg-offset-4 col-lg-4">

        <input type="text" class="form-control" placeholder="Логин">
        <label> Почта </label>
        <input type="text" class="form-control" placeholder="email">
        <input type="text" class="form-control" placeholder="Пароль">


    </form>
<div class="input-group col-lg-offset-4 col-lg-4"">
<input type="text" class="form-control" placeholder="Повторить пароль">
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
