<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Frontend Authentication',
    'description' => 'Provides an authentication option for website users.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'alpha',
    'clearCacheOnLoad' => true,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99'
        ]
    ]
];
