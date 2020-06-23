@include('layout/admin_top')
    <link href="<?php echo resource('css/user.css')?>" rel="stylesheet" type="text/css">
    <div class="content-box">
        <div class="user_list">
            <h6>用户列表</h6>
            <!--
            <div class="search-box">
                <a class="add-user-button" href="<?php echo url('/user/add/view')?>">添加用户</a>
                <input class="search-input" type="text" name="keyword" value="<?php echo $keyword?>" placeholder="请输入关键词，按回车键搜索" onkeydown="onSearch(event)">
                <select class="search-type" name="search_type" onchange="onSearch({keyCode:13})">
                    <?php foreach ($search_item as $key=>$value):?>
                    <option <?php echo $key == $search_type ? 'selected' : '' ?> value="<?php echo $key?>"><?php echo $value?></option>
                    <?php endforeach;?>
                </select>
            </div>
            -->
            <table>
                <tr>
                    <td width="100px">昵称</td>
                    <td width="150px">账号</td>
                    <td>公司</td>
                    <td width="140px">分销公司</td>
                    <td width="120px">电话</td>
                    <td width="150px">设备ID</td>
                    <td width="100px">版本</td>
                    <td width="120px">注册日期</td>
                    <td width="100px">操作</td>
                </tr>

                <?php foreach ($user_list as $list):?>
                    <tr>
                        <td><?php echo $list['name']?></td>
                        <td><?php echo $list['user']?></td>
                        <td><?php echo $list['company']?></td>
                        <td><?php echo $list['distribution_company']?></td>

                        <td><?php echo $list['tel']?></td>
                        <td><?php echo $list['device_id']?></td>
                        <td><?php echo $list['device_version']?></td>
                        <td><?php echo $list['register_time']?></td>
                        <td>
                            <a href="<?php echo url('/user/add/view&id='.base64_encode($list['id']))?>">编辑</a>&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;<a href="<?php echo url('/user/del/data&id='.base64_encode($list['id']).$search.'&page='.$page.'&rows='.$rows)?>">删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
            <?php echo \app\Lib\Page::createPageView($page, $page_all, url('/user/lists/view'.$search))?>
        </div>
    </div>
    <script type="text/javascript">
        function onSearch(event) {
            //console.log(event);
            if(event.keyCode == 13){
                var keyword = $("input[name='keyword']").val();
                var search_type = $("select[name='search_type']").val();

                var url = '<?php echo url('/user/lists/view')?>&keyword='+keyword+'&search_type='+search_type;
                //console.log(url);
                window.location.href = url;

            }
        }
    </script>
@include('layout/admin_bottom')
