<?php

$EM_CONF['flogin'] = [
    'title' => 'Frontend Authentication',
    'description' => 'Provides an authentication option for website users.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '9.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'routes' => '*'
        ]
    ]
];
