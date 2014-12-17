<?php
$a = array(
  'src'  => $versioning ? $this->asset($file) : $file,
  'type' => 'text/javascript',
);

$t = new \SQRT\Tag('script', null, $a);

echo ($if ? '<!--[if ' . $if . ']>' . $t . '<![endif]-->' : $t) . "\n";