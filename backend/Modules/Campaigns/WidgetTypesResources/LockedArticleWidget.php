<?php


namespace Modules\Campaigns\WidgetTypesResources;


class LockedArticleWidget extends WidgetTypeResource
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
            $this->textContainer('50', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '20px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('50', 'relative', '60', 'auto',
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
            $this->continueReadingButtonContainer('100%', 'relative', array(
                'top' => '15',
                'right' => 'auto',
                'bottom' => '15',
                'left' => 'auto'
            ), array(
                'text' => 'Continue without donating',
                'alignment' => 'center',
                'width' => '300px',
                'maxWidth' => '100%',
                'padding' => array(
                    'top' => '8',
                    'right' => '15',
                    'bottom' => '8',
                    'left' => '15'
                ),
                'fontSettings' => array(
                    'fontWeight' => 'medium',
                    'color' => '#FFFFFF',
                    'fontFamily' => 'Roboto Slab',
                    'fontSize' => 15
                ),
                'design' => array(
                    'fill' => array(
                        'active' => true,
                        'color' => 'rgba(0, 0, 0, .3)',
                        'opacity' => 20
                    ),
                    'border' => array(
                        'active' => true,
                        'color' => '#FFFFFF',
                        'size' => 1,
                        'opacity' => 100
                    ),
                    'shadow' => array(
                        'active' => false,
                        'x' => 2,
                        'y' => 2,
                        'b' => 2,
                        'opacity' => 15
                    ),
                    'radius' => array(
                        'active' => false,
                        'tl' => 3,
                        'tr' => 4,
                        'br' => 2,
                        'bl' => 1
                    )
                ),
                'hover' => array(
                    'type' => 'fade',
                    'fontSettings' => array(
                        'fontWeight' => 'medium',
                        'color' => '#FFFFFF',
                        'fontFamily' => 'Roboto Slab',
                        'fontSize' => 15
                    ),
                    'design' => array(
                        'fill' => array(
                            'active' => true,
                            'color' => 'rgba(0, 0, 0, .3)',
                            'opacity' => 20
                        ),
                        'border' => array(
                            'active' => true,
                            'color' => '#FFFFFF',
                            'size' => 1,
                            'opacity' => 100
                        ),
                        'shadow' => array(
                            'active' => false,
                            'x' => 2,
                            'y' => 2,
                            'b' => 2,
                            'opacity' => 15
                        ),
                        'radius' => array(
                            'active' => false,
                            'tl' => 3,
                            'tr' => 4,
                            'br' => 2,
                            'bl' => 1
                        )
                    )
                )
            ))
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
            $this->textContainer('50', array(
                'top' => '0',
                'right' => 'auto',
                'bottom' => '0',
                'left' => 'auto'
            ), 'relative', 'auto', 'auto', 'auto', 'auto', array(
                'width' => '100%',
                'top' => '30px',
                'textAlign' => 'center'
            )),
            $this->buttonContainer('50', 'relative', '40', 'auto',
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
            $this->continueReadingButtonContainer('100%', 'relative', array(
                'top' => '15',
                'right' => 'auto',
                'bottom' => '15',
                'left' => 'auto'
            ), array(
                'text' => 'Continue without donating',
                'alignment' => 'center',
                'width' => '300px',
                'maxWidth' => '100%',
                'padding' => array(
                    'top' => '8',
                    'right' => '15',
                    'bottom' => '8',
                    'left' => '15'
                ),
                'fontSettings' => array(
                    'fontWeight' => 'medium',
                    'color' => '#FFFFFF',
                    'fontFamily' => 'Roboto Slab',
                    'fontSize' => 15
                ),
                'design' => array(
                    'fill' => array(
                        'active' => true,
                        'color' => 'rgba(0, 0, 0, .3)',
                        'opacity' => 20
                    ),
                    'border' => array(
                        'active' => true,
                        'color' => '#FFFFFF',
                        'size' => 1,
                        'opacity' => 100
                    ),
                    'shadow' => array(
                        'active' => false,
                        'x' => 2,
                        'y' => 2,
                        'b' => 2,
                        'opacity' => 15
                    ),
                    'radius' => array(
                        'active' => false,
                        'tl' => 3,
                        'tr' => 4,
                        'br' => 2,
                        'bl' => 1
                    )
                ),
                'hover' => array(
                    'type' => 'fade',
                    'fontSettings' => array(
                        'fontWeight' => 'medium',
                        'color' => '#FFFFFF',
                        'fontFamily' => 'Roboto Slab',
                        'fontSize' => 15
                    ),
                    'design' => array(
                        'fill' => array(
                            'active' => true,
                            'color' => 'rgba(0, 0, 0, .3)',
                            'opacity' => 20
                        ),
                        'border' => array(
                            'active' => true,
                            'color' => '#FFFFFF',
                            'size' => 1,
                            'opacity' => 100
                        ),
                        'shadow' => array(
                            'active' => false,
                            'x' => 2,
                            'y' => 2,
                            'b' => 2,
                            'opacity' => 15
                        ),
                        'radius' => array(
                            'active' => false,
                            'tl' => 3,
                            'tr' => 4,
                            'br' => 2,
                            'bl' => 1
                        )
                    )
                )
            ))
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
            $this->continueReadingButtonContainer('100%', 'relative', array(
                'top' => '15',
                'right' => 'auto',
                'bottom' => '15',
                'left' => 'auto'
            ), array(
                'text' => 'Continue without donating',
                'alignment' => 'center',
                'width' => '300px',
                'maxWidth' => '100%',
                'padding' => array(
                    'top' => '8',
                    'right' => '15',
                    'bottom' => '8',
                    'left' => '15'
                ),
                'fontSettings' => array(
                    'fontWeight' => 'medium',
                    'color' => '#FFFFFF',
                    'fontFamily' => 'Roboto Slab',
                    'fontSize' => 15
                ),
                'design' => array(
                    'fill' => array(
                        'active' => true,
                        'color' => 'rgba(0, 0, 0, .3)',
                        'opacity' => 20
                    ),
                    'border' => array(
                        'active' => true,
                        'color' => '#FFFFFF',
                        'size' => 1,
                        'opacity' => 100
                    ),
                    'shadow' => array(
                        'active' => false,
                        'x' => 2,
                        'y' => 2,
                        'b' => 2,
                        'opacity' => 15
                    ),
                    'radius' => array(
                        'active' => false,
                        'tl' => 3,
                        'tr' => 4,
                        'br' => 2,
                        'bl' => 1
                    )
                ),
                'hover' => array(
                    'type' => 'fade',
                    'fontSettings' => array(
                        'fontWeight' => 'medium',
                        'color' => '#FFFFFF',
                        'fontFamily' => 'Roboto Slab',
                        'fontSize' => 15
                    ),
                    'design' => array(
                        'fill' => array(
                            'active' => true,
                            'color' => 'rgba(0, 0, 0, .3)',
                            'opacity' => 20
                        ),
                        'border' => array(
                            'active' => true,
                            'color' => '#FFFFFF',
                            'size' => 1,
                            'opacity' => 100
                        ),
                        'shadow' => array(
                            'active' => false,
                            'x' => 2,
                            'y' => 2,
                            'b' => 2,
                            'opacity' => 15
                        ),
                        'radius' => array(
                            'active' => false,
                            'tl' => 3,
                            'tr' => 4,
                            'br' => 2,
                            'bl' => 1
                        )
                    )
                )
            ))
        );
    }
}