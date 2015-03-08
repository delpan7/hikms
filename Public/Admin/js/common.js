/* 
 * 后台公用js
 */
$(function(){
  $(window).resize(function(){
    $("#right_content").css("min-height", $(this).height() - 150);
  }).resize();
});
