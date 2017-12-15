<?php

class Model_Config extends \Orm\Model
{
    protected static $_properties = [
        'key',
        'value'
    ];

    protected static $_table_name = 'config';
    protected static $_primary_key = ['key'];


    protected function getAll()
    {
        return $this::find('all');
    }

    public static function getVersion()
    {
        $key       = 'version';
        $dbVersion = Model_Config::getValueByKey($key);
        if ($dbVersion != null) {
            return (int)$dbVersion;
        }
//        $currentTimestamp = time();
        $new              = new Model_Config();
        $new->key         = $key;
        $new->value       = 0;
        $new->save();
        return (int)$new->_data['value'];
    }

    public static function getValueByKey($key)
    {
        $dbRow = Model_Config::find($key);
        if ($dbRow) {
            return $dbRow->_data['value'];
        }
        return null;
    }

    public static function updateLatestVersion($latestVersion)
    {
        $key       = 'version';
        $entry = Model_Config::find($key);
        $entry->value = $latestVersion;
        $entry->save();
    }
}
