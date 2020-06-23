<?php layout('/layout/admin_top')?>

        <link href="<?php echo resource('css/feedback.css')?>" rel="stylesheet" type="text/css">
        <div class="content-box">
            <h2>用户反馈调查</h2>
            <p class="error-info">您的支持，是我们前进中最大的动力！</p>
            <form action="<?php echo url('/add/feedback/item')?>" method="post" onsubmit="return validate()">
                <table>

                    <tr>
                        <td>&nbsp; 来源公司：</td>
                        <td><input type="text" value="<?php echo $source?>" readonly="readonly"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp; 系统版本：</td>
                        <td><input type="text" value="<?php echo $version?>" readonly="readonly"/></td>
                    </tr>
                    <tr>
                        <td width="80px">* 反馈类型：</td>
                        <td>
                            <select name="type">
                                <option value="0">请选择</option>
                                <option value="1">问题或BUG</option>
                                <option value="2">意见或建议</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>* 主题内容：</td>
                        <td><input type="text" name="title"/></td>
                    </tr>

                    <tr>
                        <td>* 详细描述：</td>
                        <td >
                            <div id="editor_toolbar" class="editor_toolbar"></div>
                            <div id="editor_content" class="editor_content"></div>
                        </td>
                    </tr>
                </table>
                <textarea id="describe" name="describe" style="display: none"></textarea>
                <input type="hidden" name="version" value="<?php echo $version?>">
                <input type="hidden" name="source" value="<?php echo $source?>">
                <input type="submit" value="提交">
            </form>
        </div>

        <!--<script src="https://unpkg.com/wangeditor/release/wangEditor.min.js" type="text/javascript"></script>-->
        <script src="<?php echo resource('/js/release/wangEditor.min.js')?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var h = $(window).height();
                $("#panel").height(h - 2 + "px");
                $("#editor_content").css("height", h-430 + "px");
            });

            var $text1 = $('#describe');
            var E = window.wangEditor;
            var editor = new E('#editor_toolbar','#editor_content');

            editor.customConfig.uploadImgServer = '<?php echo url('/upload/image')?>';
            editor.customConfig.uploadImgMaxLength = 10;
            editor.customConfig.uploadImgMaxSize = 2 * 1024 * 1024;
            editor.customConfig.onchange = function (html){$text1.val(html)}

            editor.create();


            function validate() {
                var value = $('select[name="type"]').val();
                if(value == '0'){
                    alert('请选择反馈类型！');
                    return false;
                }

                value = $('input[name="title"]').val();
                if (value == ''){
                    alert('请填写主题内容！');
                    return false;
                }
            }
        </script>
<?php layout('/layout/admin_bottom')?>
