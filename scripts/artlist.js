var clickHandler = function markArticle(event)
	{
		var artRow = event.currentTarget;
		var idNumber = getArticleIdNumber(artRow);		
		if (idNumber != currentArtId)
		{
			var artTable = document.getElementById('tablerows');
			var articleRows = artTable.getElementsByTagName('tr');	
			for (var cnt = 0; cnt < articleRows.length; cnt++)
			{
				articleRow = articleRows[cnt];
				locIdNumber = getArticleIdNumber(articleRow);
				if (locIdNumber == currentArtId)
				{
					articleRow.className = artRowClassName;
				}
				else if (locIdNumber == idNumber)
				{
					articleRow.className = artRowSelectedClassName;
				}
			}
			currentArtId = idNumber;
		}	
	}
	
	var overHandler = function overArticle(event)
	{
		var artRow = event.currentTarget;
		setClassNameToUnselectedRow(artRow, artRowOverClassName);
	}
	
	var outHandler = function outArticle(event)
	{
		var artRow = event.currentTarget;
		setClassNameToUnselectedRow(artRow, artRowClassName);
	}
	
	var overButtonHandler = function overButton(event)
	{
		var btn = event.currentTarget;
		btn.className = buttonOverClassName;
	}
	
	var outButtonHandler = function outButton(event)
	{
		var btn = event.currentTarget;
		btn.className = buttonClassName;
	}
	
	function setClassNameToUnselectedRow(artRow, lClassName)
	{
		var idNumber = getArticleIdNumber(artRow);
		if (idNumber != currentArtId)
		{
			artRow.className = lClassName;
		}
	}
	
	function getArticleIdNumber(artRow)
	{
		var artCells = artRow.getElementsByTagName('td');
		//return parseInt(artCells[0].innerHTML,10);
		return artCells[0].innerHTML;
	}
	
	function setEventHandlers()
	{
		var artTable = document.getElementById('tablerows');
		var artRows = artTable.getElementsByTagName('tr');	
		for (var cnt = 0; cnt < artRows.length; cnt++)
		{	
			artRow = artRows[cnt];
			artRow.addEventListener('click', clickHandler, false);		
			artRow.addEventListener('mouseover', overHandler, false);		
			artRow.addEventListener('mouseout', outHandler, false);		
			setClassNameToUnselectedRow(artRow, artRowClassName);
		}
		var buttons = document.getElementsByTagName('input');
		for (cnt = 0; cnt < buttons.length; cnt++)
		{
			btn = buttons[cnt];
			if (btn.type == "button")
			{
				btn.addEventListener('mouseover', overButtonHandler, false);
				btn.addEventListener('mouseout', outButtonHandler, false);
				btn.className = buttonClassName;		
			}
		}
	}
	
	function fillFormParams(actionName)
	{
		var docForm = document.forms["commandsForm"];
		docForm.action = actionName;
		var artIdElement = document.getElementById('artIdInput');
		artIdElement.setAttribute('value',currentArtId);
		docForm.submit();
	}