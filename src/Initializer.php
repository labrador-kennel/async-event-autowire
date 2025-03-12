<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\Bootstrap\ThirdPartyInitializer;

final class Initializer extends ThirdPartyInitializer {

    public function packageName() : string {
        return 'labrador-kennel/async-event';
    }

    public function relativeScanDirectories() : array {
        return [];
    }

    public function definitionProviderClass() : ?string {
        return DefinitionProvider::class;
    }
}
