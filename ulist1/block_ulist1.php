<?php
require_once(__DIR__ . '/UserListController.php');
require_once(__DIR__ . '/UserListViewAction.php');
class block_ulist1 extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_ulist1');
    }

    public function has_config() {
        return true;
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        
        $action = optional_param('action', 'view', PARAM_TEXT);
        
        try {
            $controller = UserListController::getInstance($action);
            $this->content->text = $controller->execute();
        } catch (\Exception $e) {
            $this->content->text = 'Помилка: ' . $e->getMessage();
        }

        return $this->content;
    }

    public function instance_allow_multiple() {
        return true;
    }
}
