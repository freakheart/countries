<?php
namespace App;

include __DIR__.'/vendor/autoload.php';
include __DIR__.'/src/Run.php';
include __DIR__.'/src/RestCountries.php';

use App\src\Run;

//Remove index.php from arguments
array_shift($argv);
new Run($argv);