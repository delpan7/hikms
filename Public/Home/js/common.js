/* 
 * 公用js库
 */
/**
 * 将特殊的字符转换为HTML实体
 * @param {string} str 要转换的字符串
 * @returns {string}
 */
function htmlspecialchars(str){
  str = str.replace('&', '&amp;', str);
  str = str.replace('"', '&quot;', str);
  str = str.replace("'", '&#039;', str);
  str = str.replace('<', '&lt;', str);
  str = str.replace('<', '&gt;', str);
  return str;
}

/**
 * 将特殊的 HTML 实体转换回普通字符
 * @param {string} str 要转换的字符串
 * @returns string
 */
function htmlspecialchars_decode(str){
  str = str.replace('&amp;', '&', str);
  str = str.replace('&quot;', '"', str);
  str = str.replace('&#039;', "'", str);
  str = str.replace('&lt;', '<', str);
  str = str.replace('&gt;', '<', str);
  return str;
}

$(function(){
  pajaxEvent();
  showLogin();
  resetVerify();
});

function pajaxEvent(){
  $.pjax({
    selector: 'a',
    container: '#pjax-container', //内容替换的容器
    show: 'fade',  //展现的动画，支持默认和fade, 可以自定义动画方式，这里为自定义的function即可。
    cache: true,  //是否使用缓存
    storage: true,  //是否使用本地存储
    titleSuffix: '', //标题后缀
    filter: function(){ return true;},
    callback: function(status){
      var type = status.type;
      switch(type){
        case 'success': ;break; //正常
        case 'cache':;break; //读取缓存 
        case 'error': ;break; //发生异常
        case 'hash': ;break; //只是hash变化
      }
    }
  });
  $('#pjax-container').bind('pjax.start', function(){
    $('#loading').show();
  });
  $('#pjax-container').bind('pjax.end', function(){
    $('#loading').hide();
  });
}

function showLogin(){
  $('#login').hover(function(){
    $(this).children('.login-box').show();
  }, function(){
    $(this).children('.login-box').hide();
  });
}

function resetVerify(){
  var verifyi_obj = $(".verifyimg");
  var url = verifyi_obj.attr('src');
  verifyi_obj.click(function(){
    $(this).attr('src', url + '?random=' + Math.random());
  });
}
