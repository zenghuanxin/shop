<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>获取元素节点</h1>
    <input type="text" id="username" value="tom"/><br>
    <input type="text" id="useremail" value="tom@163.com"/><br>
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
    var its = document.getElementsByTagName('input');
    console.log(its);
</script>