<?php
    use yii\helpers\Url;
?>
<link rel="stylesheet" href="<?=Url::base(true);?>/css/bluebox.css" />
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <!-- 内容 -->
        <div class="content">
            <article class="thread thread-card  article-nav">
                <a href="<?=Url::base(true);?>">首页</a> &gt; <a href="<?=Url::to(['site/index', 'cid' => $article['cid']])?>"><?=$article['cname']?></a> &gt; <span><?=$article['title']?></span>
            </article>
            <div class="card thread-card ps-parent">
                <div class="status-btn" id="i-like">赞<span><?=$article['up']?><span></div>
                <header class="page-header with-author">
                    <h2 style="padding-right:30px;"><?=$article['title']?></h2>
                    <div class="thread-meta">
                        <span class="article-info">作者：<?=$article['author']?></span>
                        <span class="article-info">&nbsp;更新时间：<time><?=date('Y-m-d', $article['update_date'])?></time></span>
                        <span class="article-info">&nbsp;浏览次数：<?=$article['count']?></span>
                    </div>
                </header>
                <div class="inner markdown-body">
                <!-- 内容-->
                <?=$article['content']?>
                <!-- 内容-->
                </div>
            </div>
        </div>
        <!-- 评论 -->
        <div class="card">
            <div class="comments">
                <div id="ds-thread" class="ds-thread">
                    <div id="ds-reset">
                        <!-- 评论回复框 -->
                        <div class="ds-replybox">
                            <a class="ds-avatar" href="javascript:void(0);">
                                <img src="<?=Url::base(true);?>/images/recomment.jpg" alt="smister">
                            </a>
                            <form method="post" class="comment-form">
                                <div class="ds-post-options ds-gradient-bg" style="margin-bottom:10px;">
                                    <input type="text" value="" placeholder="名称" id="name" class="ds-name" />
                                </div>
                                <div class="ds-textarea-wrapper ds-rounded-top">
                                    <textarea id="message" placeholder="亲 , 想评论必须先登录哦."></textarea>
                                    <pre class="ds-hidden-text"></pre>
                                </div>
                                <div class="ds-post-toolbar">
                                    <div class="ds-post-options ds-gradient-bg"><span class="ds-sync"></span></div>
                                    <button class="ds-post-button" type="button" id="submit-recomment">发布</button>
                                    <div class="ds-toolbar-buttons">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- 用户评论列表 -->
                        <div class="ds-comments-info">
                            <div class="ds-sort">
                                <a class="ds-order-desc ds-current" data="DESC">最新</a>
                            </div>
                            <ul class="ds-comments-tabs">
                                <li class="ds-tab">
                                    <a href="javascript:void(0);" class="ds-comments-tab-duoshuo ds-current">
                                        <span class="ds-highlight" id="recomment-count">0</span>条评论
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <ul id="comments-list" class="ds-comments">
<!--                            <li class="ds-post">-->
<!--                                <div data-source="duoshuo" class="ds-post-self">-->
<!--                                    <div class="ds-avatar">-->
<!--                                        <img alt="smister" src="http://qzapp.qlogo.cn/qzapp/101196234/CCF0E87444307C250B53A314957416F4/50">-->
<!--                                    </div>-->
<!--                                    <div class="ds-comment-body">-->
<!--                                        <div class="ds-comment-header">-->
<!--                                            <span data-qqt-account="" class="ds-user-name"><a class="ds-user-name ds-highlight">53Liu</a></span>-->
<!--                                        </div>-->
<!--                                        <p>sdf            </p>-->
<!--                                        <div class="ds-comment-footer ds-comment-actions">-->
<!--                                            <span class="ds-time">2016年02月17日 15:52:22</span>-->
<!--                                            <a href="javascript:void(0);" class="ds-post-reply" onclick="showComment(this);" data="3">-->
<!--                                            <span class="ds-icon ds-icon-reply"></span>回复                    </a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <ul class="ds-comments" style="padding-left:25px;">-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li class="ds-post">-->
<!--                                <div data-source="duoshuo" class="ds-post-self">-->
<!--                                    <div class="ds-avatar">-->
<!--                                        <img alt="smister" src="http://qzapp.qlogo.cn/qzapp/101196234/CCF0E87444307C250B53A314957416F4/50">-->
<!--                                    </div>-->
<!--                                    <div class="ds-comment-body">-->
<!--                                        <div class="ds-comment-header">-->
<!--                                            <span data-qqt-account="" class="ds-user-name"><a class="ds-user-name ds-highlight">53Liu</a></span>-->
<!--                                        </div>-->
<!--                                        <p>sdf            </p>-->
<!--                                        <div class="ds-comment-footer ds-comment-actions">-->
<!--                                            <span class="ds-time">2016年02月17日 15:52:22</span>-->
<!--                                            <a href="javascript:void(0);" class="ds-post-reply" onclick="showComment(this);" data="3">-->
<!--                                            <span class="ds-icon ds-icon-reply"></span>回复                    </a>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <ul class="ds-comments" style="padding-left:25px;">-->
<!--                                     <li class="ds-post">-->
<!--                                        <div data-source="duoshuo" class="ds-post-self">-->
<!--                                            <div class="ds-avatar">-->
<!--                                                    <img alt="smister" src="http://qzapp.qlogo.cn/qzapp/101196234/CCF0E87444307C250B53A314957416F4/50"/>-->
<!--                                            </div>-->
<!--                                            <div class="ds-comment-body">-->
<!--                                                <div class="ds-comment-header">-->
<!--                                                    <span data-qqt-account="" class="ds-user-name"><a class="ds-user-name ds-highlight">smister</a></span>-->
<!--                                                </div>-->
<!--                                                <p>-->
<!--                                                                我是子回复-->
<!--                                                </p>-->
<!--                                                <div class="ds-comment-footer ds-comment-actions">-->
<!--                                                        <span class="ds-time">2016年02月17日 15:52:22</span>-->
<!--                                                        <a href="javascript:void(0);" class="ds-post-reply" onclick="showComment(this);" data="' + jsonData['data'][dd]['commentData']  + '">-->
<!--                                                             <span class="ds-icon ds-icon-reply"></span>回复-->
<!--                                                        </a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
                        </ul>
                        <div id="cmpage" class="ds-paginator">
<!--                            <ul id="yw0" class="yiiPager">-->
<!--                                <li class="previous hidden"><a href="javascript:;">上一页</a></li>-->
<!--                                <li class="selected"><a href="javascript:;" onclick="ajaxData(this,0)" data="sort=DESC&amp;rid=29">1</a></li-->
<!--                                <li class="next hidden"><a href="javascript:;">下一页</a></li>-->
<!--                            </ul>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 评论 -->
    </div>
    </div>
</div>
<script type="text/javascript">
    var rid = '<?=$article['id']?>';
    var member_img = '<?=Url::base(true);?>/images/recomment.jpg';
    var load_img = '/common/images/loading_hor.gif';
    var globalUpUrl = '<?=Url::to(['site/up'])?>';
    var globalRecommentUrl = '<?=Url::to(['site/recomment'])?>';
    var globalCommentlistUrl = '<?=Url::to(['site/recomment-list'])?>';
</script>
<script type="text/javascript" src="<?=Url::base(true);?>/js/comment.js"></script>
<link rel="stylesheet" href="<?=Url::base(true);?>/css/article_detail.css" />