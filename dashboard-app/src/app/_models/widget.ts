export class Widget {
    id = 0;
    updated_at: any = new Date();
    campaign_id = 0;
    active = true;
    widget_type = {
        id: 0,
        name: '',
        description: '',
        method: ''
    };
    settings = {
        desktop: {
            headline_text: '',
            payment_widget: false,
            widget_settings: {
                general: {
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        alignment: 'center',
                        color: '#f00',
                        fontSize: 24
                    },
                    background: {
                        type: 'image-overlay',
                        image: {
                            id: 1,
                            url: ''
                        },
                        color: '#1F47BB',
                        opacity: 33
                    },
                    text_background: '#fff',
                    text_margin: {
                        top: '0',
                        right: 'auto',
                        bottom: '0',
                        left: 'auto'
                    },
                    common_text: {
                        active: true,
                        value: ''
                    },
                },
                additional_text: {
                    text: 'additional text',
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        alignment: 'center',
                        color: '#fa',
                        fontSize: 24
                    },
                    background: {
                        type: 'image-overlay',
                        image: {
                            id: 1,
                            url: ''
                        },
                        color: '#1F47BB',
                        opacity: 33
                    },
                    text_background: '#fff',
                    text_margin: {
                        top: '0',
                        right: 'auto',
                        bottom: '0',
                        left: 'auto'
                    },
                    common_text: {
                        active: true,
                        value: ''
                    },
                },
                call_to_action: {
                    default: {
                        padding: {
                            top: '0',
                            right: '0',
                            bottom: '0',
                            left: '0'
                        },
                        margin: {
                            top: '0',
                            right: '0',
                            bottom: '0',
                            left: '0'
                        },
                        fontSettings: {
                            fontFamily: 'Roboto',
                            fontWeight: 'bold',
                            alignment: 'center',
                            color: '#FFFFFF',
                            fontSize: 24
                        },
                        design: {
                            fill: {
                                active: true,
                                color: '#B71100',
                                opacity: 100
                            },
                            border: {
                                active: false,
                                color: '#B71100',
                                size: 2,
                                opacity: 0
                            },
                            shadow: {
                                active: false,
                                x: 2,
                                y: 2,
                                b: 2,
                                opacity: 15
                            },
                            radius: {
                                active: true,
                                tl: 3,
                                tr: 4,
                                br: 2,
                                bl: 1
                            },

                        },
                    },
                    hover: {
                        type: 'fade',
                        fontSettings: {
                            fontWeight: 'bold',
                            color: '#FFFFFF'
                        },
                        design: {
                            fill: {
                                active: true,
                                color: '#B71100',
                                opacity: 100
                            },
                            border: {
                                active: false,
                                color: '#B71100',
                                size: 2,
                                opacity: 0
                            },
                            shadow: {
                                active: false,
                                x: 2,
                                y: 2,
                                b: 2,
                                opacity: 15
                            },
                        },
                    },
                },
            },
            promote_settings: {
                status_bar: false,
                donation_goal: {
                    active: false,
                    value: 9000
                },
                selected_date: {
                    active: false,
                    value: '2019-03-04'
                },
                design: {
                    fill_color: '#10be16',
                    text_color: '#2e3131'
                },
            },
            payment_settings: {
                active: true,
                payment_type: 'both',
                monthly_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ]
                },
                once_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ]
                },
                default_price: {
                    active: true,
                    value: 30,
                    styles: {
                        background: '#3b3232',
                        color: '#ffffff'
                    }
                },
            },
            email_settings: {
                active: false,
                subscribe_text: 'Activated email includes "I agree with the processing my personal data an subscribe to the newsletter.'
            },
            additional_text: {
                active: false,
                text: ''
            },
            cta: {
                text: '',
                url: ''
            },
            // rovnaka struktura pre vsetky
            additional_settings: {
                width: '100%',
                maxWidth: '200px',
                height: '300px',
                position: 'relative', // relative || fixed
                fixedSettings: {
                    top: '0',
                    bottom: 'auto',
                    zIndex: 100,
                },
                display: 'block',
                textContainer: {
                    width: '100%',
                    margin: '0 auto',
                    position: 'absolute',
                    top: '',
                    right: '',
                    bottom: '',
                    left: '',
                    text: {
                        width: '300px',
                        maxWidth: '100%',
                        textAlign: ''
                    }
                },
                buttonContainer: {
                    width: '100%',
                    position: 'absolute',
                    top: '',
                    right: '',
                    bottom: '',
                    left: '',
                    display: '',
                    textAlign: '',
                    margin: {
                      top: '',
                      right: '',
                      bottom: '',
                      left: ''
                    },
                    button: {
                        width: '300px',
                        maxWidth: '100%',
                        padding: {
                            top: '',
                            right: '',
                            bottom: '',
                            left: ''
                        }
                    }
                }
            }
        },
        tablet: {
            headline_text: '',
            payment_widget: false,
            widget_settings: {
                general: {
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        alignment: 'center',
                        color: '#f00',
                        fontSize: 24
                    },
                    background: {
                        type: 'image-overlay',
                        image: {
                            id: 1,
                            url: ''
                        },
                        color: '#1F47BB',
                        opacity: 33
                    },
                    text_background: '#fff',
                    text_margin: {
                        top: '0',
                        right: 'auto',
                        bottom: '0',
                        left: 'auto'
                    },
                    common_text: {
                        active: true,
                        value: ''
                    },
                },
                additional_text: {
                    text: 'additional text',
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        alignment: 'center',
                        color: '#FFFFFF',
                        fontSize: 24
                    },
                    background: {
                        type: 'image-overlay',
                        image: {
                            id: 1,
                            url: ''
                        },
                        color: '#1F47BB',
                        opacity: 33
                    },
                    text_background: '#fff',
                    text_margin: {
                        top: '0',
                        right: 'auto',
                        bottom: '0',
                        left: 'auto'
                    },
                    common_text: {
                        active: true,
                        value: ''
                    },
                },
                call_to_action: {
                    default: {
                        padding: {
                            top: '0',
                            right: '0',
                            bottom: '0',
                            left: '0'
                        },
                        margin: {
                            top: '0',
                            right: '0',
                            bottom: '0',
                            left: '0'
                        },
                        fontSettings: {
                            fontFamily: 'Roboto',
                            fontWeight: 'bold',
                            alignment: 'center',
                            color: '#FFFFFF',
                            fontSize: 24
                        },
                        design: {
                            fill: {
                                active: true,
                                color: '#B71100',
                                opacity: 100
                            },
                            border: {
                                active: false,
                                color: '#B71100',
                                size: 2,
                                opacity: 0
                            },
                            shadow: {
                                active: false,
                                x: 2,
                                y: 2,
                                b: 2,
                                opacity: 15
                            },
                            radius: {
                                active: true,
                                tl: 3,
                                tr: 4,
                                br: 2,
                                bl: 1
                            },

                        },
                    },
                    hover: {
                        type: 'fade',
                        fontSettings: {
                            fontWeight: 'bold',
                            color: '#FFFFFF'
                        },
                        design: {
                            fill: {
                                active: true,
                                color: '#B71100',
                                opacity: 100
                            },
                            border: {
                                active: false,
                                color: '#B71100',
                                size: 2,
                                opacity: 0
                            },
                            shadow: {
                                active: false,
                                x: 2,
                                y: 2,
                                b: 2,
                                opacity: 15
                            },
                        },
                    },
                },
            },
            promote_settings: {
                status_bar: false,
                donation_goal: {
                    active: false,
                    value: 9000
                },
                selected_date: {
                    active: false,
                    value: '2019-03-04'
                },
                design: {
                    fill_color: '#10be16',
                    text_color: '#2e3131'
                },
            },
            payment_settings: {
                payment_type: 'both',
                monthly_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ]
                },
                once_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ]
                },
                default_price: {
                    active: true,
                    value: 30,
                    styles: {
                        background: '#3b3232',
                        color: '#ffffff'
                    }
                },
            },

            email_settings: {
                active: false,
                subscribe_text: ''
            },
            additional_text: {
                active: false,
                text: ''
            },
            cta: {
                text: '',
                url: ''
            },
            additional_settings: {
                width: '100%',
                maxWidth: '200px',
                height: '300px',
                position: 'relative', // relative || fixed
                fixedSettings: {
                    top: '0',
                    bottom: 'auto',
                    zIndex: 100,
                },
                display: 'block',
                textContainer: {
                    width: '100%',
                    margin: '0 auto',
                    position: 'absolute',
                    top: '',
                    right: '',
                    bottom: '',
                    left: '',
                    text: {
                        width: '300px',
                        maxWidth: '100%'
                    }
                },
                buttonContainer: {
                    width: '100%',
                    position: 'absolute',
                    top: '',
                    right: '',
                    bottom: '',
                    left: '',
                    button: {
                        width: '300px',
                        maxWidth: '100%'
                    }
                }
            }
        },
        mobile: {
            headline_text: '',
            payment_widget: false,
            widget_settings: {
                general: {
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        alignment: 'center',
                        color: '#f00',
                        fontSize: 24
                    },
                    background: {
                        type: 'image-overlay',
                        image: {
                            id: 1,
                            url: ''
                        },
                        color: '#1F47BB',
                        opacity: 33
                    },
                    text_margin: {
                        top: '0',
                        right: 'auto',
                        bottom: '0',
                        left: 'auto'
                    },
                    text_background: '#fff',
                    common_text: {
                        active: true,
                        value: ''
                    },
                },
                additional_text: {
                    text: 'additional text',
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        alignment: 'center',
                        color: '#FFFFFF',
                        fontSize: 24
                    },
                    background: {
                        type: 'image-overlay',
                        image: {
                            id: 1,
                            url: ''
                        },
                        color: '#1F47BB',
                        opacity: 33
                    },
                    text_background: '#fff',
                    text_margin: {
                        top: '0',
                        right: 'auto',
                        bottom: '0',
                        left: 'auto'
                    },
                    common_text: {
                        active: true,
                        value: ''
                    },
                },
                call_to_action: {
                    default: {
                        padding: {
                            top: '0',
                            right: '0',
                            bottom: '0',
                            left: '0'
                        },
                        margin: {
                            top: '0',
                            right: '0',
                            bottom: '0',
                            left: '0'
                        },
                        fontSettings: {
                            fontFamily: 'Roboto',
                            fontWeight: 'bold',
                            alignment: 'center',
                            color: '#FFFFFF',
                            fontSize: 24
                        },
                        design: {
                            fill: {
                                active: true,
                                color: '#B71100',
                                opacity: 100
                            },
                            border: {
                                active: false,
                                color: '#B71100',
                                size: 2,
                                opacity: 0
                            },
                            shadow: {
                                active: false,
                                x: 2,
                                y: 2,
                                b: 2,
                                opacity: 15
                            },
                            radius: {
                                active: true,
                                tl: 3,
                                tr: 4,
                                br: 2,
                                bl: 1
                            },

                        },
                    },
                    hover: {
                        type: 'fade',
                        fontSettings: {
                            fontWeight: 'bold',
                            color: '#FFFFFF'
                        },
                        design: {
                            fill: {
                                active: true,
                                color: '#B71100',
                                opacity: 100
                            },
                            border: {
                                active: false,
                                color: '#B71100',
                                size: 2,
                                opacity: 0
                            },
                            shadow: {
                                active: false,
                                x: 2,
                                y: 2,
                                b: 2,
                                opacity: 15
                            },
                        },
                    },
                },
            },
            promote_settings: {
                status_bar: false,
                donation_goal: {
                    active: false,
                    value: 9000
                },
                selected_date: {
                    active: false,
                    value: '2019-03-04'
                },
                design: {
                    fill_color: '#10be16',
                    text_color: '#2e3131'
                },
            },
            payment_settings: {
                payment_type: 'both',
                monthly_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ]
                },
                once_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ]
                },
                default_price: {
                    active: true,
                    value: 30,
                    styles: {
                        background: '#3b3232',
                        color: '#ffffff'
                    }
                },
            },
            email_settings: {
                active: false,
                subscribe_text: ''
            },
            additional_text: {
                active: false,
                text: ''
            },
            cta: {
                text: '',
                url: ''
            },
            additional_settings: {
                width: '100%',
                maxWidth: '200px',
                height: '300px',
                position: 'relative', // relative || fixed
                fixedSettings: {
                    top: '0',
                    bottom: 'auto',
                    zIndex: 100,
                },
                display: 'block',
                textContainer: {
                    width: '100%',
                    margin: '0 auto',
                    position: 'absolute',
                    top: '',
                    right: '',
                    bottom: '',
                    left: '',
                    text: {
                        width: '300px',
                        maxWidth: '100%'
                    }
                },
                buttonContainer: {
                    width: '100%',
                    position: 'absolute',
                    top: '',
                    right: '',
                    bottom: '',
                    left: '',
                    button: {
                        width: '300px',
                        maxWidth: '100%'
                    }
                }
            }
        },
    }

}
