import { Component, OnInit } from '@angular/core';
import {Subscription} from "rxjs";
import {TokenExpirationService} from "../../../user-management/services";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  constructor(private expirationService: TokenExpirationService) { }

    public expiration: any = false;

    private subscribtion: Subscription;

    ngOnInit() {
        this.expirationService.expiration();
        this.subscribtion = this.expirationService.expirationEmitter.subscribe(data => {
            this.expiration = data;
        });
    }

    ngOnDestroy() {
        if (this.subscribtion !== undefined) {
            this.subscribtion.unsubscribe();
        }

    }


}
