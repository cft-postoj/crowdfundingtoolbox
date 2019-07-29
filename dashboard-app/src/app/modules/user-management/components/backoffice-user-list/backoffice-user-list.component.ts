import { Component, OnInit } from '@angular/core';
import {Routing} from '../../../../constants/config.constants';
import {Router} from '@angular/router';
import {UserService} from '../../services';
import {ModalComponent} from '../../../core/parts/atoms';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-backoffice-user-list',
  templateUrl: './backoffice-user-list.component.html',
  styleUrls: ['./backoffice-user-list.component.scss']
})
export class BackofficeUserListComponent implements OnInit {

  public isAdmin: boolean = false;
  public users: any = [];
  public alertOpen: boolean = false;
  public alertMessage: string;
  public alertType: string;
  public loading: boolean = true;

  constructor(private router: Router, private userService: UserService, private _modalService: NgbModal) { }

  ngOnInit() {
    this.getAll();
  }

  getAll() {
    this.userService.getAll().subscribe((data) => {
      this.users = data;
      this.loading = false;
    });
  }

  public isAdminRole(event) {
    if (!event) {
      return this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.USER_SETTINGS}`);
    }
  }

  public deleteUser(id) {
    const modalRef = this._modalService.open(ModalComponent);
    modalRef.componentInstance.title = 'Delete backoffice user with id ' + id;
    modalRef.componentInstance.text = 'Do you want to delete backoffice user with id ' + id;
    modalRef.componentInstance.loading = false;
    modalRef.componentInstance.duplicate = 'donation-assignment';
    modalRef.result.then((data) => {
          this.loading = true;
          this.userService.delete(id).subscribe((d: any) => {
            this.alertMessage = d.message;
            this.alertType = 'success';
            this.getAll();
            this.loading = false;
            this.alertOpen = true;
          }, (e) => {
            this.alertMessage = e.error;
            this.alertType = 'danger';
            this.loading = false;
            this.alertOpen = true;

          }, () => {
            this.loading = false;
            this.alertOpen = true;
          });
        }, (error) => {
          console.log(error);
        }
    );
  }
}
