<?php

declare(strict_types=1);

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Constants\Events;

require __DIR__ . '/../vendor/autoload.php';

$events = scandir(__DIR__ . '/../src/Gateway/Events');

$events = array_filter($events, fn ($event) => !in_array($event, ['.', '..']));

$events = array_map(fn ($event) => substr($event, 0, strlen($event) - 4), $events);

$namedEvents = array_map(fn ($event) => preg_replace('/(?<!^)([A-Z])/', ' $0', $event), $events);

$events = array_combine($events, $namedEvents);

foreach ($events as $className => $friendlyName) {
    $eventInfo = [];

    $class = 'Ragnarok\\Fenrir\\Gateway\\Events\\' . $className;

    if (!class_exists($class)) {
        continue;
    }

    $reflected = new ReflectionClass($class);

    $eventInfo['name'] = $friendlyName;
    $eventInfo['event'] = array_keys(array_filter(Events::MAPPINGS, function ($mappedClass) use ($class) {
        return $mappedClass === $class;
    }))[0];

    $eventInfo['intents'] = array_map(
        fn (ReflectionAttribute $intent) => $intent->newInstance()->intent->name,
        $reflected->getAttributes(RequiresIntent::class)
    );

    $eventInfo['properties'] = array_map(function (ReflectionProperty $reflectionProp) {
        $name = $reflectionProp->getName();
        $type = $reflectionProp->getType();


        $types = [];
        if ($type === null) {
            $types[] = 'any';
        } elseif ($type instanceof ReflectionNamedType) {
            $types[] = $type->getName();
        } else {
            foreach ($type->getTypes() as $subType) {
                $types[] = $subType->getName();
            }
        }

        if ($type?->allowsNull()) {
            $types[] = 'null';
        }

        sort($types);

        $types = array_unique($types);

        return [
            'name' => $name,
            'types' => array_map(fn ($type) => '`' . $type . '`', $types),
        ];
    }, $reflected->getProperties(ReflectionProperty::IS_PUBLIC));

    $fileContent  = '## ' . $friendlyName . PHP_EOL;
    $fileContent .= '### Required Intents' . PHP_EOL;
    foreach ($eventInfo['intents'] as $intent) {
        $fileContent .= '- `' . $intent . '`' . PHP_EOL;
    }
    $fileContent .= PHP_EOL;
    $fileContent .= '### Properties' . PHP_EOL;
    $fileContent .= '|property|type|' . PHP_EOL;
    $fileContent .= '|--------|----|' . PHP_EOL;
    foreach ($eventInfo['properties'] as $property) {
        $fileContent .= '|`' . $property['name'] . '`|' . implode('&#124;', $property['types']) . '|' . PHP_EOL;
    }

    $fileContent .= PHP_EOL;
    $fileContent .= '### How to use' . PHP_EOL;
    $fileContent .= '```php' . PHP_EOL;
    $fileContent .= 'use ' . $class . ';' . PHP_EOL;
    $fileContent .= 'use ' . Events::class . ';' . PHP_EOL;
    $fileContent .= PHP_EOL;
    $fileContent .= '$discord->gateway->events->on(Events::' . $eventInfo['event'] . ', function (' . $className . ' $event) {' . PHP_EOL;
    $fileContent .= '    // ...' . PHP_EOL;
    $fileContent .= '});' . PHP_EOL;
    $fileContent .= '```' . PHP_EOL;

    var_dump(__DIR__ . '/../Docs/Events/' . $friendlyName . '.md');
    file_put_contents(__DIR__ . '/../Docs/Events/' . $friendlyName . '.md', $fileContent);
}
