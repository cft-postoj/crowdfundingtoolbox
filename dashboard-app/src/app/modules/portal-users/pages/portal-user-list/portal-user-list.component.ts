import {Component, OnInit} from '@angular/core';
import {PortalUserService} from "../../services/portal-user.service";
import {PortalUser} from "../../models/portal-user";
import {Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';
import moment from 'moment/src/moment';

@Component({
    selector: 'app-donor-list',
    templateUrl: './portal-user-list.component.html',
    styleUrls: ['./portal-user-list.component.scss']
})
export class PortalUserListComponent implements OnInit {

    alertOpen: boolean = false;
    alertType: string = '';
    alertMessage: string = '';
    loading: boolean = true;
    noUsers: boolean = false;
    users: PortalUser[];
    filterActive: boolean = false;
    exportCsvLoading: boolean = false;

    public from: string;
    public to: string;
    public tableTitle: string;
    public tables = {
        tablePayments: false,
        tableDonors: true
    };
    public statsDateSelected: any;

    constructor(private portalUserService: PortalUserService, private router: Router) {
    }

    ngOnInit() {
        this.loading = false;
        this.from = '2015-01-01'; // statically defined list of donors from this date
        this.to = moment().format('YYYY-MM-DD');
        this.tableTitle = 'All users';
        //this.getUsers();
    }

    getUsers() {
        this.portalUserService.getAll().subscribe((data: PortalUser[]) => {
            this.users = data;
            this.loading = false;
            if (data.length === 0) {
                this.noUsers = true;
            }
        });
    }

    showFilter() {
        this.filterActive = !this.filterActive;
    }

    redirectUserDetail(id: number) {
        this.router.navigateByUrl(Routing.PORTAL_USERS_FULL_PATH + '/' + id);
    }

    export2Csv(event) {
        this.alertOpen = event.alertOpen;
        this.alertMessage = event.alertMessage;
        this.alertType = event.alertType;
    }

    exportLoading(event) {
        this.loading = event;
        this.exportCsvLoading = event;
    }

}
