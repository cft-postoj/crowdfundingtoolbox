import {Component, OnInit} from '@angular/core';
import {environment} from 'environments/environment';

@Component({
    selector: 'app-sidebar-footer',
    templateUrl: './sidebar-footer.component.html',
    styleUrls: ['./sidebar-footer.component.scss']
})
export class SidebarFooterComponent implements OnInit {

    public environment = environment;

    constructor() {
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
        alert('Not working in this stage.')
    }
}
