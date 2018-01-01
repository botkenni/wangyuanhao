<?php
    use yii\widgets\Breadcrumbs;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '用户列表' , 'url' => ['index']],
        '添加用户'
    ]
])?>
<?=$this->render('_form' , ['model' => $model])?>