@include('layout/admin_top')
<link href="<?php echo resource('css/user.css')?>" rel="stylesheet" type="text/css">
<div class="content-box">
    <h6 class="title">硬件授权管理</h6>
    <div class="menus-bar">

        <a class="link-button" href="<?php echo url('/devices-manage-add-view')?>">添加设备</a>
        <input class="search-input" type="text" id="keyword" name="keyword" placeholder="请输入关键词，按回车键搜索" onkeydown="onSearch(event)">
        <select class="search-type" id="keyword_type" name="keyword_type" onchange="onSearch({keyCode:13})">
            <option value="product_id">产品标识</option>
            <option value="company">公司名称</option>
        </select>
    </div>
    <div id="hardware-authorize-index">
        <table class="list">
            <thead>
                <tr>
                    <td width="60px">序号</td>
                    <td width="150px">产品标识</td>
                    <td>注册信息</td>
                    <td style="width: 150px; text-align: right; padding-right: 30px">服务周期</td>
                    <td width="60px">操作</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items">
                    <td>{{ index+1 }}</td>
                    <td><a :href='"@url("/devices-manage-add-view?id=");" + item.id'>{{ item.product_id }}</a></td>
                    <td>
                        <span style="display: inline-block; width:40px; text-align-last: justify;">{{item.contact}}</span>
                        <span style="display: inline-block; width:110px; text-align: center;">{{item.phone}}</span>
                        {{item.company}}
                    </td>
                    <td style="text-align: right; padding-right: 30px">{{item.time}}/{{item.warrant}}/天</td>
                    <td><a href="javascript:void(0);" v-on:click="del(index)">删除</a></td>
                </tr>
            </tbody>
        </table>
        <div class="pagination" id="pagination"></div>
    </div>
</div>

<script type="text/javascript">

    var DeviceAPP = new Vue({
        el: "#hardware-authorize-index",

        data:{
            href:  "abcd",
            items: [],
        },

        created: function () {
            this.loadList(1);
        },

        methods:{
            loadList: function (page) {
                var parent = this;
                var keyword = $("#keyword").val();
                var keyword_type = $("#keyword_type").val();
                $.post("<?php echo url('/devices-manage-list')?>",
                    {"page": page, "rows":12, "keyword": keyword, "keyword_type": keyword_type},
                    function (env) {
                        parent.items = env.rows;
                        if(env.total > 0){
                            pagination({total: env.total, page: page, click: parent.loadList, parentID: "pagination"});
                        }
                    },"json");
            },
            
            del: function (index) {
                var self = this;
                $.get("<?php echo url('/devices-manage-del')?>?id=" + this.items[index].id, function (response) {
                    if(response.status == 1){
                        self.$data.items.splice(index, 1);
                    }else{
                        alert(response.message);
                    }
                }, "json")
            }
        }
    });

    function onSearch(event){
        if(event.keyCode == 13){
            DeviceAPP.loadList(1)
        }
    }

</script>
@include('layout/admin_bottom')
