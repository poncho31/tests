<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gmail connect</title>
	<style type="text/css">
		div.toggler{ border:1px solid #ccc; cursor:pointer; padding:10px 32px; }
		div.toggler .subject { font-weight:bold; }
		div.read{ color:#666; }
		div.toggler .from, div.toggler .date { font-style:italic; font-size:11px; }
		div.body { padding:10px 20px; }
	</style>
</head>
<body>
	<script
		  src="https://code.jquery.com/jquery-3.3.1.min.js"
		  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		  crossorigin="anonymous">
  </script>

	<script type="text/javascript">
		$(document).ready(function(){
			// alert("yeep");
		})
		$(".toggler").on("click", function(){
			$(this).toggleClass('read');
		})
		window.addEvent('domready',function() {
			var togglers = $$('div.toggler');
			if(togglers.length) var gmail = new Fx.Accordion(togglers,$$('div.body'));
			togglers.addEvent('click',function() { this.addClass('read').removeClass('unread'); });
			togglers[0].fireEvent('click'); //first one starts out read
		});
	</script>
</body>
</html>

<?php
include("config.php");
/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,"ALL");
// $emails = imap_search($inbox,'FROM ' . date("Y-m-d"));
$emails = imap_search($inbox,'SINCE ' . date("Y-m-d",strtotime("-7 days")));
// echo $emails->countMessages();
/* if emails are returned, cycle through each... */
if($emails) {
	
	/* begin output var */
	$output = '';
	
	/* put the newest emails on top */
	rsort($emails);
	
	/* for every email... */
	// $i = 0;
	// $emails = array_slice($emails, 0, 20);
	foreach($emails as $email_number) {
		// if($i>20)break;
		// $i++;
		/* get information specific to this email */
		$overview = imap_fetch_overview($inbox,$email_number,0);
		// $message = imap_fetchbody($inbox,$email_number,2);
		
		// output the email header information 
		$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
		$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
		$output.= '<span class="from">'.$overview[0]->from.'</span>';
		$output.= '<span class="date">on '.$overview[0]->date.'</span>';
		$output.= '</div>';
		
		/* output the email body */
		// $output.= '<div class="body">'.$message.'</div>';
	}
	
	echo decode($output);
} 


/* close the connection */
imap_close($inbox);

function decode($string) {
    $tabChaine=imap_mime_header_decode($string);
    $texte='';
    for ($i=0; $i<count($tabChaine); $i++) {
        
        switch (strtoupper($tabChaine[$i]->charset)) { //convert charset to uppercase
            case 'UTF-8': $texte.= $tabChaine[$i]->text; //utf8 is ok
                break;
            case 'DEFAULT': $texte.= $tabChaine[$i]->text; //no convert
                break;
            default: if (in_array(strtoupper($tabChaine[$i]->charset),upperListEncode())) //found in mb_list_encodings()
                        {$texte.= mb_convert_encoding($tabChaine[$i]->text,'UTF-8',$tabChaine[$i]->charset);}
                     else { //try to convert with iconv()
                          $ret = iconv($tabChaine[$i]->charset, "UTF-8", $tabChaine[$i]->text);    
                          if (!$ret) $texte.=$tabChaine[$i]->text;  //an error occurs (unknown charset) 
                          else $texte.=$ret;
                        }                    
                break;
            }
        }
        
    return $texte;    
    }
?>