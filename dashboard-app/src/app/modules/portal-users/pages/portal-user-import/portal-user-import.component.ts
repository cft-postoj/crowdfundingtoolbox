import {Component, OnInit} from '@angular/core';
import {Routing} from '../../../../constants/config.constants';
import {NavbarItem} from '../../../core/models/navbar-item';
import {PortalUserService} from '../../services/portal-user.service';

@Component({
    selector: 'app-portal-user-import',
    templateUrl: './portal-user-import.component.html',
    styleUrls: ['./portal-user-import.component.scss']
})
export class PortalUserImportComponent implements OnInit {
    public navItems: NavbarItem[];
    public loading = false;
    public alertMessage: any;
    public alertType: string;
    public alertOpen: boolean;
    public loadingSubscribers = false;
    public alertMessageSubscribers: any;
    public alertTypeSubscribers: string;
    public alertOpenSubscribers: boolean;

    public loadingSubscribersSvetKrestanstva = false;
    public alertOpenSubscribersSvetKrestanstva: boolean;
    public alertMessageSubscribersSvetKrestanstva: string;
    public alertTypeSubscribersSvetKrestanstva: any;

    public loadingIbans = false;
    public alertOpenIbans: boolean;
    public alertMessageIbans: string;
    public alertTypeIbans: any;
    
    constructor(private portalUserService: PortalUserService) {
    }

    ngOnInit() {
        this.navItems = [
            {
                title: 'All users',
                url: Routing.DASHBOARD + '/' + Routing.PORTAL_USERS + '/' + Routing.ALL,
                active: true
            },
            {
                title: 'Import users',
                url: Routing.DASHBOARD + '/' + Routing.PORTAL_USERS + '/' + Routing.IMPORT,
                active: false
            }
        ];
    }

    public processFileDonors(file) {
        if (file !== null) {
            this.loading = true;
            this.portalUserService.importDonors(file).subscribe((data) => {
                this.alertMessage = data.message;
                this.alertType = 'success';
                this.alertOpen = true;
                this.loading = false;
            }, error => {
                this.alertMessage = error.error.message;
                this.alertType = 'danger';
                this.alertOpen = true;
                this.loading = false;
            });
        }
    }

    public processFileSubscribers(file) {
        if (file !== null) {
            this.loadingSubscribers = true;
            this.portalUserService.importSubscribers(file)
                .subscribe((data) => {
                        this.alertMessageSubscribers = data.message;
                        this.alertTypeSubscribers = 'success';
                        this.alertOpenSubscribers = true;
                        this.loadingSubscribers = false;
                    }, error => {
                        this.alertMessageSubscribers = error.error.message;
                        this.alertTypeSubscribers = 'danger';
                        this.alertOpenSubscribers = true;
                        this.loadingSubscribers = false;
                    }
                );
        }
    }

    public processFileSubscribersSvetKrestanstva(file) {
        if (file !== null) {
            this.loadingSubscribersSvetKrestanstva = true;
            this.portalUserService.importSubscribersSvetKrestanstva(file)
                .subscribe((data) => {
                        this.alertMessageSubscribersSvetKrestanstva = data.message;
                        this.alertTypeSubscribersSvetKrestanstva = 'success';
                        this.alertOpenSubscribersSvetKrestanstva = true;
                        this.loadingSubscribersSvetKrestanstva = false;
                    }, error => {
                        this.alertMessageSubscribersSvetKrestanstva = error.error.message;
                        this.alertTypeSubscribersSvetKrestanstva = 'danger';
                        this.alertOpenSubscribersSvetKrestanstva = true;
                        this.loadingSubscribersSvetKrestanstva = false;
                    }
                );
        }

    }

    public processFileIbans(file) {
        if (file !== null) {
            this.loadingIbans = true;
            this.portalUserService.importIbans(file)
                .subscribe((data) => {
                        this.alertMessageIbans = data.message;
                        this.alertTypeIbans = 'success';
                        this.alertOpenIbans = true;
                        this.loadingIbans = false;
                    }, error => {
                        this.alertMessageIbans = error.error.message;
                        this.alertTypeIbans = 'danger';
                        this.alertOpenIbans = true;
                        this.loadingIbans = false;
                    }
                );
        }
    }
}
