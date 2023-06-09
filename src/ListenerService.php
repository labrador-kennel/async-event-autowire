<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\Attribute\ServiceAttribute;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class ListenerService implements ServiceAttribute {

    /**
     * @param ListenerRemoval $listenerRemoval
     * @param list<string> $profiles
     * @param string|null $name
     */
    public function __construct(
        private readonly ListenerRemoval $listenerRemoval = ListenerRemoval::NeverRemove,
        private readonly array $profiles = [],
        private readonly ?string $name = null
    ) {
    }

    public function getListenerRemoval() : ListenerRemoval {
        return $this->listenerRemoval;
    }

    public function getProfiles() : array {
        return  $this->profiles;
    }

    public function isPrimary() : bool {
        return false;
    }

    public function getName() : ?string {
        return $this->name;
    }
}
