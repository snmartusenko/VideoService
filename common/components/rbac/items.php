<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => '����� ������',
    ],
    'user' => [
        'type' => 1,
        'description' => '������������',
        'ruleName' => 'userRole',
    ],
    'moder' => [
        'type' => 1,
        'description' => '���������',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'dashboard',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => '�������������',
        'ruleName' => 'userRole',
        'children' => [
            'moder',
        ],
    ],
];
