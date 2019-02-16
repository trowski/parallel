--TEST--
parallel killed
--SKIPIF--
<?php
if (!extension_loaded('parallel')) {
	echo 'skip';
}
?>
--FILE--
<?php
$parallel = new \parallel\Runtime();

$parallel->run(function($a, $b){
	while(1) {
		$c += $a + $b;
	}
}, [1,2]);

$future = $parallel->run(function(){
	echo "NO";
	return true;
});

$parallel->kill();

try {
	$future->value();
} catch (\parallel\Exception $ex) {
	var_dump($ex->getMessage());
}
?>
--EXPECTF--
string(%d) "Runtime was killed, cannot retrieve value"





