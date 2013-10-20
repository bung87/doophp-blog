setting={
fileInput:$('input[type=file]')[0],       //html file控件
dragDrop:$('input[type=file]').parent()[0],
 button:$('#uploadbtn')[0],      //提交按钮
 url:'',     //ajax地址
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
  var self=this;
    var html = '', i = 0;
    //等待载入gif动画
    $("#preview").html('<div class="upload_loading"></div>');
    var funAppendImage = function() {
        file = files[i];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                html = html + '<div id="uploadList_'+ i +'" class="upload_append_list">'+
                    '<div class="br image"><a href="javascript:" class="upload_delete" title="取消" data-index="'+ i +'">取消</a>' +
                    '<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="upload_image" />'+'</div>'+
                    '<p><strong>' + file.name + '</strong>'+
                    '</p>'+
                    '<div class="progress progress-striped" id="uploadProgress_' + i + '" class="upload_progress"> <div class="bar"></div></div>' +
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
                    self.deleteFile(files[parseInt($(this).attr("data-index"))]);
                    return false;
                });
                //提交按钮显示
                $(this.button).show();
            } else {
                //提交按钮隐藏
                $(this.button).hide();
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
    $(eleProgress).find('.bar').width(percent+'%');
},
  onSuccess: function(file, response) {
    var r=eval("("+response+")");
    var i=$('<input type="hidden" name="attached_id[]" value="'+r.attached_id+'" />');
    var j=$('<input type="hidden" name="attachment_id[]" value="'+r.attachment_id+'" />');

    $('#addlog').append(i);
    $('#addlog').append(j);

    $("#uploadInf").append('<p>'+r.url+'上传成功</p>');
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