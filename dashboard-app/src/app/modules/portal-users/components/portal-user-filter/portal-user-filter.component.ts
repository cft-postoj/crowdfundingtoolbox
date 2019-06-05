import {Component, OnInit, Input, OnChanges} from '@angular/core';
import {DropdownItem} from '../../../core/models';

@Component({
    selector: '[app-portal-user-filter]',
    templateUrl: './portal-user-filter.component.html',
    styleUrls: ['./portal-user-filter.component.scss']
})
export class PortalUserFilterComponent implements OnInit, OnChanges {

    filterEmailValue: string = '';
    filterFirstNameValue: string = '';
    filterLastNameValue: string = '';
    filterMonthlyDonorValue: string = null;

    filterMonthlyItems: DropdownItem[] = [
        {
            title: 'Without filter',
            value: 'null'
        },
        {
            title: 'Monthly donors',
            value: 'true'
        },
        {
            title: 'Not monthly donors',
            value: 'false'
        }
    ];

    @Input()
    active: boolean;

    constructor() {
    }

    ngOnInit() {
    }

    ngOnChanges() {
        console.log('tu');
        console.log(this.filterMonthlyDonorValue)
    }

    aaa() {
        console.log(this.filterMonthlyDonorValue)
    }

}
