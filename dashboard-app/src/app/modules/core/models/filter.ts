export class Filter {

    min: number;
    max: number;
    text: string;

    constructor() {
        this.min = Number.MIN_SAFE_INTEGER;
        this.max = Number.MAX_SAFE_INTEGER;
        this.text = '';
    }
}
