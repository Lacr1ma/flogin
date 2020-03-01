<?php

$EM_CONF['login'] = [
    'title' => 'Frontend Authentication',
    'description' => 'Provides an authentication option for website users.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'alpha',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'routes' => '*'
        ]
    ]
];
