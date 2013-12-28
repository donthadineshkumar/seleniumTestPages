<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<title><?php if (isset($_POST['q'])){echo($_POST['q'].' - '); } ?>Selenium Simplified Search Engine</title>
<!--http://www.bing.com/developers/s/API%20Basics.pdf#1-->

<?php require 'apikey.php' ?>

<SCRIPT>
<!--
/* cookie code found on http://www.cookiecentral.com/code/js_cookie8.htm */
/* 
	Cookies Demo
	By Jerry Aman, Optima System, July 28, 1996.
   	Cookie Functions written by Bill Dortch, hIdaho Design.

	Part of the PageSpinner distribution.

	We will not be held responsible for any unwanted 
	effects due to the usage of this script or any derivative.  
	No warrantees for usability for any specific application 
	are given or implied.

	You are free to use and modify this script,
	if credits are kept in the source code
*/

	var cookieVisitID 	= 'seleniumSimplifiedSearchLastVisit';	
	var cookieNumVisitID 	= 'seleniumSimplifiedSearchNumVisits';	
	var cookieLastSearch 	= 'seleniumSimplifiedLastSearch';	
	
	var gLastVisit;
	var gNumVisits;
	var gLastSearch;

	SetLastVisit();	// Execute when loading page

	function GetLastVisit ()
	{

		if ( gLastVisit == "")
		{
			return "This is your first Search.";
		}
		else 
		{
			var oldVisitDate = new Date(gLastVisit);
			return 	"Your last visit to this page was on " 
					+ gLastVisit + " and you searched for " + gLastSearch +".<BR>You have been here " 
					+ gNumVisits + " time" +(gNumVisits>1 ? "s" :"") 
					+" before."
		}
	}

	function setLastSearchCookie(searchTerm){
		var expDate = new Date (); 
		expDate.setTime( expDate.getTime() + (365 * 24 * 60 * 60 * 1000) ); 
		SetCookie( cookieLastSearch, searchTerm, expDate); 
	}
	
	function SetLastVisit (name, value) 
	{
		var newVisitDate = new Date();
		var expDate = new Date (); 
		var numVisits = 0;

			// The expDate is the date when the cookie should
			// expire, we will keep it for a year
		expDate.setTime( expDate.getTime() + (365 * 24 * 60 * 60 * 1000) ); 

			// Info about last visit
		if (GetCookie (cookieLastSearch) != null)
			gLastSearch = GetCookie (cookieLastSearch);
		else
			gLastSearch = "";
			
		if (GetCookie (cookieVisitID) != null)
			gLastVisit = GetCookie (cookieVisitID);
		else
			gLastVisit = "";

		if (GetCookie (cookieNumVisitID) != null)
			gNumVisits = GetCookie (cookieNumVisitID);	
		else
			gNumVisits = 0;

			// Use eval() to convert a string to a number
		numVisits = eval(gNumVisits) +1;	

			// Store info about this visit
		SetCookie( cookieVisitID, 	newVisitDate, expDate); 
		SetCookie( cookieNumVisitID, numVisits, expDate); 
	}

    // ---------------------------------------------------------------
    //  Cookie Functions - Second Helping  (21-Jan-96)
    //  Written by:  Bill Dortch, hIdaho Design <BDORTCH@NETW.COM>
    //  The following functions are released to the public domain.
    //
    //  The Second Helping version of the cookie functions dispenses with
    //  my encode and decode functions, in favor of JavaScript's new built-in
    //  escape and unescape functions, which do more complete encoding, and
    //  which are probably much faster.
    //
    //  The new version also extends the SetCookie function, though in
    //  a backward-compatible manner, so if you used the First Helping of
    //  cookie functions as they were written, you will not need to change any
    //  code, unless you want to take advantage of the new capabilities.
    //
    //  The following changes were made to SetCookie:
    //
    //  1.  The expires parameter is now optional - that is, you can omit
    //      it instead of passing it null to expire the cookie at the end
    //      of the current session.
    //
    //  2.  An optional path parameter has been added.
    //
    //  3.  An optional domain parameter has been added.
    //
    //  4.  An optional secure parameter has been added.
    //
    //  For information on the significance of these parameters, and
    //  and on cookies in general, please refer to the official cookie
    //  spec, at:
    //
    //      http://www.netscape.com/newsref/std/cookie_spec.html    
    //
    //
    // "Internal" function to return the decoded value of a cookie
    //
    function getCookieVal (offset) {
      var endstr = document.cookie.indexOf (";", offset);
      if (endstr == -1)
        endstr = document.cookie.length;
      return unescape(document.cookie.substring(offset, endstr));
    }

    //
    //  Function to return the value of the cookie specified by "name".
    //    name - String object containing the cookie name.
    //    returns - String object containing the cookie value, or null if
    //      the cookie does not exist.
    //
    function GetCookie (name) {
      var arg = name + "=";
      var alen = arg.length;
      var clen = document.cookie.length;
      var i = 0;
      while (i < clen) {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg)
          return getCookieVal (j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break; 
      }
      return null;
    }

    //
    //  Function to create or update a cookie.
    //    name - String object object containing the cookie name.
    //    value - String object containing the cookie value.  May contain
    //      any valid string characters.
    //    [expires] - Date object containing the expiration data of the cookie.  If
    //      omitted or null, expires the cookie at the end of the current session.
    //    [path] - String object indicating the path for which the cookie is valid.
    //      If omitted or null, uses the path of the calling document.
    //    [domain] - String object indicating the domain for which the cookie is
    //      valid.  If omitted or null, uses the domain of the calling document.
    //    [secure] - Boolean (true/false) value indicating whether cookie transmission
    //      requires a secure channel (HTTPS).  
    //
    //  The first two parameters are required.  The others, if supplied, must
    //  be passed in the order listed above.  To omit an unused optional field,
    //  use null as a place holder.  For example, to call SetCookie using name,
    //  value and path, you would code:
    //
    //      SetCookie ("myCookieName", "myCookieValue", null, "/");
    //
    //  Note that trailing omitted parameters do not require a placeholder.
    //
    //  To set a secure cookie for path "/myPath", that expires after the
    //  current session, you might code:
    //
    //      SetCookie (myCookieVar, cookieValueVar, null, "/myPath", null, true);
    //
    function SetCookie (name, value) {
      var argv = SetCookie.arguments;
      var argc = SetCookie.arguments.length;
      var expires = (argc > 2) ? argv[2] : null;
      var path = (argc > 3) ? argv[3] : null;
      var domain = (argc > 4) ? argv[4] : null;
      var secure = (argc > 5) ? argv[5] : false;
      document.cookie = name + "=" + escape (value) +
        ((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
        ((path == null) ? "" : ("; path=" + path)) +
        ((domain == null) ? "" : ("; domain=" + domain)) +
        ((secure == true) ? "; secure" : "");
    }

    //  Function to delete a cookie. (Sets expiration date to current date/time)
    //    name - String object containing the cookie name
    //
    function DeleteCookie (name) {
      var exp = new Date();
      exp.setTime (exp.getTime() - 1);  // This cookie is history
      var cval = GetCookie (name);
      document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
    }

// -->
</SCRIPT>




</head>

<body>
<div style="float:right"><img src="cover_small.gif"><p>Note: This test page uses <br/>cookies as an example to<br/>count your visits and last<br/> search criteria.<br/> Do not use this page if you<br/> are not happy with this use<br/> of cookies.</p></div>


<h1>The "Selenium Simplified" Search Engine</h1>

<?php
if (isset($_POST['q'])){
echo("<SCRIPT>setLastSearchCookie('".$_POST['q']."');</SCRIPT>");
}
?>

<form method="post" action="<?php echo $PHP_SELF;?>">
Type in a search:<input title="Search" type="text" name="q"
value="<?php
if (isset($_POST['q'])){
echo($_POST['q']); 
}
else { echo('Selenium-RC');}
?>"/>
<input type="submit" value="Search" name="btnG" />
<?php
if (isset($_POST['btnG'])) {

$request = 'https://api.datamarket.azure.com/Bing/SearchWeb/Web?Query=%27' . urlencode( $_POST["q"]) . '%27&Adult=%27Off%27&$top=20&$format=JSON';

	//http://stackoverflow.com/questions/10844463/bing-search-api-and-azure

    $process = curl_init($request);
    curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($process, CURLOPT_USERPWD,  ":" . $appid);
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($process);
	
$jsonobj = json_decode($response);

echo('<ul ID="resultList">');
if(array_key_exists('d',$jsonobj)){
	if(array_key_exists('results',$jsonobj->d)){
try{
foreach($jsonobj->d->results as $value)
{
echo('<li class="resultlistitem"><a href="' . $value->Url . '">'.$value->DisplayUrl.'</a>');
echo('<p><em>'.$value->Title.'</em> '.$value->Description.'</p></li>');
}
}catch(Exception $e){}
}}

	// fudge results in case Selenium hq changes
	if(strcasecmp($_POST["q"],"selenium-rc")==0){
		echo('<li class="resultlistitem"><a href="http://seleniumhq.org">seleniumhq.org</a>');
		echo('<p><em>Selenium Remote-Control</em> Selenium RC comes in two parts. A server which automatically launches and kills browsers, and acts as a HTTP proxy for web requests from them. ...</p></li>');
	}
	
echo("</ul>");
} ?>
</form>

<SCRIPT>document.write (GetLastVisit())</SCRIPT>

</body>
</html>
<!-- php and bing powered -->