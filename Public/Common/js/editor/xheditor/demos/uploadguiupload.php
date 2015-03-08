<script type="text/javascript">
var JSON = JSON || {}; 
JSON.stringify = JSON.stringify || function (obj) {  	 
	var t = typeof (obj);  
	if (t != "object" || obj === null) {
		if (t == "string")obj = '"'+obj+'"';  
		return String(obj);  
	}  
	else {  	
		var n, v, json = [], arr = (obj && obj.constructor == Array);  
		for (n in obj) {  
			v = obj[n]; t = typeof(v);  
			if (t == "string") v = '"'+v+'"';  
			else if (t == "object" && v !== null) v = JSON.stringify(v);  
			json.push((arr ? "" : '"' + n + '":') + String(v));  
		}
		return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");  
	}  
};
var callback = callback || function(v){
	v=JSON.stringify(v);
	window.name=escape(v);
	window.location='http://<?php echo $_POST['editorhost'];?>/xheditorproxy.html';//这个文件最好是一个0字节文件，如果无此文件也会正常工作	
}


var url='test2.zip';

callback(url);

</script>