<?php
namespace bookin\awesome\checkbox;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class AwesomeCheckbox extends InputWidget
{
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_RADIO = 'radio';

    const STYLE_DEFAULT = '';
    const STYLE_PRIMARY = 'primary';
    const STYLE_SUCCESS = 'success';
    const STYLE_INFO = 'info';
    const STYLE_WARNING = 'warning';
    const STYLE_DANGER = 'danger';
    const STYLE_LINK = 'link';

    public $checked = false;
    public $type = self::TYPE_CHECKBOX;
    public $style = self::STYLE_DEFAULT;

    public function run(){
        AwesomeCheckboxAsset::register($this->getView());
        FontAwesomeAsset::register($this->getView());
        return $this->renderCheckbox();
    }

    protected function renderCheckbox(){
        $html = [];
        $html [] = Html::beginTag('div',['class'=>$this->getClass()]);
        $options = $this->options;
        $label = array_key_exists('label',$options)?$options['label']:false;
        $options['label'] = null;
        $id = isset($options['id'])?$options['id']:$this->id;
        $inputType = ucfirst($this->type);

        if(!empty($this->model) && !empty($this->attribute)){
            if (!array_key_exists('id', $options)) {
                $id = Html::getInputId($this->model, $this->attribute);
            }
            if(!$label){
                $label = Html::encode($this->model->getAttributeLabel(Html::getAttributeName($this->attribute)));
            }
            $inputType = 'active'.$inputType;
            $html[] = Html::$inputType($this->model, $this->attribute, $options);
        }else{
            $html[] = Html::$inputType($this->name, $this->checked, $options);
        }

        if($label){
            $html[] = Html::tag('label', $label, ['for'=>$id]);
        }

        $html [] = Html::endTag('div');
        return implode('',$html);
    }

    protected function getClass(){
        $class = [];
        $class[] = $this->type;
        if(!empty($this->style)){
            $class[] = $this->type.'-'.$this->style;
        }
        return implode(' ', $class);
    }

}