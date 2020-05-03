export class AdditionalText {

    text: string;
    fontSettings: {
        fontFamily: string,
        fontWeight: string,
        alignment: string,
        color: string,
        fontSize: number
    };

    background: {
        type: string,
        image: {
            id: number,
            url: string
        },
        color: string,
        opacity: number
    };

    text_background: string;
    text_margin: {
        top: string,
        right: string,
        bottom: string,
        left: string
    };

    common_text: {
        active: true,
        value: any
    };

    constructor() {
        this.text = '';
        this.fontSettings = {
            fontFamily: 'Roboto',
            fontWeight: 'bold',
            alignment: 'center',
            color: '#fff',
            fontSize: 24
        };
        this.background = {
            type: 'image-overlay',
            image: {
                id: 1,
                url: ''
            },
            color: '#1F47BB',
            opacity: 33
        };
        this.text_background = 'transparent';
        this.text_margin = {
            top: '0',
            right: 'auto',
            bottom: '0',
            left: 'auto'
        };
        this.common_text = {
            active: true,
            value: ''
        };

        return this;
    }
}
