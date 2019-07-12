import {Injectable} from '@angular/core';
import {TableModel} from '../models/table-model';

@Injectable({
    providedIn: 'root'
})
export class TableService {


    constructor() {
    }

    sort(model, objects) {
        const filteredObjects = this.filterByValues(model, objects);
        let sortedObjects = filteredObjects;
        if (!!model.sortBy) {
            sortedObjects = filteredObjects.sort((a, b) => {
                return this.compare(this.nestedBracketNotation(a, model.sortBy.value_name),
                    this.nestedBracketNotation(b, model.sortBy.value_name), model.asc);
            });
        }
        return sortedObjects;
    }

    compare(a: number | string | boolean, b: number | string | boolean, isAsc: boolean) {
        return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
    }

    private filterByValues(model: TableModel, objects) {
        return objects.filter(object => {
                for (const column of model.columns) {
                    if (column.type === 'text') {
                        const safeValueInColumn = typeof this.nestedBracketNotation(object, column.value_name) === 'string' ?
                            this.nestedBracketNotation(object, column.value_name) : '';
                        if (safeValueInColumn.indexOf(column.filter.text) === -1) {
                            return false;
                        }
                    }
                    if (column.type === 'number') {
                        if (!!column.filter.min && column.filter.min > this.nestedBracketNotation(object, column.value_name) ||
                            !!column.filter.max && column.filter.max < this.nestedBracketNotation(object, column.value_name)) {
                            return false;
                        }
                    }
                }
                return true;
            }
        );
    }

    // eval foo['test0.test1.test2'] as foo['test0']['test1']['test2'] based on spliting string using '.' character
    nestedBracketNotation(object, property: string) {
        const dotIndex = property.indexOf('.');
        if (object == null) {
            return null;
        }
        if (dotIndex > -1) {
            return this.nestedBracketNotation(object[property.substr(0, dotIndex)], property.substr(property.indexOf('.') + 1));
        } else {
            if (typeof object[property] === 'object') {
                return (!!object[property]);
            }
            return object[property];
        }
    }

    public activeColumn(model, searchColumnByValueName: any) {
        return this.getColumnByValueName(model, searchColumnByValueName) != null;
    }

    public getColumnByValueName(model, searchColumnByValueName: any) {
        let result = null;
        model.columns.forEach(column => {
            if (column.value_name === searchColumnByValueName) {
                result = column;
            }
        });
        return result;
    }


}
