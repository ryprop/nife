<?php

require __DIR__.'/../vendor/autoload.php';

class Nife_Demo_SlowBlob implements Nife_Blob {
	protected $chunk;
	protected $chunkCount;
	protected $interChunkDelay;
	function __construct($chunk, $chunkCount, $interChunkDelay) {
		$this->chunk = $chunk;
		$this->chunkCount = $chunkCount;
		$this->interChunkDelay = $interChunkDelay;
	}
	
	public function getLength() {
		return strlen($this->chunk)*$this->chunkCount;
	}
	public function writeTo( $callback ) {
		for( $i=0; $i<$this->chunkCount; ++$i ) {
			sleep($this->interChunkDelay);
			call_user_func($callback, $this->chunk);
		}
	}

	public static function outputAndFlush($str) {
		echo $str;
		flush();
	}
}

// Fiddle with these numbers to show that:
// - If inter-chunk delay is higher than max execution time,
//   the response should fail to send
// - if inter-chunk reset is lower than max execution time
//   the response should fail to send completely
// - So long max execution time and inter-chunk reset
//   are both greater than inter-chunk delay, you should
//   get the full response
$maxExecutionTime = 3;
$interChunkDelay = 2;
$interChunkReset = 3;

ini_set('max_execution_time', $maxExecutionTime);

$chunk
	= "Max execution time: $maxExecutionTime\n"
	. "Inter-chunk delay: $interChunkDelay\n"
	. "Inter-chunk reset: $interChunkReset\n"
	. "\n";

$outputFunction = array('Nife_Demo_SlowBlob','outputAndFlush');
$outputFunction = Nife_Util::makeTimeoutResettingOutputter($interChunkReset, $outputFunction);

Nife_Util::outputResponse(
	new Nife_HTTP_BasicResponse(200, "I shall be slow", array('Content-Type'=>'text/plain'), new Nife_Demo_SlowBlob($chunk, 5, $interChunkDelay)),
	$outputFunction
);
