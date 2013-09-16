<?php
class otajob {
	public function loadBalanc($serverArray, $revArray) {
		$collection = array ();
		$jobs = array ();
		$serverCounts = count ( $serverArray );
		// 为还要做最后一个版本的降级包,所以具体任务的个数就是版本数
		$jobCounts = count ( $revArray );
		
		foreach ( $revArray as $index => $rev ) {
			if ($index != ($jobCounts - 1)) {
				$jobs [] = $rev . "/" . $revArray [$jobCounts - 1];
			} else 			// 后一个版本的ota必须退回到上一个版本
			{
				$jobs [] = $rev . "/" . $revArray [$jobCounts - 2];
			}
		}
		
		
		#注意php中的整除取商的方法,其默认的  '/' 运算符返回的是一个浮点型的数据 
		$average = intval( count ( $jobs ) / $serverCounts );
		$extra = $jobCounts % $serverCounts;
		// 量均分所有的任务,当不能均分任务时,将余数任务再平均加到每一个机器上
		foreach ( $serverArray as $index => $value ) {
			if ($extra == 0) 			// 台机器均分所有的任务
			{
				$collection [$value->host] = array_slice ( $jobs, $index * $average, $average );
			} else {
				if ($index < $extra) {
					$startindex = $index * ($average + 1);
					$collection [$value->host] = array_slice ( $jobs, $startindex, $average + 1 );
				} else 				// 数任务己经全部加到其它机器上了,现在每个机器只能按最开始的平均数来分任务了
				{
					// 新计算没有加余数任务的数量
					$startindex = ($average + 1) * $extra + ($index - $extra) * $average;
					
					#如果数组中的要截取的最后一个元素的下标实际大于数组的总元素数量时,php会自动只取存在的,不存在的元素这里不会导致出错,所以这里没有再加判断
					$collection [$value->host] = array_slice ( $jobs, $startindex, $average );
				}
			}
		}
		unset($jobs);
		return $collection;
	}
	public function submit($jobArray,$product)
	{
		$ser=new server();
		foreach ($jobArray as $host=>$jobs)
		{
			$command="";
			foreach ($jobs as $job)
			{
				#$tmp_str[0] 是ota升级包的源版本,$tmp_str[0] 是ota升级包的目标版本
				$tmp_str=explode("/",$job);
				$command=$command."ota/".$product."/".$job.";";
			}			
			$port=$ser->getServerPort($host);
			$sk=new socket($host, $port);
			$sk->send($command);			
		}
	}
}

?>