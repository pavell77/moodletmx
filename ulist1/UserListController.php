<?php

require_once(__DIR__ . '/AbstractController.php');
require_once(__DIR__ . '/AbstractAction.php');

class UserListController extends AbstractController
{
    /**
     * @return array [
     *      'view' => UserListViewAction::class,
     *      'save' => UserGradeSaveAction::class,
     * ];
     */
    public static function actions()
    {
        return [
            'view' => UserListViewAction::class,
            'save' => UserGradeSaveAction::class,
        ];
    }
}
