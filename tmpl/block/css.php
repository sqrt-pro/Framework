<?php
$a = array(
  'href'  => $versioning ? $this->asset($file) : $file,
  'media' => $media ?: 'all',
  'rel'   => 'stylesheet',
  'type'  => 'text/css',
);

$t = new \SQRT\Tag('link', null, $a, true);

echo ($if ? '<!--[if ' . $if . ']>' . $t . '<![endif]-->' : $t) . "\n";