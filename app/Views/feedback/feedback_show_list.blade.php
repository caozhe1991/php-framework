<?php layout('/layout/admin_top')?>
    <div class="content-box">
        <div class="dai-jie-jue">
            <h6>待处理的</h6>
            <table>
                <thead>
                <tr>
                    <th width="150px">反馈用户</th>
                    <th style="text-align: left">主题内容</th>
                    <th width="150px">反馈类型</th>
                    <th width="120px">创建时间</th>
                    <th width="100px">完成状态</th>
                    <th width="100px">回复状态</th>
                    <th width="100px">操作</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($rows as $row):?>
                    <tr class="on-mouse-move">
                        <td><?php echo $row['source']?></td>
                        <td style="text-align: left"><?php echo $row['title']?></td>
                        <td><?php echo $obj->TYPE[$row['type']]?></td>
                        <td><?php echo $row['create_time']?></td>
                        <td><?php echo $obj->STATUS[$row['status']]?></td>
                        <td><?php echo $obj->REPLY[$row['reply_status']]?></td>
                        <td><a target="_blank" href="<?php echo url('/show/feedback/item&id='.base64_encode($row['id']))?>">查看</a></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <?php echo \app\Lib\Page::createPageView($page, $total, url('/show/feedback/list'))?>
    </div>

<?php layout('/layout/admin_bottom')?>
