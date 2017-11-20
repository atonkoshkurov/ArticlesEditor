	var PARAGRAPG_DEFINITION_LEFT = "<p align=\"left\">";
	var PARAGRAPG_DEFINITION_CENTER = "<p align=\"center\">";
	var PARAGRAPG_DEFINITION_RIGHT = "<p align=\"right\">";
	var PARAGRAPG_DEFINITION_END = "</p>";
	
	var SectionTypes = {
		UNKNOWN : 0,
		PARAGRAPH : 1,
		PASSAGE : 2,
	};
	
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
		this.setEnd = function(endPosition) {this.endPos = endPosition;}
	}
	
	function SectionParams()
	{
		this.position = -1;
		this.sectionType = SectionTypes.UNKNOWN;
		
		this.getPosition = function() {return this.position;}
		this.getSectionType = function() {return this.sectionType;}
		
		this.setPosition = function(position) {this.position = position;}
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
		var openTagLength = 3;
		var closeTagLength = 4;
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
		
		if ((endpos - startpos) >= (openTagLength + closeTagLength)) 
		{
			if (tmiddle.substring(0,openTagLength)==tagbegin && tmiddle.substr(tmiddle.length-closeTagLength)==tagend)
			{
				removing = 1;
				tmiddle = tmiddle.substr(openTagLength,tmiddle.length-(openTagLength + closeTagLength));
				txtarea.value = tbegin + tmiddle + tend;
				txtarea.selectionStart = startpos;
				txtarea.selectionEnd = endpos - (openTagLength + closeTagLength);
			}
		}
		
		if (removing == 0)
		{
			txtarea.value = tbegin + tagbegin + tmiddle + tagend + tend;
			if (tmiddle.length == 0) 
			{
				txtarea.selectionStart = startpos + openTagLength;
				txtarea.selectionEnd = startpos + openTagLength;
			}
			else
			{
				txtarea.selectionStart = startpos;
				txtarea.selectionEnd = endpos + (openTagLength + closeTagLength);
			}
		}
		txtarea.focus();
	}
	
	function setCaption(captionSize)
	{
		var openTagLength = 4;
		var txtarea = document.getElementById("artarea");
		var startpos = txtarea.selectionStart;
		var endpos = txtarea.selectionEnd;
		var textcontent = txtarea.value;
		var tbegin = "";
		var tmiddle = "";
		var tend = "";
		if (startpos > 0) {tbegin = textcontent.substring(0,startpos);}
		if (endpos > startpos) {tmiddle = textcontent.substring(startpos,endpos);}
		if (textcontent.length > endpos) {tend = textcontent.substr(endpos);}
		var newmiddle = setCaptionSize(tmiddle,captionSize);
		var posBeforeCaption = tbegin.length;		
		txtarea.value = tbegin + newmiddle + tend;
		if (startpos == endpos)
		{			
			txtarea.selectionStart = posBeforeCaption + openTagLength;
			txtarea.selectionEnd = posBeforeCaption + openTagLength;
		}
		else
		{
			txtarea.selectionStart = posBeforeCaption;
			txtarea.selectionEnd = posBeforeCaption + newmiddle.length;
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
		var leftLength = PARAGRAPG_DEFINITION_LEFT.length;
		var rightLength = PARAGRAPG_DEFINITION_RIGHT.length;
		var centerLength = PARAGRAPG_DEFINITION_CENTER.length;
		var textLength = textPiece.length;
		
		if ((textLength >= leftLength && textPiece.substr(0,leftLength) == PARAGRAPG_DEFINITION_LEFT)
			|| (textLength >= rightLength && textPiece.substr(0,rightLength) == PARAGRAPG_DEFINITION_RIGHT)
			|| (textLength >= centerLength && textPiece.substr(0,centerLength) == PARAGRAPG_DEFINITION_CENTER))
		{
			result = true;
		}
		return result;
	}
	
	function isParagraphEnd(textPiece)
	{
		var result = false;
		var endLength = PARAGRAPG_DEFINITION_END.length;
		var textLength = textPiece.length;
		
		if (textLength >= endLength && textPiece.substr(textLength-endLength) == PARAGRAPG_DEFINITION_END)
		{
			result = true;
		}
		
		return result;
	}
	
	function hasParagraphEndBefore(textPiece)
	{
		var result = false;
		var textLength = textPiece.length;
		var endLength = PARAGRAPG_DEFINITION_END.length;
		if (textLength >= endLength && textPiece.substr(textLength-endLength) == PARAGRAPG_DEFINITION_END)
		{
			result = true;
		}
		return result;
	}
	
	function hasParagraphStartAfter(textPiece)
	{
		var result = false;
		var textLength = textPiece.length;
		
		var leftLength = PARAGRAPG_DEFINITION_LEFT.length;
		var centerLength = PARAGRAPG_DEFINITION_CENTER.length;
		var rightLength = PARAGRAPG_DEFINITION_RIGHT.length;
		if ((textLength >= leftLength && textPiece.substr(0,leftLength) == PARAGRAPG_DEFINITION_LEFT)
			|| (textLength >= centerLength && textPiece.substr(0,centerLength) == PARAGRAPG_DEFINITION_CENTER)
			|| (textLength >= rightLength && textPiece.substr(0,rightLength) == PARAGRAPG_DEFINITION_RIGHT))
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
	
	function getSectionEnd(text, startPos, endPos)
	{
		var result = new SectionParams();
		var locEndPos = endPos;
		var rightSectionType = SectionTypes.UNKNOWN;
		
		while (rightSectionType === SectionTypes.UNKNOWN)
		{
			if (locEndPos != startPos && isParagraphEnd(text.substr(0,locEndPos)))
			{
				rightSectionType = SectionTypes.PARAGRAPH;
			}
			else if (locEndPos >= text.length || isNewLine(text.charAt(locEndPos)) || hasParagraphStartAfter(text.substr(locEndPos)))
			{
				rightSectionType = SectionTypes.PASSAGE;
			}
			else
			{
				locEndPos++;
			}
		}
		
		result.setPosition(locEndPos);
		result.setSectionType(rightSectionType);
		return result;
	}
	
	function getSectionStart(text, startPos, endPos)
	{
		var result = new SectionParams();
		var locStartPos = startPos;
		var leftSectionType = SectionTypes.UNKNOWN;
		
		while (leftSectionType === SectionTypes.UNKNOWN)
		{
			if (locStartPos != endPos && isParagraphStart(text.substr(locStartPos)))
			{
				leftSectionType = SectionTypes.PARAGRAPH;
			}
			else if (locStartPos <= 0 || isNewLine(text.charAt(locStartPos-1)) || hasParagraphEndBefore(text.substr(0,locStartPos)))
			{
				leftSectionType = SectionTypes.PASSAGE;
			}
			else
			{
				locStartPos--;
			}
		}
		
		result.setPosition(locStartPos);
		result.setSectionType(leftSectionType);
		return result;
	}
	
	function noSubparagraph(textPiece)
	{
		var result = true;
		if (textPiece.length > 2)
		{
			var partAfterStart = textPiece.substr(1);
			if (partAfterStart.indexOf("<p")>=0)
			{
				result = false;
			}
			else
			{
				var partWithoutEnd = textPiece.substr(0,textPiece.length-1);
				if (partWithoutEnd.indexOf(PARAGRAPG_DEFINITION_END)>=0)
				{
					result = false;
				}
			}
		}
		return result;
	}
	
	function changeParagraphAlign(middlePart,alignType)
	{
		var result = middlePart;
		var endTagPos = middlePart.indexOf(">");
		if (endTagPos>=0)
		{
			result = getOpenParagraphTag(alignType) + middlePart.substr(endTagPos+1);
		}			
		return result;
	}
	
	function wrapWithParagraph(middlePart,alignType)
	{
		var result = getOpenParagraphTag(alignType) + middlePart + PARAGRAPG_DEFINITION_END;		
		return result;
	}
	
	function getOpenParagraphTag(alignType)
	{
		var result = "";
		if (alignType == "left")
		{
			result = PARAGRAPG_DEFINITION_LEFT;
		}
		else if (alignType == "right")
		{
			result = PARAGRAPG_DEFINITION_RIGHT;
		}
		else if (alignType == "center")
		{
			result = PARAGRAPG_DEFINITION_CENTER;
		}
		else
		{
			throw new TypeError("Unknown align type");
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
		{ endPos = text.length; }
						
		var leftSection = getSectionStart(text,startPos,endPos);
		var rightSection = getSectionEnd(text,startPos,endPos);
		var locStartPos = leftSection.getPosition();
		var locEndPos = rightSection.getPosition();		
	
		if (leftSection.getSectionType() == SectionTypes.PARAGRAPH && rightSection.getSectionType() != SectionTypes.PARAGRAPH)
		{		
			var searchPos = text.indexOf(">",locStartPos);
			if (searchPos !== -1) // looking for the end of "p" opening tag
			{
				locStartPos = searchPos + 1;
			}
		}
		else if (rightSection.getSectionType() == SectionTypes.PARAGRAPH && leftSection.getSectionType() != SectionTypes.PARAGRAPH)
		{		
			locEndPos = locEndPos - PARAGRAPG_DEFINITION_END.length;
		}
		
		var middlePart = text.substring(locStartPos,locEndPos);
		if (noSubparagraph(middlePart))
		{
			var leftPart = "";
			var rightPart = "";
			if (locStartPos>0)
			{
				leftPart = text.substring(0,locStartPos);
			}
			if (locEndPos < text.length)
			{
				rightPart = text.substr(locEndPos);
			}
			if (leftSection.getSectionType()==SectionTypes.PARAGRAPH && rightSection.getSectionType()==SectionTypes.PARAGRAPH)
			{
				middlePart = changeParagraphAlign(middlePart,alignType);				
			}
			else
			{				
				middlePart = wrapWithParagraph(middlePart,alignType);				
			}
			result.setStart(locStartPos);
			result.setEnd(locStartPos + middlePart.length);
			result.setText(leftPart.concat(middlePart,rightPart));
		}
		else
		{
			result.setText(text);	
			result.setStart(startPos);
			result.setEnd(endPos);
		}				
		return result;
	}
	
	function setLeftAlign()
	{
		setAlign("left");
	}
	
	function setCenterAlign()
	{
		setAlign("center");
	}
	
	function setRightAlign()
	{
		setAlign("right");
	}
	
	function setAlign(alignType)
	{
		var txtarea = document.getElementById("artarea");
		var startpos = txtarea.selectionStart;
		var endpos = txtarea.selectionEnd;
		var textcontent = txtarea.value;	
		
		var newTextAreaParams = setParagraphAlign(textcontent, startpos, endpos, alignType);
		txtarea.value = newTextAreaParams.getText();
		txtarea.selectionStart = newTextAreaParams.getStart();
		txtarea.selectionEnd = newTextAreaParams.getEnd();
		txtarea.focus();
	}
	
	function setNewPicture()
	{
		picLastNumber = picLastNumber + 1;
		var stringPicNumber = String(picLastNumber);
		putPictureTag(stringPicNumber);
		insertPictureRow(stringPicNumber);
	}
	
	function getPictureFieldTag(stringPicNumber)
	{
		return " [(Picture" + stringPicNumber + ")] ";
	}
	
	function getPicRowTag(stringPicNumber)
	{
		return "picRow"+stringPicNumber;
	}
	
	function putPictureTag(stringPicNumber)
	{
		var txtarea = document.getElementById("artarea");
		var endpos = txtarea.selectionEnd;	
		var textcontent = txtarea.value;
		var startPiece = textcontent.substring(0,endpos);
		var endPiece = textcontent.substring(endpos);
		var tagText = getPictureFieldTag(stringPicNumber);
		
		txtarea.value = startPiece + tagText + endPiece;
		var startSel = txtarea.value.indexOf(tagText,endpos-3);
		txtarea.selectionStart = startSel;
		txtarea.selectionEnd = startSel + tagText.length;
		txtarea.focus();
	}
	
	function insertPictureRow(stringPicNumber)
	{
		var maintable = document.getElementById("maintable");
		var newPicTd = document.createElement('td');
		var picTemplate = getPictureTemplate();		
		newPicTd.innerHTML = picTemplate.replace(new RegExp("\\[pNmb\\]",'g'),stringPicNumber);		
		var tblRow = maintable.insertRow(maintable.rows.length);
		tblRow.id = getPicRowTag(stringPicNumber);
		tblRow.appendChild(newPicTd);
	}
	
	function getPictureTemplate()
	{
		var pictureTemplate = '<span class = "piclabel">&lt;&lt; рис.[pNmb] &gt;&gt;</span>&nbsp;\
			<input class = "filefield" type = "file" name = "pic[pNmb]" accept = "image/*"/>&nbsp;\
			<input class = "xyfield" type = "text" name = "xvalue[pNmb]" maxlength = "4"/>&nbsp;<span class = "bigcomma">,</span>&nbsp;&nbsp;\
			<input class = "xyfield" type = "text" name = "yvalue[pNmb]" maxlength = "4"/>&nbsp;\
			<select name = "measure[pNmb]">\
				<option value = "1">px</option>\
				<option value = "2">%</option>\
			</select>\
			&nbsp;\
			<button type = "button" onclick = "deletePicture([pNmb])" >x</button>';
		return pictureTemplate;	
	}
	
	function delPictureTags(stringPicNumber)
	{
		var txtarea = document.getElementById("artarea");
		var textcontent = txtarea.value;
		var tagText = getPictureFieldTag(stringPicNumber).trim();
		var pos = textcontent.indexOf(tagText);
		while (pos >= 0)
		{
			textcontent = textcontent.replace(tagText,"");
			pos = textcontent.indexOf(tagText);
		}
		txtarea.value = textcontent;
	}
	
	function removePictureRow(stringPicNumber)
	{
		var maintable = document.getElementById("maintable");
		var trId = getPicRowTag(stringPicNumber);
		var rowAmount = maintable.rows.length;
		var cnt = 0;
		var seeking = true;
		while (seeking && cnt < rowAmount)
		{
			var currentRow = maintable.rows[cnt];
			if (currentRow.id == trId)
			{
				maintable.deleteRow(cnt);
				seeking = false;
			}
			cnt++;
		}
	}
	
	function deletePicture(nmb)
	{
		var stringPicNumber = String(nmb);
		delPictureTags(stringPicNumber);
		removePictureRow(stringPicNumber);
	}
	
	function onsubmitform()
	{
		return 0;
	}