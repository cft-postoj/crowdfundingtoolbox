import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {PortalUserService} from '../../../portal-users/services/portal-user.service';
import {PortalUser} from '../../../portal-users/models/portal-user';

@Component({
    selector: 'app-user-dropdown',
    templateUrl: './user-dropdown.component.html',
    styleUrls: ['./user-dropdown.component.scss']
})
export class UserDropdownComponent implements OnInit {

    public users: any = [];
    public selectedValue: string;
    @Input()
    public userId: number;
    @Input()
    public label: string;
    @Output()
    public changeIdEmit = new EventEmitter();

    constructor(private portalUserService: PortalUserService) {
    }

    ngOnInit() {
        this.getUsers();
    }

    getUsers() {
        this.portalUserService.getAll().subscribe((data: [PortalUser]) => {
            data.map((u, key) => {
                const value = u.user_detail.first_name + ' ' + u.user_detail.last_name + ' - [ID: ' + u.id + ']';
                this.users.push(value);
                if (u.id === this.userId) {
                    this.selectedValue = value;
                }
            });
        });
    }

    public selectAction() {
        const id = this.selectedValue.match(/\d+/g).map(Number)[0];
        this.changeIdEmit.emit(id);
    }


}
