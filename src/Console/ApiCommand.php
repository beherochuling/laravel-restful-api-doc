<?php
namespace OlderW\RestfulDoc\Console;

use Illuminate\Console\Command;

use OlderW\RestfulDoc\RestfulDoc;

class ApiCommand extends Command {
    protected $signature = 'build:apidoc {doc} {--publish}';
    protected $description = '生成系统所用的文档 type的取值为api或者error --publish 表示直接自动发布';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $doc = $this->argument('doc');
        $docs = config(RestfulDoc::$config_path.'.docs');
        if ( !isset($docs[$doc]) ) {
            if ( empty($docs) ) {
                die("目前系统中没有任何配置，请修改 config/" . RestfulDoc::$config_path . ".php\n"
                    ."初次安装，请执行 php artisan vendor:publish --provider=\"OlderW\RestfulDoc\RestfulServiceProvider\"\n");
            } else {
                die("您输入的文档类型 " . $doc . " 没有对应配置\n"
                    . "目前系统仅仅配置了 " . implode(", ", array_keys($docs)) . "\n"
                    . "新的类型请在 " . RestfulDoc::$config_path . " 的 .pusher.docs 中进行配置\n");
            }
        }

        $type = $docs[$doc]['type'];
        $publish = $this->option('publish');
        $marker = app(config(RestfulDoc::$config_path.'.maker'));

        $data = '';
        switch ( $type ) {
            case 'api':
                $data = $marker::getDoc($docs[$doc]['path'], $docs[$doc]['base_class']);
            break;
            case 'error':
                $data =  $marker::getExceptionDoc($docs[$doc]['path'], $docs[$doc]['base_class']);
                break;
            case 'enum':
                $data =  $marker::getEnumDoc($docs[$doc]['path'], $docs[$doc]['base_class']);
            break;
            default:
                echo '请输入要生成的文件类型 api backend exception menu';
        }
        if ( empty($data) ) die("内如为空，请修正后发布\n");

        if ( $publish ) {
            app(config(RestfulDoc::$config_path.'.publisher'))->push($doc, $data);
        } else {
            echo $data;
        }
    }
}