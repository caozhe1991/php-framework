<?php layout('layout/admin_top');?>
<div class="content-box">
    <h6 class="title"><a href="<?php echo url('/devices-manage')?>">硬件授权管理</a>&gt;添加设备</h6>

    <div id="add-device-view">
        <table class="input-form-one">
            <tr>
                <td width="80px">产品标识：</td>
                <td><input type="text" v-model="product_id"></td>
            </tr>
            <tr class="disabled">
                <td>激活KEY：</td>
                <td>{{ key }}</td>
            </tr>
            <tr class="disabled">
                <td>激活日期：</td>
                <td>{{ time }}</td>
            </tr>
            <tr>

                <td>所属公司：</td>
                <td><input type="text" v-model="company"></td>
            </tr>
            <tr>

                <td>联系人：</td>
                <td><input type="text" v-model="contact"></td>
            </tr>
            <tr>

                <td>手机：</td>
                <td><input type="text" v-model="phone"></td>
            </tr>
            <tr>
                <td>电话：</td>
                <td><input type="text" v-model="tel"></td>
            </tr>
            <tr>
                <td>邮箱：</td>
                <td><input type="text" v-model="email"></td>
            </tr>
            <tr>
                <td>保修期：</td>
                <td>
                    <select v-model="warrant">
                        <option value="30">1月（30天）</option>
                        <option value="90">3月（90天）</option>
                        <option value="180">半年（180天）</option>
                        <option value="365">1年（365天）</option>
                        <option value="730">2年（730天）</option>
                    </select>
                </td>
            </tr>
            <tr class="disabled">
                <td>实施人：</td>
                <td>{{ staff }}</td>
            </tr>
            <tr class="disabled">
                <td>系统版本：</td>
                <td>{{ version }}</td>
            </tr>
            <tr class="disabled">
                <td>添加日期：</td>
                <td>{{ update_time }}</td>
            </tr>
        </table>

        <div style="margin-top: 32px;"><a class="submit-button" href="javascript:void(0);" v-on:click="submit">提交</a></div>
    </div>
</div>
<script type="text/javascript">
    var app = new Vue({
        el: "#add-device-view",
        data: {
            id:             "{{ ~$data['id'] }}",
            product_id :    "{{ ~$data['product_id'] }}",
            key :           "{{ ~$data['key'] }}",
            time :          "{{ ~$data['time'] }}",
            company:        "{{ ~$data['company'] }}",
            contact :       "{{ ~$data['contact'] }}",
            phone:          "{{ ~$data['phone'] }}",
            tel:            "{{ ~$data['tel'] }}",
            email:          "{{ ~$data['email'] }}",
            warrant:        "{{ ~$data['warrant'] }}",
            staff :         "{{ ~$data['staff'] }}",
            version:        "{{ ~$data['version'] }}",
            update_time:    "{{ ~$data['update_time'] }}",
        },

        methods:{
            submit:function () {
                var url = "@url('/devices-manage-add');";
                Save(url, this);
            }
        }
    });


</script>


<?php layout('layout/admin_bottom');?>
