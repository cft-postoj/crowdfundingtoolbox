<?php


namespace Modules\Campaigns\WidgetTypesResources;


interface WidgetTypeInterface
{
    public function generalStyles($width, $height, $position, $fixedSettings, $display, $padding);
    public function bodyContainer($width, $margin, $position, $top, $right, $bottom, $left, $text);
    public function textContainer($width, $margin, $position, $top, $right, $bottom, $left, $text);
    public function buttonContainer($width, $position, $top, $right, $bottom, $left, $textAlign, $button);
    public function init($generalStyles, $bodyContainer, $textContainer, $buttonContainer, $continueReadingButtonContainer, $articleWidgetText);
    public function initDesktop();
    public function initTablet();
    public function initMobile();
}