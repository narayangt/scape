<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 23/1/17
 * Time: 10:10 AM
 */

namespace scape\source\element;


use scape\source\scape\FileHandler;

class Parralax extends Div{
    public function __construct($id="", $class="parallax")
    {
        parent::__construct($id, $class);
        FileHandler::getInstance()->addCssPath("//www.planetonnet.com/SCAPE/library/css/parallax.css");


        $this->setText('<div id="group1" class="parallax__group">
      <div class="parallax__layer parallax__layer--base">
        <div class="title"> group 1 Base Layer</div>
      </div>
    </div>
    <div id="group2" class="parallax__group">
      <div class="parallax__layer parallax__layer--base">
        <div class="title">group 2 Base Layer</div>
      </div>
      <div class="parallax__layer parallax__layer--back">
        <div class="title">group 2 Background Layer</div>
      </div>
    </div>
    <div id="group3" class="parallax__group">
      <div class="parallax__layer parallax__layer--fore">
        <div class="title">group 3 Foreground Layer</div>
      </div>
      <div class="parallax__layer parallax__layer--base">
        <div class="title">group 3 Base Layer</div>
      </div>
    </div>
    <div id="group4" class="parallax__group">
      <div class="parallax__layer parallax__layer--base">
        <div class="title">group 4 Base Layer</div>
      </div>
      <div class="parallax__layer parallax__layer--back">
        <div class="title">group 4 Background Layer</div>
      </div>
      <div class="parallax__layer parallax__layer--deep">
        <div class="title">group 4 Deep Background Layer</div>
      </div>
    </div>
    <div id="group5" class="parallax__group">
      <div class="parallax__layer parallax__layer--fore">
        <div class="title">group 5 Foreground Layer</div>
      </div>
      <div class="parallax__layer parallax__layer--base">
        <div class="title">group 5 Base Layer</div>
      </div>
    </div>
    <div id="group6" class="parallax__group">
      <div class="parallax__layer parallax__layer--back">
        <div class="title">group 6 Background Layer</div>
      </div>
      <div class="parallax__layer parallax__layer--base">
        <div class="title">group 6 Base Layer</div>
      </div>
    </div>
    <div id="group7" class="parallax__group">
      <div class="parallax__layer parallax__layer--base">
        <div class="title">group 7 Base Layer</div>
      </div>
    </div>');
    }

}