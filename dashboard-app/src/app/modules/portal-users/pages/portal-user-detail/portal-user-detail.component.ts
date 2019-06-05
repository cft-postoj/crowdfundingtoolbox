import {Component, OnInit} from '@angular/core';
import {PortalUser} from '../../models/portal-user';
import {PortalUserService} from '../../services/portal-user.service';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    selector: 'app-donor-detail',
    templateUrl: './portal-user-detail.component.html',
    styleUrls: ['./portal-user-detail.component.scss']
})
export class PortalUserDetailComponent implements OnInit {

    user: PortalUser;
    id: number;

    constructor(private portalUserService: PortalUserService, private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.params.subscribe(
            params => {
                this.id = params['id'];
                this.showDetail();
            }
        );
    }

    private showDetail() {
        this.portalUserService.getById(this.id).subscribe((data) => {
            this.user = data[0];
            console.log(data);
        });
    }

}
