import {Component, Input, OnInit} from '@angular/core';
import {PortalUser} from '../../models/portal-user';

@Component({
    selector: '[app-portal-user-item]',
    templateUrl: './portal-user-list-item.component.html',
    styleUrls: ['./portal-user-list-item.component.scss']
})
export class PortalUserListItemComponent implements OnInit {

    @Input()
    users: PortalUser[];

    constructor() {
    }

    ngOnInit() {
    }

    getDonorStatus(statuses) {
        if (statuses.length === 0) {
            return 'inactive';
        }
    }

    showDetail(id) {

    }

}
