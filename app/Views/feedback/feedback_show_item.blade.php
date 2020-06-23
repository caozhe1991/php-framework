<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户反馈中心</title>
    <link href="<?php echo resource('css/feedback.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo resource('css/reset.css')?>" rel="stylesheet" type="text/css">
    <script src="<?php echo resource('js/jquery-3.2.1.min.js')?>" type="text/javascript"></script>
    </head>

    <body>
        <div class="show-item-panel">
            <div class="item-head clearfix">
                <div class="item-head-left">
                    <img src="<?php echo resource($users['user']['portrait'])?>" onerror="this.style.display='none'">
                    <img src="<?php echo resource($users['admin']['portrait'])?>" onerror="this.style.display='none'">
                </div>
                <div class="item-head-right">
                    <span><?php echo $users['user']['name']?> & <?php echo $users['admin']['name']?></span><a href="#">更多帮助</a>
                    <p><?php echo $feedback['title']?></p>
                </div>
            </div>

            <div class="item-body">
                <ul>
                    <!-- 反馈主体 -->
                    <li class="item-body-list clearfix">
                        <p class="item-body-time"><span><?php echo $feedback['create_time']?></span></p>
                        <div>
                            <img class="item-body-left-tx" src="<?php echo resource($users['user']['portrait'])?>">
                            <div class="item-body-left-xx">
                                <?php echo $feedback['describe']?>
                            </div>
                        </div>
                    </li>
                    <!-- 输入对话内容 -->
                    <?php foreach ($replys as $reply):?>
                        <li class="item-body-list clearfix">
                            <p class="item-body-time"><span><?php echo $reply['reply_time']?></span></p>
                            <div>
                                <img class="item-body-<?php echo $reply['direction'] == '0' ? 'right' : 'left' ?>-tx"
                                     src="<?php echo resource($reply['direction'] == '0' ? $users['admin']['portrait'] : $users['user']['portrait'])?>"
                                >
                                <div class="item-body-<?php echo $reply['direction'] == '0' ? 'right' : 'left' ?>-xx">
                                    <?php echo $reply['reply_content']?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <!-- 判断是否已完成 -->
            <?php if($feedback['status'] == '0'):?>
                <div class="editor">
                    <div id="editor"></div>
                </div>
                <div class="btn-submit">
                    <a href="javascript:;" onclick="submitReply()">提交</a>
                </div>
                <div class="bottom">
                    <p>* 感谢您的支持与建议，如问题已经解决，请点击<a href="javascript:;" onclick="submitSetOver()">完成</a>。</p>
                </div>
            <?php else:?>
                <div class="bottom-over">
                    <!--<p>该反馈信息已经完成。</p>-->
                    <span><?php echo $feedback['over_time']?></span>
                </div>
            <?php endif;?>
            <input type="hidden" id="fid" value="<?php echo $feedback['id']?>">
        </div>

    </body>
    <script src="<?php echo resource('/js/release/wangEditor.min.js')?>" type="text/javascript"></script>
    <script type="text/javascript">
        var E = window.wangEditor;
        var editor = new E('#editor');

        editor.customConfig.uploadImgServer = '<?php echo url('/upload/image')?>';
        editor.customConfig.uploadImgMaxLength = 10;
        editor.customConfig.uploadImgMaxSize = 2 * 1024 * 1024;

        editor.create();


        function submitReply() {
            var html =  editor.txt.html()
            var fid = $("#fid").val();
            var url = "<?php echo url('/add/feedback/reply')?>";
            var data = {"fid":fid, 'reply_content':html}
            $.post(url,data,function (e) {
                alert(e.msg);
                if(e.code == 1){
                    location.reload();
                }
            },"json")
        }

        function submitSetOver() {
            var url = "<?php echo url('/set/feedback/over&fid='.$feedback['id'])?>";
            $.get(url,function (e) {
                alert(e.msg);
                if(e.code == 1){
                    location.reload();
                }
            },"json")
        }
    </script>
</html>