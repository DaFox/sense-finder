<?php

use sense\finder\Finder;
use sense\finder\matcher\Accept;
use sense\finder\matcher\Composite;
use sense\finder\matcher\FileContent;
use sense\finder\matcher\FilePath;
use sense\finder\matcher\FilePathRegexp;
use sense\finder\matcher\LastModified;
use sense\finder\matcher\Negate;

require 'vendor/autoload.php';

$i = 0;

$finder = new Finder('.');
$start  = microtime(true);

date_default_timezone_set('Europe/Berlin');

$matcher = new Composite([
    new Accept(),

    # Not in vendor directory
    new Negate(new FilePath('vendor/*')),

    # Having php extension
    new FilePathRegexp('.*\\.php$'),

    # File modified yesterday or within the last hour
    new Composite([
        new LastModified('now -1 hour'),
        new LastModified('yesterday 00:00:00', 'yesterday 23:59:59')
    ], Composite::ANY),

    # Files containing: sense
    new FileContent('sense')
]);

foreach($matcher->getMatchersSorted() as $m) {
    echo "{$m->getCost()} - ", get_class($m), "\n";
}

foreach($finder->search($matcher) as $file) {
    echo $file . "\n";
    $i++;
}

echo "FOUND $i FILES IN ", microtime(true) - $start, " SECONDS\n";