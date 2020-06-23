<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <script src="<?php echo resource('js/jquery-3.2.1.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo resource('js/vue.js')?>" type="text/javascript"></script>
    <link href="<?php echo resource('css/reset.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo resource('css/mobile.css')?>" rel="stylesheet" type="text/css">
    <script src="<?php echo resource('js/admin.js')?>" type="text/javascript"></script>
    <style>
        .panel-description {position: absolute;width: 100%; height: 100%; top:0; left: 0; background-color:#ffffff; z-index: 3; transition: left 0.5s;}
        .panel-description .content-box{margin: 0 1rem;}
        .panel-description h2{margin-top: 2.5rem;text-align: center; font-size: 1.2rem}
        .panel-description p{line-height: 1.5rem;margin-top: 0.5rem; font-size: 0.8rem;}

        .panel-form {position: absolute;width: 100%; height: 100%; top:0; left: 0; background-color:#ffffff; z-index: 2}
        .panel-form div{margin: 2rem 1rem 0;}
    </style>
</head>
<body>
    <div id="__vue_app">
        <div class="panel-description" id="panel-description">
            <div class="content-box">
                <h2>激活说明</h2>
                <p>本公司不会向任何无关第三方提供、出售、出租、分享或交易您的个人信息，除非事先得到您的许可。亦不允许任何第三方以任何手段收集、编辑、出售或者无偿传播您的个人信息。</p>
                <p> 1. 点击“我已了解”，进入填表。<br />
                    2. 带 * 号选项为必填项<br />
                    3. 填写完毕，点击提交可获取到激活KEY。请妥善保管<br />
                    4. 在您扫码的下方，点击“进入系统”。登录后选择<span style="color: red">【系统管理>>产品激活】</span>，输入您的KEY，完成激活。<br />
                </p>
                <a style="margin-top: 2rem" class="link-button" href="javascript:void(0)" v-on:click="next">我已了解</a>
            </div>
        </div>
        <div class="panel-form">
            <div>
                <table class="input-form-two">
                    <tr>
                        <td>
                            <label>产品标识：</label>
                            <input type="text" disabled="disabled" v-model="product_id">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><span style="color: red"> * </span>公司名称：</label>
                            <input type="text" v-model="company">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><span style="color: red"> * </span>联系人：</label>
                            <input type="text" v-model="contact">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><span style="color: red"> * </span>手机：</label>
                            <input type="text" v-model="phone">
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td>
                            <label>电话：</label>
                            <input type="text" v-model="tel">
                        </td>
                    </tr>
                    -->
                    <tr>
                        <td>
                            <label>电子邮箱：</label>
                            <input type="text" v-model="email">
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td>
                            <label>实施人：</label>
                            <input type="text" v-model="staff">
                        </td>
                    </tr>
                    -->
                </table>

                <a style="margin-top: 2rem" href="javascript:void(0);" class="link-button" v-on:click="submit_form">提交</a>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    new Vue({
        el: "#__vue_app",
        data:{
            product_id:"{{ $product_id }}",
            company:"",
            contact:"",
            phone:"",
            tel:"",
            email:"",
            staff:"",
            token:"{{ ~$token }}",
        },

        methods:{
            next: function () {
                var div = document.getElementById("panel-description");
                if (div == undefined || div == null)
                    return;

                var width = div.clientWidth;
                div.style.left = (0 - width) + "px";
            },

            submit_form: function () {
                var url = "@url('/device-activation');";
                Save(url, this);
            }
        }

    })


</script>

</html>