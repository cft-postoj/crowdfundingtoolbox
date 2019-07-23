import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PortalUserListComponent } from './pages/portal-user-list/portal-user-list.component';
import {PotralUsersRoutingModule} from './potral-users-routing.module';
import {CoreModule} from '../core/core.module';
import { PortalUserFilterComponent } from './components/portal-user-filter/portal-user-filter.component';
import { PortalUserListItemComponent } from './components/portal-user-list-item/portal-user-list-item.component';
import { BackToListComponent } from './components/back-to-list/back-to-list.component';
import { ExludeUserFromTargetingComponent } from './components/exlude-user-from-targeting/exlude-user-from-targeting.component';
import { EditPortalUserComponent } from './components/edit-portal-user/edit-portal-user.component';
import {StatisticsModule} from '../statistics/statistics.module';
import { PortalUserDetailDonationsComponent } from './pages/portal-user-detail-donations/portal-user-detail-donations.component';
import { PortalUserDetailGeneralComponent } from './pages/portal-user-detail-general/portal-user-detail-general.component';
import {PortalUserDetailComponent} from './components/portal-user-detail/portal-user-detail.component';
import {DonationDetailSimplifiedComponent} from './components/donation-detail-simplified/donation-detail-simplified.component';
import { TransferTypeConvertToStringPipe } from './pipes/transfer-type-convert-to-string.pipe';
import { DonorsComponent } from './pages/donors/donors.component';
import { DonorsNewComponent } from './pages/donors-new/donors-new.component';

@NgModule({
    declarations: [PortalUserDetailComponent, PortalUserListComponent, PortalUserFilterComponent, PortalUserListItemComponent,
        BackToListComponent, ExludeUserFromTargetingComponent, EditPortalUserComponent, PortalUserDetailDonationsComponent,
        PortalUserDetailGeneralComponent, DonationDetailSimplifiedComponent, TransferTypeConvertToStringPipe, DonorsComponent, DonorsNewComponent],
    imports: [
        CommonModule,
        PotralUsersRoutingModule,
        CoreModule,
        StatisticsModule
    ],
    exports: [PortalUserDetailComponent, PortalUserListComponent, PortalUserFilterComponent, PortalUserListItemComponent,
        BackToListComponent, ExludeUserFromTargetingComponent, EditPortalUserComponent, DonationDetailSimplifiedComponent]
})
export class PortalUsersModule {
}
