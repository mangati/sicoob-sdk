<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class TestUtils
{
    private const RESOURCES_DIR = __DIR__ . '/resources';

    public static function readResource(string $name): string
    {
        return file_get_contents(sprintf('%s/%s', self::RESOURCES_DIR, $name));
    }
}
