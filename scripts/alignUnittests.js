QUnit.test( "1.change align test", function( assert ) 
{
  var sampleText = "test\n<p align=\"center\">a word<\/p>\nnew string";
    
  var inputText = "test\n<p align=\"left\">a word<\/p>\nnew string";
  var selInText = setParagraphAlign(inputText,21,24,"center");
  
  assert.equal( selInText.getText(), sampleText, "Passed 1!" );
  assert.equal( selInText.getStart(), 5, "Passed 2!" );
  assert.equal( selInText.getEnd(), 33, "Passed 3!" );
});

QUnit.test( "2. split paragraph test", function( assert ) 
{
  var sampleText = "test\n<p align=\"right\"><p align=\"left\">a piece of text<\/p>\nnew string<\/p>";
    
  var inputText = "test\n<p align=\"right\">a piece of text\nnew string<\/p>";
  var selInText = setParagraphAlign(inputText,5,29,"left");
  
  assert.equal( selInText.getText(), sampleText, "Passed 1!" );
  assert.equal( selInText.getStart(), 22, "Passed 2!" );
  assert.equal( selInText.getEnd(), 57, "Passed 3!" );
});

QUnit.test( "3. the whole text align test", function( assert ) 
{
  var sampleText = "<p align=\"right\">string1\nstring2<\/p>";
    
  var inputText = "string1\nstring2";
  var selInText = setParagraphAlign(inputText,6,9,"right");
  
  assert.equal( selInText.getText(), sampleText, "Passed 1!" );
  assert.equal( selInText.getStart(), 0, "Passed 2!" );
  assert.equal( selInText.getEnd(), 36, "Passed 3!" );
});

QUnit.test( "4. the second string align test", function( assert ) 
{
  var sampleText = "string1\n<p align=\"left\">string2<\/p>";
    
  var inputText = "string1\nstring2";
  var selInText = setParagraphAlign(inputText,12,14,"left");
  
  assert.equal( selInText.getText(), sampleText, "Passed 1!" );
  assert.equal( selInText.getStart(), 8, "Passed 2!" );
  assert.equal( selInText.getEnd(), 35, "Passed 3!" );
});

QUnit.test( "5. add paragraph test", function( assert ) 
{
  var sampleText = "test\n<p align=\"left\">paragraph\n<p align=\"right\">inside paragraph<\/p><p align=\"center\">abc<\/p><\/p>";
    
  var inputText = "test\n<p align=\"left\">paragraph\n<p align=\"right\">inside paragraph<\/p>abc<\/p>";
  var selInText = setParagraphAlign(inputText,69,70,"left");
  
  assert.equal( selInText.getText(), sampleText, "Passed 1!" );
  assert.equal( selInText.getStart(), 68, "Passed 2!" );
  assert.equal( selInText.getEnd(), 93, "Passed 3!" );
});