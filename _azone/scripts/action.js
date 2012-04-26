function fList(cls,moduleName,itemId) 
{
	window.open('gen_list.php?class='+cls+'&moduleName='+moduleName+'&itemId='+itemId+'&rand='+Math.random(), '_gen_list');

}

function fiMagick(params) 
{
	if (params!="")
		window.open('imagick/imagick.php?'+params+'&rand='+Math.random(), '_imagick');
}

function fDate(id) 
{
  objI = document.getElementById(id);
  objD = document.getElementById('day_'+id);
  objM = document.getElementById('month_'+id);
  objY = document.getElementById('year_'+id);
  objI.value = objY.options[objY.selectedIndex].value+"-"+objM.options[objM.selectedIndex].value+"-"+objD.options[objD.selectedIndex].value;
}

function fTimeStamp(id) 
{
  objI = document.getElementById(id);
   
  objH = document.getElementById('hour_'+id);
  objMin = document.getElementById('minute_'+id);
  objS = document.getElementById('second_'+id);
  objD = document.getElementById('day_'+id);
  objM = document.getElementById('month_'+id);
  objY = document.getElementById('year_'+id);
  objI.value = objY.options[objY.selectedIndex].value+"-"+objM.options[objM.selectedIndex].value+"-"+objD.options[objD.selectedIndex].value+" "+objH.options[objH.selectedIndex].value+":"+objMin.options[objMin.selectedIndex].value+":"+objS.options[objS.selectedIndex].value;
}