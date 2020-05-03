import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Routing} from './constants/config.constants';
import {TranslateService} from '@ngx-translate/core';
import {environment} from '../environments/environment';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {

    constructor(private router: Router, private translate: TranslateService) {
        translate.addLangs(['en', 'sk']);
        translate.setDefaultLang('en');
        translate.use(environment.lang);

        // check for responsive version -- Responsive version has only campaigns active/deactive setting
        if (window.innerWidth <= 991) {
            this.router.navigateByUrl(`responsive`);
        } else {
            if (location.href.indexOf('/responsive') > -1) {
                this.router.navigateByUrl(`${Routing.STATS_FULL_PATH}`);
            }
        }
    }


    ngOnInit() {
    }


}
