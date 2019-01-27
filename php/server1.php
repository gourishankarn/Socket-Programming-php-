<?php
$servername="localhost";
$username="root";
$password="";
$database="bus_booking";
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
  echo "unable to find open the server or database, Please try again later some time";
}
else
{
$address="127.0.0.1";
$port=3322;
echo "php version is :".phpversion()."<br>";
$sock=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
socket_bind($sock,$address,$port) or die("Couldnot bind to socket");
socket_listen($sock) or die("Couldnot listen to socket");
//    echo $request;
while(1){
	
$accept=socket_accept($sock) or die("Couldnot accept");
$len=(int)socket_read($accept,2);
$request=socket_read($accept,$len) or die("Cannot read from socket");
    //echo $request;
    switch($request){
	case "login": $phno=socket_read($accept,10);
			$len1=(int)socket_read($accept,2);
			$pwd=socket_read($accept,$len1);
			$query1="SELECT * FROM admin WHERE phone= '$phno'  and pass = '$pwd'";
			 $result=mysqli_query($conn,$query1);
			$row=mysqli_fetch_assoc($result);
		     if($row==null){
                          //socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+10) or die("Could not connect to the socket");
			//socket_close($sock);		
			socket_write($sock2,"0");
                        
                      }
                      else{
			$file = fopen("dashboard.html","r");
			$contents = fread($file,99999);
			fclose($file);
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+10) or die("Could not connect to the socket");
			//socket_close($sock);			
			$len = (string)strlen($contents);
			$l= strlen($len);
			while($l<5)
			{
				$l=$l+1;
				$len="0".$len;
			}	
			socket_write($sock2,"1");
			socket_write($sock2,$len);
                          socket_write($sock2,$contents);
			socket_close($sock2);
                      }
			
			break;
        
	case "signup": $phno=socket_read($accept,10);
			$len1=(int)socket_read($accept,2);
			$pwd=socket_read($accept,$len1);
			$query1="INSERT INTO admin values ('$phno','$pwd')";
			 $result=mysqli_query($conn,$query1);
			$row=mysqli_fetch_assoc($result);
			var_dump($row);
		     if(mysqli_error($conn)){
			echo "sql_error";
                          //socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);		
			socket_write($sock2,"0");
                        
                      }
                      else{
			$file = fopen("dashboard.html","r");
			$contents = fread($file,99999);
			fclose($file);
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);			
			$len = (string)strlen($contents);
			$l= strlen($len);
			while($l<5)
			{
				$l=$l+1;
				$len="0".$len;
			}	
			socket_write($sock2,"1");
			socket_write($sock2,$len);
                          socket_write($sock2,$contents);
			socket_close($sock2);
                      }
			
			break;

	case "forgot_password": $phno=socket_read($accept,10);
			$len1=(int)socket_read($accept,2);
			$pwd=socket_read($accept,$len1);
			$query1="UPDATE admin SET pass='$pwd' WHERE phone= '$phno'";
			 $result=mysqli_query($conn,$query1);
		//	$row=mysqli_fetch_assoc($result);
		//	var_dump($row);
		     if($result==NULL){
			echo "sql_error";
                          //socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);		
			socket_write($sock2,"0");
                        
                      }
                      else{
			$file = fopen("dashboard.html","r");
			$contents = fread($file,99999);
			fclose($file);
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);			
			$len = (string)strlen($contents);
			$l= strlen($len);
			while($l<5)
			{
				$l=$l+1;
				$len="0".$len;
			}	
			socket_write($sock2,"1");
			socket_write($sock2,$len);
                          socket_write($sock2,$contents);
			socket_close($sock2);
                      }
			
			break;

        case "estimate": $dest=socket_read($accept,5);
			echo $dest;
                      $src=socket_read($accept,8);
			echo $src;
		      $type=socket_read($accept,13);
			echo $type;
			echo "entered";
                      $query="SELECT * FROM estimate WHERE destination='$dest' and source_location='$src'  and bus_type='$type'";
			echo "before";
                      $result=mysqli_query($conn,$query);
		      $row=mysqli_fetch_assoc($result);
			echo "after";
			echo $row['fare_estmate'];
			echo "hhihihh";
                     if($result==null){
                          socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
                      }
                      else{
			socket_write($accept,strlen($row["fare_estmate"]));
                          socket_write($accept,$row["fare_estmate"]);
                         // fclose($myfile);
                      }
                      break;
	
	case "checkbus": 
			$len1=(int)socket_read($accept,2);			
			$src=socket_read($accept,$len1);
			
			$len1=(int)socket_read($accept,2);			
			$dest=socket_read($accept,$len1);
			
			$len1=(int)socket_read($accept,2);			
			$bustype=socket_read($accept,$len1);
			
			$query1="SELECT name,price FROM buses2 where(source_location='$src' and destination='$dest' and bus_type='$bustype')";
			 $result=mysqli_query($conn,$query1);
			//$row=mysqli_fetch_assoc($result);
		//	var_dump($row);
		     if(mysqli_error($conn)){
			echo "sql_error";
                          //socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);		
			socket_write($sock2,"0");
                        
                      }
                      else{
			$file = fopen("bus.html","r");
			$contents = fread($file,99999);
			$contents = $contents."<table><tr><td>Bus name</td><td>Price</td></tr>";
			while($row=mysqli_fetch_assoc($result)){
				$contents=$contents."<tr><td>".$row["name"]."</td><td>".$row["price"]."</td></tr>";
			}
			$contents=$contents."</table></body></html>";
			fclose($file);
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);			
			$len = (string)strlen($contents);
			$l= strlen($len);
			while($l<5)
			{
				$l=$l+1;
				$len="0".$len;
			}	
			socket_write($sock2,"1");
			socket_write($sock2,$len);
                          socket_write($sock2,$contents);
			socket_close($sock2);
                      }
        	    break;
	
	case "booking": 
			$len1=(int)socket_read($accept,2);			
			$name=socket_read($accept,$len1);
			
			$len1=(int)socket_read($accept,2);			
			$phone=socket_read($accept,$len1);
			
			$len1=(int)socket_read($accept,2);			
			$busname=socket_read($accept,$len1);

			$len1=(int)socket_read($accept,2);			
			$bustype=socket_read($accept,$len1);

			$len1=(int)socket_read($accept,2);			
			$src=socket_read($accept,$len1);
			
			$len1=(int)socket_read($accept,2);			
			$dest=socket_read($accept,$len1);

			$len1=(int)socket_read($accept,2);			
			$date=socket_read($accept,$len1);
			$query = "SELECT price FROM buses2 WHERE name = '$busname' AND bus_type='$bustype' AND source_location='$src' AND 				destination = '$dest'";
			$result=mysqli_query($conn,$query);
			var_dump($result);
			$row=mysqli_fetch_assoc($result);
			$price = $row['price'];
			if($result==NULL){
                          //socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);		
			socket_write($sock2,"0");
			}
			$query1="INSERT INTO booking(phone,name,source_location,destination,book_date,bus_name,bus_type,price) 
				 values('$phone','$name','$src','$dest','$date','$busname','$bustype','$price')";
			 $result=mysqli_query($conn,$query1);
			//$row=mysqli_fetch_assoc($result);
		//	var_dump($row);
		     if(mysqli_error($conn)){
			echo "sql_error";
                          //socket_write($accept,"<script> alert(\"Sorry, incorrect password or user roll number and board\")");
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);		
			socket_write($sock2,"0");
                        
                      }
                      else{
			$file = fopen("dashboard2.html","r");
			$contents = fread($file,99999);
			fclose($file);
			$sock2=socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
			socket_connect($sock2,$address,$port+12) or die("Could not connect to the socket");
			//socket_close($sock);			
			$len = (string)strlen($contents);
			$l= strlen($len);
			while($l<5)
			{
				$l=$l+1;
				$len="0".$len;
			}	
			socket_write($sock2,"1");
			socket_write($sock2,$len);
                          socket_write($sock2,$contents);
			socket_close($sock2);
                      }
        	    break;
        
        
        default:
                socket_write($accept,"<script> alert(\"Sorry, response not registered in server\")");
                break;
    }
    //socket_close($sock);
}
}
?>
