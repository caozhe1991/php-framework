@include('layout/admin_top')
<div class="content-box">
    <div class="dai-jie-jue">
        <h6>待处理的</h6>
        <table>
            <thead>
                <tr>
                    <th width="150px">反馈用户</th>
                    <th style="text-align: left">主题内容</th>
                    <th width="100px">反馈类型</th>
                    <th width="100px">系统版本</th>
                    <th width="100px">回复状态</th>
                    <th width="120px">创建时间</th>
                    <th width="80px">操作</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($items as $item):?>
                <tr class="on-mouse-move">
                    <td><?php echo $item['source']?></td>
                    <td style="text-align: left"><?php echo $item['title']?></td>
                    <td><?php echo $type[$item['type']]?></td>
                    <td><?php echo $item['version']?></td>
                    <td><?php echo $reply_status[$item['reply_status']]?></td>
                    <td><?php echo $item['create_time']?></td>
                    <td><a target="_blank" href="<?php echo url('/show/feedback/item&id='.base64_encode($item['id']))?>">查看</a></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php echo \app\Lib\Page::createPageView($page, $page_all, url('/'))?>
    </div>
    <div class="dai-jie-jue" style="margin-top: 20px;">
        <h6>统计图表</h6>
        <div style="height: 300px;">

        </div>

    </div>
</div>

<script type="text/javascript">



</script>


@include('layout/admin_bottom')
