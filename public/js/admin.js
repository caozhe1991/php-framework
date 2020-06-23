/**
 * Created by cz on 2019/9/17.
 */
function Message(id, message, color) {
    if (typeof color != "string"){
        color = "#000";
    }
    var html = `<div style="position: absolute; left: 50%; top:50%; transform: translate(-50%, -50%);padding: 20px 40px; border: 1px solid #d0d0d0;border-radius: 10px;background-color: #ffffff"">
<p style="text-align: center; white-space: nowrap; color: `+ color +`">`+ message +`</p>
<a href="javascript:void(0);" style="display: block;text-align: center; margin-top: 12px;" onclick="DelElement('` + id + `')">确定</a>
</div>`;

    var mask = document.getElementById(id);
    if (mask == undefined || mask == null){
        throw "id '" + id + "' not existent";
    }

    mask.innerHTML = html;
}

function Save(url, app) {
    var mask_id = Mask();
    Loading(mask_id, "正在处理，请稍后...");
    var data = getValue(app);
    $.ajax({
        url : url,
        data: data,
        method: "POST",
        dataType:"json",
        error: function () {
            Message(mask_id, "提交失败！");
        },

        success: function (result) {
            if(result.status == 1 || result.status == "1"){
                if(result.message == "success" || result.message == ""){
                    Message(mask_id, "操作成功！");
                }else{
                    Message(mask_id, result.message);
                }
            }else {
                Message(mask_id, "失败：" + result.message, "#E86C1A");
            }
        }
    });
}

function Loading(id, message) {
    var html = `<div style="position: absolute; left: 50%; top:50%; transform: translate(-50%, -50%); vertical-align:middle;padding: 20px 40px; border: 1px solid #d0d0d0; border-radius: 10px;background-color: #ffffff">
<img style="float: left" src="/image/loading.gif" />
<span style="display: block;line-height: 32px; float: left; margin-left: 12px;">` + message + `</span>
</div>`;

    var mask = document.getElementById(id);
    if (mask == undefined || mask == null){
        throw "id '" + id + "' not existent";
    }

    mask.innerHTML = html;
}


function Mask() {
    var body = document.getElementsByTagName("body");
    var div = document.createElement("div");
    var number = Math.ceil(Math.random() * 10000000);
    div.id = "mask_" + number;
    div.style.position = "absolute";
    div.style.width = "100%";
    div.style.height = "100%";
    div.style.left = "0px";
    div.style.top = "0px";
    div.style.backgroundColor = "rgba(220,220,220,0.6)";
    div.style.zIndex = "1000";
    body[0].appendChild(div);
    return div.id;
}

function DelElement(id) {
    var obj = document.getElementById(id)
    if (obj == undefined || obj == null ){
        throw "id '" + id + "' not existent";
    }

    obj.parentElement.removeChild(obj);
}

function getValue(vue) {
    var data = {};
    for (var key in vue.$data){
        data[key] = vue.$data[key];
    }
    return data;
}

function pagination(param) {
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
