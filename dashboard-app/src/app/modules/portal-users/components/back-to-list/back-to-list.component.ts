import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-back-to-list',
    templateUrl: './back-to-list.component.html',
    styleUrls: ['./back-to-list.component.scss']
})
export class BackToListComponent implements OnInit {

    constructor(private router: Router) {
    }

    ngOnInit() {
    }

    backToPortalUsers() {
        this.router.navigateByUrl(`${Routing.PORTAL_USER_LIST_FULL_PATH}`);
    }

}
