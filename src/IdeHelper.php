<?php

namespace Mitirrli\IdeHelper;

use yii\base\Component;
use yii\console\Application;
use yii\helpers\ArrayHelper;
use Mitirrli\IdeHelper\commands\IdeHelperController;

/**
 * Ide helper component for Yii framework 2.x.x version.
 */
class IdeHelper extends Component
{
    /**
     * the root directory
     */
    public $rootDir;
    /**
     * the custom configuration files
     */
    public $configFiles = [];
    /**
     * the generated file name
     */
    public $filename = '_ide_helper';
    /**
     * the default configuration files
     */
    protected $defaultConfigFiles = [
        'common/config/main.php',
        'common/config/main-local.php',
        'frontend/config/main.php',
        'frontend/config/main-local.php',
        'backend/config/main.php',
        'backend/config/main-local.php',
    ];
    
    /**
     * init method.
     */
    public function init()
    {
        if (\Yii::$app instanceof Application) {
            \Yii::$app->controllerMap['ide-helper'] = IdeHelperController::class;
        }
    }

    /**
     * get the root directory.
     */
    protected function getRootDir()
    {
        return $this->rootDir ? rtrim($this->rootDir, '\/') : dirname(\Yii::getAlias('@vendor'));
    }

    /**
     * return the default configuration and custom configuration.
     */
    protected function readConfig()
    {
        $configFiles = array_merge($this->defaultConfigFiles, $this->configFiles);
        $config = ['components' => []];
        $root = $this->getRootDir();
        foreach ($configFiles as $file) {
            if (is_file($root . DIRECTORY_SEPARATOR . $file)) {
                $config = ArrayHelper::merge($config, require($file));
            }
        }

        return $config;
    }

    /**
     * return final of the filename.
     */
    protected function generateFilename()
    {
        return $this->getRootDir() . DIRECTORY_SEPARATOR . $this->filename . '.php';
    }

    /**
     * generate the ide helper.
     */
    public function generate()
    {
        $config = $this->readConfig();
        $string = '';
        foreach ($config['components'] as $name => $component) {
            if (isset($component['class'])) {
                $string .= ' * @property ' . $component['class'] . ' $' . $name . PHP_EOL;
            }
        }

        $template = '<?php

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication
     */
    public static $app;
}

/**
 * phpdoc
 */
abstract class BaseApplication extends \yii\base\Application {}';

        file_put_contents($this->generateFilename(), str_replace(' * phpdoc', rtrim($string, PHP_EOL), $template));
    }
}

