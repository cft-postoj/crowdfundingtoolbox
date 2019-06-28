import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {UserService} from '../../services';
import {User} from '../../models';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {UserDetail} from '../../models/userDetail';
import {Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-user-settings',
    templateUrl: './user-settings.component.html',
    styleUrls: ['./user-settings.component.scss']
})
export class UserSettingsComponent implements OnInit {

    public userForm: FormGroup;
    public isAdmin: boolean = false;
    private userRoleSlug: string;
    public userRoleName: string;
    public firstName: string = '';
    public lastName: string = '';
    public email: string = '';
    public username: string = '';
    public password: string = '******';
    private userDetail: UserDetail;
    private userId: number = 0;
    public alertOpen: boolean = false;
    public alertFixed: boolean = false;
    public alertMessage: string = '';
    public alertType: string = 'success';
    public loading: boolean = false;


    constructor(private userService: UserService, public formBuilder: FormBuilder, private router: Router) {
    }

    ngOnInit() {
        this.userForm = this.formBuilder.group({
            username: [this.username, Validators.required],
            password: [this.password, Validators.required],
            email: [this.email, Validators.required],
            firstName: [this.firstName],
            lastName: [this.lastName]
        });
        this.getUserDetail();
    }

    // convenience getter for easy access to form fields
    get form() {
        return this.userForm.controls;
    }


    getUserDetail() {
        this.userService.getUserDetail().subscribe((data) => {
            this.userRoleSlug = data.role.slug;
            this.userRoleName = data.role.name;
            this.isAdmin = (data.role.id === 1);
            this.userId = data.id;
            if (data.user !== null) {
                if (data.user.user_detail !== null) {
                    this.firstName = (data.user.user_detail.first_name !== null) ? data.user.user_detail.first_name : '';
                    this.lastName = (data.user.user_detail.last_name !== null) ? data.user.user_detail.last_name : '';
                    localStorage.removeItem('user_firstName');
                    localStorage.setItem('user_firstName', this.firstName);
                    localStorage.setItem('user_lastName', this.lastName);
                }
                this.email = (data.user.email !== null) ? data.user.email : '';
                this.username = (data.user.username !== null) ? data.user.username : '';
            }

        });
    }

    storeUserDetail() {
        this.loading = true;
        this.userDetail = {
            username: (this.userForm.value.username === '') ? this.username : this.userForm.value.username,
            password: this.userForm.value.password,
            email: (this.userForm.value.email === '') ? this.email : this.userForm.value.email,
            firstName: (this.userForm.value.firstName === '') ? this.firstName : this.userForm.value.firstName,
            lastName: (this.userForm.value.lastName === '') ? this.lastName : this.userForm.value.lastName,
            role: ''
        };

        this.userService.updateUserDetail(this.userDetail).subscribe((data) => {
            this.alertMessage = 'Successfully updated user detail.';
            this.alertType = 'success';
            this.alertOpen = true;
        }, (e) => {
            this.loading = false;
            if (e.error !== null) {
                this.alertMessage = '';
                if (e.error.error.username !== undefined) {
                    this.alertMessage = e.error.error.username[0];
                }
                if (e.error.error.password !== undefined) {
                    this.alertMessage += ' ' + e.error.error.password[0];
                }
                if (e.error.error.email !== undefined) {
                    this.alertMessage += ' ' + e.error.error.email[0];
                }
                this.alertType = 'danger';
                this.alertOpen = true;
            }
        }, () => {
            this.loading = false;
        });
    }

    createUser() {
        this.router.navigateByUrl(Routing.DASHBOARD + '/' + Routing.USER_SETTINGS + '/' + Routing.CREATE_USER);
    }

}
