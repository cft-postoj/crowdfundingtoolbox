<?php


namespace Modules\Campaigns\WidgetTypesResources;


class ArticleWidget extends WidgetTypeResource
{
    public function initDesktop()
    {
        return $this->init(
            $this->generalStyles('auto', 'auto', 'relative', '', 'inline', ''),
            $this->bodyContainer('auto', array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 'auto'
            )),
            $this->textContainer('auto', array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 'auto'
            )),
            $this->bodyContainer(0, array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 0
            )),
            null,
            '<p>This is <span style="color:red">article</span> widget...</p>'
        );
    }

    public function initTablet()
    {
        return $this->init(
            $this->generalStyles('auto', 'auto', 'relative', '', 'inline', ''),
            $this->bodyContainer('auto', array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 'auto'
            )),
            $this->textContainer('auto', array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 'auto'
            )),
            $this->bodyContainer(0, array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 0
            )),
            null,
            '<p>This is <span style="color:red">article</span> widget...</p>'
        );
    }

    public function initMobile()
    {
        return $this->init(
            $this->generalStyles('auto', 'auto', 'relative', '', 'inline', ''),
            $this->bodyContainer('auto', array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 'auto'
            )),
            $this->textContainer('auto', array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 'auto'
            )),
            $this->bodyContainer(0, array(
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0
            ), 'relative', '', '', '', '', array(
                'width' => 0
            )),
            null,
            '<p>This is <span style="color:red">article</span> widget...</p>'
        );
    }

}