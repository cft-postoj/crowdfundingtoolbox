import {Component, OnInit} from '@angular/core';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {ModalComponent} from '../../../core/parts/atoms';
import {PaymentService} from '../../services/payment.service';

@Component({
    selector: 'app-import-payments',
    templateUrl: './import-payments.component.html',
    styleUrls: ['./import-payments.component.scss']
})
export class ImportPaymentsComponent implements OnInit {

    constructor(private _modalService: NgbModal, private paymentService: PaymentService) {
    }

    ngOnInit() {
    }

    public processFile(file) {
        this.paymentService.checkUploadedFileType(file).subscribe((data) => {
            console.log(data);
        });
        this.showModal(file.name);
    }

    /*
    TODO: double check (if payment with same data is more times) and if is in payment table
     */

    private showModal(documentName) {
        const modalRef = this._modalService.open(ModalComponent); // if user is admin
        modalRef.componentInstance.title = 'Import payments from document <b>' + documentName + '</b>';
        modalRef.componentInstance.text = 'Are you sure you want to import all payments from this document? ' +
            'System\'ll process only unique payments (all payments which are already in system will be skiped. ' +
            'Do you want to continue';
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then((data) => {
                // change id for donation
                //         this.donationService.updateAssignment(this.id, id).subscribe((d) => {
                //             this.loading = true;
                //             this.getDetail();
                //         }, (error) => {
                //             console.log(error);
                //             alert('There was an error during updating assignment, please try again later.');
                //         });
                //     }, (error) => {
                //         console.log(error);
            }
        );
    }

}
