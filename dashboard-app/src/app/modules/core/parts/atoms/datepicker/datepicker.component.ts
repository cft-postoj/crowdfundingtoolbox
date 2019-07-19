import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {NgbDateParserFormatter, NgbDateStruct} from "@ng-bootstrap/ng-bootstrap";
import {DateParserFormatter} from "./ngb-datepicker-formatter";
import {environment} from 'environments/environment';
import {NgxDaterangepickerMd} from 'ngx-daterangepicker-material';
import {Moment} from 'moment';
import moment from 'moment/src/moment';

@Component({
    selector: 'app-datepicker',
    templateUrl: './datepicker.component.html',
    styleUrls: ['./datepicker.component.scss'],
    providers: [{provide: NgbDateParserFormatter, useClass: DateParserFormatter}]
})
export class DatepickerComponent implements OnInit {

    @Output()
    public dateChange = new EventEmitter<any>();
    @Input()
    public date;
    @Input()
    public display;
    @Input()
    public minDate;
    @Input()
    public maxDate;
    @Input()
    public type: string;

    @Input()
    public disabled: boolean;


    public displayMonths = 1;
    public navigation = 'select';
    public showWeekNumbers = false;
    public outsideDays = 'visible';
    public environment = environment;

    public datepickerOpened: boolean = false;

    @Input()
    public startDate: string;
    @Input()
    public endDate: string;
    @Input()
    public singleDatePicker: boolean = false;

    @Input()
    public selected: any = {
        start: moment(),
        end: moment().add(1, 'days')
    };

    @Input()
    minMomentDate: Moment;
    @Input()
    maxMomentDate: Moment;

    public selectedRange: any = {
        start: moment(),
        end: moment()
    };


    ngOnInit(): void {
        this.selected.start = moment(this.startDate);
        this.selected.end = moment(this.endDate);

        console.log(this.endDate)
    }

    public changeEvent() {
        // variable datepickerOpened is necessary for this logic. otherwise date would be update every time when is datepicker input showed
        if (this.selected !== undefined && this.datepickerOpened) {
            this.selectedRange.start = moment(this.selected.start).format('YYYY-MM-DD');
            this.selectedRange.end = moment(this.selected.end).format('YYYY-MM-DD');
            this.dateChange.emit(this.selectedRange);
            this.datepickerOpened = false;
        }
    }

}

