import {Component, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {ActivatedRoute, Router} from '@angular/router';
import {Donation} from '../../models/donation';
import {PaymentMethod} from '../../models/payment-method';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {CampaignService} from '../../../campaigns/services';
import {Routing} from '../../../../constants/config.constants';
import {ModalComponent} from '../../../core/parts/atoms';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';

@Component({
    selector: 'app-donation-detail',
    templateUrl: './donation-detail.component.html',
    styleUrls: ['./donation-detail.component.scss']
})
export class DonationDetailComponent implements OnInit {

    private id: number;
    public detail = new Donation();
    public paymentMethods = new PaymentMethod();
    public loading: boolean = true;
    public campaignName: string = '';
    public campaignId: number = 0;

    constructor(private donationService: DonationService, private router: Router,
                private route: ActivatedRoute, private campaignService: CampaignService,
                private _modalService: NgbModal) {
    }

    ngOnInit() {
        this.route.params.subscribe(
            params => {
                this.id = params['id'];
                this.getDetail();
            }
        );
    }

    private getDetail() {
        this.donationService.getDetail(this.id).subscribe((data: Donation) => {
            this.detail = data;
            this.loading = false;
            this.getCampaign();
            console.log(this.detail);
        });
    }

    private getCampaign() {
        this.campaignService.getCampaignByWidgetId(this.detail.referral_widget_id).subscribe((data) => {
            this.campaignName = data.name;
            this.campaignId = data.id;
        });
    }

    private getPaymentMethod(id) {
        let paymentMethod = '';
        switch (id) {
            case 1:
                paymentMethod = 'Bank transfer';
                break;
            case 2:
                paymentMethod = 'Card pay';
                break;
            case 3:
                paymentMethod = 'Pay by square';
                break;
            case 4:
                paymentMethod = 'Google pay';
                break;
            case 5:
                paymentMethod = 'Apple pay';
                break;
            default:
                break;
        }
        return paymentMethod;
    }

    public isNullOrUndefined(variable) {
        return (variable === null || variable === undefined);
    }

    public showCampaignDetail(id) {
        this.router.navigateByUrl(Routing.CAMPAIGNS_FULL_PATH + '/' + id);
    }

    public showDetailDonor() {
        const id = this.detail.portal_user.user.id;
        this.router.navigateByUrl(Routing.PORTAL_USERS_FULL_PATH + '/' + id);
    }

    public changeDonationAssignment(id) {
        const modalRef = this._modalService.open(ModalComponent); // if user is admin
        modalRef.componentInstance.title = 'Change donation assignment';
        modalRef.componentInstance.text = 'Are you sure you want to assign this donation to user with id ' + id;
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then((data) => {
                // change id for donation
                this.donationService.updateAssignment(this.id, id).subscribe((d) => {
                    this.loading = true;
                    this.getDetail();
                }, (error) => {
                    console.log(error);
                    alert('There was an error during updating assignment, please try again later.');
                });
            }, (error) => {
                console.log(error);
            }
        );

    }
}
