<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container9cw4vez\appProdProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container9cw4vez/appProdProjectContainer.php') {
    touch(__DIR__.'/Container9cw4vez.legacy');

    return;
}

if (!\class_exists(appProdProjectContainer::class, false)) {
    \class_alias(\Container9cw4vez\appProdProjectContainer::class, appProdProjectContainer::class, false);
}

return new \Container9cw4vez\appProdProjectContainer([
    'container.build_hash' => '9cw4vez',
    'container.build_id' => '98e70cf7',
    'container.build_time' => 1669917113,
], __DIR__.\DIRECTORY_SEPARATOR.'Container9cw4vez');
