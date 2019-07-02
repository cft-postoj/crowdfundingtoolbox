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

  constructor(private portalUserService: PortalUserService, public formBuilder: FormBuilder) { }

  ngOnInit() {
    this.userForm = this.formBuilder.group({
      firstName: [this.userData.user_detail.first_name, Validators.required],
      lastName: [this.userData.user_detail.last_name, Validators.required],
      email: [this.userData.email, Validators.required],
      username: [this.userData.username, Validators.required],
      telephonePrefix: [this.userData.user_detail.telephone_prefix],
      telephone: [this.userData.user_detail.telephone],
      street: [this.userData.user_detail.street],
      houseNumber: [this.userData.user_detail.house_number],
      zip: [this.userData.user_detail.zip],
      city: [this.userData.user_detail.city],
      country: [this.userData.user_detail.country],
      password: ['******'],
      bankAccount: [''],
      cardNumber: [''],
      cardExpiration: ['']
    });
  }

}
