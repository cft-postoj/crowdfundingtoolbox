<?php


namespace Modules\Campaigns\WidgetTypesResources;


class FixedWidget extends WidgetTypeResource
{
    public function initDesktop()
    {
        return $this->init(
            $this->generalStyles('100%', '72px', 'fixed', array(
                'top' => 'auto',
                'bottom' => '0',
                'zIndex' => 999999,
                'textAlign' => 'center'
            ), 'block', array(
                'top' => '0',
                'right' => '0',
                'bottom' => '0',
                'left' => '0'
            )),
            $this->bodyContainer('100%', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => 0,
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '300px',
                'maxWidth' => '100%'
            )),
            $this->textContainer('70', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', '8', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '10px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('30', 'relative', 'auto', 'auto',
                'auto', 'auto', 'center', array(
                    'width' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '15',
                        'right' => '15',
                        'bottom' => '15',
                        'left' => '15'
                    )
                )),
            null
        );
    }

    public function initTablet()
    {
        return $this->init(
            $this->generalStyles('100%', '125px', 'fixed', array(
                'top' => 'auto',
                'bottom' => '0',
                'zIndex' => 999999,
                'textAlign' => 'center'
            ), 'block', array(
                'top' => '50',
                'right' => '15',
                'bottom' => '50',
                'left' => '15'
            )),
            $this->bodyContainer('100%', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => 0,
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '300px',
                'maxWidth' => '100%'
            )),
            $this->textContainer('100', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '7px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100', 'relative', '15', 'auto',
                'auto', 'auto', 'center', array(
                    'width' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '10',
                        'right' => '15',
                        'bottom' => '10',
                        'left' => '15'
                    )
                )),
            null
        );
    }

    public function initMobile()
    {
        return $this->init(
            $this->generalStyles('100%', '220px', 'fixed', array(
                'top' => 'auto',
                'bottom' => '0',
                'zIndex' => 999999,
                'textAlign' => 'center'
            ), 'block', array(
                'top' => 'auto',
                'right' => 'auto',
                'bottom' => 'auto',
                'left' => 'auto'
            )),
            $this->bodyContainer('100%', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => 0,
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '300px',
                'maxWidth' => '100%'
            )),
            $this->textContainer('100', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => 'auto',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100', 'relative', '15', 'auto',
                'auto', 'auto', 'center', array(
                    'width' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '10',
                        'right' => '15',
                        'bottom' => '10',
                        'left' => '15'
                    )
                )),
            null
        );
    }
}