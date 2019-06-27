import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: 'app-target-modal',
    templateUrl: './target-modal.component.html',
    styleUrls: ['./target-modal.component.scss']
})
export class TargetModalComponent implements OnInit {
    @Input()
    public loading: boolean;

    @Input()
    public usersCount: number;

    @Input()
    public visitorsCount: number;

    @Output()
    public signedUsersListEmit = new EventEmitter();

    constructor() {
    }

    ngOnInit() {
        this.usersCount = 0;
        this.loading = true;
    }

    showSignedUsersList() {
        this.signedUsersListEmit.emit(true);
    }

}
