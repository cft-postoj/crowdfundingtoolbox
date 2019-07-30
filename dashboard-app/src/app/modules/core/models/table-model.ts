import {Column} from './column';

export class TableModel {
    columns: Column[] = [];
    sortBy: any;
    asc: boolean;
}
