import {AdditionalText} from './additional-text';

export class Widget {
    id = 0;
    updated_at: any = new Date();
    campaign_id = 0;
    active = true;
    prevent_disable = false;
    widget_type = {
        id: 0,
        name: '',
        description: '',
        method: '',
        widgetSubtypes: [],
        active_subtype: ''
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
                additional_text:  new AdditionalText(),
                additional_text_bottom:  new AdditionalText(),
                call_to_action: {
                    default: {
                        width: 'auto',
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
                            width: 'auto',
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
                close_text: '',
                close_top : '',
                close_color : '',
                close_font_size : '',
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
                active: false,
                payment_type: 'both',
                payment_method: 'bank_transfer',
                type: 'classic' || 'lite' || 'row' || 'column', // classic or lite
                currency: '€',
                currencyInPriceOptions: 'disabled',
                monetization_title: {
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        backgroundColor: '#fff',
                        fontSize: 24
                    },
                    margin: {
                        top: '15',
                        right: '10',
                        bottom: '15',
                        left: '10'
                    },
                    text: '',
                    textColor: '#000000',
                    alignment: 'center'
                },
                design: {
                    background_color: '#fff',
                    padding: {
                        top: '10',
                        right: '25',
                        bottom: '10',
                        left: '25'
                    },
                    margin: {
                        top: '15',
                        right: '10',
                        bottom: '15',
                        left: '10'
                    },
                    width: '100%',
                    height: 'auto',
                    text_color: '#1f4e7b',
                    shadowBox: true,
                    stepsPanel: true
                },
                monthly_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    count_of_options_in_row: 3,
                    benefit: {
                        active: true,
                        text: 'S podporou 10 € a viac mesačne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                        value: 10
                    },
                    benefits: [{
                        id: 1,
                        name: 'edit text of this benefit'
                    }],
                    columns_count: 1,
                    columns: [{
                        header: {
                            enable: false,
                            text: 'BEST OPTION',
                            color: '#fff',
                            background_color: '#2178CB',
                        },
                        title: 'Title',
                        active_benefits: [],
                        show_benefits: [],
                        custom_price: false,
                        count_of_options: 2,
                        count_of_options_in_row: 2,
                        options: [
                            {value: 30},
                            {value: 20}
                        ],
                    }],
                },
                once_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    count_of_options_in_row: 3,
                    options: [
                        {value: 80},
                        {value: 40}
                    ],
                    benefit: {
                        active: true,
                        text: 'S podporou 60 € a viac ročne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                        value: 60
                    }
                },
                price_background_color: 'inherit',
                price_text_color: 'inherit',
                default_price: {
                    monthly_active: true,
                    monthly_value: 30,
                    one_time_active: true,
                    one_time_value: 30,
                    styles: {
                        background: '#32a300',
                        color: '#ffffff'
                    }
                },
                second_step: {
                    title: {text: 'title'},
                    cta: {
                        transfer: {
                            text: 'Go to your bank'
                        },
                        payBySquare: {
                            text: 'Done'
                        }
                    }
                },
                third_step: {
                    title: {
                        text: 'Thank you for your support'
                    },
                    cta: {
                        description: 'To get all rewards please  fill your personal data in My profile',
                        list: '<ul><li><b>Newsletter</b> denníka Postoj</li><li><b>Ukladanie článkov</b> na neskôr</li>' +
                            '<li><b>Zľavy a novinky</b> z vydavatelstva</li></ul>',
                        text: 'My profile'
                    }
                },
                terms: {
                    text: 'I agree to processing of  personal data and receiving newsletters'
                }
            },
            email_settings: {
                active: false,
                subscribe_text: 'Activated email includes I agree with the processing my personal data an subscribe to the newsletter.'
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
                padding: {
                    top: '30',
                    right: '30',
                    bottom: '30',
                    left: '30'
                },
                fixedSettings: {
                    top: '0',
                    bottom: 'auto',
                    zIndex: 100,
                },
                display: 'block',
                bodyContainer: {
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
                },
                continueReadingButtonContainer: {
                    width: '100%',
                    position: 'relative',
                    margin: {
                        top: '',
                        right: '',
                        bottom: '',
                        left: ''
                    },
                    button: {
                        text: '',
                        alignment: '',
                        width: '300px',
                        maxWidth: '100%',
                        padding: {
                            top: '',
                            right: '',
                            bottom: '',
                            left: ''
                        },
                        fontSettings: {
                            fontWeight: 'bold',
                            color: '#FFFFFF',
                            fontFamily: '',
                            fontSize: 15
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
                            }
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
                                radius: {
                                    active: true,
                                    tl: 3,
                                    tr: 4,
                                    br: 2,
                                    bl: 1
                                }
                            },
                        }
                    }
                },
                articleWidgetText: '',
                customHtmlWidget: '',
                subtype: 'TOP' || 'BOTTOM' || 'MIDDLE'
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
                additional_text:  new AdditionalText(),
                additional_text_bottom:  new AdditionalText(),
                call_to_action: {
                    default: {
                        width: 'auto',
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
                close_text: '',
                close_top : '',
                close_color : '',
                close_font_size : '',
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
                active: false,
                payment_type: 'both',
                payment_method: 'bank_transfer',
                type: 'classic',
                currency: '€',
                currencyInPriceOptions: 'disabled',
                monetization_title: {
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        backgroundColor: '#fff',
                        fontSize: 24
                    },
                    margin: {
                        top: '15',
                        right: '10',
                        bottom: '15',
                        left: '10'
                    },
                    text: '',
                    textColor: '#000000',
                    alignment: 'center'
                },
                design: {
                    background_color: '#fff',
                    padding: {
                        top: '10',
                        right: '25',
                        bottom: '10',
                        left: '25'
                    },
                    margin: {
                        top: '15',
                        right: '10',
                        bottom: '15',
                        left: '10'
                    },
                    width: '100%',
                    height: 'auto',
                    text_color: '#1f4e7b',
                    shadowBox: true,
                    stepsPanel: true
                },
                monthly_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    count_of_options_in_row: 3,
                    options: [
                        {
                            title: 'Čestný čitateľ postoj Postoj',
                            value: 5,
                            description: '<ul><li><b>tlačené noviny</b> raz ročne</li></ul>'
                        },
                        {
                            title: 'Člen Klubu Postoj',
                            value: 10,
                            description: '<div><ul><li><b>tlačené noviny</b> raz ročne</li><li>darček - <b>kniha </b>len pre darcov</li><li><b>zľava na knihy</b> z vydavatelstva Postoj</li></ul></div>'
                        },
                        {
                            title: 'VIP člen klubu',
                            value: 20,
                            description: '<div><ul><li><b>tlačené noviny</b> raz ročne</li><li>darček - <b>kniha </b>len pre darcov</li><li><b>zľava na knihy</b> z vydavatelstva Postoj</li><li><b>VIP vstup</b> na eventy Postoj</li></ul></div>'
                        },
                        {
                            title: 'Biznis klub Postoj',
                            value: 50,
                            description: '<div><ul><li><b>tlačené noviny</b> raz ročne</li><li>darček - <b>kniha </b>len pre darcov</li><li><b>zľava na knihy</b> z vydavatelstva Postoj</li><li><b>VIP vstup</b> na eventy Postoj</li><li>pozvánka na <b>diskusné večery</b> s redaktormi</li></ul></div>'
                        }

                    ],
                    benefit: {
                        active: true,
                        text: 'S podporou 10 € a viac mesačne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                        value: 10
                    },
                    benefits: [{
                        id: 1,
                        name: 'edit text of this benefit'
                    }],
                    columns_count: 1,
                    columns: [{
                        header: {
                            enable: false,
                            text: 'BEST OPTION',
                            color: '#fff',
                            background_color: '#2178CB',
                        },
                        title: 'Title',
                        active_benefits: [],
                        show_benefits: [],
                        custom_price: false,
                        count_of_options: 2,
                        count_of_options_in_row: 2,
                        options: [
                            {value: 30},
                            {value: 20}
                        ],
                    }],
                },
                once_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    count_of_options_in_row: 2,
                    options: [
                        {value: 80},
                        {value: 40}
                    ],
                    benefit: {
                        active: true,
                        text: 'S podporou 60 € a viac ročne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                        value: 60
                    }
                },
                default_price: {
                    monthly_active: true,
                    monthly_value: 30,
                    one_time_active: true,
                    one_time_value: 30,
                    styles: {
                        background: '#32a300',
                        color: '#ffffff'
                    }
                },
                second_step: {
                    title: {text: 'title'},
                    cta: {
                        transfer: {
                            text: 'Go to your bank'
                        },
                        payBySquare: {
                            text: 'Done'
                        }
                    }
                },
                third_step: {
                    title: {
                        text: 'Thank you for your support'
                    },
                    cta: {
                        description: 'To get all rewards please  fill your personal data in My profile',
                        list: '<ul><li><b>Newsletter</b> denníka Postoj</li><li><b>Ukladanie článkov</b> na neskôr</li>' +
                            '<li><b>Zľavy a novinky</b> z vydavatelstva</li></ul>',
                        text: 'My profile'
                    }
                },
                terms: {
                    text: 'I agree to processing of  personal data and receiving newsletters'
                }

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
                padding: {
                    top: '30',
                    right: '30',
                    bottom: '30',
                    left: '30'
                },
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
                },
                continueReadingButtonContainer: {
                    width: '100%',
                    position: 'relative',
                    margin: {
                        top: '',
                        right: '',
                        bottom: '',
                        left: ''
                    },
                    button: {
                        text: '',
                        alignment: '',
                        width: '300px',
                        maxWidth: '100%',
                        padding: {
                            top: '',
                            right: '',
                            bottom: '',
                            left: ''
                        },
                        fontSettings: {
                            fontWeight: 'bold',
                            color: '#FFFFFF',
                            fontFamily: '',
                            fontSize: 15
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
                                color: '',
                                opacity: 15
                            },
                            radius: {
                                active: true,
                                tl: 3,
                                tr: 4,
                                br: 2,
                                bl: 1
                            }
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
                                radius: {
                                    active: true,
                                    tl: 3,
                                    tr: 4,
                                    br: 2,
                                    bl: 1
                                }
                            },
                        }
                    }
                },
                articleWidgetText: '',
                customHtmlWidget: '',
                subtype: 'TOP' || 'BOTTOM' || 'MIDDLE'
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
                additional_text:  new AdditionalText(),
                additional_text_bottom:  new AdditionalText(),
                call_to_action: {
                    default: {
                        width: 'auto',
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
                                color: '',
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
                close_text: '',
                close_top : '',
                close_color : '',
                close_font_size : '',
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
                active: false,
                payment_type: 'both',
                payment_method: 'bank_transfer',
                type: 'classic',
                currency: '€',
                currencyInPriceOptions: 'disabled',
                monetization_title: {
                    fontSettings: {
                        fontFamily: 'Roboto',
                        fontWeight: 'bold',
                        backgroundColor: '#fff',
                        fontSize: 24
                    },
                    margin: {
                        top: '15',
                        right: '10',
                        bottom: '15',
                        left: '10'
                    },
                    text: '',
                    textColor: '#000000',
                    alignment: 'center'
                },
                design: {
                    background_color: '#fff',
                    padding: {
                        top: '10',
                        right: '25',
                        bottom: '10',
                        left: '25'
                    },
                    margin: {
                        top: '40',
                        right: '0',
                        bottom: '0',
                        left: '0'
                    },
                    width: '100%',
                    height: 'auto',
                    text_color: '#1f4e7b',
                    shadowBox: true,
                    stepsPanel: true
                },
                monthly_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    count_of_options_in_row: 2,
                    options: [
                        {value: 30},
                        {value: 40}
                    ],
                    benefit: {
                        active: true,
                        text: 'S podporou 10 € a viac mesačne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                        value: 10
                    },
                    benefits: [{
                        id: 1,
                        name: 'edit text of this benefit'
                    }],
                    columns_count: 1,
                    columns: [{
                        header: {
                            enable: false,
                            text: 'BEST OPTION',
                            color: '#fff',
                            background_color: '#2178CB',
                        },
                        title: 'Title',
                        active_benefits: [],
                        show_benefits: [],
                        custom_price: false,
                        count_of_options: 2,
                        count_of_options_in_row: 2,
                        options: [
                            {value: 30},
                            {value: 20}
                        ],
                    }],
                },
                once_prices: {
                    custom_price: false,
                    count_of_options: 2,
                    count_of_options_in_row: 2,
                    options: [
                        {value: 80},
                        {value: 40}
                    ],
                    benefit: {
                        active: true,
                        text: 'S podporou 60 € a viac ročne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                        value: 60
                    }
                },
                default_price: {
                    monthly_active: true,
                    monthly_value: 30,
                    one_time_active: true,
                    one_time_value: 30,
                    styles: {
                        background: '#32a300',
                        color: '#ffffff'
                    }
                },
                second_step: {
                    title: {text: 'title'},
                    cta: {
                        transfer: {
                            text: 'Go to your bank'
                        },
                        payBySquare: {
                            text: 'Done'
                        }
                    }
                },
                third_step: {
                    title: {
                        text: 'Thank you for your support'
                    },
                    cta: {
                        description: 'To get all rewards please  fill your personal data in My profile',
                        list: '<ul><li><b>Newsletter</b> denníka Postoj</li><li><b>Ukladanie článkov</b> na neskôr</li>' +
                            '<li><b>Zľavy a novinky</b> z vydavatelstva</li></ul>',
                        text: 'My profile'
                    }
                },
                terms: {
                    text: 'I agree to processing of  personal data and receiving newsletters'
                }
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
                padding: {
                    top: '30',
                    right: '30',
                    bottom: '30',
                    left: '30'
                },
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
                },
                continueReadingButtonContainer: {
                    width: '100%',
                    position: 'relative',
                    margin: {
                        top: '',
                        right: '',
                        bottom: '',
                        left: ''
                    },
                    button: {
                        text: '',
                        alignment: '',
                        width: '300px',
                        maxWidth: '100%',
                        padding: {
                            top: '',
                            right: '',
                            bottom: '',
                            left: ''
                        },
                        fontSettings: {
                            fontWeight: 'bold',
                            color: '#FFFFFF',
                            fontFamily: '',
                            fontSize: 15
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
                                color: '',
                                opacity: 15
                            },
                            radius: {
                                active: true,
                                tl: 3,
                                tr: 4,
                                br: 2,
                                bl: 1
                            }
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
                                radius: {
                                    active: true,
                                    tl: 3,
                                    tr: 4,
                                    br: 2,
                                    bl: 1
                                }
                            },
                        }
                    }
                },
                articleWidgetText: '',
                customHtmlWidget: '',
                subtype: 'TOP' || 'BOTTOM' || 'MIDDLE'
            }
        },
    };
    public contains_additional_widget_settings: boolean;
    public additional_widget_settings: [];
}
