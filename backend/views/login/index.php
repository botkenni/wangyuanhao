<?php
    use backend\assets\LoginAsset;
    use yii\helpers\Html;
    use yii\captcha\Captcha;

    LoginAsset::register($this);
    //$this->registerCssFile('@web/css/login.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>王信强技术博客后台登录</title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body>
   <div id="login_box">
   <h1>王信强技术博客后台登录</h1>
       <?=Html::beginForm('' , 'post' ,  ['id' => 'form'])?>
		  <ul>
			 <li class="text">用户名：<?=Html::activeInput('text' , $model , 'username' , ['class' => 'input'])?></li>
			 <li class="tip">&nbsp;<?=Html::error($model , 'username' , ['class' => 'error'])?></li>
			 <li>密　码：<?=Html::activeInput('password' , $model , 'password' , ['class' => 'input'])?></li>
			 <li class="tip">&nbsp;<?=Html::error($model , 'password' , ['class' => 'error'])?></li>
			 <li style="position:relative;">验证码：
                 <?=Captcha::widget([
                     'model' => $model,
                     'attribute' => 'verifyCode',
                     'template' => '{input}{image}',
                     'captchaAction' => 'login/captcha',
                     'options' => [
                        'class' => 'input verifycode',
                         'id' => 'verifyCode'
                     ],
                     'imageOptions' => [
                        'class' => 'imagecode',
                         'id' => 'verifyCode-image',
                     ],
                 ])?>
             </li>
			 <li class="tip">&nbsp;<?=Html::error($model , 'verifyCode' , ['class' => 'error'])?></li>
			 <li class="tip remember"><input type="checkbox" id="remember" name="LoginForm[remember]" value="1"><label for="remember">&nbsp;保持登录状态</label></li>
		  </ul>
		  <div>
              <?=Html::submitButton('登录' , ['id' => 'login_submit'])?>
		  </div>
	   </div>
	  <?=Html::endForm();?>
   </div>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>