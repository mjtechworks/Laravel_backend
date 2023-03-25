<?php

return [
    // Days before deleting soft deleted content
    'days' => 60,

    // Whether to log the number of soft deleted records
    'log' => false,

    // List of models and/or pivot tables to run Quicksand on
    'deletables' => [
        \App\Model\User::class, // Media is not deleted in quicksand

        // App\Example::class => [
        //     'days' => '30' // override default 'days'
        // ]

        // 'example_pivot', 

        // 'example_pivot' => 
        //     'days' => '30' // override default 'days'
        // ]
    ],
];
