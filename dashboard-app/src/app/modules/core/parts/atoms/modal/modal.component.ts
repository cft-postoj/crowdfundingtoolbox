import {Component, Input} from '@angular/core';
import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";

@Component({
    selector: 'app-modal',
    templateUrl: './modal.component.html',
    styleUrls: ['./modal.component.scss']
})
export class ModalComponent {

    @Input() title;

    @Input() text;

    @Input() textPrimary;

    @Input() duplicate;

    @Input() loading = true;


    constructor(public modal: NgbActiveModal) {
    }

}
