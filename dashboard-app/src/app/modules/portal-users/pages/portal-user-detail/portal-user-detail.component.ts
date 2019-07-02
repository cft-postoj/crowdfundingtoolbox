import {Component, OnInit} from '@angular/core';
import {PortalUser} from '../../models/portal-user';
import {PortalUserService} from '../../services/portal-user.service';
import {ActivatedRoute, Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-donor-detail',
    templateUrl: './portal-user-detail.component.html',
    styleUrls: ['./portal-user-detail.component.scss']
})
export class PortalUserDetailComponent implements OnInit {

    user: PortalUser;
    id: number;
    loading: boolean = true;
    isUserMonthlyDonor: boolean = false;

    constructor(private portalUserService: PortalUserService, private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.params.subscribe(
            params => {
                this.id = params['id'];
                this.isMonthlyDonor();
                this.showDetail();
            }
        );
    }

    private showDetail() {
        this.portalUserService.getById(this.id).subscribe((data) => {
            this.user = data;
            console.log(this.user)
            // if current user is not exist or is not a portal user - redirect to portal users list
            if (this.user.portal_user === null) {
                this.router.navigateByUrl(`${Routing.PORTAL_USER_LIST_FULL_PATH}`);
            }
            this.loading = false;
        }, (error) => {
            console.log(error);
            // if error - redirect to portal users list
            this.router.navigateByUrl(`${Routing.PORTAL_USERS_FULL_PATH}`);
        });
    }

    private isMonthlyDonor() {
        this.portalUserService.isMonthlyDonor().subscribe((data) => {
            if (data.is_monthly_donor) {
                this.isUserMonthlyDonor = true;
            }
        });
    }

}
