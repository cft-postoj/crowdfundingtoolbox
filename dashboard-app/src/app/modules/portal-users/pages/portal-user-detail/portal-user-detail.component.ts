import {Component, Input, OnInit, Output} from '@angular/core';
import {PortalUser} from '../../models/portal-user';
import {PortalUserService} from '../../services/portal-user.service';
import {ActivatedRoute, Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';
import {DropdownItem} from '../../../core/models';

@Component({
    selector: 'app-donor-detail',
    templateUrl: './portal-user-detail.component.html',
    styleUrls: ['./portal-user-detail.component.scss']
})
export class PortalUserDetailComponent implements OnInit {

    user: PortalUser;
    id: number;
    loading: boolean = true;
    modalOpened: boolean = false;

    alertOpen: boolean = false;
    alertType: string = 'success';
    alertMessage: string;
    paymentsPairingTypes: DropdownItem[];


    constructor(private portalUserService: PortalUserService, private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.params.subscribe(
            params => {
                this.id = params['id'];
                this.showDetail();
            }
        );
        this.paymentsPairingTypes = [
            {
                value: 'variable_symbol',
                title: 'Variable symbol'
            },
            {
                value: 'iban',
                title: 'IBAN'
            }
        ];
    }

    private showDetail() {
        this.portalUserService.getById(this.id).subscribe((data) => {
            this.user = data;
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

    public updatedExcluded($event) {
        this.alertType = 'success';
        if ($event !== 'reason') {
            if ($event) {
                this.alertMessage = 'Successfully excluded <b>' + this.user.user_detail.first_name + ' ' +
                    this.user.user_detail.last_name + '</b> from campaigns targeting.';
            } else {
                this.alertMessage = 'Successfully remove <b>' + this.user.user_detail.first_name + ' ' +
                    this.user.user_detail.last_name + '</b> from excluding users from campaigns targeting.';
            }
        } else {
            this.alertType = 'danger';
            this.alertMessage = 'Reason of excluding users from campaigns targeting is required!';
        }

        this.alertOpen = true;
    }

    public showEditModal() {
        this.modalOpened = true;
    }

    public updatedUserDetails(val) {
        if (val) {
            this.showDetail();
            this.modalOpened = false;
            this.alertMessage = 'User details were successfully updated.';
            this.alertOpen = true;
        }
    }

    public changePaymentsPairing(val) {
        this.portalUserService.changePaymentsPairing(this.user.portal_user.id, val).subscribe((data) => {
            this.modalOpened = false;
            this.alertMessage = 'User\'s preferred payments pairing was successfully changed.';
            this.alertType = 'success';
            this.alertOpen = true;
        }, (error) => {
            this.alertMessage = 'During update there was an error: ' + error;
            this.alertType = 'danger';
            this.alertOpen = true;
        });
    }

}
