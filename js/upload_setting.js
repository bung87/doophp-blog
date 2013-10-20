 setting={
fileInput:$('input[type=file]')[0],       //html file控件
dragDrop:$('input[type=file]').parent()[0],
 button:$('#uploadbtn')[0],      //提交按钮
 url:'{{rootUrl}}admin/attachment',     //ajax地址
 filter: function(files) {
    var arrFiles = [];
    for (var i = 0, file; file = files[i]; i++) {
        if (file.type.indexOf("image") == 0) {
            if (file.size >= 512000) {
                alert('您这张"'+ file.name +'"图片大小过大，应小于500k');
            } else {
                arrFiles.push(file);
            }
        } else {
            alert('文件"' + file.name + '"不是图片。');
        }
    }
    return arrFiles;
},
onSelect: function(files) {
    var html = '', i = 0;
    //等待载入gif动画
    $("#preview").html('<div class="upload_loading"></div>');
    var funAppendImage = function() {
        file = files[i];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                html = html + '<div id="uploadList_'+ i +'" class="upload_append_list"><p><strong>' + file.name + '</strong>'+
                    '<a href="javascript:" class="upload_delete" title="删除" data-index="'+ i +'">删除</a><br />' +
                    '<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="upload_image" /></p>'+
                    '<span id="uploadProgress_' + i + '" class="upload_progress"></span>' +
                '</div>';

                i++;
                funAppendImage();
            }
            reader.readAsDataURL(file);
        } else {
            //图片相关HTML片段载入
            $("#preview").html(html);
            if (html) {
                //删除方法
                $(".upload_delete").click(function() {
                    ZXXFILE.deleteFile(files[parseInt($(this).attr("data-index"))]);
                    return false;
                });
                //提交按钮显示
                $("#fileSubmit").show();
            } else {
                //提交按钮隐藏
                $("#fileSubmit").hide();
            }
        }
    };
    //执行图片HTML片段的载人
    funAppendImage();
},
  onDelete: function(file) {
    $("#uploadList_" + file.index).fadeOut();
},
 onDragOver: function() {
    $(this).addClass("upload_drag_hover");
},
 onDragLeave: function() {
    $(this).addClass("upload_drag_hover");
},
  onProgress: function(file, loaded, total) {
    var eleProgress = $("#uploadProgress_" + file.index), percent = (loaded / total * 100).toFixed(2) + '%';
    $( "#progressbar" ).progressbar({value: percent});
    //eleProgress.show().html(percent);
},
  onSuccess: function(file, response) {
    $("#uploadInf").append('<p>上传成功，图片地址是：'+ response + '</p>');
},
 onFailure: function(file) {
    $("#uploadInf").append("<p>图片" + file.name + "上传失败！</p>");
    $("#uploadImage_" + file.index).css("opacity", 0.2);
},
 onComplete: function() {
    //提交按钮隐藏
    $("#fileSubmit").hide();
    //file控件value置空
    $("#fileImage").val("");
    $("#uploadInf").append("<p>当前图片全部上传完毕，可继续添加上传。</p>");
}
};