<?php

declare(strict_types=1);

uses()->group('arch');

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch()->preset()->php();

arch()->preset()->security()
    ->ignoring('md5')
    ->ignoring('sha1')
    ->ignoring('tempnam');
