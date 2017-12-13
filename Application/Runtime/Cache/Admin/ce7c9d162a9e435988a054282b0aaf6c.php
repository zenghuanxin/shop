<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <!--<h1>获取元素节点</h1>-->
    <!--<input type="text" id="username" value="tom"/><br>-->
    <!--<input type="text" id="useremail" value="tom@163.com"/><br>-->
    <!--<div>1</div>-->
    <!--<div>2</div>-->
    <!--<div>3</div>-->
    <!--<h2>父亲节点获取</h2>-->
    <!--<ul>-->
        <!--<li>red</li>-->
        <!--<li>blue</li>-->
        <!--<li>green</li>-->
    <!--</ul>-->

    <!--<h2>属性值操作</h2>-->
    <!--<a href="http://www.baidu.com" addr='beijing' target='_blank' class="apple">百度</a><br>-->
    <!--<input type="button" value="修改属性" onclick="f1()" /><br>-->

    <h2>属性节点获取</h2>
    <input type="text" name="username" value="tom" class="orange" id="username" /><br>
    <input type="button" value="修改属性" onclick="f1()">
</body>
</html>

<script type="text/javascript">
//    var name = document.getElementById('username');
//    console.log(name);
//    var email = document.getElementById('useremail');
//    console.log(email);
//    var hh = document.getElementsByTagName('h1');
//    console.log(hh);
//    console.log(hh[0]);
//    var its = document.getElementsByTagName('input');
//    console.log(its);
//    console.log(its[1]);
//    console.log(its.item(1))
//    var dv = document.getElementsByTagName('div')[0];
//    console.log(dv.firstChild);
//    console.log(dv.nextSibling);
//    var sib = document.getElementsByTagName('ul')[0];
//    console.log(sib.childNodes);
//    console.log(sib.childNodes.length);
//    console.log(sib.firstChild);
//    console.log(sib.firstChild.nextSibling);
//    console.log(sib.lastChild.previousSibling);

//    var blue = document.getElementsByTagName('li')[1];
//    console.log(blue);
//    console.log(blue.parentNode);
//    console.log(blue.parentNode.parentNode);
//    console.log(blue.parentNode.parentNode.parentNode);
//    console.log(blue.parentNode.parentNode.parentNode.parentNode);
//    console.log(blue.parentNode.parentNode.parentNode.parentNode.parentNode);

//    var baidu = document.getElementsByTagName('a')[0];
//    console.log(baidu.href);
//    console.log(baidu.getAttribute('addr'));
//    console.log(baidu.target);



//    var baidu = document.getElementsByTagName('a')[0];
//    function f1() {
//        baidu.href = 'http://www.163.com';
//        baidu.target = '_self';
//        baidu.addr = 'tianjin';
//
//        baidu.setAttribute('addr','tianjin');
//        baidu.setAttribute('height',170);
//    }
//    console.log(baidu.className);


    var name = document.getElementsById('username');
    var attrs = name.attributes;
    console.log(attrs);
</script>