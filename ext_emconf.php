<?php

$EM_CONF['flogin'] = [
    'title' => 'Frontend Authentication',
    'description' => 'Provides an authentication option for website users.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '11.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.3-11.5.99',
            'routes' => '*'
        ]
    ]
];