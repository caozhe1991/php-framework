<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>用户自助注册</title>
        <link href="<?php echo resource('css/reset.css')?>" rel="stylesheet" type="text/css"">
        <link href="<?php echo resource('css/user.css')?>" rel="stylesheet" type="text/css"">
    </head>

    <body>
        <div style="width: 550px;margin: 100px auto;">
            <h1 style="font-size: 24px; color: #4c4c4c;text-align: center;margin-bottom: 20px;font-weight: bolder">用户反馈系统</h1>
            <div class="add-user">
                <h6>请完善您的个人信息！</h6>
                <form action="<?php echo url('/self/user/add/date')?>" method="post" enctype="multipart/form-data">
                     <table>
                         <tr>
                            <td width="120px">头像：</td>
                            <td><input type="file" name="portrait" value=""/></td>
                         </tr>
                         <tr>
                             <td>* 您的姓名：</td>
                             <td><input type="text" autocomplete="off" name="param[name]" value="<?php echo $param['name']?>"/></td>
                         </tr>
                         <tr>
                             <td>* 所在公司：</td>
                             <td><input type="text" autocomplete="off" name="param[company]" value="<?php echo $param['company']?>"/></td>
                         </tr>
                         <tr>
                            <td>账号：</td>
                            <td><input type="text" autocomplete="off" name="param[user]" value="<?php echo $param['user']?>"/></td>
                         </tr>
                         <tr>
                            <td>密码：</td>
                            <td><input type="password" name="param[password]" value="<?php echo $param['password']?>"/></td>
                         </tr>
                         <tr>
                            <td>电话：</td>
                            <td><input type="text" autocomplete="off" name="param[tel]" value="<?php echo $param['tel']?>"/></td>
                         </tr>
                         <tr>
                            <td>邮箱：</td>
                            <td><input type="text" autocomplete="off" name="param[email]" value="<?php echo $param['email']?>"/></td>
                         </tr>
                     </table>
                     <p><?php echo empty($message) ? '' : $message ?></p>
                     <input type="hidden" name="param[device_id]" value="<?php echo $param['device_id']?>">
                     <input type="hidden" name="param[device_version]" value="<?php echo $param['device_version']?>">
                     <input type="hidden" name="param[distribution_company]" value="<?php echo $param['distribution_company']?>">
                     <div class="add-user-btn"><input type="submit" value="提交"></div>
                </form>
            </div>
        </div>
    </body>
</html>