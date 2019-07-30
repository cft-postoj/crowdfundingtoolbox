import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
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
    @Input()
    public selectedValue: string = '';
    @Input()
    public userId: number;
    @Input()
    public label: string;
    @Input()
    public placeholder: string;
    @Input()
    public extraClass: string;
    @Output()
    public changeIdEmit = new EventEmitter();

    constructor() {
    }

    ngOnInit(): void {
    }

    public selectAction() {
        const id = parseInt(this.selectedValue.match(/\d+]$/)[0].split(']')[0], 10);
        this.changeIdEmit.emit(id);
    }


}
