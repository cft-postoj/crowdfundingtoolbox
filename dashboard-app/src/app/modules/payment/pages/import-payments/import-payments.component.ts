import {Component, OnInit, Output} from '@angular/core';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {ModalComponent} from '../../../core/parts/atoms';
import {PaymentService} from '../../services/payment.service';

@Component({
    selector: 'app-import-payments',
    templateUrl: './import-payments.component.html',
    styleUrls: ['./import-payments.component.scss']
})
export class ImportPaymentsComponent implements OnInit {

    public loading: boolean = false;
    public loadingPairing: boolean = false;
    public alertOpen: boolean = false;
    public alertMessage: string = '';
    public alertType: string = '';
    private queue: any[] = [];
    public alerts: { alertOpen, alertMessage, alertType }[] = [];

    constructor(private _modalService: NgbModal, private paymentService: PaymentService) {
    }

    ngOnInit() {

    }

    public processFiles(files) {
        if (files !== null && files.length) {
            this.showModal(files);
        }
    }

    public processFilePairing(files) {
        if (files !== null && files.length) {
            this.showModalPairing(files);
        }
    }

    private showModal(files: FileList) {
        console.log(files);
        var filesNames = '';
        this.queue = [];
        for (let i = 0; i < files.length; i++) {
            this.queue.push(files.item(i));
            filesNames += files.item(i).name;
            filesNames += i + 1 !== files.length ? ', ' : '.';
        }
        const modalRef = this._modalService.open(ModalComponent); // if user is admin
        modalRef.componentInstance.title = 'Import payments from document <b>' + filesNames + '</b>';
        modalRef.componentInstance.text = 'Are you sure you want to import all payments from this document? ' +
            'System\'ll process only unique payments (all payments which are already in system will be skiped. ' +
            'Do you want to continue';
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then(
            (data) => {
                this.handleImportPayment(files[0]);
            },
            (error) => {
                console.log(error);
            }
        );
    }

    private showModalPairing(files: FileList) {
        console.log(files);
        var filesNames = '';
        this.queue = [];
        for (let i = 0; i < files.length; i++) {
            this.queue.push(files.item(i));
            filesNames += files.item(i).name;
            filesNames += i + 1 !== files.length ? ', ' : '.';
        }
        const modalRef = this._modalService.open(ModalComponent); // if user is admin
        modalRef.componentInstance.title = 'Pair account name to payments from document <b>' + filesNames + '</b>';
        modalRef.componentInstance.text = 'Are you sure you want to pair all account names to payments from this document? ' +
            'Do you want to continue';
        modalRef.componentInstance.loadingPairing = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then(
            (data) => {
                this.handleImportPaymentForPairing(files[0]);
            },
            (error) => {
                console.log(error);
            }
        );
    }

    public handleImportPayment(file) {
        if (!this.loading) {
            this.loading = true;
            this.paymentService.importPayments(file).subscribe((d) => {
                console.log(d)
                if (d.type === 1 && d.loaded && d.total) {
                    console.log(d.total)
                }
                this.loading = false;
                this.alerts.push({
                    alertMessage: '<b>Result for uploaded file ' + file.name + ':</b><br>' + d.message,
                    alertType: 'success',
                    alertOpen: true
                });
                this.queue.shift();
                console.log(this.queue);
                if (this.queue.length !== 0) {
                    this.handleImportPayment(this.queue[0]);
                }
            }, (error) => {
                this.loading = false;
                this.alerts.push({
                    alertMessage: (error.error !== null) ? error.error.error : 'During the payments import there was an unknown error. ' +
                        'Please, try it later or contact administrator.',
                    alertType: 'danger',
                    alertOpen: true
                });
            });
        }
    }

    public handleImportPaymentForPairing(file) {
        if (!this.loadingPairing) {
            this.loadingPairing = true;
            this.paymentService.pairAccountNameToPayments(file).subscribe((d) => {
                console.log(d)
                if (d.type === 1 && d.loaded && d.total) {
                    console.log(d.total);
                }
                this.loadingPairing = false;
                this.alerts.push({
                    alertMessage: '<b>Result for uploaded file ' + file.name + ':</b><br>' + d.message,
                    alertType: 'success',
                    alertOpen: true
                });
                this.queue.shift();
                console.log(this.queue);
                if (this.queue.length !== 0) {
                    this.handleImportPayment(this.queue[0]);
                }
            }, (error) => {
                this.loadingPairing = false;
                this.alerts.push({
                    alertMessage: (error.error !== null) ? error.error.error : 'During the payments import there was an unknown error. ' +
                        'Please, try it later or contact administrator.',
                    alertType: 'danger',
                    alertOpen: true
                });
            });
        }
    }

}
