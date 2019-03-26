import {NgModule} from '@angular/core';
import {LoginComponent} from "../../login";
import {DashboardComponent} from "../../dashboard/dashboard.component";
import {AboutComponent} from "../../about/about.component";
import {ContactComponent} from "../../contact/contact.component";
import {TranslationsComponent} from "../../translations/translations.component";
import {NewTranslationComponent} from "../../translations/new-translation/new-translation.component";
import {CampaignsComponent} from "../../pages/campaigns/list/campaigns.component";
import {ConfigurationComponent} from "../../pages/configuration/configuration.component";
import {CampaignDetailComponent} from "../../pages/campaigns/detail/campaignDetail.component";
import {CampaignEditComponent} from "../../pages/campaigns/edit/campaignEdit.component";
import {WidgetEditComponent} from "../../pages/widget/widget-edit/widget-edit.component";
import {AlertComponent} from "../../_parts/atoms/alert/alert.component";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {CommonModule} from "@angular/common";
import {LoadingComponent} from "../../_parts/atoms/loading/loading.component";
import {TopPanelComponent} from "../../top-panel/top-panel.component";

@NgModule({
    declarations: [LoginComponent, DashboardComponent, AboutComponent, ContactComponent,
        TranslationsComponent, NewTranslationComponent, CampaignsComponent, ConfigurationComponent,
        CampaignDetailComponent, CampaignEditComponent, WidgetEditComponent,
        AlertComponent, LoadingComponent, TopPanelComponent],
    imports: [CommonModule,
        FormsModule,
        ReactiveFormsModule]
})
export class TestSharedModule {
}
