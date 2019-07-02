import {Injectable} from '@angular/core';
import {TableModel} from '../models/table-model';

@Injectable({
    providedIn: 'root'
})
export class TableService {


    constructor() {
    }

    sort(model, objects) {
        const filteredCampaignStats = this.filterByValues(model, objects);
        let sortedObjects = filteredCampaignStats;
        if (!!model.sortBy) {
            sortedObjects = filteredCampaignStats.sort((a, b) => {
                return this.compare(this.nestedBracketNotation(a, model.sortBy.value_name),
                    this.nestedBracketNotation(b, model.sortBy.value_name), model.asc);
            });
        }
        return sortedObjects;
    }

    compare(a: number | string, b: number | string, isAsc: boolean) {
        return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
    }

    private filterByValues(model: TableModel, objects) {
        return objects.filter(object => {
                for (const column of model.columns) {
                    if (column.type === 'text') {
                        const safeValueInColumn = this.nestedBracketNotation(object, column.value_name) != null ?
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
        if (dotIndex > -1) {
            return this.nestedBracketNotation(object[property.substr(0, dotIndex)], property.substr(property.indexOf('.') + 1));
        } else {
            return object[property];
        }
    }


}
