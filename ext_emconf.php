<?php

$EM_CONF["bdm_middleware_redirect_with_tsfe"] = [
    'title' => 'bdm_middleware_redirect_with_tsfe',
    'description' => 'Workaround for the "TypoScriptFrontendController was tried to be injected before initial creation" - Bug.',
    'category' => 'plugin',
    'author' => 'Benjamin Beck',
    'author_email' => '',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
