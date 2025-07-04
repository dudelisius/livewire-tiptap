<?php

declare(strict_types=1);

if (! function_exists('arch')) {
    return;
}

uses()->group('arch');

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('php preset')->preset()->php();

arch('security preset')->preset()->security()
    ->ignoring('md5')
    ->ignoring('sha1')
    ->ignoring('tempnam');
