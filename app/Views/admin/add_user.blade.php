<?php layout('layout/admin_top');?>
    <link href="<?php echo resource('css/user.css')?>" rel="stylesheet" type="text/css">
    <div class="content-box">
        <div class="add-user">
            <h6>添加用户</h6>
            <form action="<?php echo url('/user/add/date')?>" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>头像：</td>
                        <td><input type="file" name="portrait" value="<?php echo $user_info['portrait']?>"/></td>
                    </tr>
                    <tr>
                        <td>类别：</td>
                        <td>
                            <input type="radio" name="param[type]" value="2" <?php echo $user_info['type'] == 2 ? 'checked':'' ?>> 普通用户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="param[type]" value="1" <?php echo $user_info['type'] == 1 ? 'checked':'' ?>> 管理员
                        </td>
                    </tr>
                    <tr>
                        <td>分销公司：</td>
                        <td><input type="text" autocomplete="off" name="param[distribution_company]" value="<?php echo $user_info['distribution_company']?>"/></td>
                    </tr>
                    <tr>
                        <td>账号：</td>
                        <td><input type="text" autocomplete="off" name="param[user]" value="<?php echo $user_info['user']?>"/></td>
                    </tr>
                    <tr>
                        <td>密码：</td>
                        <td><input type="password" name="param[password]" value="<?php echo $user_info['password']?>"/></td>
                    </tr>
                    <tr>
                        <td>客户姓名：</td>
                        <td><input type="text" autocomplete="off" name="param[name]" value="<?php echo $user_info['name']?>"/></td>
                    </tr>
                    <tr>
                        <td>客户公司：</td>
                        <td><input type="text" autocomplete="off" name="param[company]" value="<?php echo $user_info['company']?>"/></td>
                    </tr>
                    <tr>
                        <td>设备ID：</td>
                        <td><input type="text" autocomplete="off" name="param[device_id]" value="<?php echo $user_info['device_id']?>"/></td>
                    </tr>
                    <tr>
                        <td>设备版本：</td>
                        <td><input type="text" autocomplete="off" name="param[device_version]" value="<?php echo $user_info['device_version']?>"/></td>
                    </tr>
                    <tr>
                        <td>客户电话：</td>
                        <td><input type="text" autocomplete="off" name="param[tel]" value="<?php echo $user_info['tel']?>"/></td>
                    </tr>
                    <tr>
                        <td>客户邮箱：</td>
                        <td><input type="text" autocomplete="off" name="param[email]" value="<?php echo $user_info['email']?>"/></td>
                    </tr>

                </table>
                <p><?php echo empty($message) ? '' : $message ?></p>
                <input type="hidden" name="param[id]" value="<?php echo $user_info['id']?>">
                <div class="add-user-btn"><input type="submit" value="提交"></div>
            </form>
        </div>
    </div>
<?php layout('layout/admin_bottom')?>