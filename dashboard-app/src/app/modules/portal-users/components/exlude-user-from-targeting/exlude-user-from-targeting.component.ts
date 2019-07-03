import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {PortalUserService} from '../../services/portal-user.service';

@Component({
    selector: 'app-exlude-user-from-targeting',
    templateUrl: './exlude-user-from-targeting.component.html',
    styleUrls: ['./exlude-user-from-targeting.component.scss']
})
export class ExludeUserFromTargetingComponent implements OnInit {

    @Input()
    public excluded: boolean;

    @Input()
    public portalUserId: number;

    @Output()
    public excludedUserEmit = new EventEmitter();

    @Input()
    public excludingReason: string = '';

    constructor(private portalUserService: PortalUserService) {
    }

    ngOnInit() {
    }

    public changeExcluded(event) {
        if (this.excludingReason !== '') {
            this.excluded = !this.excluded;
            this.portalUserService.excludeFromTargeting(this.excluded, this.excludingReason, this.portalUserId).subscribe((data) => {
                console.log(data);
                this.excludedUserEmit.emit(this.excluded);
            });
        } else {
            this.excludedUserEmit.emit('reason');
            event.target.checked = false;
        }

    }

}
