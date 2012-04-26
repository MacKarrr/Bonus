function fLoad(ud)
{
	ulObj = top.iList.document.getElementById("u"+ud);
		if (ulObj)
			ulObj.innerHTML = document.getElementById("content").innerHTML;
}