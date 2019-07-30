import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {Router} from "@angular/router";
import {environment} from "../../../../../../environments/environment";
import {AuthenticationService} from "../../../../user-management/services";

@Component({
  selector: 'app-notification',
  templateUrl: './notification.component.html',
  styleUrls: ['./notification.component.scss']
})
export class NotificationComponent implements OnInit {

  constructor(private authService: AuthenticationService,
              private router: Router) { }

  public isClosed: boolean = false;

  ngOnInit() {
  }

  stayLoggedIn() {
    this.isClosed = true;
    this.authService.stayLoggedIn();
  }

  logout() {
    this.isClosed = true;
      this.authService.logout(() =>
          this.router.navigate([this.router.navigateByUrl(environment.login)])
      );
  }

}
