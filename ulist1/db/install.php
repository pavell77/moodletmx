<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_block_ulist1_install() {
    global $DB;

    // Создаем таблицу для хранения оценок пользователей
    $table = new xmldb_table('user_grades');
    
    // Определяем поля таблицы
    $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, '0', 'id');
    $table->add_field($field);
    
    $field = new xmldb_field('grade', XMLDB_TYPE_INTEGER, '2', null, null, null, null, '0', 'userid');
    $table->add_field($field);
    
    $field = new xmldb_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, '0', 'grade');
    $table->add_field($field);
    
    // Создаем индекс
    $index = new xmldb_index('userid', XMLDB_INDEX_UNIQUE, ['userid']);
    $table->add_index($index);
    
    // Создаем таблицу
    if (!$DB->get_manager()->table_exists($table)) {
        $DB->get_manager()->create_table($table);
    }
}
