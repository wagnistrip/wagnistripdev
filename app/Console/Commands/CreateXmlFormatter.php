<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateXmlFormatter extends Command
{
    protected $signature = 'make:xml-formatter';
    protected $description = 'Create the XmlFormatter.php file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filesystem = new Filesystem();
        $path = app_path('Logging/Formatters/XmlFormatter.php');

        if ($filesystem->exists($path)) {
            $this->error('XmlFormatter.php already exists!');
            return;
        }

        $filesystem->ensureDirectoryExists(dirname($path));

        $content = <<<'PHP'
<?php

namespace App\Logging\Formatters;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

class XmlFormatter implements FormatterInterface
{
    public function format(LogRecord $record)
    {
        $xml = new \SimpleXMLElement('<log/>');
        $recordArray = $record->toArray(); // Assign to a variable first
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
            $recordArray = $record->toArray(); // Assign to a variable first
            array_walk_recursive($recordArray, function($value, $key) use ($log) {
                $log->addChild($key, htmlspecialchars($value));
            });
        }
        return $xml->asXML() . PHP_EOL;
    }
}
PHP;

        $filesystem->put($path, $content);
        $this->info('XmlFormatter.php has been created successfully.');
    }
}
