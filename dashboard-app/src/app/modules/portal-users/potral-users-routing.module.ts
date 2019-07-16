import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {PortalUserListComponent} from './pages/portal-user-list/portal-user-list.component';
import {Routing} from '../../constants/config.constants';
import {PortalUserDetailGeneralComponent} from './pages/portal-user-detail-general/portal-user-detail-general.component';
import {PortalUserDetailDonationsComponent} from './pages/portal-user-detail-donations/portal-user-detail-donations.component';
import {PortalUserDetailComponent} from './components/portal-user-detail/portal-user-detail.component';

const routes: Routes = [
    {
        path: 'all',
        component: PortalUserListComponent
    },
    {
        path: ':' + Routing.ID,
        component: PortalUserDetailComponent,
        children: [
            {
                path: Routing.GENERAL,
                component: PortalUserDetailGeneralComponent
            },
            {
                path: 'donations',
                component: PortalUserDetailDonationsComponent
            },
            {
                path: '**',
                redirectTo: Routing.GENERAL
            },
        ]
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class PotralUsersRoutingModule {
}
