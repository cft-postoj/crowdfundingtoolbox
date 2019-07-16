import {Component, OnInit} from '@angular/core';
import {PortalUserService} from '../../services/portal-user.service';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    selector: 'app-portal-user-detail-donations',
    templateUrl: './portal-user-detail-donations.component.html',
    styleUrls: ['./portal-user-detail-donations.component.scss']
})
export class PortalUserDetailDonationsComponent implements OnInit {

    private id: any;
    from = {year: 2010, month: 1, day: 1};
    to = {year: new Date().getFullYear(), month: new Date().getMonth() + 1, day: new Date().getDate()};
    public donationsDetail;
    private loading: boolean = true;
    private nowDate = new Date();

    constructor(private portalUserService: PortalUserService, private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.parent.params.subscribe(
            params => {
                this.id = params['id'];
                this.getDonationsDetailInfo();
            }
        );

    }

    private getDonationsDetailInfo() {
        this.loading = true;
        this.portalUserService.getDonationsDetailInfo(this.id).subscribe(result => {
            this.donationsDetail = result;
            this.loading = false;
        });
    }


    public isNewDonor() {
        if (this.donationsDetail.first_donation == null) {
            return false;
        }
        const firstDate = new Date(this.donationsDetail.first_donation.payment.transaction_date);
        const nowDate = new Date();
        // 30 days in milliseconds
        const thirthyDays = 30 * 24 * 60 * 60 * 1000;
        return firstDate.getTime() + thirthyDays > nowDate.getTime();
    }

    public daysAgo() {
        if (this.donationsDetail.last == null) {
            return null;
        }
        const last = new Date(this.donationsDetail.last.payment.transaction_date);

        // 30 days in milliseconds
        const day = 24 * 60 * 60 * 1000;
        const daysAgo = Math.round((this.nowDate.getTime() - last.getTime()) / day);
        return '( ' + daysAgo + ' days ago)';
    }
}
