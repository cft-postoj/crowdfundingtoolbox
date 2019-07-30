import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {environment} from '../../../../../environments/environment';
import {Routing} from '../../../../constants/config.constants';

@Component({
  selector: 'app-signed-users-list',
  templateUrl: './signed-users-list.component.html',
  styleUrls: ['./signed-users-list.component.scss']
})
export class SignedUsersListComponent implements OnInit {

  @Input()
  public showSignedUsersModal: boolean = true;

  @Input()
  public targetedUsers: any = [];

  @Output()
  public showSignedUsersModalChange = new EventEmitter();

  constructor() { }

  ngOnInit() {
  }

  closeSignedUsersModal() {
    this.showSignedUsersModal = false;
    this.showSignedUsersModalChange.emit(false);
  }

  showUserDetail(id) {
    window.open(Routing.PORTAL_USERS_FULL_PATH + '/' + id, '_blank');
  }

}
