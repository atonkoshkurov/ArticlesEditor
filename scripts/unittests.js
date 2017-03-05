QUnit.test( "1.empty caption test", function( assert ) 
{
  assert.ok( setCaptionSize("",2) == "<h2></h2>", "Passed!" );
});

QUnit.test( "2.change caption size test", function( assert ) 
{
  assert.ok( setCaptionSize("<h1>test piece</h1>",2) == "<h2>test piece</h2>", "Passed!" );
});

QUnit.test( "3.change caption size of bad piece test", function( assert ) 
{
  assert.ok( setCaptionSize("<h1>test piece</h3>",2) == "<h2>test piece</h2>", "Passed!" );
});

QUnit.test( "4.add caption test", function( assert ) 
{
  assert.ok( setCaptionSize("a piece",1) == "<h1>a piece</h1>", "Passed!" );
});

QUnit.test( "5.add caption to large piece test", function( assert ) 
{
  assert.ok( setCaptionSize("some large piece of text",3) == "<h3>some large piece of text</h3>", "Passed!" );
});

QUnit.test( "6.remove caption test", function( assert ) 
{
  assert.ok( setCaptionSize("<h1>test piece</h1>",1) == "test piece", "Passed!" );
});

QUnit.test( "7.remove empty caption test", function( assert ) 
{
  assert.ok( setCaptionSize("<h1></h1>",1) == "", "Passed!" );
});

QUnit.test( "8.caption exception test", function( assert ) 
{
  var exceptionName = "";
  try 
  {
	  var res = setCaptionSize("test", 0);
  }
  catch (err)
  {
	  exceptionName = err.name;
  }
  
  assert.equal( exceptionName, "RangeError", "Exception has occured." );
});