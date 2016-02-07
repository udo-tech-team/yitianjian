<!DOCTYPE html>
<!--[if IE 6]><html class="ie lt-ie8"><![endif]-->
<!--[if IE 7]><html class="ie lt-ie8"><![endif]-->
<!--[if IE 8]><html class="ie ie8"><![endif]-->
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<!--[if !IE]><!--> <html> <!--<![endif]-->

  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
<script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"beacon":"bam.nr-data.net","errorBeacon":"bam.nr-data.net","licenseKey":"1255494d3a","applicationID":"1070872","transactionName":"e1daR0JWVV9RER9ZWkxdRxxDUVZE","queueTime":12,"applicationTime":80,"agent":"js-agent.newrelic.com/nr-686.min.js"}</script>
<script type="text/javascript">(window.NREUM||(NREUM={})).loader_config={xpid:"XAUOVFNACQMHVFlVBQ=="};window.NREUM||(NREUM={}),__nr_require=function(t,e,n){function r(n){if(!e[n]){var o=e[n]={exports:{}};t[n][0].call(o.exports,function(e){var o=t[n][1][e];return r(o?o:e)},o,o.exports)}return e[n].exports}if("function"==typeof __nr_require)return __nr_require;for(var o=0;o<n.length;o++)r(n[o]);return r}({QJf3ax:[function(t,e){function n(t){function e(e,n,a){t&&t(e,n,a),a||(a={});for(var c=s(e),u=c.length,f=i(a,o,r),d=0;u>d;d++)c[d].apply(f,n);return f}function a(t,e){u[t]=s(t).concat(e)}function s(t){return u[t]||[]}function c(){return n(e)}var u={};return{on:a,emit:e,create:c,listeners:s,_events:u}}function r(){return{}}var o="nr@context",i=t("gos");e.exports=n()},{gos:"7eSDFh"}],ee:[function(t,e){e.exports=t("QJf3ax")},{}],3:[function(t){function e(t){try{i.console&&console.log(t)}catch(e){}}var n,r=t("ee"),o=t(1),i={};try{n=localStorage.getItem("__nr_flags").split(","),console&&"function"==typeof console.log&&(i.console=!0,-1!==n.indexOf("dev")&&(i.dev=!0),-1!==n.indexOf("nr_dev")&&(i.nrDev=!0))}catch(a){}i.nrDev&&r.on("internal-error",function(t){e(t.stack)}),i.dev&&r.on("fn-err",function(t,n,r){e(r.stack)}),i.dev&&(e("NR AGENT IN DEVELOPMENT MODE"),e("flags: "+o(i,function(t){return t}).join(", ")))},{1:20,ee:"QJf3ax"}],4:[function(t){function e(t,e,n,i,s){try{c?c-=1:r("err",[s||new UncaughtException(t,e,n)])}catch(u){try{r("ierr",[u,(new Date).getTime(),!0])}catch(f){}}return"function"==typeof a?a.apply(this,o(arguments)):!1}function UncaughtException(t,e,n){this.message=t||"Uncaught error with no additional information",this.sourceURL=e,this.line=n}function n(t){r("err",[t,(new Date).getTime()])}var r=t("handle"),o=t(6),i=t("ee"),a=window.onerror,s=!1,c=0;t("loader").features.err=!0,t(3),window.onerror=e;try{throw new Error}catch(u){"stack"in u&&(t(4),t(5),"addEventListener"in window&&t(1),window.XMLHttpRequest&&XMLHttpRequest.prototype&&XMLHttpRequest.prototype.addEventListener&&window.XMLHttpRequest&&XMLHttpRequest.prototype&&XMLHttpRequest.prototype.addEventListener&&!/CriOS/.test(navigator.userAgent)&&t(2),s=!0)}i.on("fn-start",function(){s&&(c+=1)}),i.on("fn-err",function(t,e,r){s&&(this.thrown=!0,n(r))}),i.on("fn-end",function(){s&&!this.thrown&&c>0&&(c-=1)}),i.on("internal-error",function(t){r("ierr",[t,(new Date).getTime(),!0])})},{1:5,2:8,3:3,4:7,5:6,6:21,ee:"QJf3ax",handle:"D5DuLP",loader:"G9z0Bl"}],5:[function(t,e){function n(t){i.inPlace(t,["addEventListener","removeEventListener"],"-",r)}function r(t){return t[1]}var o=t("ee").create(),i=t(1)(o),a=t("gos");if(e.exports=o,n(window),"getPrototypeOf"in Object){for(var s=document;s&&!s.hasOwnProperty("addEventListener");)s=Object.getPrototypeOf(s);s&&n(s);for(var c=XMLHttpRequest.prototype;c&&!c.hasOwnProperty("addEventListener");)c=Object.getPrototypeOf(c);c&&n(c)}else XMLHttpRequest.prototype.hasOwnProperty("addEventListener")&&n(XMLHttpRequest.prototype);o.on("addEventListener-start",function(t){if(t[1]){var e=t[1];"function"==typeof e?this.wrapped=t[1]=a(e,"nr@wrapped",function(){return i(e,"fn-",null,e.name||"anonymous")}):"function"==typeof e.handleEvent&&i.inPlace(e,["handleEvent"],"fn-")}}),o.on("removeEventListener-start",function(t){var e=this.wrapped;e&&(t[1]=e)})},{1:22,ee:"QJf3ax",gos:"7eSDFh"}],6:[function(t,e){var n=t("ee").create(),r=t(1)(n);e.exports=n,r.inPlace(window,["requestAnimationFrame","mozRequestAnimationFrame","webkitRequestAnimationFrame","msRequestAnimationFrame"],"raf-"),n.on("raf-start",function(t){t[0]=r(t[0],"fn-")})},{1:22,ee:"QJf3ax"}],7:[function(t,e){function n(t,e,n){t[0]=o(t[0],"fn-",null,n)}var r=t("ee").create(),o=t(1)(r);e.exports=r,o.inPlace(window,["setTimeout","setInterval","setImmediate"],"setTimer-"),r.on("setTimer-start",n)},{1:22,ee:"QJf3ax"}],8:[function(t,e){function n(){u.inPlace(this,p,"fn-")}function r(t,e){u.inPlace(e,["onreadystatechange"],"fn-")}function o(t,e){return e}function i(t,e){for(var n in t)e[n]=t[n];return e}var a=t("ee").create(),s=t(1),c=t(2),u=c(a),f=c(s),d=window.XMLHttpRequest,p=["onload","onerror","onabort","onloadstart","onloadend","onprogress","ontimeout"];e.exports=a,window.XMLHttpRequest=function(t){var e=new d(t);try{a.emit("new-xhr",[],e),f.inPlace(e,["addEventListener","removeEventListener"],"-",o),e.addEventListener("readystatechange",n,!1)}catch(r){try{a.emit("internal-error",[r])}catch(i){}}return e},i(d,XMLHttpRequest),XMLHttpRequest.prototype=d.prototype,u.inPlace(XMLHttpRequest.prototype,["open","send"],"-xhr-",o),a.on("send-xhr-start",r),a.on("open-xhr-start",r)},{1:5,2:22,ee:"QJf3ax"}],9:[function(t){function e(t){var e=this.params,r=this.metrics;if(!this.ended){this.ended=!0;for(var i=0;c>i;i++)t.removeEventListener(s[i],this.listener,!1);if(!e.aborted){if(r.duration=(new Date).getTime()-this.startTime,4===t.readyState){e.status=t.status;var a=t.responseType,u="arraybuffer"===a||"blob"===a||"json"===a?t.response:t.responseText,f=n(u);if(f&&(r.rxSize=f),this.sameOrigin){var d=t.getResponseHeader("X-NewRelic-App-Data");d&&(e.cat=d.split(", ").pop())}}else e.status=0;r.cbTime=this.cbTime,o("xhr",[e,r,this.startTime])}}}function n(t){if("string"==typeof t&&t.length)return t.length;if("object"!=typeof t)return void 0;if("undefined"!=typeof ArrayBuffer&&t instanceof ArrayBuffer&&t.byteLength)return t.byteLength;if("undefined"!=typeof Blob&&t instanceof Blob&&t.size)return t.size;if("undefined"!=typeof FormData&&t instanceof FormData)return void 0;try{return JSON.stringify(t).length}catch(e){return void 0}}function r(t,e){var n=i(e),r=t.params;r.host=n.hostname+":"+n.port,r.pathname=n.pathname,t.sameOrigin=n.sameOrigin}if(window.XMLHttpRequest&&XMLHttpRequest.prototype&&XMLHttpRequest.prototype.addEventListener&&!/CriOS/.test(navigator.userAgent)){t("loader").features.xhr=!0;var o=t("handle"),i=t(2),a=t("ee"),s=["load","error","abort","timeout"],c=s.length,u=t(1);t(4),t(3),a.on("new-xhr",function(){this.totalCbs=0,this.called=0,this.cbTime=0,this.end=e,this.ended=!1,this.xhrGuids={}}),a.on("open-xhr-start",function(t){this.params={method:t[0]},r(this,t[1]),this.metrics={}}),a.on("open-xhr-end",function(t,e){"loader_config"in NREUM&&"xpid"in NREUM.loader_config&&this.sameOrigin&&e.setRequestHeader("X-NewRelic-ID",NREUM.loader_config.xpid)}),a.on("send-xhr-start",function(t,e){var r=this.metrics,o=t[0],i=this;if(r&&o){var u=n(o);u&&(r.txSize=u)}this.startTime=(new Date).getTime(),this.listener=function(t){try{"abort"===t.type&&(i.params.aborted=!0),("load"!==t.type||i.called===i.totalCbs&&(i.onloadCalled||"function"!=typeof e.onload))&&i.end(e)}catch(n){try{a.emit("internal-error",[n])}catch(r){}}};for(var f=0;c>f;f++)e.addEventListener(s[f],this.listener,!1)}),a.on("xhr-cb-time",function(t,e,n){this.cbTime+=t,e?this.onloadCalled=!0:this.called+=1,this.called!==this.totalCbs||!this.onloadCalled&&"function"==typeof n.onload||this.end(n)}),a.on("xhr-load-added",function(t,e){var n=""+u(t)+!!e;this.xhrGuids&&!this.xhrGuids[n]&&(this.xhrGuids[n]=!0,this.totalCbs+=1)}),a.on("xhr-load-removed",function(t,e){var n=""+u(t)+!!e;this.xhrGuids&&this.xhrGuids[n]&&(delete this.xhrGuids[n],this.totalCbs-=1)}),a.on("addEventListener-end",function(t,e){e instanceof XMLHttpRequest&&"load"===t[0]&&a.emit("xhr-load-added",[t[1],t[2]],e)}),a.on("removeEventListener-end",function(t,e){e instanceof XMLHttpRequest&&"load"===t[0]&&a.emit("xhr-load-removed",[t[1],t[2]],e)}),a.on("fn-start",function(t,e,n){e instanceof XMLHttpRequest&&("onload"===n&&(this.onload=!0),("load"===(t[0]&&t[0].type)||this.onload)&&(this.xhrCbStart=(new Date).getTime()))}),a.on("fn-end",function(t,e){this.xhrCbStart&&a.emit("xhr-cb-time",[(new Date).getTime()-this.xhrCbStart,this.onload,e],e)})}},{1:"XL7HBI",2:10,3:8,4:5,ee:"QJf3ax",handle:"D5DuLP",loader:"G9z0Bl"}],10:[function(t,e){e.exports=function(t){var e=document.createElement("a"),n=window.location,r={};e.href=t,r.port=e.port;var o=e.href.split("://");return!r.port&&o[1]&&(r.port=o[1].split("/")[0].split("@").pop().split(":")[1]),r.port&&"0"!==r.port||(r.port="https"===o[0]?"443":"80"),r.hostname=e.hostname||n.hostname,r.pathname=e.pathname,r.protocol=o[0],"/"!==r.pathname.charAt(0)&&(r.pathname="/"+r.pathname),r.sameOrigin=!e.hostname||e.hostname===document.domain&&e.port===n.port&&e.protocol===n.protocol,r}},{}],11:[function(t,e){function n(t){return function(){r(t,[(new Date).getTime()].concat(i(arguments)))}}var r=t("handle"),o=t(1),i=t(2);"undefined"==typeof window.newrelic&&(newrelic=window.NREUM);var a=["setPageViewName","addPageAction","setCustomAttribute","finished","addToTrace","inlineHit","noticeError"];o(a,function(t,e){window.NREUM[e]=n("api-"+e)}),e.exports=window.NREUM},{1:20,2:21,handle:"D5DuLP"}],gos:[function(t,e){e.exports=t("7eSDFh")},{}],"7eSDFh":[function(t,e){function n(t,e,n){if(r.call(t,e))return t[e];var o=n();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(t,e,{value:o,writable:!0,enumerable:!1}),o}catch(i){}return t[e]=o,o}var r=Object.prototype.hasOwnProperty;e.exports=n},{}],D5DuLP:[function(t,e){function n(t,e,n){return r.listeners(t).length?r.emit(t,e,n):void(r.q&&(r.q[t]||(r.q[t]=[]),r.q[t].push(e)))}var r=t("ee").create();e.exports=n,n.ee=r,r.q={}},{ee:"QJf3ax"}],handle:[function(t,e){e.exports=t("D5DuLP")},{}],XL7HBI:[function(t,e){function n(t){var e=typeof t;return!t||"object"!==e&&"function"!==e?-1:t===window?0:i(t,o,function(){return r++})}var r=1,o="nr@id",i=t("gos");e.exports=n},{gos:"7eSDFh"}],id:[function(t,e){e.exports=t("XL7HBI")},{}],G9z0Bl:[function(t,e){function n(){var t=p.info=NREUM.info,e=u.getElementsByTagName("script")[0];if(t&&t.licenseKey&&t.applicationID&&e){s(d,function(e,n){e in t||(t[e]=n)});var n="https"===f.split(":")[0]||t.sslForHttp;p.proto=n?"https://":"http://",a("mark",["onload",i()]);var r=u.createElement("script");r.src=p.proto+t.agent,e.parentNode.insertBefore(r,e)}}function r(){"complete"===u.readyState&&o()}function o(){a("mark",["domContent",i()])}function i(){return(new Date).getTime()}var a=t("handle"),s=t(1),c=window,u=c.document;t(2);var f=(""+location).split("?")[0],d={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-686.min.js"},p=e.exports={offset:i(),origin:f,features:{}};u.addEventListener?(u.addEventListener("DOMContentLoaded",o,!1),c.addEventListener("load",n,!1)):(u.attachEvent("onreadystatechange",r),c.attachEvent("onload",n)),a("mark",["firstbyte",i()])},{1:20,2:11,handle:"D5DuLP"}],loader:[function(t,e){e.exports=t("G9z0Bl")},{}],20:[function(t,e){function n(t,e){var n=[],o="",i=0;for(o in t)r.call(t,o)&&(n[i]=e(o,t[o]),i+=1);return n}var r=Object.prototype.hasOwnProperty;e.exports=n},{}],21:[function(t,e){function n(t,e,n){e||(e=0),"undefined"==typeof n&&(n=t?t.length:0);for(var r=-1,o=n-e||0,i=Array(0>o?0:o);++r<o;)i[r]=t[e+r];return i}e.exports=n},{}],22:[function(t,e){function n(t){return!(t&&"function"==typeof t&&t.apply&&!t[i])}var r=t("ee"),o=t(1),i="nr@wrapper",a=Object.prototype.hasOwnProperty;e.exports=function(t){function e(t,e,r,a){function nrWrapper(){var n,i,s,u;try{i=this,n=o(arguments),s=r&&r(n,i)||{}}catch(d){f([d,"",[n,i,a],s])}c(e+"start",[n,i,a],s);try{/*return u=t.apply(i,n)*/}catch(p){throw c(e+"err",[n,i,p],s),p}finally{c(e+"end",[n,i,u],s)}}return n(t)?t:(e||(e=""),nrWrapper[i]=!0,u(t,nrWrapper),nrWrapper)}function s(t,r,o,i){o||(o="");var a,s,c,u="-"===o.charAt(0);for(c=0;c<r.length;c++)s=r[c],a=t[s],n(a)||(t[s]=e(a,u?s+o:o,i,s))}function c(e,n,r){try{t.emit(e,n,r)}catch(o){f([o,e,n,r])}}function u(t,e){if(Object.defineProperty&&Object.keys)try{var n=Object.keys(t);return n.forEach(function(n){Object.defineProperty(e,n,{get:function(){return t[n]},set:function(e){return t[n]=e,e}})}),e}catch(r){f([r])}for(var o in t)a.call(t,o)&&(e[o]=t[o]);return e}function f(e){try{t.emit("internal-error",e)}catch(n){}}return t||(t=r),e.inPlace=s,e.flag=i,e}},{1:21,ee:"QJf3ax"}]},{},["G9z0Bl",4,9]);</script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="description"  content="除去广为人知、人见人爱的VPN，其实还有十八般兵器存在于科学上（翻）网（墙）界，其中ShadowSocks可以说是其中一把功能齐全的瑞士军刀。服务器端提供了各种版本，如Python、Nodejs、Go、Clibev等等，安装配置过程极其简单。而用户端则可以在windows、mac、iOS和andro...">
  <meta property="wb:webmaster" content="294ec9de89e7fadb" />
  <meta property="qc:admins" content="104102651453316562112116375" />
  <meta property="qc:admins" content="11635613706305617" />
  <meta property="qc:admins" content="1163561616621163056375" />
  <meta http-equiv="mobile-agent" content="format=html5; url=http://www.jianshu.com/p/08ba65d1f91a">
    <!--  Meta for Twitter Card -->
  <meta content="summary" property="twitter:card">
  <meta content="@jianshucom" property="twitter:site">
  <meta content="ShadowSocks—科学上（翻）网（墙）之瑞士军刀" property="twitter:title">
  <meta content="除去广为人知、人见人爱的VPN，其实还有十八般兵器存在于科学上（翻）网（墙）界，其中ShadowSocks可以说是其中一把功能齐全的瑞士军刀。服务器端提供了各种版本，如Python、Nodejs、Go、Clibev等等，安装配置过程极其简单。而用户端则可以在windows、mac、iOS和andro..." property="twitter:description">
  <meta content="http://www.jianshu.com/p/08ba65d1f91a" property="twitter:url">

  <!--  Meta for OpenGraph -->
  <meta content="ShadowSocks—科学上（翻）网（墙）之瑞士军刀" property="og:title">
  <meta content="除去广为人知、人见人爱的VPN，其实还有十八般兵器存在于科学上（翻）网（墙）界，其中ShadowSocks可以说是其中一把功能齐全的瑞士军刀。服务器端提供了各种版本，如Python、Nodejs、Go、Cl..." property="og:description">
  <meta content="简书" property="og:site_name">
  <meta content="website" property="og:type">

  <title>ShadowSocks—科学上（翻）网（墙）之瑞士军刀 - 简书</title>
  <meta name="csrf-param" content="authenticity_token" />
<meta name="csrf-token" content="yqT4yHtdzZc6AsN7rk7CIDAm8Sve9Ud2fhKIBe0DsSTvO3PcuGA/z3u/DSslNEp0Q6IvVp7XRIrNWQ7xk8Gs0g==" />
  <!--[if lte IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <link rel="stylesheet" media="all" href="http://static.jianshu.io/assets/base-1548d07b6cd51c38e7352c50372a92a0.css" />

    <link rel="stylesheet" media="all" href="http://static.jianshu.io/assets/reading-note-0464f91905ab2e17feb372a1efd93cbb.css" />
  <link rel="stylesheet" media="all" href="http://static.jianshu.io/assets/base-read-mode-ce2fd8b74d859d176f37a287169483f8.css" />
  <script src="http://static.jianshu.io/assets/modernizr-1a919965e17abadafd276b9ad5c53472.js"></script>
  <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
  <!--[if IE 8]><link rel="stylesheet" media="all" href="http://static.jianshu.io/assets/scaffolding/for_ie-38b1be95d4cf922ccf54e0e49199367e.css" /><![endif]-->
  <!--[if lt IE 9]><link rel="stylesheet" media="all" href="http://static.jianshu.io/assets/scaffolding/for_ie-38b1be95d4cf922ccf54e0e49199367e.css" /><![endif]-->
  <link href="http://baijii-common.b0.upaiyun.com/icons/favicon.ico" rel="icon">
  <link rel="apple-touch-icon-precomposed" href="http://static.jianshu.io/assets/icon114-2f9cb857aaba989bca6af5532bbc499b.png" />
  <script>
    var _czc = _czc || [];
    _czc.push(["_setAccount", "1253183112"]);
  </script>
  <div id='wx_pic' style='margin:0 auto;display:none;'>
  </div>
</head>

  <body class="post output zh cn reader-day-mode reader-font2" data-js-module="note-show" data-locale="zh-CN">
    
    <div class="navbar navbar-jianshu shrink">
  <div class="dropdown">
    <a class="dropdown-toggle logo" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="javascript:void(0)">
    M
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    <li><a href="<?php 
echo $this->Html->url('/');
        ?>">
        <i class="fa fa-home"></i> 首页</a></li>
        <!--li><a href="">
         <i class="fa fa-th"></i> 专题</a></li>
      <li><a href="http://www.jianshu.com/user_invitations"><i class="fa fa-money"></i> 发钱啦</a></li-->
    </ul>
  </div>
</div>
<div class="navbar-user">
<?php if (!$this->Session->read('uid')) : ?>
<a class="login" data-signup-link="true" data-toggle="modal" href="<?php 
 echo $this->Html->url([
    'controller' => 'users',
    'action' => 'register'
]); ?>">
      <i class="fa fa-user"></i> 注册
</a>    <a class="login" data-signin-link="true" data-toggle="modal" 
href="<?php 
echo $this->Html->url([
    'controller' => 'users',
    'action' => 'login'
]);
        ?>">
      <i class="fa fa-sign-in"></i> 登录
</a>    <a class="daytime set-view-mode pull-right" href="javascript:void(0)"><i class="fa fa-moon-o"></i></a>
<?php endif ?>
</div>
<div class="navbar navbar-jianshu expanded">
  <div class="dropdown">
  <a class="active logo" role="button" data-original-title="个人主页" data-container="div.expanded" href="<?php echo $this->Html->url('/'); ?>">
        <b>M</b><i class="fa fa-home"></i><span class="title">首页</span>
</a>      <!--a data-toggle="tooltip" data-placement="right" data-original-title="专题" data-container="div.expanded" href="http://www.jianshu.com/collections">
        <i class="fa fa-th"></i><span class="title">专题</span>
</a>    <a data-toggle="tooltip" data-placement="right" data-original-title="下载手机应用" data-container="body" href="http://www.jianshu.com/apps">
      <i class="fa fa-mobile"></i><span class="title">下载手机应用</span-->
</a>  </div>
  <div class="nav-user">
      <a href='08ba65d1f91a#view-mode-modal' data-toggle='modal'><i class="fa fa-font"></i><span class="title">显示模式</span></a>

      <a class="signin" data-signin-link="true" data-toggle="modal" data-placement="right" data-original-title="登录" data-container="div.expanded" 
      href="<?php 
echo $this->Html->url([
    'controller' => 'users',
    'action' => 'login'
]);
        ?>">
        <i class="fa fa-sign-in"></i><span class="title">登录</span>
</a>    </div>
  </div>

    
      <div class="fixed-btn">
    <a class="go-top hide-go-top" href="#"> <i class="fa fa-angle-up"></i></a>
    <!--a class="qrcode" data-target="#bottom-qrcode" data-toggle="modal" href="javascript:void(0)"><i class="fa fa-qrcode"></i></a-->
    <a class="writer" href="<?php 
echo $this->Html->url([
    'controller' => 'users',
    'action' => 'ucenter'
]);
?>" 

data-toggle="tooltip" data-placement="left" title="建议与投诉"><i class="fa fa-pencil"></i></a>
    <!-- qrcode modal -->
  </div>


    <div id="show-note-container">
      

<div class="post-bg" id="flag">
  <div class="wrap-btn">
    <!-- Notebook and collections button upper left -->
      <div class="article-related pull-left">
          <!--a class="collection-menu-btn" data-toggle="modal" data-target="#collection-menu" href="javascript:void(null);">
            <i class="fa fa-th"></i>
</a>          <a class="notebooks-menu-btn" data-toggle="modal" data-target="#notebooks-menu" href="javascript:void(null);"><i class="fa fa-list-ul"></i></a-->
        <div class="related-avatar-group activities"></div>
      </div>
    <!-- ******* -->

<?php if (!$this->Session->read('uid')) : ?>
    <a class="login" data-signup-link="true" data-toggle="modal" href="<?php 
echo $this->Html->url([
    'controller' => 'users',
    'action' => 'register'
]);
?>">
    <i class="fa fa-user"></i> 注册
    </a>  <a class="login" data-signin-link="true" data-toggle="modal" href="<?php
echo $this->Html->url([
    'controller' => 'users',
    'action' => 'login'
]);
 ?>">
    <i class="fa fa-sign-in"></i> 登录
</a>
<?php endif ?>

    <!-- Buttons upper right -->
    <!-- ******* -->
  </div>

  <div class="container">
    <!-- Article activities for width under 768px -->
    <div class="related-avatar-group activities"></div>
      <div class="article">
        <div class="preview">
          <h1 class="title">ShadowSocks—科学上(翻)网(墙)之瑞士军刀</h1>
          <div class="meta-top">
            <span class="wordage"></span>
            <span class="views-count"></span>
            <span class="comments-count"></span>
            <span class="likes-count"></span>
          </div>

          <!-- Collection/Bookmark/Share for width under 768px -->
          <div class="article-share"></div>
          <!-- -->

          <div class="show-content"><!--p>除去广为人知、人见人爱的VPN<a href="http://vpno.vpno.net" target="_blank">VPN</a>，其实还有十八般兵器存在于科学上（翻）网（墙）界，其中ShadowSocks可以说是其中一把功能齐全的瑞士军刀。服务器端提供了各种版本，如Python、Nodejs、Go、C libev等等，安装配置过程极其简单。而用户端则可以在windows、mac、iOS和android上轻松运行，很好很强大。<br>PS：此程序<a href="https://github.com/clowwindy/shadowsocks" target="_blank">开源</a>，感谢作者<a href="https://twitter.com/clowwindy" target="_blank">@clowwindy</a>为主的所有程序员。<br>官网地址<a href="http://shadowsocks.org/en/index.html" target="_blank">www.shadowsocks.org</a><br>注意那个.com并不是官网，而是上面的.org<br><strong>2015年4月24日更新了最新的windows/Mac/Android版下载地址及使用方法！！！！</strong></p-->
<h4>Shadowsocks是什么？</h4>
<p>码农对于shadowsocks应该不陌生，而一般普通网民可能知之甚少。shadowsocks实质上也是一种socks5代理服务，类似于ssh代理。与vpn的全局代理不同，shadowsocks仅针对浏览器代理，不能代理应用软件，比如youtube、twitter客户端软件。如果把vpn比喻为一把屠龙刀，那么shadowsocks就是一把瑞士军刀，轻巧方便，功能却非常强大。</p>
<h4>喜欢上shadowsocks的理由</h4>
<p>很多时候，我们仅仅只是需要上一下google，收个gmail邮件，或者打开某个网站瞄一眼看看有无更新。这种情况下，vpn可以做到吗，可以，但是很麻烦，连个vpn，qq也得掉一次线，有时候还连半天连不上。而通过ss的话呢，后台运行一个小程序，然后浏览器点击切换一下SS的网络，就可以了。不用的时候，再切回来。这也就是其轻巧的地方。</p>
<h4>如何使用shadowsocks？</h4>
<p>首先，你需要有一个shadowsocks账号，这里有<a href="<?php 
    echo $this->Html->url([
        'controller' => 'tutorial',
        'action' => 'trial_port',
        '#' => 'free'
]);
?>" target="_blank">免费shadowsocks账号</a>（会换密码）
<!--，也可以购买，比如<a href="http://www.godusevpn.net" target="_blank">这里</a>（免费试用3天）。-->
</p>
<h5>windows平台</h5>
<p>1.下载一个shadowsocks的客户端程序<br><a href="http://pan.baidu.com/s/1o6KF4vw" target="_blank"> Win7及以下百度网盘下载地址</a><br><a href="http://pan.baidu.com/s/1gdvlsif" target="_blank"> Win8及以上百度网盘下载地址</a><br>不需要安装，解压就可以用。<br>2.运行解压后文件夹中的“shadowsocks.exe”<br>3.右下角找到程序图标，右键图标，“服务器”--“编辑服务器”，如下图，设置好shadowsocks的账号信息，点确定；</p>
<div class="image-package">
<?php echo $this->Html->image('tutorial/shadowsocks-win1.png', ['alt' => 'shadowsocks-windows-1']); ?>
<br><div class="image-caption">shadowsocks_win_01.png</div>
</div>
<p>4.再次右键程序图标，勾选“启用系统代理”。</p>
<div class="image-package">
<?php echo $this->Html->image('tutorial/shadowsocks-win2.png', ['alt' => 'shadowsocks-windows-2']); ?>
<br><div class="image-caption">shadowsocks_win_02.png</div>
</div>
<p>5.接下来，可以在chrome中直接打开youtube试试，测试OK，没问题。</p>
<div class="image-package">
<?php echo $this->Html->image('tutorial/shadowsocks-youtube.png', ['alt' => 'shadowsocks-youtube']); ?>
<br><div class="image-caption">shadowsocks_youtube.png</div>
</div>
<p>Tips：</p>
<ul>
<li>原GUI版本需要配合浏览器插件才能使用，新版无需浏览器插件配合，直接启用系统代理，配置好后就可以上（翻）网（墙）了。</li>
<li>系统代理模式一项，可以选择“PAC模式”和“全局模式”。PAC模式即需要代理的网站才代理，不需要代理的则通过本地网络访问，可以理解为，访问国内网站还是和你原来的网络一样，只有访问部分国外网站，才通过shadowsocks服务器。全局模式则是访问所有网站都通过shadowsocks服务器。</li>
<li>如何关闭shadowsocks呢？shadowsocks程序直接关闭就行了。</li>
</ul>
<h5>Mac OS X平台</h5>
<p>还是先下载mac下的客户端程序（<a href="http://pan.baidu.com/s/1gdIRTnl" target="_blank">百度网盘下载</a>），后面的过程和win是一样的，设置好以后，打开浏览器上（翻）网（墙）就O了，新版支持海外和全局的选项，一般默认选海外，基本感觉不到Wall的存在。</p>
<h5>iOS平台</h5>
<p>直接在appstore搜索下载shadowsocks（<a href="https://itunes.apple.com/cn/app/shadowsocks/id665729974?mt=8" target="_blank">safari直接进入下载</a>），app打开后就是一个浏览器，内置了公共服务器，可以直接输入网址打开youtube了。当然，有时候公共服务器会出现不稳定的情况，这时可以设置自己的服务器使用，设置方法和windows一样。相比Android版，iOS版只支持浏览器，有点弱爆了的感觉。<!--iOS上还是VPN更方便<br>前往<a href="http://www.jianshu.com/p/90e18e1e40a7" target="_blank">iOS上那些好用的VPN应用</a--></p>
<div class="image-package">

<?php echo $this->Html->image('tutorial/shadowsocks-twitter.jpg', ['alt' => 'shadowsocks-twitter']); ?>
<br><div class="image-caption">shadowsocks_ios.jpg</div>
</div>
<h5>Android平台</h5>
<p>安卓下的软件名称为“<strong>影梭</strong>”（<a href="https://play.google.com/store/apps/details?id=com.github.shadowsocks" target="_blank">GooglePlay下载</a>  <a href="http://pan.baidu.com/s/1kTEacbt" target="_blank">百度网盘</a>），下载后无需root，设置好服务器和帐号信息后即可直接使用。</p>
<p>与iOS版本不同，android版是以VPN的方式运行的，也就是说不仅支持浏览器，而且支持其他App，简直好用到没朋友。</p>
<div class="image-package">

<?php echo $this->Html->image('tutorial/shadowsocks-android.jpg', ['alt' => 'shadowsocks-android']); ?>
<br><div class="image-caption">shadowsocks_android.jpg</div>
</div>
</div>
        </div>
      </div>

      <div class="visitor_edit">
        <!-- further readings -->
        <div id="further-readings" data-user-slug="" data-user-nickname="">
          <div id="further-reading-line" class="hide further-reading-line"></div>
          <ul id="further-readings-list" class="reading-list unstyled"></ul>
          <!--div id="further-reading-new" class="reading-edit">
              <a data-signin-link="true" data-toggle="modal" href="http://www.jianshu.com/sign_in">
                <i class="fa fa-plus-circle"></i> 推荐拓展阅读
</a>            <div id="further-reading-form"></div>
          </div-->
        </div>
      </div>

      <!-- Reward / Support Author -->
        <!--div class="support-author">
          <p>如果觉得我的文章对您有用，请随意打赏。您的支持将鼓励我继续创作！</p>
            <a class="btn btn-pay" data-toggle="modal" href="08ba65d1f91a#pay-modal">¥ 打赏支持</a>
          <div class="avatar-list"></div>
        </div-->

      <!-- article meta bottom -->
      <div class="meta-bottom clearfix">
        <!--  Like Button -->
        <div class="like ">
            <div class="like-button">
            <a id="like-note" class="like-content" data-signin-link="true" 
            data-toggle="modal" href="<?php
echo $this->Html->url([
    'controller' => 'users',
    'action' => 'ucenter'
]);
 ?>">
                <i class="fa fa-heart-o"></i>  喜欢
</a></div>          <!--span id="likes-count" data-toggle="tooltip" data-placement="right" title="查看所有喜欢的用户">
            <i class="fa fa-spinner fa-pulse"></i-->
</span>        </div>
        <!--  share group -->
        <!--div class="share-group pull-right">
          <a href="javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f=&#39;http://v.t.sina.com.cn/share/share.php?appkey=1881139527&#39;,u=z||d.location,p=[&#39;&amp;url=&#39;,e(u),&#39;&amp;title=&#39;,e(t||d.title),&#39;&amp;source=&#39;,e(r),&#39;&amp;sourceUrl=&#39;,e(l),&#39;&amp;content=&#39;,c||&#39;gb2312&#39;,&#39;&amp;pic=&#39;,e(p||&#39;&#39;)].join(&#39;&#39;);function%20a(){if(!window.open([f,p].join(&#39;&#39;),&#39;mb&#39;,[&#39;toolbar=0,status=0,resizable=1,width=440,height=430,left=&#39;,(s.width-440)/2,&#39;,top=&#39;,(s.height-430)/2].join(&#39;&#39;)))u.href=[f,p].join(&#39;&#39;);};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,&#39;&#39;,&#39;&#39;,&#39;http://cwb.assets.jianshu.io/notes/images/145800/weibo/image_94175e2b6e5a.jpg&#39;, &#39;推荐 @我爱VPN 的文章《ShadowSocks—科学上（翻）网（墙）之瑞士军刀》（ 分享自 @简书 ）&#39;,&#39;<?php echo $this->get('share_url'); ?>&#39;,&#39;页面编码gb2312|utf-8默认gb2312&#39;));" data-name="weibo">
            <i class="fa fa-weibo"></i><span>分享到微博</span>
          </a>
          <a data-toggle="modal" href="#share-weixin-modal" data-name="weixin">
            <i class="fa fa-weixin"></i><span>分享到微信</span>
          </a>
          <div class="more">
            <a href="javascript:void(0)" data-toggle="dropdown">更多分享<i class="fa fa-caret-down"></i></a>
            <ul class="dropdown-menu arrow-top">
                <li><a href="http://cwb.assets.jianshu.io/notes/images/145800/weibo/image_94175e2b6e5a.jpg" target="_blank" data-name="changweibo"><i class="fa fa-arrow-circle-o-down"></i> 下载长微博图片</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,r=&#39;http://share.v.t.qq.com/index.php?c=share&amp;a=index&amp;url=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;)+&#39;&amp;title=&#39;+e(&#39;推荐 Gibson 的文章《ShadowSocks—科学上（翻）网（墙）之瑞士军刀》（ 分享自 @jianshuio ）&#39;),x=function(){if(!window.open(r,&#39;tweibo&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=600,height=600&#39;))location.href=r};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})();" data-name="tweibo"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/tweibo.png">分享到腾讯微博</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,r=&#39;http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;)+&#39;&amp;title=&#39;+e(&#39;推荐 Gibson 的文章《ShadowSocks—科学上（翻）网（墙）之瑞士军刀》&#39;),x=function(){if(!window.open(r,&#39;qzone&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=600,height=600&#39;))location.href=r};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})();" data-name="qzone"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/qzone.png">分享到QQ空间</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,r=&#39;https://twitter.com/share?url=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;)+&#39;&amp;text=&#39;+e(&#39;推荐 Gibson 的文章《ShadowSocks—科学上（翻）网（墙）之瑞士军刀》（ 分享自 @jianshucom ）&#39;)+&#39;&amp;related=&#39;+e(&#39;jianshucom&#39;),x=function(){if(!window.open(r,&#39;twitter&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=600,height=600&#39;))location.href=r};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})();" data-name="twitter"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/twitter.png">分享到Twitter</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,r=&#39;http://www.facebook.com/sharer.php?s=100&amp;p[url]=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;)+&#39;&amp;p[title]=&#39;+e(&#39;ShadowSocks—科学上（翻）网（墙）之瑞士军刀 - 简书社&#39;)+&#39;&amp;p[summary]=&#39;+e(&#39;推荐 Gibson 的文章《ShadowSocks—科学上（翻）网（墙）之瑞士军刀》&#39;),x=function(){if(!window.open(r,&#39;facebook&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=450,height=330&#39;))location.href=r};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})();" data-name="facebook"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/facebook.png">分享到Facebook</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,r=&#39;https://plus.google.com/share?url=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;),x=function(){if(!window.open(r,&#39;google_plus&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=450,height=330&#39;))location.href=r};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})();" data-name="google_plus"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/google_plus.png">分享到Google+</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,r=&#39;http://widget.renren.com/dialog/share?resourceUrl=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;)+&#39;&amp;description=&#39;+e(&#39;推荐 Gibson 的文章《ShadowSocks—科学上（翻）网（墙）之瑞士军刀》&#39;)+&#39;&amp;title=&#39;+e(&#39;ShadowSocks—科学上（翻）网（墙）之瑞士军刀&#39;),x=function(){if(!window.open(r,&#39;renren&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=600,height=600&#39;))location.href=r};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})();" data-name="renren"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/renren.png">分享到人人网</a></li>
                <li><a href="javascript:void(function(){var d=document,e=encodeURIComponent,s1=window.getSelection,s2=d.getSelection,s3=d.selection,s=s1?s1():s2?s2():s3?s3.createRange().text:&#39;&#39;,r=&#39;http://www.douban.com/recommend/?url=&#39;+e(&#39;<?php echo $this->get('share_url'); ?>&#39;)+&#39;&amp;title=&#39;+e(&#39;ShadowSocks—科学上（翻）网（墙）之瑞士军刀&#39;)+&#39;&amp;sel=&#39;+e(s)+&#39;&amp;v=1&#39;,x=function(){if(!window.open(r,&#39;douban&#39;,&#39;toolbar=0,resizable=1,scrollbars=yes,status=1,width=450,height=330&#39;))location.href=r+&#39;&amp;r=1&#39;};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})()" data-name="douban"><img src="http://baijii-common.b0.upaiyun.com/social_icons/32x32/douban.png">分享到豆瓣</a></li>
            </ul>
          </div> 
        </div-->
      </div>

      <!-- Modals -->
      <div id="share-weixin-modal" class="modal hide fade share-weixin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  </div>
  <div class="modal-body">
    <h5>打开微信“扫一扫”，打开网页后点击屏幕右上角分享按钮</h5>
  </div>
</div>

      
      <div id="notebooks-menu" class="panel notebooks-menu arrow-top modal hide fade"><img class="loader-tiny" src="http://baijii-common.b0.upaiyun.com/loaders/tiny.gif" alt="Tiny" /></div>
      <div id="collection-menu" class="panel collection-menu arrow-top modal hide fade"><img class="loader-tiny" src="http://baijii-common.b0.upaiyun.com/loaders/tiny.gif" alt="Tiny" /></div>
      
      <div id="likes-modal" class="modal modal_new support_list-modal fullscreen hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>喜欢的用户</h3>
      </div>
      <div class="modal-body">
        <ul class="unstyled users">
          <img class="loader-tiny editor-loading" src="http://baijii-common.b0.upaiyun.com/loaders/tiny.gif" alt="Tiny" />
        </ul>
      </div>
    </div>
  </div>
</div>



    <!-- Comments -->
    <div id="comments" class="comment-list clearfix">
        <div class="comment-head clearfix">
        </div>
        <div class="comment-head clearfix">
          82条评论
          <!--span class="order">
            （
            <a data-order="asc" class="active" href="javascript:void(0)">按时间正序</a>·
            <a data-order="desc" href="javascript:void(0)">按时间倒序</a>·
            <a data-order="likes_count" href="javascript:void(0)">按喜欢排序</a>
            ）
          </span-->
          <a class="goto-comment pull-right" data-signin-link="true" data-toggle="modal" href="<?php 
                echo $this->Html->url([
                    'controller' => 'users',
                    'action' => 'ucenter'
                ]);
        ?>">
              <i class="fa fa-pencil"></i>###
</a>        </div>
        <div id="comment-list">
          <img class="loader-tiny" src="http://baijii-common.b0.upaiyun.com/loaders/tiny.gif" alt="Tiny" />
        </div>
          <p class="signout-comment">
          <a class="btn btn-info" data-signin-link="true" data-toggle="modal" href="<?php 
                echo $this->Html->url('/');
            ?>">
      免费获取试用账号
</a>  </p>

    </div>
    <!-- -->

  </div>

  <script type='application/json' data-name='note'>
    {"id":145800,"abbr":"除去广为人知、人见人爱的VPN，其实还有十八般兵器存在于科学上（翻）网（墙）界，其中ShadowSocks可以说是其中一把功能齐全的瑞士军刀。服务器端提供了各种版本，如Python、Nodejs、Go、Clibev等等，安装配置过程极其简单。而用户端则可以在windows、mac、iOS和andro...","slug":"08ba65d1f91a","url":"http://www.jianshu.com/p/08ba65d1f91a","image_url":"http://cwb.assets.jianshu.io/notes/images/145800/weibo/image_94175e2b6e5a.jpg","wordage":1089,"has_further_readings":false,"views_count":191865,"likes_count":427,"comments_count":82,"rewards_total_count":2}
  </script>

  <script type='application/json' data-name='uuid'>
    {"uuid":"a054e5f0-4a46-0133-bad2-525400182069"}
  </script>

  <script type='application/json' data-name='author'>
    {"id":29832,"nickname":"Gibson","slug":"77c71e2d4814","public_notes_count":14,"followers_count":648,"total_likes_count":2038,"is_current_user":false}
  </script>


    <div class="include-collection">
      <div class="content">
      </div>
    </div>

  <!-- Modal -->
    <div class="modal pay-modal text-center hide fade" id="pay-modal">
  <div class="modal-header clearfix">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  </div>
  <form id="new_reward" class="new_reward" target="_blank" action="http://www.jianshu.com/notes/145800/rewards" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="nmYu1TDCnC5WAYhhLA9WxEtazlWDTzAqLS0ecC1wwfO7+aXB8/9udhe8RjGndd6QON4QKMNtM9aeZpiEU7LcBQ==" />
    <div class="modal-body">
      <a href="http://www.jianshu.com/users/77c71e2d4814">
        <div class="avatar"><img thumbnail="90x90" quality="100" src="http://upload.jianshu.io/users/upload_avatars/29832/QQ%E6%88%AA%E5%9B%BE20140207120028.png?imageMogr/thumbnail/90x90/quality/100" alt="Qq%e6%88%aa%e5%9b%be20140207120028" /></div>
</a>      <p><i class="fa fa-quote-left pull-left"></i>如果觉得我的文章对您有用，请随意打赏。您的支持将鼓励我继续创作！<i class="fa fa-quote-right pull-right"></i></p>
      <div class="main-inputs text-left">
        <div class="control-group">
          <label for="reward_amount">打赏金额</label><i class="fa fa-yen"></i>
          <input value="2.00" type="text" name="reward[amount_in_yuan]" id="reward_amount_in_yuan" />
        </div>
        <div class="control-group message">
          <textarea placeholder="给Ta留言" name="reward[message]" id="reward_message">
</textarea>
        </div>
      </div>
      <div class="choose-pay text-left">
        <h5>选择支付方式：</h5>
        <div>
          <label for="reward_channel_alipay">
            <input type="radio" value="alipay" checked="checked" name="reward[channel]" id="reward_channel_alipay" />
            <span class="alipay-bg"></span>
</label>
          
          <label for="reward_channel_wx_pub_qr">
            <input type="radio" value="wx_pub_qr" name="reward[channel]" id="reward_channel_wx_pub_qr" />
            微信支付
</label>        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button name="button" type="submit" class="btn btn-large btn-pay">立即支付</button>
    </div>
</form></div>

    <div class="modal success-pay text-center hide fade" id="success-pay">
  <div class="modal-header clearfix">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  </div>
  <div class="modal-body">
    <h3><i class="icon-ok"></i>打赏成功</h3>
    <img src="http://static.jianshu.io/assets/complete-pay-e37e8fe424f285118c7ef9fa15ca19e1.png" alt="Complete pay" />
  </div>
  <div class="modal-footer">
    
  </div>
</div>

</div>

    </div>
    <div id="flash" class="hide"></div>
    
  <div id="view-mode-modal" tabindex="-1" class="modal hide read-modal" aria-hidden="false" data-js-module='view-mode-modal'>
    <div class="btn-group change-background" data-toggle="buttons-radio">
      <a class="btn btn-daytime active" data-mode="day" href="javascript:void(null);">
        <i class="fa fa-sun-o"></i>
</a>      <a class="btn btn-nighttime " data-mode="night" href="javascript:void(null);">
        <i class="fa fa-moon-o"></i>
</a>    </div>
    <div class="btn-group change-font" data-toggle="buttons-radio">
      <a class="btn font " data-font="font1" href="javascript:void(null);">宋体</a>
      <a class="btn font hei active" data-font="font2" href="javascript:void(null);">黑体</a>
    </div>
    <div class="btn-group change-locale" data-toggle="buttons-radio">
      <a class="btn font active" data-locale="zh-CN" href="javascript:void(null);">简</a>
      <a class="btn font hei " data-locale="zh-TW" href="javascript:void(null);">繁</a>
    </div>
  </div>

    

    <script src="http://static.jianshu.io/assets/base-46f6701e996eabe28ecaeda3b73d6c73.js"></script>
    
    <script src="http://static.jianshu.io/assets/reading-base-662515e9144ecf42c0ad6609bd8b1799.js"></script>
    <script src="http://static.jianshu.io/assets/reading/module_sets/note_show-4f75b00e8b5b11d87e3de7ebc551b99b.js"></script>

<div style="display:none">
</div>
  </body>
</html>
