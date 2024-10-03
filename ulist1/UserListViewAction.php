<?php

require_once(__DIR__ . '/AbstractAction.php');

class UserListViewAction extends AbstractAction
{
    public function execute()
    {
        global $DB;

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'user_') === 0) {
                    $userid = str_replace('user_', '', $key); 
                    $grade = intval($value); 

                    
                    if ($grade >= 1 && $grade <= 10) {
                       
                        if ($DB->record_exists('user_grades', ['userid' => $userid])) {
                            
                            $DB->set_field('user_grades', 'grade', $grade, ['userid' => $userid]);
                        } else {
                            
                            $record = new stdClass();
                            $record->userid = $userid;
                            $record->grade = $grade;
                            $record->timecreated = time();
                            $DB->insert_record('user_grades', $record);
                        }
                    }
                }
            }
        }

        
        $users = $DB->get_records('user', ['deleted' => 0]);

        
        $output = html_writer::tag('h2', 'Список користувачів');

        
        $table = new html_table();
        $table->head = ['ID', 'Ім\'я', 'Призвище', 'Email', 'Оцінка', 'Дія'];

        foreach ($users as $user) {
            
            $grade = $DB->get_field('user_grades', 'grade', ['userid' => $user->id]);

           
            $form = html_writer::start_tag('form', ['method' => 'post']);
            $form .= html_writer::select(range(1, 10), "user_{$user->id}", $grade ?: 0, ['' => 'Виберіть оцінку']);
            $form .= html_writer::empty_tag('input', ['type' => 'submit', 'value' => 'Зберегти']);
            $form .= html_writer::end_tag('form');

            
            $table->data[] = [
                $user->id,
                $user->firstname,
                $user->lastname,
                $user->email,
                $grade ?: 'Немає оцінки',
                $form
            ];
        }

        
        $output .= html_writer::table($table);

        return $output;
    }
}
