<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 5/8/16
 * Time: 10:34 AM
 */

namespace scape\source\element;



use scape\source\controller\BaseController;

class Element extends AElement  implements IElement {

    protected $childs;
    protected $parent;


    public function __construct($tagName, $id="", $class="", $height=0, $width=0, $closingTag=true,$text="",$attributes=null, $styles=null)
    {
        parent::__construct($tagName,$id,$class,$height,$width,$closingTag,$text,$attributes,$styles);
        $this->childs= [];
    }

    /**
     * @param Element|array $element
     */
    public function addSubElement($element){
        if(is_array($element)) {
            foreach ($element as $item) {
                $this->addSubElement($item);
            }
        }
        else{
            $copy= clone $element;
            $copy->setParent($this);
            $this->childs[]= clone $copy;
        }
    }

    /**
     * @param Element|null $parent
     */
    public function setParent(Element $parent=null){
        $this->parent=$parent;
    }

    /**  Not used yet, left for next advance programming
     * todo
     * public function getParentID(){
     *
     * }
     * public function getParentTag(){
     *
     * }
     *
     */

     /**
     *
     * @param BaseController $controller
     */

    public function configController(BaseController $controller){
        foreach ($controller->getVars() as $var=>$value){
            $search=VAR_PREFIX.$var;
            $this->setText(str_replace($search,$value,$this->getText()));
        }
    }

}
?>