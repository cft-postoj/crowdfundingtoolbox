<?php


namespace Modules\Campaigns\WidgetTypesResources;


class LeaderboardWidget extends WidgetTypeResource
{
    public function initDesktop()
    {
        return $this->init(
            $this->generalStyles('100%', '300px', 'relative', array(), 'block', array(
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
            $this->textContainer('100%', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '20px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100%', 'relative', '60', 'auto',
                '0', 'auto', 'center', array(
                    'width' => '100%',
                    'alignment' => 'center',
                    'fontSize' => 26,
                    'padding' => array(
                        'top' => '20',
                        'right' => '70',
                        'bottom' => '25',
                        'left' => '70'
                    )
                )),
            null,
            null
        );
    }

    public function initTablet()
    {
        return $this->init(
            $this->generalStyles('100%', '250px', 'relative', array(), 'block', array(
                'top' => '10',
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
            $this->textContainer('100%', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '30px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100%', 'relative', '40', 'auto',
                '0', 'auto', 'center', array(
                    'width' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '15',
                        'right' => '70',
                        'bottom' => '20',
                        'left' => '70'
                    )
                )),
            null,
            null
        );
    }

    public function initMobile()
    {
        return $this->init(
            $this->generalStyles('100%', 'auto', 'relative', array(), 'block', array(
                'top' => '20',
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
            $this->textContainer('100%', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '0px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('100%', 'relative', '50', 'auto',
                '0', 'auto', 'center', array(
                    'width' => '100%',
                    'alignment' => 'center',
                    'padding' => array(
                        'top' => '15',
                        'right' => '50',
                        'bottom' => '20',
                        'left' => '50'
                    )
                )),
            null,
            null
        );
    }
}