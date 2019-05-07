export class Campaign {
    id: number = 0;

    active: boolean = false;
    name: string = "";
    description: string = "";
    headline_text: string = "";
    date_from: any = { year: new Date().getFullYear(), month: new Date().getMonth()+1, day: new Date().getDate()};
    date_to: any ;
    targeting: {};

    promote_settings = {
        status_bar: false,
        donation_goal: {
            active: false,
            value: 9000
        },
        selected_date: {
            active: true,
            value: "2019-03-04"
        },
        design: {
            fill_color: "#0074E9",
            text_color: "#2E3131"
        },
    };

    payment_settings = {
        payment_type: "both",
        monthly_prices : {
            /* TODO: moznost pridat min value */
            // custom_price: {
            //     active: false,
            //     min: 10
            // },
            custom_price: false,
            count_of_options: 2,
            options: [
                { value: 30},
                { value: 20}
            ]
        },
        once_prices: {
            custom_price: false,
            count_of_options: 2,
            options: [
                { value: 30},
                { value: 20}
            ]
        },
        default_price: {
            active: true,
            value: 30,
            styles: {
                background: "#3B3232",
                color: "#FFFFFF"
            }
        }
    };

    widget_settings = {
        general: {
            fontSettings: {
                fontFamily: "Roboto",
                fontWeight: "Bold",
                alignment: "center",
                color: "#FFFFFF",
                fontSize: 24
            },
            background: {
                type: "image-overlay",
                image: {
                  id: 10,
                  url: ''
                },
                color: "#1F4F7B",
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
                value: "Lorem ipsum bla bla"
            }
        },
        call_to_action: {
            default: {
                padding: {
                    top: "10",
                    right: "25",
                    bottom: "10",
                    left: "25"
                },
                margin: {
                    top: "0",
                    right: "auto",
                    bottom: "0",
                    left: "auto"
                },
                fontSettings: {
                    fontFamily: "Roboto",
                    fontWeight: "bold",
                    alignment: "center",
                    color: "#FFFFFF",
                    fontSize: 24
                },
                display: 'block',
                design: {
                    fill: {
                        active: true,
                        color: "#B71100",
                        opacity: 100
                    },
                    border: {
                        active: false,
                        color: "#B71100",
                        size: 2,
                        opacity: 0
                    },
                    shadow: {
                        active: false,
                        color: "#777",
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
                type: "fade",
                fontSettings: {
                    fontWeight: "bold",
                    color: "#FFFFFF"
                },
                design: {
                    fill: {
                        active: true,
                        color: "#B71100",
                        opacity: 100
                    },
                    border: {
                        active: false,
                        color: "#B71100",
                        size: 2,
                        opacity: 0
                    },
                    shadow: {
                        active: false,
                        color: "#777",
                        x: 2,
                        y: 2,
                        b: 2,
                        opacity: 15
                    }
                }
            }
        }
    }

}

