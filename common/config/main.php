<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        // �������� �������� �������� �������
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],

        // �������� �������� ����� (RBAC)
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user', 'admin'], //����� ����������� ����
            //������� ���� ����� ����������� ���� ����� ������������ RBAC
            'itemFile' => '@common/components/rbac/items.php',
            'assignmentFile' => '@common/components/rbac/assignments.php',
            'ruleFile' => '@common/components/rbac/rules.php'
        ],

        //JWPlayer
        'jwplayer' => [
            'class' => 'wadeshuler\jwplayer\JWConfig',
            'key' => '7kZ8KfoujmqMy6LzovFAyq2VvcmVMrhC3e4LoQ==',  // <-- Your Key Here!!
        ]
    ],
];
