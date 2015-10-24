<?php
namespace bookin\aws\checkbox;

use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class AwesomeCheckbox
 * @package bookin\awesome\checkbox
 *
 * @property boolean|string|array $checked
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
    const STYLE_CIRCLE = 'circle';
    const STYLE_INLINE = 'inline';

    public $checked = false;
    public $type = self::TYPE_CHECKBOX;
    public $style = self::STYLE_DEFAULT;
    public $list = [];

    public function run(){
        AwesomeCheckboxAsset::register($this->getView());
        FontAwesomeAsset::register($this->getView());
        if(!empty($this->list) && is_array($this->list)){
            return $this->renderList();
        }else {
            return $this->renderItem();
        }
    }

    /**
     * @return string
     */
    protected function renderItem(){
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

    protected function renderList(){
        $listAction = $this->type.'List';
        $this->options['item'] = function ($index, $label, $name, $checked, $value) {
            $action = $this->type;
            $id = strtolower($index.'-'.str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name));
            $html = [];
            $html[] = Html::beginTag('div',['class'=>$this->getClass()]);
                $html[] = Html::$action($name, $checked, ['label' => null, 'value' => $value, 'id'=>$id]);
                $html[] = Html::tag('label', $label, ['for'=>$id]);
            $html[] = Html::endTag('div');
            return implode(' ',$html);
        };
        if($this->hasModel()) {
            $listAction = 'active'.ucfirst($listAction);
            $input = Html::$listAction($this->model, $this->attribute, $this->list, $this->options);
        }else{
            $input = Html::$listAction($this->name, $this->checked, $this->list, $this->options);
        }
        return $input;
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