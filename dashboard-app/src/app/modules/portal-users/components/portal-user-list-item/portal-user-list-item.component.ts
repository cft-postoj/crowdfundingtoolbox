import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {PortalUser} from '../../models/portal-user';
import {PortalUserService} from '../../services/portal-user.service';
import {Router} from '@angular/router';

@Component({
    selector: '[app-portal-user-item]',
    templateUrl: './portal-user-list-item.component.html',
    styleUrls: ['./portal-user-list-item.component.scss']
})
export class PortalUserListItemComponent implements OnInit {

    public isMonthlyDonor: boolean = false;

    @Input()
    users: PortalUser[];

    @Output()
    public userDetailEmitter = new EventEmitter();

    constructor(private router: Router) {
    }

    ngOnInit() {
    }


    getDonorStatus(statuses) {
        if (statuses.length === 0) {
            return 'inactive';
        }
    }

    showDetail(id) {
        this.userDetailEmitter.emit(id);
    }

}
