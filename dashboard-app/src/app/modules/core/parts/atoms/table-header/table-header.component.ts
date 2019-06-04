import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: '[app-table-header]',
    templateUrl: './table-header.component.html',
    styleUrls: ['./table-header.component.scss']
})
export class TableHeaderComponent implements OnInit {

    @Input() title;

    @Input() column;

    // name of column of table, that is currently active and is sorted
    @Input() model;

    @Output() modelChange = new EventEmitter();

    public type: 'number' | 'string';

    public asc;
    public min = 0;
    public max;
    public textSearch;


    constructor() {
    }

    ngOnInit() {
    }

    toogleOrdering() {
        if (this.model.sortBy !== this.column || this.model.asc) {
            this.asc = false;
        } else {
            this.asc = true;
        }
        this.model.sortBy = this.column;
        this.model.asc = this.asc;
        this.modelChange.emit(this.model);
    }

    setFilter(type, input) {
        this.model.forEach(singleStat => {
            if (singleStat.description === this.column.description) {
                singleStat.filter[type] = input;
            }
        });
        this.modelChange.emit(this.model);
    }
}
