/**
 * Created by cz on 2019/9/17.
 */

window.Wtm = {
    COLOR_FAILED : "#E86C1A",

    /**
     * 创建遮罩消息
     * @param id        必须，遮罩层ID，可由mask()创建
     * @param message   必须，提示消息
     * @param color     可选，消息颜色
     */
    message : function(id, message, color) {
        if (typeof color != "string"){
            color = "#000";
        }
        var html = `<div style="position: absolute; left: 50%; top:50%; transform: translate(-50%, -50%);padding: 20px 40px; border: 1px solid #d0d0d0;border-radius: 10px;background-color: #ffffff"">
    <p style="text-align: center; white-space: nowrap; color: `+ color +`">`+ message +`</p>
    <a href="javascript:void(0);" style="display: block;text-align: center; margin-top: 12px;" onclick="Wtm.delElement('` + id + `')">确定</a>
    </div>`;

        var mask = document.getElementById(id);
        if (mask == undefined || mask == null){
            throw "id '" + id + "' not existent";
        }

        mask.innerHTML = html;
    },

    /**
     * 向指定地址提交数据（POST）
     * @param url       必须，数据提交地址
     * @param data      必须，提交的数据
     * @param callback  可选，提交成功回调
     */
    save:function (url, data, callback) {
        var mask_id = this.mask();
        this.loading(mask_id, "正在处理，请稍后...");

        var self = this;
        $.ajax({
            url : url,
            data: data,
            method: "POST",
            dataType:"json",
            error: function () {
                self.message(mask_id, "提交失败！");
            },

            success: function (result) {
                if(result.status == 1 || result.status == "1"){
                    if(result.message == "success" || result.message == ""){
                        self.message(mask_id, "操作成功！");
                    }else{
                        self.message(mask_id, result.message);
                    }
                }else {
                    self.message(mask_id, "失败：" + result.message, this.COLOR_FAILED);
                }

                if (typeof callback == "function"){
                    callback(result);
                }
            }
        });
    },


    /**
     * 创建Loading遮罩
     * @param id        必须，遮罩层ID，可由mask()创建
     * @param message   可选，提示消息
     */
    loading:function(id, message) {
        if(message == undefined)
            message = "正在处理，请稍后...";
        var html = `<div style="position: absolute; left: 50%; top:50%; transform: translate(-50%, -50%); vertical-align:middle;padding: 20px 40px; border: 1px solid #d0d0d0; border-radius: 10px;background-color: #ffffff"><img style="float: left" src="/image/loading.gif" /><span style="display: block;line-height: 32px; float: left; margin-left: 12px;">` + message + `</span></div>`;
        var mask = document.getElementById(id);
        if (mask == undefined || mask == null){
            throw "id '" + id + "' not existent";
        }

        mask.innerHTML = html;
    },

    /**
     * 创建进度条
     * @param title
     */
    progress:function(title){
        if(title == undefined)
            title = "请稍等...";

        let mask_id = this.mask();

        let div = document.createElement("div");
        div.className = "wtm-progress";

        let span_box = document.createElement("span");
        span_box.className = "wtm-progress-box";

        let span_bar = document.createElement("span");
        span_bar.className = "wtm-progress-bar";

        let span_number = document.createElement("span");
        span_number.className = "wtm-progress-num";
        span_number.innerText = "0%";

        let p = document.createElement("p");
        p.innerText = title;

        span_box.appendChild(span_bar);
        span_box.appendChild(span_number);

        div.appendChild(span_box);
        div.appendChild(p);
        document.getElementById(mask_id).appendChild(div);

        return {
            set:function(value) {
                if(value < 0) value = 0;
                if(value > 100) value = 100;
                span_bar.style.width = value + "%";
                span_number.innerText = value + "%";
            },
            close: function () {
                Wtm.delElement(mask_id);
            }
        }
    },

    /**
     * 创建一个遮罩层，返回遮罩层DOM id
     * @returns {string}
     */
    mask:function() {
        var body = document.getElementsByTagName("body");
        var div = document.createElement("div");
        var number = Math.ceil(Math.random() * 10000000);
        div.id = "mask_" + number;
        div.style.position = "fixed";
        div.style.width = "100%";
        div.style.height = "100%";
        div.style.left = "0px";
        div.style.top = "0px";
        div.style.backgroundColor = "rgba(220,220,220,0.6)";
        div.style.zIndex = "1000";
        body[0].appendChild(div);
        return div.id;
    },

    /**
     * 删除一个DOM元素
     * @param id 必须，要删除的元素ID
     */
    delElement:function(id) {
        var obj = document.getElementById(id);
        if (obj == undefined || obj == null ){
            throw "id '" + id + "' not existent";
        }
        obj.parentElement.removeChild(obj);
    },


    /**
     * 打开一个带提交数据的内置窗口（GET）
     * @param param 必选，对象，包含属性如下：
     *  url      必选，加载窗口的地址
     *  title    可选，窗口标题，默认“窗口”
     *  width    可选，窗口宽度，不包含外边框2px，默认“320px”
     *  file     可选，from表单中是否包含文件需要上传
     *  success  可选，点击窗口内置“确定”后，服务器返回的回调函数，内置简易提醒
     */
    window : function (param) {
        if(typeof param.url == "undefined")
            throw "URL not null";
        if(typeof param.title == "undefined")
            param.title = "窗口";
        if(typeof param.success == "undefined")
            param.success = function (result) {  };
        if(typeof param.width == "undefined")
            param.width = "320px";
        if(typeof param.file == "undefined")
            param.file = false;

        let mask_id = this.mask();

        function ok() {
            Wtm.submitForm(mask_id, undefined, function (result, data) {
                if(result.status == 1 || result.status == "1"){
                    Wtm.delElement(mask_id);
                    param.success(result, data);
                }
            }, param.file, false);
        }

        function cancel(){
            Wtm.delElement(mask_id);
        }

        let div1 =  document.createElement("div");
        let div2 =  document.createElement("div");
        let div3 =  document.createElement("div");
        let h2 = document.createElement("h2");
        let a1 = document.createElement("a");
        let a2 = document.createElement("a");


        div1.style.width = param.width;
        div1.className = "js-window";

        h2.innerText = param.title;
        h2.className = "window-title";

        a1.onclick = ok;
        a1.href = "javascript:void(0);";
        a1.innerText = "确定";
        a1.className = "window-button";

        a2.onclick = cancel;
        a2.href = "javascript:void(0);";
        a2.innerText = "取消";
        a2.className = "window-button";

        div3.style.textAlign="center";
        div3.style.margin="12px 0";
        div3.appendChild(a1);
        div3.appendChild(a2);

        this.loading(mask_id, "正在加载，请稍后...");

        var self = this;
        $.ajax({
            url : param.url,
            method: "GET",
            dataType:"html",
            error: function () {
                self.message(mask_id, "打开窗口失败！");
            },

            success: function (result) {
                div2.innerHTML = result;
                div1.appendChild(h2);
                div1.appendChild(div2);
                div1.appendChild(div3);
                $("#"+mask_id).html(div1);
            }
        });
    },

    /**
     * 将表单中所有数据提交到指定地址（POST）
     * @param id    必须，form的父标签ID
     * @param url   可选，如果提供本参数，则将数据提交至当前URL，否则提交至form中action指定的URL
     * @param callback  可选，回调函数，参数1：服务器返回的数据；参数2：提交的数据
     * @param file  可选，是否上传文件
     */
    submitForm: function (id, url, callback, file, successMessage) {
        let process = true;
        let content = "application/x-www-form-urlencoded";
        let data    = '';
        let form = $("#"+id+" form");
        if (file === true){
            process = false;
            content = false;
            data = new FormData(document.getElementById(id).getElementsByTagName('form')[0]);
        }else{
            data = form.serialize();
        }

        if(url == undefined)
            url = form.attr("action");

        let self = this;
        let mask_id = this.mask();
        this.loading(mask_id, "正在处理，请稍后...");

        $.ajax({
            url : url,
            method: "POST",
            data : data,
            dataType: "json",
            processData: process,
            contentType: content,
            error: function () {
                self.message(mask_id, "提交失败！");
            },
            success: function (result) {
                if(result.status == 1 || result.status == "1"){
                    // 某中情况下不需要提示成功消息
                    if(successMessage !== false){
                        if(result.message == "success" || result.message == ""){
                            self.message(mask_id, "操作成功！");
                        }else{
                            self.message(mask_id, result.message);
                        }
                    }else {
                        Wtm.delElement(mask_id);
                    }
                }else {
                    self.message(mask_id, "失败：" + result.message, this.COLOR_FAILED);
                }

                if (typeof callback == "function"){
                    callback(result, form.serializeArray());
                }
            }
        });
    },

    pagination: function (param) {
        if (typeof param.total == "undefined")
            throw new Error("total not null");
        if(typeof param.click == "undefined")
            throw new Error("onclick not null");
        if(typeof param.parentID == "undefined")
            throw new Error("parentID not null");

        if (typeof param.rows == "undefined")
            param.rows = 12;
        if (typeof param.page == "undefined")
            param.page = 1;


        let page_all = Math.ceil(param.total / param.rows);
        let start = 1;
        let end = page_all;

        if(page_all > 9){
            start = param.page > 4 ? param.page - 4 : 1;
            end   = page_all > 9 ? param.page + 4 : 9;
        }

        console.log(start, end);
        let ul = document.createElement("ul");
        for (let i = start; i <= end; i++){
            let li = document.createElement("li");
            let a  = document.createElement("a");
            a.href = "javascript:void(0);";
            a.onclick = function(){ param.click(i); };
            a.innerText = i.toString();
            if(i == param.page)
                a.className = "on";
            li.appendChild(a);
            ul.appendChild(li);
        }

        let parent_dom = document.getElementById(param.parentID);
        parent_dom.innerHTML = '';
        parent_dom.appendChild(ul);
    }




};


window.Format = {
    formats :function (items, events) {
        console.log(items);
        for(let key in events){
            if(items instanceof Array){
                for(let i=0, len = items.length; i < len; i++){
                    if(typeof items[i][key] !== "undefined"){
                        items[i][key] = eval("Format." + events[key] + "('" + items[i][key] + "')");
                    }
                }
            }else {
                if(typeof items[key] !== "undefined"){
                    items[key] = eval("Format." + events[key] + "('" + items[key] + "')");
                }
            }
        }

        console.log(items);
        return items;
    },

    /**
     * 将字符串转换到整型
     * @param str
     * @returns {number}
     */
    str2Int: function (str) {
        return Number(str);
    },

    /**
     * 将布尔型转换到整型
     * @param v
     * @returns {number}
     */
    bool2Int: function (v) {
        if(v == "false" || v == false)
            return 0;
        else
            return 1;
    },

    dateTime2Date: function (dt) {
        let t = new Date(dt);
        return this.date("yyyy-MM-dd", t);
    },

    dateTime2Time: function(dt){
        let t = new Date(dt);
        return this.date("hh:mm:ss", t);
    },

    toObject: function (arrays) {
        let data = new Object();
        for(let i=0, max=arrays.length; i<max; i++){
            data[arrays[i].name] = arrays[i].value;
        }
        return data;
    },

    date : function (fmt, t) {
        if(t == undefined)
            t = new Date();

        var o = {
            "M+" : t.getMonth()+1,                    //月份
            "d+" : t.getDate(),                       //日
            "h+" : t.getHours(),                      //小时
            "m+" : t.getMinutes(),                    //分
            "s+" : t.getSeconds(),                    //秒
            "q+" : Math.floor((t.getMonth()+3)/3), //季度
            "S"  : t.getMilliseconds()                //毫秒
        };
        if(/(y+)/.test(fmt))
            fmt=fmt.replace(RegExp.$1, (t.getFullYear()+"").substr(4 - RegExp.$1.length));
        for(var k in o)
            if(new RegExp("("+ k +")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        return fmt;
    }
};