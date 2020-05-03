import {Component, EventEmitter, Input, OnChanges, OnDestroy, OnInit, Output} from '@angular/core';
import {PortalUserService} from '../../../portal-users/services/portal-user.service';
import {PortalUser} from '../../../portal-users/models/portal-user';
import {Subscription} from 'rxjs';
import {User} from '../../../user-management/models';

@Component({
    selector: 'app-user-dropdown',
    templateUrl: './user-dropdown.component.html',
    styleUrls: ['./user-dropdown.component.scss']
})
export class UserDropdownComponent implements OnInit, OnDestroy {

    @Input()
    public users: PortalUser [] = [];
    @Input()
    public selectedValue: number;
    @Input()
    public currentUser: PortalUser;
    @Input()
    public label: string;
    @Input()
    public placeholder: string;
    @Input()
    public extraClass: string;
    @Output()
    public changeIdEmit = new EventEmitter();
    @Output()
    public filterChanged = new EventEmitter();
    @Output()
    public changedUser = new EventEmitter();
    private usersSubscription: Subscription;
    private timerTriggerFilterLazy;
    private timeToTriggerFilterLazy = 300;


    constructor(private portalUserService: PortalUserService) {
    }

    ngOnInit(): void {
        if (this.users.length === 0) {
            this.getUserByString();
        }
        if (this.currentUser && !this.placeholder) {
            this.addTextProperty(this.currentUser);
            this.placeholder = this.currentUser['text'];
        }
    }

    public selectAction() {
        this.changeIdEmit.emit(this.selectedValue);
        this.changedUser.emit(this.users.find(selectedValue => {
            return selectedValue.id === this.selectedValue;
        }));
    }

    public getUserByStringLazy(findingString) {
        clearTimeout(this.timerTriggerFilterLazy);
        // suspend sort for 300 ms and wait to prevent multiple selects when user is writing string
        this.timerTriggerFilterLazy = setTimeout(() => {
            this.getUserByString(findingString);
        }, this.timeToTriggerFilterLazy);
    }

    public getUserByString(findingString = '') {
        if (this.usersSubscription) {
            this.usersSubscription.unsubscribe();
        }
        this.usersSubscription = this.portalUserService.getPortalUsersEmails(findingString).subscribe(result => {
            this.users = result.map(u => {
                return this.addTextProperty(u);
            });
        });
    }


    public filterChange($event) {
        this.filterChanged.emit($event);
    }

    ngOnDestroy() {
        if (this.usersSubscription) {
            this.usersSubscription.unsubscribe();
        }
    }

    private addTextProperty(u: PortalUser) {
        u['text'] = (u.user_detail && u.user_detail.first_name +
            ' ' + u.user_detail.last_name) + ' [email: ' + u.email + ', ID: ' + u.id + ']';
        return u;
    }
}
