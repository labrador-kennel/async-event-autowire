<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

enum ListenerRemoval : string {
    case NeverRemove = 'never';
    case AfterOneEvent = 'one';
}
