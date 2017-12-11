/**
 * Created by Administrator on 2017/12/11 0011.
 */
$(function () {
    $(".tron").mouseOver(function () {
        $(this).find('td').css('backgroundColor','#BBDDE5');
    });
    $(".tron").mouseOut(function () {
        $(this).find('td').css('backgroundColor','#FFF');
    });
});
