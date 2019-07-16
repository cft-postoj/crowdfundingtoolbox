import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {Payment} from '../../models/payment';
import {TableModel} from '../../../core/models/table-model';
import {TableService} from '../../../core/services/table.service';
import {Filter} from '../../../core/models/filter';
import {ModalComponent} from '../../../core/parts/atoms';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {PaymentService} from '../../services/payment.service';
import {PortalUser} from '../../../portal-users/models/portal-user';
import {PortalUserService} from '../../../portal-users/services/portal-user.service';
import {PaymentMethodsService} from '../../services/payment-methods.service';

@Component({
    selector: 'app-unpaired-payments',
    templateUrl: './unpaired-payments.component.html',
    styleUrls: ['./unpaired-payments.component.scss']
})
export class UnpairedPaymentsComponent implements OnInit {

    public loading: boolean = true;
    public items: any = [];
    private payments: Payment[];
    public textSearch: string;

    private allUsers: PortalUser[];

    public paymentMethods: any = [];

    public users: any = [];

    public model: TableModel = new TableModel();

    public alertOpen: boolean = false;
    public alertType: string = 'success';
    public alertMessage: string = '';

    @Output() modelChange = new EventEmitter();

    constructor(private paymentService: PaymentService, private portalUserService: PortalUserService,
                private paymentMethodsService: PaymentMethodsService,
                private tableService: TableService, private _modalService: NgbModal) {
    }

    ngOnInit() {
        this.getPaymentMethods();
        this.getUnpairedPayments();
        this.getUsers();
        this.model.columns.push({
            value_name: 'iban',
            description: 'IBAN',
            type: 'text',
            filter: new Filter()
        });
    }

    private getUnpairedPayments() {
        this.paymentService.getUnpairedPayments().subscribe((data: Payment[]) => {
            this.payments = data;
            this.payments.map((item, key) => {
                if (key < 200) {
                    this.items.push(item);
                }
            });
            // TODO LOAD MORE (LAZY LOADING)
            this.loading = false;
        });
    }

    private getPaymentMethods() {
        this.paymentMethodsService.getAll().subscribe((data) => {
            data.map((d, key) => {
                this.paymentMethods.push(d.method_name);
            });
        });
    }

    sortTable() {
        this.items = this.tableService.sort(this.model, this.payments);
    }

    changeDonationAssignment(id) {
        //const countSameIban = this.getCountOfPaymentsWithSameIban(iban);
        // let stringCount = '';
        // if (countSameIban === 1) {
        //     stringCount = '<b>1</b> payment';
        // } else {
        //     stringCount = '<b>' + countSameIban + '</b> payments';
        // }
        // this.allUsers.map((u, key) => {
        //     if (u.id === id) {
        //         this.assignToUserModal('Assign payment to user with email ' + u.email + '.',
        //             'Are you sure you want to assign all payments with IBAN of choosed payment to choosed user?',
        //             '<div><br><span>You\'ll assign ' + stringCount + ' to user with email <b>' + u.email + '</b>.</span><br><br>' +
        //             'If you confirm this, user will have assigned new IBAN from this payment and all payments with this IBAN will be ' +
        //             'paired via IBAN for this specific user.</div> <span>' +
        //             'Do you want to continue with this action</span>', id, u.email, itemId, iban);
        //     }
        // });

    }

    pairViaIbanModal(itemId) {
        let title = '';
        let text = '';
        const itemIds = [];
        if (itemId !== null) {
            // pair all filtered payments
            title = 'Pair this payment via IBAN';
            text = 'Are you sure you want to pair this payment via IBAN? If there will be found some user who has same IBAN, ' +
                'payment will be assign to this user and all next payments for this user will be paired via IBAN.' +
                ' Do you want to continue with this action';
            itemIds.push(itemId);
        } else {
            title = 'Pair all filtered payments via IBAN';
            text = 'Are you sure you want to pair all ' + this.items.length + ' payments' +
                ' via IBAN? If there will be found some user who has same IBAN, ' +
                'a single payment will be assign to this user and all next payments for this user will be paired via IBAN.' +
                ' Do you want to continue with this action';
            this.items.map((i, key) => {
                itemIds.push(i.id);
            });
        }
        const modalRef = this._modalService.open(ModalComponent);
        modalRef.componentInstance.title = title;
        modalRef.componentInstance.text = text;
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';
        modalRef.result.then((data) => {
                this.loading = true;
                this.paymentService.pairViaIban(itemIds).subscribe((d) => {
                    this.alertMessage = d.message;
                    this.loading = true;
                    this.getUnpairedPayments();
                    this.alertType = d.status;
                    this.alertOpen = true;
                }, (error) => {
                    console.log(error);
                    this.alertMessage = 'Error during pairing payments. Error message: ' + error;
                    this.alertType = 'success';
                    this.alertOpen = true;
                });
            }, (error) => {
                console.log(error);
            }
        );
    }

    private getCountOfPaymentsWithSameIban(iban) {
        let count = 0;
        this.items.map((i, key) => {
            if (i.iban === iban) {
                count++;
            }
        });
        return count;
    }

    private assignToUserModal(title, text, textPrimary, userId, userEmail, itemId, iban) {
        const modalRef = this._modalService.open(ModalComponent);
        modalRef.componentInstance.title = title;
        modalRef.componentInstance.text = text;
        modalRef.componentInstance.textPrimary = textPrimary;
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then((data) => {
                // change id for donation
                this.paymentService.pairPaymentToUser(itemId, userId, iban).subscribe((d) => {
                    this.loading = true;
                    this.getUnpairedPayments();
                    this.alertMessage = 'Successfully paired payment to user with email ' + userEmail + '.';
                    this.alertType = 'success';
                    this.alertOpen = true;
                }, (error) => {
                    console.log(error);
                    alert('There was an error during updating assignment, please try again later.');
                });
            }, (error) => {
                console.log(error);
            }
        );
    }

    getUsers() {
        this.portalUserService.getAll().subscribe((data: [PortalUser]) => {
            this.allUsers = data;
            data.map((u, key) => {
                const value = u.user_detail.first_name + ' ' + u.user_detail.last_name + ' [email: ' + u.email + ', ID: ' + u.id + ']';
                this.users.push(value);
            });
        });
    }


}
