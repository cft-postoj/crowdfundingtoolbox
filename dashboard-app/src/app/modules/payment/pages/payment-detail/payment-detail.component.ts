import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {PaymentService} from '../../services/payment.service';
import {PaymentMethod} from '../../models/payment-method';
import {Payment} from '../../models/payment';
import {HelpersService} from '../../../core/services/helpers.service';
import {Routing} from '../../../../constants/config.constants';

@Component({
  selector: 'app-payment-detail',
  templateUrl: './payment-detail.component.html',
  styleUrls: ['./payment-detail.component.scss']
})
export class PaymentDetailComponent implements OnInit {

  public id: number;
  public detail = new Payment();
  public paymentMethods = new PaymentMethod();
  public loading: boolean = true;
  public campaignName: string = '';
  public campaignId: number = 0;
  public users: any = [];
  public selectedUser: string = '';

  constructor(private router: Router, private route: ActivatedRoute,
              private paymentService: PaymentService, private helperService: HelpersService) { }

  ngOnInit() {
    this.route.params.subscribe(
        params => {
          this.id = params['id'];
        }
    );
    this.getPaymentDetail();
  }

  private getPaymentDetail() {
    this.paymentService.getPaymentById(this.id).subscribe((data: Payment) => {
      this.detail = data;
      this.loading = false;
    });
  }

  public isNullOrUndefined(variable) {
    return (variable === null || variable === undefined);
  }

  public getPaymentMethod(id) {
    return this.helperService.getPaymentType(id);
  }

  public showDonation(id) {
    if (id !== null) {
      this.router.navigateByUrl(`${Routing.DONATIONS_FULL_PATH}/${id}`);
    } else {
      this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.UNPAIRED_PAYMENTS}`);
    }
  }

}
