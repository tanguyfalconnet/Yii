<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "createUser" permission
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create an user';
        $auth->add($createUser);
        
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a Post';
        $auth->add($createPost);

        // add "updateUser" permission
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update an user';
        $auth->add($updateUser);
        
        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update a Post';
        $auth->add($updatePost);

        // add "deleteUser" permission
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete an user';
        $auth->add($deleteUser);
        
        // add "deletePost" permission
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete a Post';
        $auth->add($deletePost);
        
        // add "user" role and give this role the "createPost" permission
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createPost);
        
        $modo = $auth->createRole('moderator');
        $auth->add($modo);
        $auth->addChild($modo, $updatePost);
        $auth->addChild($modo, $deletePost);
        $auth->addChild($modo, $user);
        

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $modo);
        
        // add the rules
        $rule1 = new \console\rbac\UpdateOwnUserRule;
        $auth->add($rule1);
        $rule2 = new \console\rbac\DeleteOtherUserRule;
        $auth->add($rule2);
        $rule3 = new \console\rbac\UpdateOwnPostRule;
        $auth->add($rule3);
        $rule4 = new \console\rbac\DeleteOwnPostRule;
        $auth->add($rule4);

        // add the "updateOwnUser" permission and associate the rule with it.
        $updateOwnUser = $auth->createPermission('updateOwnUser');
        $updateOwnUser->description = 'Update own user';
        $updateOwnUser->ruleName = $rule1->name;
        $auth->add($updateOwnUser);
        
        // add the "deleteOtherUser" permission and associate the rule with it.
        $deleteOtherUser = $auth->createPermission('deleteOtherUser');
        $deleteOtherUser->description = 'Delete other user';
        $deleteOtherUser->ruleName = $rule2->name;
        $auth->add($deleteOtherUser);
        
        // add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own Post';
        $updateOwnPost->ruleName = $rule3->name;
        $auth->add($updateOwnPost);
        
        // add the "deleteOwnPost" permission and associate the rule with it.
        $deleteOwnPost = $auth->createPermission('deleteOwnPost');
        $deleteOwnPost->description = 'Delete own Post';
        $deleteOwnPost->ruleName = $rule4->name;
        $auth->add($deleteOwnPost);

        // "updateOwnUser" will be used from "updateUser"
        $auth->addChild($updateOwnUser, $updateUser);
        
        // "deleteOtherUser" will be used from "deleteUser"
        $auth->addChild($deleteOtherUser, $deleteUser);
        
        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPost, $updatePost);
        
        // "deleteOwnPost" will be used from "deletePost"
        $auth->addChild($deleteOwnPost, $deletePost);

        // allow "user" to update their own profile
        $auth->addChild($user, $updateOwnUser);
        
        // allow "user" to update their own post
        $auth->addChild($user, $updateOwnPost);
        
        // allow "user" to delete their own post
        $auth->addChild($user, $deleteOwnPost);
        
        // allow "qdmin" to delete other user
        $auth->addChild($admin, $deleteOtherUser);

        
        $auth->assign($user, 3);
        $auth->assign($modo, 2);
        $auth->assign($admin, 1);
    }
}