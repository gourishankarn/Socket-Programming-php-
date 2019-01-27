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
	socket_write($sock,"06");
	socket_write($sock,"signup");
	socket_write($sock,$phone);
	socket_write($sock,$l1);
	socket_write($sock,$pwd);
	socket_close($sock);

	$sock1=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_set_option($sock1, SOL_SOCKET, SO_REUSEADDR, 1);
	socket_bind($sock1,$address,$port+12) or die("Couldnot bind to socket");
	socket_listen($sock1) or die("Couldnot listen to socket");
		
	$accept=socket_accept($sock1) or die("Couldnot accept");
	$flag=socket_read($accept,1);
	echo $flag;
	if($flag==0)
	{
		socket_shutdown ($sock1);
		echo "Some error occured. Please type again.";
		include("signup.html");
	}
	else{
		$length=(int)socket_read($accept,5);
		$content=socket_read($accept,$length);
		$file=fopen("user-dashboard.html","w");
		fwrite($file,$content,$length);
		header("Location: user-dashboard.html");
		exit();
	}
?>
