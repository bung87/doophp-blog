/**
* Notifier.js by bung
* Copyright 2012
* http://fan16.net/s/1347801300
*/

function Notifier(icon,title,info){
    var self=this;
    this.icon=icon;
    this.title=title;
    this.info=info;
    this.init();
    this.show=function(){
      if(self.checkPermission()==0){
      self.msg=self.create(self.icon,self.title,self.info);
      self.msg.show();
     }else{self.requestPermission(self.show);}

   };
 }
   Notifier.prototype={
    constructor:Notifier, 
    center:(window.Notifications || window.webkitNotifications),
    checkPermission:function(){var p=this.center.checkPermission();return p},
    requestPermission:function(cb){this.center.requestPermission(cb);
    },
    create:function(icon,title,info){var o=this.center.createNotification(icon,title,info);return o;},
    show:function(){},
    init:function(){var permission = this.center.checkPermission();
        if (permission == 0) {
          console.log ('您已接受来自网站的通知！');
           this.show();
        } else if (permission == 1) {
            console.log ('请点击“允许”按钮，以接受来自网站的通知');
        this.requestPermission(this.show);
        } else { 

            //用户不允许Notification事件
           console.log ( '您已选择禁止本页面显示网页通知！');
        }}
   };