<?php  

class socket
{
	private $host;
	private $port;
	public function  __construct($host,$port)
	{
		$this->host=$host;
		$this->port=$port;
	}
	public function send($command)
	{
		if (false == ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
			throw new Exception("Create Socket failed:" . socket_strerror(socket_last_error()));
			return NULL;
		}
		if (!socket_set_option($socket,SOL_SOCKET,SO_SNDTIMEO,array("sec"=>0, "usec"=>800 ))) {
			throw new Exception('Set Socket Send Data timeout option failed: '.socket_strerror(socket_last_error()));
			return NULL;
		}		

		socket_set_nonblock($socket);
// 		socket_set_block($socket);

		$attempts = 0;
		$timeout = 800;  // adjust because we sleeping in 1 millisecond increments
		$connected = socket_connect($socket, $this->host, $this->port);
		while (!$connected && $attempts++ < $timeout) {
			$error = socket_last_error();
			if ($error != SOCKET_EINPROGRESS && $error != SOCKET_EALREADY) {
				socket_close($socket);
				throw new Exception("Error Connecting Socket: ".socket_strerror($error));
				return NULL;
			}
			usleep(500);
			$connected = socket_connect($socket, $this->host, $this->port);
		}
		
		if (!$connected) {
			socket_close($socket);
			throw new Exception('Could not connect Server '.$this->host.":".$this->port." ".socket_strerror(socket_last_error()));
			return NULL;
		}
		 
		if (false === socket_write($socket, $command,strlen($command))) {
			throw new Exception($this->host." Socket Write failed:".socket_strerror(socket_last_error()));
			return NULL;
		}
		socket_close($socket);
		return true;
	}
}


?>
