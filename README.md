# Labrador async-event Autowire

This library is an optional tool to be used with [labrador-kennel/async-event]() and [cspray/annotated-container](). It allows automatically registering async-event Listeners into the Emitter wired in your container. This library and documentation are geared toward users with an understanding of both async-event and annotated-container. If you are not already using these libraries, this repo doesn't have a lot for you.

## Guide

### Step 1: Install the library

Composer is the only supported method of installing this library.

```shell
composer require labrador-kennel/async-event-autowire
```

### Step 2: Configure the DefinitionProvider

In your app's Annotated Container configuration, add the appropriate DefinitionProvider: `Labrador\AsyncEvent\Autowire\DefinitionProvider`. This will ensure that the `Labrador\AsyncEvent\Emitter` is wired into your container appropriately. By default, this interface will be aliased to `Labrador\AsyncEvent\AmpEmitter`. 

If you are using the default XML configuration for Annotated Container, this should look something like:

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<annotatedContainer xmlns="https://annotated-container.cspray.io/schema/annotated-container.xsd" version="3.0.0">
    <!-- all the rest of the configuration -->
    <definitionProviders>
        <definitionProvider>
            Labrador\AsyncEvent\Autowire\DefinitionProvider
        </definitionProvider>
    </definitionProviders>
</annotatedContainer>
```

> If you are starting with a greenfield project that does not yet have an Annotated Container configuration, you can ensure this library is installed and run `./vendor/bin/annotated-container init` and this configuration value will automatically be set.

### Step 3: Add autowiring Annotated Container Listener

In your app's bootstrapping code, add the `Labrador\AsyncEvent\Autowire\RegisterAutowiredListener` to your Annotated Container emitter. This Annotated Container Listener is responsible for finding appropriate Listener services that should be automatically registered and adding them to the Async Event Emitter defined in your Container.

Bootstrapping code is generally more varied, but you should have something that resembles the following:

```php
<?php declare(strict_types=1);

use Cspray\AnnotatedContainer\Bootstrap\Bootstrap;
// Replace this with the ContainerFactory implementation of your choice
use Cspray\AnnotatedContainer\ContainerFactory\PhpDiContainerFactory;
use Cspray\AnnotatedContainer\Event\Emitter;
use Labrador\AsyncEvent\Autowire\RegisterAutowiredListener;

require_once __DIR__ . '/vendor/autoload.php';

$emitter = new Emitter();

/** !! This is the piece to add so your Listeners are automatically registered !! */
$emitter->addListener(new RegisterAutowiredListener());

$container = Bootstrap::fromAnnotatedContainerConventions(
    new PhpDiContainerFactory($emitter),
    $emitter
)->bootstrapContainer();
```

### Step 4: Annotate your Async Event Listener

Finally, ensure your Labrador Listeners are properly annotated with the `#[AutowiredListener]` attribute. This will define each Listener as a service in the Container. This allows us to retrieve them after the Container is created to register them with the Labrador Emitter. This also means that your Labrador Listeners can define other services in their constructor, and they will be automatically resolved by the Container.

```php
<?php declare(strict_types=1);

use Amp\Future
use Labrador\AsyncEvent\Event;
use Labrador\AsyncEvent\Listener;
use Labrador\AsyncEvent\Autowire\AutowiredListener;
use Labrador\CompositeFuture\CompositeFuture;

#[AutowiredListener('my-event-name')]
final class MyListener implements Listener {

    public function handle(Event $event) : Future|CompositeFuture|null {
        // do the thing for your listener
        return null;
    }

}
```