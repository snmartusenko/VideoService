<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 02.01.2017
 * Time: 11:37
 */

namespace common\components\rbac;

use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //ѕолучаем массив пользовател€ из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; //«начение из пол€ role базы данных
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            }
//            elseif ($item->name === 'moder') {
//                //moder €вл€етс€ потомком admin, который получает его права
//                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER;
//            }
            elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN /*|| $role == User::ROLE_MODER*/
                || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}