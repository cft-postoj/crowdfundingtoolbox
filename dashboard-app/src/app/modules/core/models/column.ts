import {Filter} from './filter';

export class Column {
    value_name: string;
    description: string;
    type: 'text' | 'number' | 'none';
    filter: Filter;
}
