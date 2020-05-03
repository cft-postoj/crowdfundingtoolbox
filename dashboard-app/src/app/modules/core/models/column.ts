import {Filter} from './filter';

export class Column {
    value_name: string;
    value?: any;
    description: string;
    title?: string = '';
    type: 'text' | 'number' | 'checkbox' | 'none';
    filter: Filter = new Filter();
    private _preventSorting?: boolean;


    constructor(value_name: string, description: string, type: 'text' | 'number' | 'checkbox' | 'none',
                filter: Filter = new Filter(), title: string = '', value: any = null, preventSorting: boolean = false) {
        this.value_name = value_name;
        this.value = value;
        this.description = description;
        this.title = title;
        this.type = type;
        this.filter = filter;
        this._preventSorting = preventSorting;
    }


    public get preventSorting(): boolean {
        return this._preventSorting;
    }

    public set preventSorting(value: boolean) {
        this._preventSorting = value;
    }
}
