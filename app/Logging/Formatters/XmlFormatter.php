<?php

namespace App\Logging\Formatters;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

class XmlFormatter implements FormatterInterface
{
    public function format(LogRecord $record)
    {
        $xml = new \SimpleXMLElement('<log/>');
        $recordArray = $record->toArray(); 
        array_walk_recursive($recordArray, function($value, $key) use ($xml) {
            $xml->addChild($key, htmlspecialchars($value));
        });
        return $xml->asXML() . PHP_EOL;
    }

    public function formatBatch(array $records)
    {
        $xml = new \SimpleXMLElement('<logs/>');
        foreach ($records as $record) {
            $log = $xml->addChild('log');
            $recordArray = $record->toArray(); 
            array_walk_recursive($recordArray, function($value, $key) use ($log) {
                $log->addChild($key, htmlspecialchars($value));
            });
        }
        return $xml->asXML() . PHP_EOL;
    }
}
