import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: '[app-table-header]',
    templateUrl: './table-header.component.html',
    styleUrls: ['./table-header.component.scss']
})
export class TableHeaderComponent implements OnInit {

    //column, that handle current tableHeaderComponent
    @Input() column;

    //model with all columns and with filters data
    @Input() model;

    @Output() modelChange = new EventEmitter();

    @Input() hide: string[];

    public asc;
    public min = 0;
    public max;
    public textSearch;


    constructor() {
    }

    ngOnInit() {
        console.log(this.hide.indexOf('title') === -1);
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
