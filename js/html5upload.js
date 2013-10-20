function Upload(setting){
	this.fileInput=setting.fileInput;				//html file控件
	this.dragDrop=setting.dragDrop;					//拖拽敏感区域
	this.button=setting.button;				//提交按钮
	this.url=setting.url;						//ajax地址
	this.fileFilter= [];					//过滤后的文件数组
	this.filter=setting.filter;
	this.onSelect=setting.onSelect;	//文件选择后
	this.onDelete=setting.onDelete;	//文件删除后
	this.onDragOver=setting.onDragOver;	//文件拖拽到敏感区域时
	this.onDragLeave=setting.onDragLeave;	//文件离开到敏感区域时
	this.onProgress=setting.onProgress;	//文件上传进度
	this.onSuccess=setting.onSuccess;		//文件上传成功时
	this.onFailure=setting.onFailure;	//文件上传失败时,
	this.onComplete=setting.onComplete;	//文件全部上传完毕时
}
Upload.prototype = {
	//文件拖放
	dragOver: function(e) {
		e.stopPropagation();
		e.preventDefault();
		this[e.type === "dragover"? "onDragOver": "onDragLeave"].call(e.target);
		return this;
	},
	//获取选择文件，file控件或拖放
	getFiles: function(e) {
		// 取消鼠标经过样式
		this.dragOver(e);
				
		// 获取文件列表对象
		var files = e.target.files || e.dataTransfer.files;
		//继续添加文件
		this.fileFilter = this.fileFilter.concat(this.filter(files));
		this.dealFiles();
		return this;
	},
	
	//选中文件的处理与回调
	dealFiles: function() {
		for (var i = 0, file; file = this.fileFilter[i]; i++) {
			//增加唯一索引值
			file.index = i;
		}
		//执行选择回调
		this.onSelect(this.fileFilter);
		return this;
	},
	
	//删除对应的文件
	deleteFile: function(fileDelete) {
		var arrFile = [];
		for (var i = 0, file; file = this.fileFilter[i]; i++) {
			if (file != fileDelete) {
				arrFile.push(file);
			} else {
				this.onDelete(fileDelete);	
			}
		}
		this.fileFilter = arrFile;
		return this;
	},
	
	//文件上传
	uploadFile: function() {
		var self = this;	
		if (location.host.indexOf("sitepointstatic") >= 0) {
			//非站点服务器上运行
			return;	
		}
		for (var i = 0, file; file = this.fileFilter[i]; i++) {
			(function(file) {
				var xhr = new XMLHttpRequest();
				if (xhr.upload) {
					// 上传中
					xhr.upload.addEventListener("progress", function(e) {
						self.onProgress(file, e.loaded, e.total);
					}, false);
		
					// 文件上传成功或是失败
					xhr.onreadystatechange = function(e) {
						if (xhr.readyState == 4) {
							if (xhr.status == 200) {
								self.onSuccess(file, xhr.responseText);
								self.deleteFile(file);
								if (!self.fileFilter.length) {
									//全部完毕
									self.onComplete();	
								}
							} else {
								self.onFailure(file, xhr.responseText);		
							}
						}
					};
		
					// 开始上传
					xhr.open("POST", self.url, true);
					xhr.setRequestHeader("X_FILENAME", file.name);
					xhr.send(file);
				}	
			})(file);	
		}	
			
	},
	
	init: function() {
		var self = this;
		
		if (this.dragDrop) {
			this.dragDrop.addEventListener("dragover", function(e) { self.dragOver(e); }, false);
			this.dragDrop.addEventListener("dragleave", function(e) { self.dragOver(e); }, false);
			this.dragDrop.addEventListener("drop", function(e) { self.getFiles(e); }, false);
		}
		
		//文件选择控件选择
		if (this.fileInput) {
			this.fileInput.addEventListener("change", function(e) { self.getFiles(e); }, false);	
		}
		
		//上传按钮提交
		if (this.button) {
			this.button.addEventListener("click", function(e) { self.uploadFile(e); }, false);	
		} 
	}
};
