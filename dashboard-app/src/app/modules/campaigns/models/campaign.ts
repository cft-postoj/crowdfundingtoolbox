import {Targeting} from './targeting';

export class Campaign {
    id: number = 0;
    active: boolean = false;
    name: string = '';
    description: string = '';
    headline_text: string = '';
    targeting = new Targeting();
    prevent_disable:boolean;
    promote_settings = {
        start_date_value: '',
        start_date_json: {year: new Date().getFullYear(), month: new Date().getMonth() + 1, day: new Date().getDate()},
        is_end_date: true,
        end_date_value: '',
        end_date_json: {
            year: new Date().getFullYear(),
            month: new Date().getMonth() + 1,
            day: new Date().getDate() + 1
        },
        donation_goal_value: ''
    };

    payment_settings = {
        payment_type: 'both',
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
        },
        monthly_prices: {
            /* TODO: moznost pridat min value */
            // custom_price: {
            //     active: false,
            //     min: 10
            // },
            custom_price: false,
            count_of_options: 2,
            count_of_options_in_row:3,
            options: [
                {value: 30},
                {value: 20}
            ],
            benefit: {
                active: true,
                text: 'S podporou 10 € a viac mesačne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                value: 10
            }
        },
        once_prices: {
            custom_price: false,
            count_of_options: 2,
            options: [
                {value: 30},
                {value: 20}
            ],
            benefit: {
                active: true,
                text: 'S podporou 60 € a viac ročne sa môžete stať členom Klubu Postoj a získať naše špeciálne tlačené vydanie.',
                value: 10
            }
        },
        default_price: {
            active: true,
            value: 30,
            styles: {
                background: '#32a300',
                color: '#FFFFFF'
            }
        },

        second_step: {
            title: {
                text: 'title'
            },
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
                text: 'My profile'
            }
        },

        terms: {
            text: 'I agree to processing of  personal data and receiving newsletters'
        }
    };

    widget_settings = {
        general: {
            fontSettings: {
                fontFamily: 'Roboto',
                fontWeight: 'Bold',
                alignment: 'center',
                color: '#FFFFFF',
                fontSize: 24
            },
            background: {
                type: 'image-overlay',
                image: {
                    id: 10,
                    url: ''
                },
                color: '#1F4F7B',
                opacity: 33
            },
            text_margin: {
                top: '0',
                right: 'auto',
                bottom: '0',
                left: 'auto'
            },
            text_display: 'block',
            text_background: '#ffffff',
            common_text: {
                active: true,
                value: 'Lorem ipsum bla bla'
            }
        },
        call_to_action: {
            default: {
                width: 'auto',
                padding: {
                    top: '10',
                    right: '25',
                    bottom: '10',
                    left: '25'
                },
                margin: {
                    top: '0',
                    right: 'auto',
                    bottom: '0',
                    left: 'auto'
                },
                fontSettings: {
                    fontFamily: 'Roboto',
                    fontWeight: 'bold',
                    alignment: 'center',
                    color: '#FFFFFF',
                    fontSize: 24
                },
                display: 'block',
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
                        color: '#777',
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
                        bl: 1,
                    }
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
                        color: '#777',
                        x: 2,
                        y: 2,
                        b: 2,
                        opacity: 15
                    }
                }
            }
        }
    };

}

