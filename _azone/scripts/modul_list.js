function fOpenGlobal1 (cls)
{
	window.open('item_list.php?class='+cls+'&r='+Math.random(),'iList');
	window.open('action.php?class='+cls,'action');
}

function fOpenGlobal2 (cls)
{
	window.open('item_list.php?class='+cls+'&r='+Math.random(),'iList');
	window.open('action.php','action');
}