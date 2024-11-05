<?php

declare(strict_types=1);

namespace Mangati\Sicoob;

use RuntimeException;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
# Symfony >= 7
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
# Symfony <= 6.4
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Helper class responsible for creating the correct serializer/normalizer instances.
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 *
 * @internal
 */
final class SerializerFactory
{
    private static ?SerializerInterface $serializer = null;
    private static ?NormalizerInterface $normalizer = null;

    public static function createSerializer(): SerializerInterface
    {
        if (!self::$serializer) {
            self::setup();
        }

        return self::$serializer;
    }

    public static function createNormalizer(): NormalizerInterface
    {
        if (!self::$normalizer) {
            self::setup();
        }

        return self::$normalizer;
    }

    private static function setup(): void
    {
        if (class_exists(AttributeLoader::class)) {
            $loader = new AttributeLoader();
        } elseif (class_exists(AnnotationLoader::class)) {
            $loader = new AnnotationLoader();
        } else {
            throw new RuntimeException('No loader available');
        }

        $classMetadataFactory = new ClassMetadataFactory($loader);
        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);

        self::$normalizer = new ObjectNormalizer($classMetadataFactory, null, null, $extractor);

        self::$serializer = new Serializer(
            normalizers: [
                new ArrayDenormalizer(),
                new UidNormalizer(),
                new DateTimeNormalizer(),
                new BackedEnumNormalizer(),
                self::$normalizer,
            ],
            encoders: [
                new JsonEncoder(),
            ]
        );
    }
}
