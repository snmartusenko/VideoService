<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 02.01.2017
 * Time: 11:42
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //������� ������ ������

        //�������� ��� ������� ����� ��� ������� � �������
        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description = '����� ������';
        $auth->add($dashboard);

        //�������� ��� ����������
        $rule = new UserRoleRule();
        $auth->add($rule);

        //��������� ����
        $user = $auth->createRole('user');
        $user->description = '������������';
        $user->ruleName = $rule->name;
        $auth->add($user);

        $moder = $auth->createRole('moder');
        $moder->description = '���������';
        $moder->ruleName = $rule->name;
        $auth->add($moder);

        //��������� ��������
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);
        $admin = $auth->createRole('admin');
        $admin->description = '�������������';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moder);
    }
}