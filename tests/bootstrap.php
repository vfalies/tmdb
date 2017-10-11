<?php
/*
 * This file is part of the TMDB package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
date_default_timezone_set('UTC');
require __DIR__.'/../vendor/autoload.php';

@unlink('logs/unittest.log');
