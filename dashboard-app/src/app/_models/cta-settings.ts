export class CtaSettings {
    default: any = {
        padding: {
            top: '15',
            right: '15',
            bottom: '15',
            left: '15'
        },
        margin: {
            top: '0',
            right: 'auto',
            bottom: '0',
            left: 'auto'
        },
        fontSettings: {
            fontFamily: 'Roboto Slab',
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
                color: '#B71100',
                x: 2,
                y: 2,
                b: 2,
                opacity: 0
            },
            radius: {
                selected: false,
                value: '0'
            }
        }
    };
    hover: any = {
        type: 'fade',
        fontSettings: {
            fontWeight: 'bold',
            opacity: 100,
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
                color: '#B71100',
                x: 2,
                y: 2,
                b: 2,
                opacity: 0
            },
            radius: {
                active: false,
                value: '0'
            }
        }
    };
}
