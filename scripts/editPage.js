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
	
	function selectionInText()
	{
		this.text = "";
		this.startPos = -1;
		this.endPos = -1;
		
		this.getText = function() {return this.text;}
		this.getStart = function() {return this.startPos;}
		this.getEnd = function() {return this.endPos;}
		
		this.setText = function(txt) {this.text = txt;}
		this.setStart = function(startPosition) {this.startPos = startPosition;}
		this.setEnd = function(endPosition) {this.endpos = endPosition;}
	}
	
	function setEventHandlers()
	{
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
	
	function setfontweight()
	{
		settexttag("b");
	}
	
	function setfontstyle()
	{
		settexttag("i");
	}
	
	function setfontdecor()
	{
		settexttag("u");
	}
	
	// На стороне php заменять теги b, i, u на span c необходимым CSS
	function settexttag(tagname)
	{
		var tagbegin = "<"+tagname+">";
		var tagend = "</"+tagname+">";
		var txtarea = document.getElementById("artarea");
		var startpos = txtarea.selectionStart;
		var endpos = txtarea.selectionEnd;
		var textcontent = txtarea.value;
		var tbegin = "";
		var tmiddle = "";
		var tend = "";
		var removing = 0;
		if (startpos > 0) {tbegin = textcontent.substring(0,startpos);}
		if (endpos > startpos) {tmiddle = textcontent.substring(startpos,endpos);}
		if (textcontent.length > endpos) {tend = textcontent.substr(endpos);}
		
		if ((endpos - startpos)>6) 
		{
			if (tmiddle.substring(0,3)==tagbegin && tmiddle.substr(tmiddle.length-4)==tagend)
			{
				removing = 1;
				tmiddle = tmiddle.substr(3,tmiddle.length-7);
				txtarea.value = tbegin + tmiddle + tend;
				txtarea.selectionStart = startpos;
				txtarea.selectionEnd = endpos - 7;
			}
		}
		
		if (removing == 0)
		{
			txtarea.value = tbegin + tagbegin + tmiddle + tagend + tend;
			if (tmiddle.length == 0) 
			{
				txtarea.selectionStart = startpos + 3;
				txtarea.selectionEnd = startpos + 3;
			}
			else
			{
				txtarea.selectionStart = startpos;
				txtarea.selectionEnd = endpos + 7;
			}
		}
		txtarea.focus();
	}
	
	function setCaptionSize(textPiece, captionSize)
	{
		if (captionSize < 1 || captionSize > 3)
		{
			throw new RangeError("The caption must have an integer number from 1 to 3.");
		}
		var result = "";
		var emptyCaptionLength = 9; // length of empty caption text "<h1></h1>"
		var tagbegin = "<h"+String(captionSize)+">";
		var tagend = "</h"+String(captionSize)+">";
		
		if (textPiece.length >= emptyCaptionLength)
		{
			var startpiece = textPiece.substring(0,4);
			var endpiece = textPiece.substr(textPiece.length-5);
			var middlepiece = textPiece.substr(4,textPiece.length-9);
			if (startpiece==tagbegin && endpiece==tagend)
			{
				result = middlepiece;
			}
			else
			{
				var startReg = "<h[123]>";
				var endReg = "<\/h[123]>";
				if (startpiece.search(startReg)!=-1 && endpiece.search(endReg)!=-1)
				{
					result = tagbegin + middlepiece + tagend;
				}
				else
				{
					result = tagbegin + textPiece + tagend;
				}
			}
		}
		else
		{
			result = tagbegin + textPiece + tagend;
		}
		return result;
	}
	
	function setParagraphAlign(text, startPos, endPos, alignType)
	{
		var result = new selectionInText();
		if (startPos > endPos)
		{ throw new RangeError("The start position should not be more than end position."); }
		if (endPos > text.length)
		{ throw new RangeError("The end position is out of text length"); }
		
		return result;
	}
	
	function onsubmitform()
	{
		
	}