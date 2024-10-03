<?php

require_once(__DIR__ . '/AbstractAction.php');

class UserGradeSaveAction extends AbstractAction
{
    public function execute()
    {
        global $DB;

        
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'user_') === 0) {
                $userid = str_replace('user_', '', $key);
                
                
                $grade = intval($value);

                
                if ($grade >= 1 && $grade <= 10) {
                    
                    if ($DB->record_exists('user_grades', ['userid' => $userid])) {
                        $DB->update_record('user_grades', ['userid' => $userid, 'grade' => $grade, 'timecreated' => time()]);
                    } else {
                        $DB->insert_record('user_grades', ['userid' => $userid, 'grade' => $grade, 'timecreated' => time()]);
                    }

                    return 'Оцінка збережена!';
                } else {
                    return 'Помилка: Оцінка повинна бути від 1 до 10.';
                }
            }
        }

        return 'Помилка: оцінка не збережена.';
    }
}
