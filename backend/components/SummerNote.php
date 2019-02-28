<?php

namespace backend\components;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

use backend\assets\CodeMirror as CodeMirrorAssets;
use backend\assets\SummerNote as SummerNoteAssets;

class SummerNote extends InputWidget
{
    /**
     * @var array
     */
    public $options = [
        'id' => 'summernote',
    ];

    /**
     * @var boolean
     */
    public $render = true;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function run()
    {
        if ($this->render) {
            if ($this->hasModel()) {
                echo Html::activeTextarea($this->model, $this->attribute, $this->options);
            } else {
                echo Html::textarea($this->name, $this->value, $this->options);
            }
        }

        $this->connectAssets();
    }

    /**
     * register css, js
     * @throws InvalidConfigException
     */
    public function connectAssets()
    {
        $view = $this->getView();

        $view->registerAssetBundle(SummerNoteAssets::className());
        $view->registerAssetBundle(CodeMirrorAssets::className());

        $id = $this->options['id'];

        $view->registerJs("
            \$(document).ready(function() {
                \$(\"#$id\").summernote({
                    codemirror: {
                        lineNumbers:     true,
                        styleActiveLine: true,
                        //lineWrapping:  true,
                        autoCloseTags:   true,
                        indentUnit:      4,
                        matchTags:       \"bothTags: true\",
                        theme:           \"monokai\",
                        mode:            \"text/html\",
                    }
                });
            });
        ");
    }
}
