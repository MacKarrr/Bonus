function fOpen(cls,moduleName,itemId,a,page) 
{
	ul = document.getElementById('u'+moduleName+'_'+itemId);
	imgObj = document.getElementById("i"+moduleName+'_'+itemId);
		if (ul) 
		{
			if(ul.innerHTML=="" || page>0)
			{
				ul.innerHTML = '<span class="load">загрузка...</span>';
				ul.style.display = '';

				window.open('gen_list.php?class='+cls+'&page='+page+'&moduleName='+moduleName+'&itemId='+itemId,'_gen_list');

				if (imgObj) 
					imgObj.src = 'im/btnon'+a+'.gif';
			}
			else
			{
				ul.innerHTML = "";
				if (imgObj) 
					imgObj.src = 'im/btnoff'+a+'.gif';
			}
		}
}

function fOpenList(cls,moduleName,itemId,actionName,moduleNameBack,itemIdBack) 
{
	window.open('action.php?class='+cls+'&moduleName='+moduleName+'&itemId='+itemId+'&action='+actionName+'&moduleNameBack='+moduleNameBack+'&itemIdBack='+itemIdBack+'&rand='+Math.random(), 'action');
}

function fOpenAction(cls,moduleName,itemId,formName,moduleNameBack,itemIdBack) 
{
	window.open('action.php?class='+cls+'&moduleName='+moduleName+'&itemId='+itemId+'&formName='+formName+'&moduleNameBack='+moduleNameBack+'&itemIdBack='+itemIdBack+'&rand='+Math.random(), 'action');
}
