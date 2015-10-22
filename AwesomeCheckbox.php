<?php
namespace bookin\awesome\checkbox;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class AwesomeCheckbox
 * @package bookin\awesome\checkbox
 *
 * @property boolean $checked
 * @property string $type
 * @property array|string $style
 *
 * @property string $labelId
 * @property string $labelContent
 * @property string $input
 */
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
    const STYLE_CIRCLE = 'circle';

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
            $label = $this->labelContent;
            $html[] = $this->input;
            if($label){
                $html[] = Html::tag('label', $label, ['for'=>$this->labelId]);
            }
        $html [] = Html::endTag('div');
        return implode('',$html);
    }

    /**
     * @return string
     */
    protected function getLabelContent(){
        $label = array_key_exists('label',$this->options)?$this->options['label']:'';
        if($this->hasModel()&&empty($label)){
            $label = Html::encode($this->model->getAttributeLabel(Html::getAttributeName($this->attribute)));
        }
        $this->options['label']=null;
        return $label;
    }

    /**
     * @return string
     */
    protected function getLabelId(){
        $id = $this->id;
        if($this->hasModel()&&!array_key_exists('id', $this->options)){
            $id = Html::getInputId($this->model, $this->attribute);
        }elseif(isset($this->options['id'])){
            $id = $this->options['id'];
        }
        return $id;
    }

    /**
     * @return string
     */
    protected function getInput(){
        $input = '';
        $inputType = ucfirst($this->type);
        if($this->hasModel()){
            $inputType = 'active'.$inputType;
            $input = Html::$inputType($this->model, $this->attribute, $this->options);
        }else {
            $input = Html::$inputType($this->name, $this->checked, $this->options);
        }
        return $input;
    }

    /**
     * @return string
     */
    protected function getClass(){
        $class = [];
        $class[] = $this->type;
        if(!empty($this->style)){
            if(is_array($this->style)){
                $class = array_merge($class, array_map(function($item){
                    return $this->type.'-'.$item;
                },$this->style));
            }else{
                $class[] = $this->type.'-'.$this->style;
            }
        }
        return implode(' ', $class);
    }

}