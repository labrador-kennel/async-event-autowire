<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests\Stub;

use Amp\Future;
use Labrador\AsyncEvent\AbstractListener;
use Labrador\AsyncEvent\Autowire\ListenerRemoval;
use Labrador\AsyncEvent\Autowire\ListenerService;
use Labrador\AsyncEvent\Event;
use Labrador\CompositeFuture\CompositeFuture;

#[ListenerService(ListenerRemoval::AfterOneEvent)]
class BazListener extends AbstractListener {

    public function handle(Event $event) : Future|CompositeFuture|null {
        return Future::complete('baz');
    }

    public function canHandle(string $eventName) : bool {
        return $eventName === 'something';
    }
}
