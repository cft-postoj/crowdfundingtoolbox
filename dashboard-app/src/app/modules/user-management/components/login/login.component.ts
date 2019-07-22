import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute} from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Routing} from "../../../../constants/config.constants";
import {AuthenticationService} from "../../services/authentication.service";
import {ComponentCommunicationService} from "../../../core/services";
import {UserService} from '../../services';

@Component({
    selector: 'app-login',
    templateUrl: 'login.component.html',
    styleUrls: ['../../../../app.component.scss', './login.component.scss']
})
export class LoginComponent implements OnInit {
    loginForm: FormGroup;
    loading = false;
    forgottenPasswordForm = false;
    submitted = false;
    returnUrl: string;
    alertType: string = '';
    alertMessage: string = '';
    alertOpen: boolean = false;
    alertFixed: boolean = true;
    public routing = Routing;

    constructor(
        public formBuilder: FormBuilder,
        private route: ActivatedRoute,
        private router: Router,
        private authenticationService: AuthenticationService,
        private userService: UserService,
        private compComService: ComponentCommunicationService
    ) {
        // redirect to home if already logged in
        if (this.authenticationService.currentUserValue) {
            this.router.navigate(['/']);
        }
    }

    ngOnInit() {
        if (this.compComService.getLogoutMessage()) {
            this.alertMessage = this.compComService.getLogoutMessage();
            this.alertType = 'danger';
            this.alertOpen = true;
        }
        this.loginForm = this.formBuilder.group({
            username: ['', Validators.required],
            password: ['', Validators.required]
        });

        // get return url from route parameters or default to '/'
        this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';

        // check if user has generated reset token
        if (window.location.href.indexOf('?generatedResetToken=') > -1) {
            this.checkGeneratedToken(window.location.href.split('?generatedResetToken=')[1].split('&loggedIn')[0]);
            this.loading = true;
        }
    }

    // convenience getter for easy access to form fields
    get form() {
        return this.loginForm.controls;
    }

    private submitLogin() {
        this.submitted = true;

        if (this.loginForm.invalid) {
            this.alertMessage = 'Invalid fields in form.';
            this.alertType = 'danger';
            this.alertOpen = true;
            return;
        }
        this.loadingStart();

        this.authenticationService.obtainNewToken(this.loginForm.value.username, this.loginForm.value.password, (token) => {
            this.alertMessage = 'Successfully logged in.';
            this.alertType = 'success';
            this.alertOpen = true;
            setTimeout(() => {
                this.router.navigateByUrl(this.routing.STATS_FULL_PATH);
                this.loadingStop();
            }, 1000);

        }, (e) => {
            this.alertMessage = e.error.message;
            this.alertType = 'danger';
            this.alertOpen = true;
            this.loadingStop();
        });
    }

    private loadingStart() {
        this.loading = true;
    }

    private loadingStop() {
        this.loading = false;
    }

    // TODO unused method , should be used for showing forgotten pass form
    private showForgottenForm() {
        this.forgottenPasswordForm = !this.forgottenPasswordForm;
    }

    private checkGeneratedToken(token) {
        this.userService.checkGeneratedResetToken(token).subscribe((data) => {
            if (data.token !== null) {
                localStorage.setItem('token', data.token);
                localStorage.setItem('user_firstName', (data.user_detail === null) ? 'Backoffice' : data.user_detail.first_name);
                localStorage.setItem('user_lastName', (data.user_detail === null) ? 'User' : data.user_detail.last_name);
                localStorage.setItem('user_role', data.user_role);
                this.router.navigateByUrl(Routing.DASHBOARD + '/' + Routing.USER_SETTINGS);
            }
        }, (error) => {
            console.log(error);
            this.loading = false;
        }, () => {
            this.loading = false;
        });
    }
}
