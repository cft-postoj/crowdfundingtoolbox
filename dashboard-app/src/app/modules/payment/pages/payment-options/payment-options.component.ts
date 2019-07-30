import {Component, OnInit} from '@angular/core';
import {NavbarItem} from '../../../core/models/navbar-item';

@Component({
    selector: 'app-payment-options',
    templateUrl: './payment-options.component.html',
    styleUrls: ['./payment-options.component.scss']
})
export class PaymentOptionsComponent implements OnInit {
    modalOpened: boolean = false;
    modalType: string = '';


    constructor() {
    }

    ngOnInit() {
    }

    showModal(type) {
        this.modalType = type;
        this.modalOpened = true;
    }
}
