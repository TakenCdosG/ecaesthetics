function check(){
jQuery(".niceCheck0").each(

function() {
     
     changeCheckStart(jQuery(this));
     
});                                      


function changeCheck(el)

{

	var el = el,
		input = el.find("input").eq(0);
		  
	if(el.attr("class").indexOf("niceCheck0Disabled")==-1)
	{	
   		if(!input.attr("checked")) {
			el.addClass("niceChecked0");
			input.attr("checked", true);
		} else {
			el.removeClass("niceChecked0");
			input.attr("checked", false).focus();
		}
	}
	
    return true;
}

function changeVisualCheck(input)
{
var wrapInput = input.parent();
	if(!input.attr("checked")) {
		wrapInput.removeClass("niceChecked0");
	}
	else
	{
		wrapInput.addClass("niceChecked0");
	}
}

function changeCheckStart(el)
{

try
{
var el = el,
	checkName = el.attr("name"),
	checkId = el.attr("id"),
	checkChecked = el.attr("checked"),
	checkDisabled = el.attr("disabled"),
	checkValue = el.attr("value");
	checkTab = el.attr("tabindex");
	if(checkChecked)
		el.after("<span class='niceCheck0 niceChecked0'>"+
			"<input type='checkbox'"+
			"name='"+checkName+"'"+
			"id='"+checkId+"'"+
			"checked='"+checkChecked+"'"+
			"value='"+checkValue+"'"+
			"tabindex='"+checkTab+"' /></span>");
	else
		el.after("<span class='niceCheck0'>"+
			"<input type='checkbox'"+
			"name='"+checkName+"'"+
			"id='"+checkId+"'"+
			"value='"+checkValue+"'"+
			"tabindex='"+checkTab+"' /></span>");
	
	if(checkDisabled)
	{
		el.next().addClass("niceCheck0Disabled");
		el.next().find("input").eq(0).attr("disabled","disabled");
	}
	
	/* ������� ����������� ��������������� checkbox */		
	el.next().bind("mousedown", function(e) { changeCheck(jQuery(this)) });
	el.next().find("input").eq(0).bind("change", function(e) { changeVisualCheck(jQuery(this)) });
	if(jQuery.browser.msie)
	{
		el.next().find("input").eq(0).bind("click", function(e) { changeVisualCheck(jQuery(this)) });	
	}
	el.remove();
}
catch(e)
{
}

    return true;
}
}