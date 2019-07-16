import {Component, OnInit} from '@angular/core';
import {PortalUserService} from '../../services/portal-user.service';
import {PortalUser} from '../../models/portal-user';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    selector: 'app-portal-user-detail-donations',
    templateUrl: './portal-user-detail-donations.component.html',
    styleUrls: ['./portal-user-detail-donations.component.scss']
})
export class PortalUserDetailDonationsComponent implements OnInit {

    private user: PortalUser;
    private loading: boolean;
    private id: any;
    from = {year: 2010, month: 1, day: 1};
    to = {year: new Date().getFullYear(), month: new Date().getMonth(), day: new Date().getDate()};

    constructor(private portalUserService: PortalUserService, private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.parent.params.subscribe(
            params => {
                this.id = params['id'];
            }
        );

    }


}
