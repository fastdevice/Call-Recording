<?php


  # Turn debug on/ off
  $debug = 1;
  
  # Root directory to put recordings
  $rootdir = "../rec/";
  
  /* PUT data comes in on the stdin stream */
  $putdata = fopen("php://input", "r");

  # Get REQUEST Data
  $rec =            \filter_input(\INPUT_GET, "recording", FILTER_SANITIZE_STRING); 
  $to =             \filter_input(\INPUT_GET, "to", FILTER_SANITIZE_STRING);
  $caller_id =      \filter_input(\INPUT_GET, "caller_id_number", FILTER_SANITIZE_STRING);
  $call_id =        \filter_input(\INPUT_GET, "call_id", FILTER_SANITIZE_STRING);
  $cdr_id =         \filter_input(\INPUT_GET, "cdr_id", FILTER_SANITIZE_STRING);
  $interaction_id = \filter_input(\INPUT_GET, "interaction_id", FILTER_SANITIZE_STRING);
  $account_id =     \filter_input(\INPUT_GET, "account_id", FILTER_SANITIZE_STRING);
  
  /* Custom REQUEST Data, sub-directory to place recordings; 
     assuming extensions are four digit and start with 10.. 
     Regex expression can be changed to match your extension scheme */
  $ext = \filter_input(\INPUT_GET, "callflow", FILTER_SANITIZE_STRING);


if(debug) {
error_log ("      REQUEST Data callflow : " . $ext . "\r\n", 3, './event.log');
error_log ("     REQUEST Data recording : " . $rec . "\r\n", 3, './event.log');
error_log ("            REQUEST Data to : " . $to . "\r\n", 3, './event.log');
error_log ("     REQUEST Data caller_id : " . $caller_id . "\r\n", 3, './event.log');
error_log ("       REQUEST Data call_id : " . $call_id . "\r\n", 3, './event.log');
error_log ("        REQUEST Data cdr_id : " . $cdr_id . "\r\n", 3, './event.log');
error_log ("REQUEST Data interaction_id : " . $interaction_id . "\r\n", 3, './event.log');
error_log ("    REQUEST Data account_id : " . $account_id . "\r\n", 3, './event.log');
}

  /* Assemble the sub-directory path and raw filename from REQUEST Data recording, as recording also contains the from info */
  $r = $ext . $rec;

error_log ("Match String : " . $r . "\r\n", 3, './event.log');
  
  # Regex Match String to isolate unique audio filename; filenames must be unique or they will overwrite
  $re = '/(10..\/call_recording_(.+)\.mp3)|(inbound\/call_recording_(.+)\.mp3)|(outbound\/call_recording_(.+)\.mp3)/';
  if ( preg_match_all($re, $r, $matches, PREG_SET_ORDER,0) ) {
    $r = $matches[0][0];
    error_log ("Directory : " . $r . "\r\n", 3, './event.log');
  } 
  else {
      error_log ("Error Bad Match : " . $r . "\r\n", 3, './event.log');
      fclose($putdata);
      exit(1);
  } 

  /* Open a file for writing */
  $fp = fopen($rootdir . $r, "w");

  /* Read the data 1 KB at a time and write to the file */
  while ($data = fread($putdata, 1024))
    fwrite($fp, $data); 

  /* Close the streams */
  fclose($fp);
  fclose($putdata);
error_log ("Close file for writing : " . $r. "\r\n", 3, './event.log');
error_log ("File Size : " . filesize("../rec/$r") . "\r\n", 3, './event.log');

  /* Check for empty file size */
  if (filesize("../rec/$r") < 100) { 
    unlink("../rec/$r");
error_log ("unlink zero length : " . $r . "\r\n", 3, './event.log');
}

/* Check for old files and delete */
removeFiles ($rootdir . "outbound/");
removeFiles ($rootdir . "inbound/");
removeFiles ($rootdir . "1001/");
removeFiles ($rootdir . "1002/");
removeFiles ($rootdir . "1003/");
removeFiles ($rootdir . "1004/");
removeFiles ($rootdir . "1005/");
removeFiles ($rootdir . "1006/");
removeFiles ($rootdir . "1007/");
removeFiles ($rootdir . "1008/");
removeFiles ($rootdir . "1009/");



function removeFiles($path) 
{
	$days = 10;   

error_log ("Look in path : " . $path . "\r\n", 3, './event.log');
	// Open the directory  
	if ($handle = opendir($path))  
	{  
		// Loop through the directory  
		while (false !== ($file = readdir($handle)))  
		{  
			// Check the file we're doing is actually a file  
			if (is_file($path.$file))  
			{  
				// Check if the file is older than X days old  
				if (filemtime($path.$file) < ( time() - ( $days * 24 * 60 * 60 ) ) )  
				{  
					// Do the deletion 
error_log ("unlink old file : " . $path.$file . "\r\n", 3, './event.log');					
					unlink($path.$file);  
				}  
			}  
		}  
	}
}

?>








