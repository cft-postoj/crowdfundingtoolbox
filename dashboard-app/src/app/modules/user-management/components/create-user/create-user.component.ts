import {Component, OnInit} from '@angular/core';
import {UserService} from '../../services';
import {UserDetail} from '../../models/userDetail';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-create-user',
    templateUrl: './create-user.component.html',
    styleUrls: ['./create-user.component.scss']
})
export class CreateUserComponent implements OnInit {

    public isAdmin: boolean = false;
    public loading: boolean = false;
    public pageLoading: boolean = true;
    private userDetail: UserDetail;
    public userForm: FormGroup;
    public alertMessage: string = '';
    public alertType: string = 'success';
    public alertOpen: boolean = false;
    public alertFixed: boolean = false;

    constructor(private userService: UserService, public formBuilder: FormBuilder, private router: Router) {
    }

    ngOnInit() {
        this.userForm = this.formBuilder.group({
            password: ['', Validators.required],
            email: ['', Validators.required],
            firstName: [''],
            lastName: [''],
            role: ['']
        });
        this.getUserDetail();
    }

    // convenience getter for easy access to form fields
    get form() {
        return this.userForm.controls;
    }

    getUserDetail() {
        this.userService.getUserDetail().subscribe((data) => {
            this.isAdmin = (data.role.id === 1);
            this.pageLoading = false;
        });

    }

    storeUserDetail() {
        this.pageLoading = true;
        this.userDetail = {
            username: '',
            password: this.userForm.value.password,
            email: this.userForm.value.email,
            firstName: this.userForm.value.firstName,
            lastName: this.userForm.value.lastName,
            role: this.userForm.value.role
        };
        this.userService.createBackOfficeUser(this.userDetail).subscribe((data) => {
            this.alertMessage = 'Successfully created backoffice user.';
            this.alertType = 'success';
            this.alertOpen = true;
            this.userForm.value.password = '';
            this.userForm.value.email = '';
            this.userForm.value.firstName = '';
            this.userForm.value.lastName = '';
            this.userForm.value.role = '';
        }, (e) => {
            this.pageLoading = false;
            if (e.error !== null) {
                console.log(e.error)
                this.alertMessage = '';
                if (e.error.error.password !== undefined) {
                    this.alertMessage += ' ' + e.error.error.password[0];
                }
                if (e.error.error.email !== undefined) {
                    this.alertMessage += ' ' + e.error.error.email[0];
                }
                if (e.error.error.role !== undefined) {
                    this.alertMessage += ' ' + e.error.error.role[0];
                }
                if (typeof e.error.error === 'string') {
                    this.alertMessage += ' ' + e.error.error;
                }
                this.alertType = 'danger';
                this.alertOpen = true;
            }
        }, () => {
            this.pageLoading = false;
        });
    }

    public isAdminRole(event) {
        if (!event) {
            return this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.USER_SETTINGS}`);
        }
    }

}
