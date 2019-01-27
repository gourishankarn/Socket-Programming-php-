<?php
  $address="localhost";
  $port=3322;
  $msg="Hello s5rverhdsjfhjsg";
	echo $msg;
	$source=$_POST['source_location'];
	$dest=$_POST['destination'];
	$bustype=$_POST['bus_type'];
	echo $dest;
	echo $source;
  $sock=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
  socket_connect($sock,$address,$port) or die("Could not connect to the socket");
socket_write($sock,5);  
	socket_write($sock,"estimate");
	
  socket_write($sock,$dest);
   socket_write($sock,$source);
    socket_write($sock,$bustype);
	$size=socket_read($sock,2);
    $file=socket_read($sock,$size);
      echo $file;
    socket_close($sock);
?>
