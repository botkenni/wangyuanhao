<?php
    use yii\helpers\Url;
?>
<link rel="stylesheet" href="css/article.css" />
<div class="container">
    <div class="row">
        <div class="col-md-9" >
            <div class="content">
                <article class="thread thread-card  article-nav" style="padding: 5px 10px;">
                    <a href="<?=Url::base(true);?>">首页</a>
                    <?php if(!empty($nowCategory) && $nowCategory['pid'] != -1) echo ' &gt;&gt; ' . $nowCategory['name'];?>
                    <?php if(!empty($search)) echo ' &gt;&gt; ' . $search;?>
                </article>
                <?php foreach($articles as $article ) {
                        $timeData = explode('-', date('Y-m-d', $article['update_date']));
                    ?>
                    <article class="thread thread-card">
                        <header>
                            <div class="time-label">
                                <span class="year"><?=$timeData[0]?></span>
                                <span style="display:block"><?=$timeData[1]?></span>
                                <span style="display:block"><?=$timeData[2]?></span>
                            </div>
                            <h3 class="thread-title">
                                <a href="<?=Url::to(['article', 'id' => $article['id']])?>"><?=$article['title']?></a>
                            </h3>
                            <div class="thread-meta">
                                <?=$article['author']?>&nbsp;
                                <ul class="blog-category">
                                    <li>分类：<?=(isset($categorys[$article['cid']]) ? $categorys[$article['cid']]['name'] : '无')?></li>
                                    <li>浏览次数：<?=$article['count']?></li>
                                </ul>
                            </div>
                        </header>
                        <div class="clearfix"></div>
                        <div class="markdown-body">
                            <?=$article['description']?>
                        </div>
                        <div class="thread-footer">
                            <a href="<?=Url::to(['article', 'id' => $article['id']])?>" class="ds-thread-bevel">阅读原文</a>
                        </div>
                    </article>
                <?php }?>

                <div class="pagination">
                   <!-- 分页数据  -->
                    <?=\yii\widgets\LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => [
                                'class' => '',
                            ]
                        ]);?>
				</div>
            </div>

        </div>
        <aside class="col-md-3 sidebar">
			<section class="visitor card">
				<div class="top">
					<div class="user-avatar">
						<a href="javascript:;" class="avatar avatar-50">
							<img alt="王信强" src="#" width="91" height="31">
						</a>
					</div>
					<h4 class="name">王信强</h4>
					<a href="javascript:;">一步一脚印 ，贵在坚持..</a>
				</div>
			</section>
			<section class="card">
				<h4>分类</h4>
				<ul>
                    <?php foreach ($categorys as $cid=>$category) {
                            if ($cid == 0) {
                                $url = Url::base(true);
                            } else {
                                if ($category['pid'] == 0) {
                                    $url = 'javascript:void(0);';
                                }else {
                                    $url = Url::to(['index', 'cid' => $cid]);
                                }
                            }
                    ?>
					<li>
						<a href="<?=$url?>"><?=$category['labelName']?></a>
					</li>
                    <?php }?>
				</ul>
			</section>

			 <section class="card">
				<h4>热门文章</h4>
				<ul>
                    <?php foreach($hotArticles as $article) {?>
					<li style="overflow:hidden;white-space: nowrap;text-overflow: ellipsis;">
						<a href="<?=Url::to(['article', 'id' => $article['id']])?>"><?=$article['title']?></a>
					</li>
                    <?php }?>
				</ul>
			</section>
	</aside>
	</div>
</div>