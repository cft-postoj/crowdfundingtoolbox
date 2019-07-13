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
    public alertOpen: boolean = false;
    public alertMessage: string = '';
    public alertType: string = '';

    constructor(private _modalService: NgbModal, private paymentService: PaymentService) {
    }

    ngOnInit() {

    }

    public processFile(file) {
        if (file !== null) {
            this.paymentService.checkUploadedFileType(file).subscribe((data) => {
                console.log(data);
            }).unsubscribe();
            this.showModal(file.name, file);
        }
    }

    /*
    TODO: double check (if payment with same data is more times) and if is in payment table
     */

    private showModal(documentName, file) {
        const modalRef = this._modalService.open(ModalComponent); // if user is admin
        modalRef.componentInstance.title = 'Import payments from document <b>' + documentName + '</b>';
        modalRef.componentInstance.text = 'Are you sure you want to import all payments from this document? ' +
            'System\'ll process only unique payments (all payments which are already in system will be skiped. ' +
            'Do you want to continue';
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then((data) => {
                this.loading = true;
                this.paymentService.importPayments(file).subscribe((d) => {
                    console.log(d)
                    if (d.type === 1 && d.loaded && d.total){
                        console.log("gaju");
                        console.log(d.total)
                    }
                    this.loading = false;
                    this.alertMessage = d.message;
                    this.alertType = 'success';
                    this.alertOpen = true;
                }, (error) => {
                    this.loading = false;
                    this.alertMessage = (error.error !== null) ? error.error.error : 'During the payments import there was an unknown error. ' +
                        'Please, try it later or contact administrator.';
                    this.alertType = 'danger';
                    this.alertOpen = true;
                });
            }, (error) => {
                console.log(error);
            }
        );
    }

}
