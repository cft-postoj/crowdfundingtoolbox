import {Column} from './column';

export class TableModel {
    columns: Column[] = [];
    sortBy: any;
    asc: boolean;
    id: string;

    constructor(id: string = '', columns: Column[] = [], sortBy: any = null, asc: boolean = null) {
        this.id = id;
        this.columns = columns;
        this.sortBy = sortBy;
        this.asc = asc;
    }
}
