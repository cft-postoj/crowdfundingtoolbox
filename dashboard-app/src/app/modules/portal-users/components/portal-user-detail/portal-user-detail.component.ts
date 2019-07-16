import {Component, OnInit} from '@angular/core';
import {Routing} from '../../../../constants/config.constants';
import {NavbarItem} from '../../../core/models/navbar-item';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    selector: 'app-portal-user-detail',
    templateUrl: './portal-user-detail.component.html',
    styleUrls: ['./portal-user-detail.component.scss']
})
export class PortalUserDetailComponent implements OnInit {


    navItems: NavbarItem[];
    private id: number;

    constructor(private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.params.subscribe(
            params => {
                this.id = params['id'];
                this.recreateNavItems(params['id']);
            }
        );
    }

    recreateNavItems(id: number) {
        this.navItems = [
            {
                title: 'General info',
                url: Routing.PORTAL_USERS_FULL_PATH + '/' + this.id + '/' + Routing.GENERAL,
                active: true
            },
            {
                title: 'Donations',
                url: Routing.PORTAL_USERS_FULL_PATH + '/' + this.id + '/' + 'donations',
                active: false
            }
        ];
    }

}
