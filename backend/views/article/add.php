<?php
    use yii\widgets\Breadcrumbs;
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' => '首页'],
    'links' => [
        ['label' => '文章列表' , 'url' => ['index']],
        '添加文章'
    ]
])?>
<?=$this->render('_form' , ['model' => $model])?>