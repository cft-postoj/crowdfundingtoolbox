import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute} from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';



import {AuthenticationService} from '../_services';
import {Routing} from "../constants/config.constants";
import {ComponentCommunicationService} from "../_services/component-communication.service";

@Component({
  selector: 'app-login',
  templateUrl: 'login.component.html',
  styleUrls: ['../app.component.scss', './login.component.scss']
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
    private compComService: ComponentCommunicationService
  ) {
    // redirect to home if already logged in
    if (this.authenticationService.currentUserValue) {
      this.router.navigate(['/']);
    }
  }

  ngOnInit() {
    if (this.compComService.getLogoutMessage()){
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

    this.authenticationService.obtainNewToken(this.loginForm.value.username, this.loginForm.value.password,  (token) => {
      this.alertMessage = 'Successfully logged in.';
        this.alertType = 'success';
        this.alertOpen = true;
        setTimeout(() => {
            this.router.navigate([this.routing.CAMPAIGNS_ALL_FULL_PATH]);
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

}
