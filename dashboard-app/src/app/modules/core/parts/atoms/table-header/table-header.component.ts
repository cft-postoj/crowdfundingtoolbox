import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {TableModel} from '../../../models/table-model';
import {Column} from '../../../models/column';

@Component({
    selector: '[app-table-header]',
    templateUrl: './table-header.component.html',
    styleUrls: ['./table-header.component.scss']
})
export class TableHeaderComponent implements OnInit {

    // column, that handle current tableHeaderComponent
    @Input() column: Column;

    // model with all columns and with filters data
    @Input() model: TableModel;

    @Output() modelChange = new EventEmitter();

    @Output() modelFilterChange = new EventEmitter();

    @Output() modelCheckedChange = new EventEmitter();

    @Input() hide: string[] = [];

    public asc;
    public min;
    public max;
    public textSearch;
    public checked: boolean;


    constructor() {
    }

    ngOnInit() {
    }

    // toogle ordering based on actual sort by value
    toogleOrdering() {
        if (!this.column.preventSorting) {
            if (this.model.sortBy !== this.column || this.model.asc) {
                this.asc = false;
            } else {
                this.asc = true;
            }
            this.model.sortBy = this.column;
            this.model.asc = this.asc;
            this.modelChange.emit(this.model);
        }
    }

    // update filters
    setFilter(type, input) {
        this.model.columns.forEach(column => {
            if (column.description === this.column.description) {
                column.filter[type] = input;
            }
        });
        this.modelFilterChange.emit(this.model);
    }

    // update filters
    emitCheckedChanges(type, input) {
        this.modelCheckedChange.emit({'column' : type, 'checked' : input });
    }
}
