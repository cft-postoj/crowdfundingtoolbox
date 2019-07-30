import {Component, OnInit} from '@angular/core';
import {Routing} from '../../../../constants/config.constants';
import {Router} from '@angular/router';
import {PortalConnectonService} from '../../services/portal-connecton.service';
import {escapeHtml} from '@angular/platform-browser/src/browser/transfer_state';

@Component({
    selector: 'app-portal-connections-settings',
    templateUrl: './portal-connections-settings.component.html',
    styleUrls: ['./portal-connections-settings.component.scss', '../settings/settings.component.scss']
})
export class PortalConnectionsSettingsComponent implements OnInit {

    loading = true;
    saving: boolean = false;

    submitted: boolean = false;
    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';
    private validUrl: boolean = false;

    public portalUrl: string = '';

    public backendUrl: string = '';

    constructor(private router: Router, private connectionService: PortalConnectonService) {
        this.fetchSettings();
    }

    ngOnInit() {
        this.getBackendUrl();
    }

    private getBackendUrl() {
        this.connectionService.getBackendUrl().subscribe((val) => {
            this.backendUrl = val;
        });
    }

    updateSettings() {
        if (this.validUrl) {
            this.saving = true;
            this.connectionService.setPortalUrl(this.portalUrl).subscribe((data) => {
                console.log(data);
                this.alertType = 'success';
                this.alertMessage = data.message;
            }, (error) => {
                this.alertType = 'danger';
                this.alertMessage = error;
            }, () => {
                this.alertOpen = true;
                this.saving = false;
            })
        } else {
            this.alertMessage = 'Portal URL must start with http:// or https://!';
            this.alertType = 'danger';
            this.alertOpen = true;
        }
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    private fetchSettings() {
        this.connectionService.getPortalUrl().subscribe((val) => {
           this.portalUrl = val;
        });
        this.loading = false;
    }

    checkUrl(event) {
        const regexp = /^http(s)*:\/\/(.)+\.(.)+/;
        if (event.target.value.match(regexp) == null) {
            this.alertMessage = 'Portal URL must start with http:// or https://!';
            this.alertType = 'danger';
            this.alertOpen = true;
            this.validUrl = false;
        } else {
            console.log('hree');
            this.validUrl = true;
        }
    }


}
