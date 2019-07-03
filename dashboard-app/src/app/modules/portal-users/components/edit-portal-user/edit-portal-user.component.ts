import {Component, Input, OnInit} from '@angular/core';
import {PortalUser} from '../../models/portal-user';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {PortalUserService} from '../../services/portal-user.service';

@Component({
    selector: 'app-edit-portal-user',
    templateUrl: './edit-portal-user.component.html',
    styleUrls: ['./edit-portal-user.component.scss']
})
export class EditPortalUserComponent implements OnInit {

    @Input()
    public userData: PortalUser;

    public userForm: FormGroup;

    public submitLoading: boolean = false;

    constructor(private portalUserService: PortalUserService, public formBuilder: FormBuilder) {
    }

    ngOnInit() {
        this.userForm = this.formBuilder.group({
            'cft-firstName': [this.userData.user_detail.first_name, Validators.required],
            'cft-lastName': [this.userData.user_detail.last_name, Validators.required],
            'cft-email': [this.userData.email, Validators.required],
            'cft-username': [this.userData.username, Validators.required],
            'cft-telephone-prefix': [this.userData.user_detail.telephone_prefix],
            'cft-telephone': [this.userData.user_detail.telephone],
            'cft-street': [this.userData.user_detail.street],
            'cft-house-number': [this.userData.user_detail.house_number],
            'cft-zip': [this.userData.user_detail.zip],
            'cft-city': [this.userData.user_detail.city],
            'cft-country': [this.userData.user_detail.country],
            'cft-password': ['********'],
            'cft-bankAccountNumber': [''],
            'cft-paymentCardNumber': [''],
            'cft-paymentCardExpirationDate': ['']
        });
    }

    public storeUserDetail() {
        this.submitLoading = true;
        this.portalUserService.editPortalUser(this.userForm.value, this.userData.id).subscribe((data) => {
            console.log(data);
        }, (error) => {
            console.log('error');
        }, () => {
            this.submitLoading = false;
        });
    }

}
