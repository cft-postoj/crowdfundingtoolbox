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

@Component({
    selector: 'app-unpaired-payments',
    templateUrl: './unpaired-payments.component.html',
    styleUrls: ['./unpaired-payments.component.scss']
})
export class UnpairedPaymentsComponent implements OnInit {

    public loading: boolean = true;
    public items: Payment[];
    private payments: Payment[];
    public textSearch: string;

    public users: any = [];

    public model: TableModel = new TableModel();

    public alertOpen: boolean = false;
    public alertType: string = 'success';
    public alertMessage: string = '';

    @Output() modelChange = new EventEmitter();

    constructor(private paymentService: PaymentService, private portalUserService: PortalUserService,
                private tableService: TableService, private _modalService: NgbModal) {
    }

    ngOnInit() {
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
            this.items = this.payments;
            this.loading = false;
        });
    }

    sortTable() {
        this.items = this.tableService.sort(this.model, this.payments);
    }

    changeDonationAssignment(id, itemId) {
        this.assignToUserModal('Assign payment to user with id ' + id,
            'Are you sure you want to assign this payment to user? ' +
            'If yes, user will have assigned new IBAN from this payment and all feature payments will be ' +
            'paired via IBAN for this specific user. Do you want to continue with this action', id, itemId);
    }

    private assignToUserModal(title, text, userId, itemId) {
        const modalRef = this._modalService.open(ModalComponent); // if user is admin
        modalRef.componentInstance.title = title;
        modalRef.componentInstance.text = text;
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then((data) => {
                // change id for donation
                this.paymentService.pairPaymentToUser(itemId, userId).subscribe((d) => {
                    this.loading = true;
                    this.getUnpairedPayments();
                    this.alertMessage = 'Successfully paired payment to user with id ' + userId + '.';
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
            data.map((u, key) => {
                const value = u.user_detail.first_name + ' ' + u.user_detail.last_name + ' - [ID: ' + u.id + ']';
                this.users.push(value);
            });
        });
    }


}
