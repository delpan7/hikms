/* 
 * 配置项页面专用js
 */
function changeOptions(obj){
  var type = $(obj).val();
  var config_options_obj = $("#config_options");
  if(type > 3){
    config_options_obj.show();
  }else{
    config_options_obj.hide();
  }
}
$(function(){
  changeOptions($('#config_type'));
});
