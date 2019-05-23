import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {PortalUserListComponent} from './pages/portal-user-list/portal-user-list.component';
import {Routing} from '../../constants/config.constants';
import {PortalUserDetailComponent} from './pages/portal-user-detail/portal-user-detail.component';

const routes: Routes = [
  {
    path: 'all',
    component: PortalUserListComponent
  },
  {
    path: ':' + Routing.ID,
    component: PortalUserDetailComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PotralUsersRoutingModule { }
