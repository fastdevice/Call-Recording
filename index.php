<?php


/* PUT data comes in on the stdin stream */
  $putdata = fopen("php://input", "r");

  # Get REQUEST Data
  $rec = \filter_input(\INPUT_GET, "recording", FILTER_SANITIZE_STRING); 
  $ext = \filter_input(\INPUT_GET, "callflow", FILTER_SANITIZE_STRING); 

error_log ("REQUEST Data recording : " . $rec . "\r\n", 3, './event.log');
error_log ("REQUEST Data callflow : " . $ext . "\r\n", 3, './event.log');

  $r = $ext . $rec;

error_log ("Match String : " . $r . "\r\n", 3, './event.log');
  
  # Regex Match String
  $re = '/(10..\/call_recording_(.+)\.mp3)|(inbound\/call_recording_(.+)\.mp3)|(outbound\/call_recording_(.+)\.mp3)/';
  if ( preg_match_all($re, $r, $matches, PREG_SET_ORDER,0) ) {
    $r = $matches[0][0];
    error_log ("Directory : " . $r . "\r\n", 3, './event.log');
  } 
  else {
      error_log ("Error Bad Match : " . $r . "\r\n", 3, './event.log');
      exit(1);
  } 

  /* Open a file for writing */
 // $fp = fopen("../$r", "w");
  $fp = fopen("../rec/$r", "w");

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
removeFiles ("../rec/outbound/");
removeFiles ("../rec/inbound/");
removeFiles ("../rec/1001/");
removeFiles ("../rec/1002/");
removeFiles ("../rec/1003/");
removeFiles ("../rec/1004/");
removeFiles ("../rec/1005/");
removeFiles ("../rec/1006/");
removeFiles ("../rec/1007/");
removeFiles ("../rec/1008/");
removeFiles ("../rec/1009/");


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








