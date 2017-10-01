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
	
	function SectionTypes()
	{
		SectionTypes.unknown = 0;
		SectionTypes.paragraph = 1;
		SectionTypes.passage = 2;
	}
	
	function ParagraphDefinitions()
	{
		ParagraphDefinitions.leftDefinition = "<p align=\"left\">";
		ParagraphDefinitions.centerDefinition = "<p align=\"center\">";
		ParagraphDefinitions.rightDefinition = "<p align=\"right\">";
		ParagraphDefinitions.endDefinition = "</p>";
	}
	
	function SectionParams()
	{
		this.position = -1;
		this.sectionType = SectionTypes.unknown;
		
		this.getPosition = function() (return this.position;)
		this.getSectionType = function() {return this.sectionType;}
		
		this.setPosition = function(position) (this.position = position;)
		this.setSectionType = function(sectionType) {this.sectionType = sectionType;}
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
	
	function isParagraphStart(textPiece)
	{
		var result = false;
		var leftLength = ParagraphDefinitions.leftDefinition.length;
		var rightLength = ParagraphDefinitions.rightDefinition.length;
		var centerLength = ParagraphDefinitions.centerDefinition.length;
		
		if ((textPiece >= leftLength && textPiece.substr(0,leftLength)==ParagraphDefinitions.leftDefinition)
			|| (textPiece >= rightLength && textPiece.substr(0,rightLength)==ParagraphDefinitions.rightDefinition)
			|| (textPiece >= centerLength && textPiece.substr(0,centerLength)==ParagraphDefinitions.centerDefinition))
		{
			result = true;
		}
		return result;
	}
	
	function hasParagraphEndBefore(textPiece)
	{
		var result = false;
		var textLength = textPiece.length;
		var endLength = ParagraphDefinitions.endDefinition.length;
		if (textLength >= endLength && textPiece.substr(textLength-endLength)==ParagraphDefinitions.endDefinition)
		{
			result = true;
		}
		return result;
	}
	
	function isNewLine(startSectionSymbol)
	{
		var result = false;
		if (startSectionSymbol == "\n" || startSectionSymbol== "\r" )
		{
			result = true;
		}
		return result;
	}
	
	function getSectionStart(text, startPos, endpos)
	{
		var result = new SectionParams();
		var leftSectionType = SectionTypes.unknown;
		
		while (leftSectionType == SectionTypes.unknown)
		{
			if (isParagraphStart(text.substr(startPos)))
			{
				leftSectionType = SectionTypes.paragraph;
			}
			else if ()
			{
				
			}
			else
			{
				startPos++;
			}
		}
		
		return result;
	}
	
	function setParagraphAlign(text, startPos, endPos, alignType)
	{
		var result = new selectionInText();
		if (startPos < 0)
		{ throw new RangeError("The start position should be positive."); }
		if (startPos > endPos)
		{ throw new RangeError("The start position should not be more, than the end position."); }
		if (endPos > text.length)
		{ throw new RangeError("The end position is out of text length."); }
		
		var locStartPos = startPos;
		var locEndPos = endPos;
		var leftSectionType = SectionTypes.unknown;
		var rightSectionType = SectionTypes.unknown;
		
		return result;
	}
	
	function onsubmitform()
	{
		
	}