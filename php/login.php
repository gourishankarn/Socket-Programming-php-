<?php
	$address="localhost";
	$port=3322;
	$sock=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_connect($sock,$address,$port) or die("Could not connect to the socket");
	
	$phone=$_POST['phone'];
	$pwd=$_POST['password'];
	$l1=(string)strlen($pwd);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}
	socket_write($sock,"05");
	socket_write($sock,"login");
	socket_write($sock,$phone);
	socket_write($sock,$l1);
	socket_write($sock,$pwd);
	socket_close($sock);

	$sock1=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_set_option($sock1, SOL_SOCKET, SO_REUSEADDR, 1);
	socket_bind($sock1,$address,$port+10) or die("Couldnot bind to socket");
	socket_listen($sock1) or die("Couldnot listen to socket");

	$accept=socket_accept($sock1) or die("Couldnot accept");
	$flag=socket_read($accept,1);
	if($flag==0)
	{
		socket_shutdown ($sock1);
		echo "Username/Password Incorrect. Please retype password";
		include("index.html");
	}
	else{
		$len=socket_read($accept,5);
		$len=(int)$len;
		$content=socket_read($accept,$len);
		$file=fopen("cache.html","w");
		fwrite($file,$content,$len);
		header("Location: cache.html");
		exit();
		
	}
?>
