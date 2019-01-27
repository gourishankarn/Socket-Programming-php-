<?php
	$address="localhost";
	$port=3322;
	$sock=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_connect($sock,$address,$port) or die("Could not connect to the socket");

	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$busname=$_POST['busname'];
	$bustype=$_POST['bustype'];
	$src=$_POST['src'];
	$dest=$_POST['dest'];
	$date=$_POST['date'];

	socket_write($sock,"07");
	socket_write($sock,"booking");
	
	$l1=(string)strlen($name);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$name);
	
	$l1=(string)strlen($phone);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$phone);

	$l1=(string)strlen($busname);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$busname);

	$l1=(string)strlen($bustype);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$bustype);

	$l1=(string)strlen($src);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$src);

	$l1=(string)strlen($dest);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$dest);

	$l1=(string)strlen($date);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}	
	socket_write($sock,$l1);
	socket_write($sock,$date);



	socket_close($sock);

	$sock1=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_set_option($sock1, SOL_SOCKET, SO_REUSEADDR, 1);
	socket_bind($sock1,$address,$port+12) or die("Couldnot bind to socket");
	socket_listen($sock1) or die("Couldnot listen to socket");

	$accept=socket_accept($sock1) or die("Couldnot accept");
	$flag=socket_read($accept,1);
	if($flag==0)
	{
		socket_shutdown ($sock1);
		echo "Error while booking!";
		include("booking.html");
	}
	else{
		$len=socket_read($accept,5);
		$len=(int)$len;
		echo $len;
		$content=socket_read($accept,$len);
		$file=fopen("cache.html","w");
		fwrite($file,$content,$len);
		header("Location: cache.html");
		exit();
	}
?>
