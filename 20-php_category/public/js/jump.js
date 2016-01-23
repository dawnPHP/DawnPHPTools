

//若干秒后自动跳转
function jumpToUrl(secs,url){
	var url=url || '';
	
	secs=secs||3;//默认值
	var jumpTo = document.getElementById('jumpTo');
	jumpTo.innerHTML=secs;  
	if(--secs>0){
		setTimeout("jumpToUrl("+secs+",'"+url+"')",1000); 
	}else{
		if(url!=''){
			location.href=url;     
		}else{
			window.history.back();
		}
	}     
}