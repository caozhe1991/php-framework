<html>
    <head>
        <meta charset="utf-8">
        <title>用户反馈系统 V1.0</title>
        <link href="<?php echo resource('css/reset.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo resource('css/user.css')?>" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div style="width: 360px;margin: 150px auto;">
            <h2 style="font-size: 22px;text-align: center;color: #4c4c4c;margin-bottom: 20px;">登录用户反馈系统</h2>
            <div class="add-user">
                <h6>用户信息</h6>
                <form action="<?php echo url('/login/auth')?>" method="post">
                    <table>
                        <tr>
                            <td width="100px">账号：</td>
                            <td><input type="text" name="user" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>密码：</td>
                            <td> <input type="password" name="password"></td>
                        </tr>
                    </table>
                    <div class="add-user-btn" style="width: 120px;height: 32px;margin: 20px auto"><input type="submit" value="提交"></div>
                    <p><?php echo Session::getOnce('error')?></p>
                </form>
            </div>
        </div>
    </body>
</html>