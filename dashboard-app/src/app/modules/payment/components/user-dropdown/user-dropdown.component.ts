import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {PortalUserService} from '../../../portal-users/services/portal-user.service';
import {PortalUser} from '../../../portal-users/models/portal-user';

@Component({
    selector: 'app-user-dropdown',
    templateUrl: './user-dropdown.component.html',
    styleUrls: ['./user-dropdown.component.scss']
})
export class UserDropdownComponent implements OnInit {

    @Input()
    public users: any = [];
    public selectedValue: string;
    @Input()
    public userId: number;
    @Input()
    public label: string;
    @Input()
    public placeholder: string;
    @Output()
    public changeIdEmit = new EventEmitter();

    constructor(private portalUserService: PortalUserService) {
    }

    ngOnInit() {
    }



    public selectAction() {
        const id = this.selectedValue.match(/\d+/g).map(Number)[0];
        this.changeIdEmit.emit(id);
    }


}
