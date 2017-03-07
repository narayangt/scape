<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 29/12/16
 * Time: 9:02 PM
 */

namespace scape\source\template;

include_once("../../scInit.php");

use scape\source\scape\Timestamp;
use scape\source\element\ALink;
use scape\source\element\Element;
use scape\source\scape\CssController;
use scape\source\scape\FileHandler;
use scape\source\view\AView;
use scape\source\element\Div;


/**
 * Class ATemplate
 *
 */
abstract class ATemplate{

    /**
     * @var  array $sections
     *  by default: adminMenu,headerContent,menu ,
     *  farLeftSideBar,leftSideBar,Content, rightSideBar,
     *  farRightSideBar and footerContent
     */
    protected $sections;

    /**
     * @var string $title
     *
     * title of the page in <head> section
     */
    protected $title;


    /**
     * todo container protected $containerType;
     */


    /**
     * Template constructor.
     * @param bool $adminMenu
     * @param bool $header
     * @param bool $menu
     * @param bool $farLeftSideBar
     * @param bool $leftSideBar
     * @param bool $rightSidebar
     * @param bool $farRightSideBar
     * @param bool $footer
     */

    public function __construct($adminMenu, $header, $menu, $farLeftSideBar, $leftSideBar, $rightSidebar, $farRightSideBar, $footer){
        $this->sections             =   [];
        $this->setTitle();
        $this->setPageView($adminMenu, $header, $menu, $farRightSideBar, $leftSideBar, $rightSidebar, $farRightSideBar,$footer);
    }
    public function getHead():Element{
        $head	=	new Element("head");
        $cssStyles= CssController::getInstance();
        $scriptHandler=FileHandler::getInstance();
        $scriptHandler->addCssPath(HOME_PATH."library/css/main.css");

        $head->addSubElement(new Element("title","","","","",true,$this->getTitle()));
        $head->addSubElement(new Element("meta","","","","",false,"",["charset"=>"utf-8"]));
        $head->addSubElement(new Element("meta","","","","",false,"",["name"=>"description","content"=>"Planet on net. Future of the web technology"]));
        $head->addSubElement(new Element("meta","","","","",false,"",["name"=>"keyword","content"=>"Future, of, Web, Planet, on, Net, Internet, Technology of web, Narayan, Bhandari, Web Developer, Web Designer, PHP, Developer, JavaScript, Framework, narayan.id.au, future"]));
        $head->addSubElement(new Element("meta","","","","",false,"",["name"=>"author","content"=>"Narayan Bhandari, narayan.id.au"]));
        $head->addSubElement(new Element("meta","","","","",false,"",["name"=> "google-site-verification", "content"=>"9AauezAlAjn7cmGZWULWcTvdSRsMm1m9b2rXRcZ6p80"]));
        $head->addSubElement(new Element("meta","","","","",false,"",["name"=>"viewport", "content"=>"width=device-width, initial-scale=1.0"]));
        $head->addSubElement($scriptHandler->getFilesTag());
        $head->addSubElement($cssStyles->getStyles(5));
        return $head;
    }
    public function getBody():Element{
        $body=new Element("body");
        $container= new Div("container");
        foreach ($this->sections as $item)
            $container->addSubElement($item);
        $body->addSubElement($container);
        return $body;
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title=TITLE){
        $this->title = $title;
    }

    // functions to set custom page;

    public function setPageView($adminMenu=false, $header=true, $menu=true, $farLeftSideBar=false,
                                $leftSideBar=true, $rightSidebar=true, $farRightSideBar=false, $footer=true){
        if($adminMenu)
            $this->addSection(\AppConstant::ADMIN_MENU,new Element("nav",\AppConstant::ADMIN_MENU));
        else
            $this->removeSection(\AppConstant::ADMIN_MENU);
        if($header)
            $this->addSection(\AppConstant::HEADER_CONTENT, new Element("header",\AppConstant::HEADER_CONTENT));
        else
            $this->removeSection(\AppConstant::HEADER_CONTENT);
        if($menu)
            $this->addSection(\AppConstant::MENU, new Element("nav",\AppConstant::MENU));
        else
            $this->removeSection(\AppConstant::MENU);
        if($farLeftSideBar)
            $this->addSection(\AppConstant::FAR_LEFT_SIDE_BAR, new Element("asside",\AppConstant::FAR_LEFT_SIDE_BAR));
        else
            $this->removeSection(\AppConstant::FAR_LEFT_SIDE_BAR);
        if($leftSideBar)
            $this->addSection(\AppConstant::LEFT_SIDE_BAR, new Element("asside",\AppConstant::LEFT_SIDE_BAR));
        else
            $this->removeSection(\AppConstant::LEFT_SIDE_BAR);
        $this->addSection(\AppConstant::CONTENT, new Element("section",\AppConstant::CONTENT));
        if($rightSidebar)
            $this->addSection(\AppConstant::RIGHT_SIDE_BAR, new Element("asside",\AppConstant::RIGHT_SIDE_BAR));
        else
            $this->removeSection(\AppConstant::RIGHT_SIDE_BAR);
        if($farRightSideBar)
            $this->addSection(\AppConstant::FAR_RIGHT_SIDE_BAR, new Element("asside",\AppConstant::FAR_RIGHT_SIDE_BAR));
        else
            $this->removeSection(\AppConstant::FAR_RIGHT_SIDE_BAR);
        if($footer){
            $tmpTime=new Timestamp();
            $tmpFooter= new Element("footer",\AppConstant::FOOTER_CONTENT);
            $tmpFooter->addSubElement(new ALink("&copy; Reserved by ".COPYRIGHT_NAME." ".$tmpTime->getYear()));
            $this->addSection(\AppConstant::FOOTER_CONTENT, $tmpFooter);
        }
        else
            $this->removeSection(\AppConstant::FOOTER_CONTENT);
    }
    public function addSection($section,Element $content){
        $this->sections[$section]=$content;
    }
    public function addSectionChild($identifier,Element $child){
        if($this->isActive($identifier))
            $this->sections[$identifier]->addSubElement($child);
    }
    public function isActive($section):bool {
        return isset($this->sections[$section]);
    }
    public function removeSection($section){
        if($this->isActive($section))
            unset($this->sections[$section]);
    }
    public function __get($name){
        if($this->isActive($name))
            return $this->sections[$name];
        return false;
    }
    public function __set($name, Element $value){
        $this->addSectionChild($name,$value);
    }
}