<?php


namespace Modules\Campaigns\WidgetTypesResources;


class PopupWidget extends WidgetTypeResource
{
    public function initDesktop()
    {
        return $this->init(
            $this->generalStyles('800px', '500px', 'fixed', array(
                'top' => '15%',
                'bottom' => 'auto',
                'zIndex' => 999999,
                'textAlign' => 'center'
            ), 'block', array(
                'top' => '100',
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
                'width' => '100%',
                'maxWidth' => '100%'
            )),
            $this->textContainer('100', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', '50', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '10px',
                'textAlign' => 'center',
                'fontSize' => 45
            )),
            $this->buttonContainer('100', 'relative', '80', 'auto',
                'auto', 'auto', 'center', array(
                    'width' => '300px',
                    'maxWidth' => '100%',
                    'alignment' => 'center',
                    'fontSize' => 35,
                    'padding' => array(
                        'top' => '15',
                        'right' => '45',
                        'bottom' => '15',
                        'left' => '45'
                    )
                )),
            null
        );
    }

    public function initTablet()
    {
        return $this->init(
            $this->generalStyles('500px', '300px', 'fixed', array(
                'top' => '5%',
                'bottom' => 'auto',
                'zIndex' => 999999,
                'textAlign' => 'center'
            ), 'block', array(
                'top' => '65',
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
                'width' => '100%',
                'maxWidth' => '100%'
            )),
            $this->textContainer('100', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', '8', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '10px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100', 'relative', '30', 'auto',
                'auto', 'auto', 'center', array(
                    'width' => '300px',
                    'maxWidth' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '12',
                        'right' => '30',
                        'bottom' => '15',
                        'left' => '30'
                    )
                )),
            null
        );
    }

    public function initMobile()
    {
        return $this->init(
            $this->generalStyles('100%', '300px', 'fixed', array(
                'top' => '0',
                'bottom' => 'auto',
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
                'width' => '100%',
                'maxWidth' => '100%'
            )),
            $this->textContainer('100', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', '8', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '10px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100', 'relative', '30', 'auto',
                'auto', 'auto', 'center', array(
                    'width' => '300px',
                    'maxWidth' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '12',
                        'right' => '30',
                        'bottom' => '15',
                        'left' => '30'
                    )
                )),
            null
        );
    }
}