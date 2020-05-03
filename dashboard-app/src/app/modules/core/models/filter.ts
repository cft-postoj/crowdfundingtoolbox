export class Filter {

    min: number;
    max: number;
    text: string;

    constructor(min: number = null, max: number = null, text: string = '') {
        this.min = min;
        this.max = max;
        this.text = text;
    }
}
