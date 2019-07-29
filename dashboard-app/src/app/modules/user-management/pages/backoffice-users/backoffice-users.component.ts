import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {NavbarItem} from '../../../core/models/navbar-item';
import {UserService} from '../../services';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-backoffice-users',
    templateUrl: './backoffice-users.component.html',
    styleUrls: ['./backoffice-users.component.scss']
})
export class BackofficeUsersComponent implements OnInit {

    public navItems: NavbarItem[] = [
        {
            title: 'User settings',
            url: Routing.DASHBOARD + '/' + Routing.USER_SETTINGS,
            active: false
        }
    ];
    public isAdmin: boolean = false;
    @Output()
    public isAdminChange = new EventEmitter();

    constructor(private userService: UserService) {
    }

    ngOnInit() {
        this.getUserDetail();
    }

    getUserDetail() {
        this.userService.getUserDetail().subscribe((data) => {
            this.isAdmin = (data.role.id === 1);
            this.isAdminChange.emit(this.isAdmin);
            if (this.isAdmin) {
                this.navItems = [
                    {
                        title: 'User settings',
                        url: Routing.DASHBOARD + '/' + Routing.USER_SETTINGS,
                        active: false
                    },
                    {
                        title: 'All backoffice users',
                        url: Routing.DASHBOARD + '/' + Routing.USER_SETTINGS + '/' + Routing.ALL,
                        active: false
                    },
                    {
                        title: 'Create backoffice user',
                        url: Routing.DASHBOARD + '/' + Routing.USER_SETTINGS + '/' + Routing.CREATE_USER,
                        active: false
                    }
                ];
            } else {
                this.navItems = [
                    {
                        title: 'User settings',
                        url: Routing.DASHBOARD + '/' + Routing.USER_SETTINGS,
                        active: true
                    }
                ];
            }
        });
    }

}
