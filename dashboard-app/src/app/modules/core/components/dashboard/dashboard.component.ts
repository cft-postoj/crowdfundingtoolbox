import {Component, OnChanges, OnDestroy, OnInit} from '@angular/core';
import {Subscription} from "rxjs";
import {TokenExpirationService} from "../../../user-management/services";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit, OnDestroy, OnChanges {

  constructor(private expirationService: TokenExpirationService) { }

    public expiration: any = false;
    public detectChanges: boolean = false;

    private subscribtion: Subscription;

    ngOnInit() {
        this.expirationService.expiration();
        this.subscribtion = this.expirationService.expirationEmitter.subscribe(data => {
            this.expiration = data;
        });
    }

    ngOnChanges(): void {
        this.detectChanges = true;
    }


    ngOnDestroy() {
        if (this.subscribtion !== undefined) {
            this.subscribtion.unsubscribe();
        }

    }


}
