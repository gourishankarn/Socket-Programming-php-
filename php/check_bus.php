<?php
	$address="localhost";
	$port=3322;
	$sock=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_connect($sock,$address,$port) or die("Could not connect to the socket");
	
	$src=$_POST['source'];
	$dest=$_POST['destination'];
	$type=$_POST['bus_type'];
	socket_write($sock,"08");
	socket_write($sock,"checkbus");
	
	$l1=(string)strlen($src);
	if (strlen($l1)==1){
		$l1="0".$l1;	
	}
	socket_write($sock,$l1);
	socket_write($sock,$src);

	$l2=(string)strlen($dest);
	if (strlen($l2)==1){
		$l2="0".$l2;	
	}
	socket_write($sock,$l2);
	socket_write($sock,$dest);

	$l3=(string)strlen($type);
	if (strlen($l3)==1){
		$l3="0".$l3;	
	}
	socket_write($sock,$l3);
	socket_write($sock,$type);

	
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
		echo "Username/Password Incorrect. Please retype password";
		include("admin.html");
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
