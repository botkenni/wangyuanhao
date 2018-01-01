<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use common\models\Category;
?>
<div class="inner-container">
    <?=Html::beginForm('' , 'post' , ['enctype' => 'multipart/form-data' , 'class' => 'form-horizontal' , 'id' =>'addForm' ])?>
        <div class="form-group">
            <?=Html::label('分类：' , 'pid' , ['class' =>'control-label col-sm-2 col-md-1'])?>
            <div class="controls col-sm-10 col-md-11">
                <?=Html::activeDropDownList($model , 'pid' , Category::getParentCategorys(), ['class' => 'form-control width_auto'])?>
                <?=Html::error($model , 'pid')?>
            </div>
		</div>
	    <div class="form-group">
            <?=Html::label('名称*：' , 'name' , ['class' =>'control-label col-sm-2 col-md-1'])?>
            <div class="controls col-sm-10 col-md-11">
                <?=Html::activeInput('text' , $model , 'name' , ['class' => 'form-control input'])?>
                <?=Html::error($model , 'name')?>
            </div>
		</div>
        <div class="form-group">
            <?=Html::label('排序：' , 'sort_order' , ['class' =>'control-label col-sm-2 col-md-1'])?>
            <div class="controls col-sm-10 col-md-11">
                <?=Html::activeInput('text' , $model , 'sort_order' , ['class' => 'form-control input'])?>
                <?=Html::error($model , 'sort_order')?>
            </div>
		</div>
	    <div class="form-group">
            <?=Html::label('状态：' , 'status' , ['class' =>'control-label col-sm-2 col-md-1'])?>
            <div class="controls col-sm-10 col-md-11">
                <?=Html::activeDropDownList($model , 'status' , [1 => '开启' , 0 => '禁用'] , ['class' => 'form-control width_auto'])?>
                <?=Html::error($model , 'status')?>
            </div>
		</div>
		<div class="form-group">
		 	<div style="margin-top:10px" class="col-sm-10 col-sm-offset-2 col-md-11 col-md-offset-1">
		 		<button class="btn btn-primary" type="submit">提交</button>
				<a class="btn btn-primary" href="<?=Url::to(['index'])?>">返回</a>
		 	</div>
		</div>
	<?=Html::endForm();?>
</div>
