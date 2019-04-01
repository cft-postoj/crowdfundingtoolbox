import {Component, OnInit} from '@angular/core';
import {environment} from 'environments/environment';
import {Router} from "@angular/router";
import {Routing} from "../constants/config.constants";

@Component({
    selector: 'app-sidebar-footer',
    templateUrl: './sidebar-footer.component.html',
    styleUrls: ['./sidebar-footer.component.scss']
})
export class SidebarFooterComponent implements OnInit {

    public environment = environment;
    public routing = Routing;

    constructor(private router: Router) {
    }

    ngOnInit() {
    }

    contactClick() {
        let emailTo = 'support@crowdfundingtoolbox.news';
        let emailSub = 'Crowdfunding Support contact';
        let emailBody = 'Your body here...';
        window.open("mailto:" + emailTo + '?subject=' + emailSub + '&body=' + emailBody);
    }

    faqClick() {
        let pdfUserGuide = 'https://docs.crowdfundingtoolbox.news/user-guide.pdf';
        window.open(pdfUserGuide);
    }

    globalSettings() {
        this.router.navigate([this.routing.CONFIGURATION_FULL_PATH]);
    }
}
