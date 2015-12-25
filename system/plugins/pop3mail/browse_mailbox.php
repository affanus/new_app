
<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
#!/usr/local/bin/php -q
/*
 * browse_mailbox.php
 *
 * @(#) $Header: /home/mlemos/cvsroot/pop3/browse_mailbox.php,v 1.1 2008/01/09 07:36:25 mlemos Exp $
 *
 */

?><html>
<head>
<title></title>
</head>
<body>
<center><h1></h1></center>

<?php

	require('mime_parser.php');
	require('rfc822_addresses.php');
	require("pop3.php");

  /* Uncomment when using SASL authentication mechanisms */
	/*
	require("sasl.php");
	*/
	stream_wrapper_register('pop3', 'pop3_stream');  /* Register the pop3 stream handler class */

	$pop3=new pop3_class;
	$pop3->hostname="mail.carriertermination.com";             /* POP 3 server host name                      */
	$pop3->port=110;                         /* POP 3 server host port,
	                                            usually 110 but some servers use other ports
	                                            Gmail uses 995                              */
	$pop3->tls=0;                            /* Establish secure connections using TLS      */
	$user="technical@carriertermination.com";                        /* Authentication user name                    */
	$password="123456";                    /* Authentication password                     */
	$pop3->realm="";                         /* Authentication realm or domain              */
	$pop3->workstation="";                   /* Workstation for NTLM authentication         */
	$apop=0;                                 /* Use APOP authentication                     */
	$pop3->authentication_mechanism="USER";  /* SASL authentication mechanism               */
	$pop3->debug=1;                          /* Output debug information                    */
	$pop3->html_debug=1;                     /* Debug information is in HTML                */
	$pop3->join_continuation_header_lines=1; /* Concatenate headers split in multiple lines */

	if(($error=$pop3->Open())=="")
	{
		"<PRE>Connected to the POP3 server &quot;".$pop3->hostname."&quot;.</PRE>\n";
		if(($error=$pop3->Login($user,$password,$apop))=="")
		{
			"<PRE>User &quot;$user&quot; logged in.</PRE>\n";
			if(($error=$pop3->Statistics($messages,$size))=="")
			{
				"<PRE>There are $messages messages in the mail box with a total of $size bytes.</PRE>\n";
				echo $messages;
				if($messages>0)
				{
					$pop3->GetConnectionName($connection_name);
					$message=4;
					$message_file='pop3://'.$connection_name.'/'.$message;
					$mime=new mime_parser_class;

					/*
					* Set to 0 for not decoding the message bodies
					*/
					$mime->decode_bodies = 1;

					$parameters=array(
						'File'=>$message_file,

						/* Read a message from a string instead of a file */
						/* 'Data'=>'My message data string',              */

						/* Save the message body parts to a directory     */
						/* 'SaveBody'=>'/tmp',                            */

						/* Do not retrieve or save message body parts     */
							/* 'SkipBody'=>1,*/
					);
					$success=$mime->Decode($parameters, $decoded);


					if(!$success)
						 '<h2>MIME message decoding error: '.HtmlSpecialChars($mime->error)."</h2>\n";
					else
					{
						
						echo '<pre>';
					
						($decoded[0]);
						echo '</pre>';
						
						if($mime->Analyze($decoded[0], $results))
						{
							 '<h2>Message analysis</h2>'."\n";
							'<pre>';
							print_r($results);

	
							
							
							 '</pre>';

							
						}
						else
							 'MIME message analyse error: '.$mime->error."\n";
					}
				}
		
				
				if($error==""
				&& ($error=$pop3->Close())=="")
					"<PRE>Disconnected from the POP3 server &quot;".$pop3->hostname."&quot;.</PRE>\n";

			}
		}
	}
	if($error!="")
		echo "<H2>Error: ",HtmlSpecialChars($error),"</H2>";
		

?>


</body>
</html>