import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {InlineSVGModule} from 'ng-inline-svg';
import {AppComponent} from './app.component';
import {routing} from './app.routing';

import {LoginComponent} from './login';
import {DashboardComponent} from './dashboard/dashboard.component';
import {SideBarComponent} from './side-bar/side-bar.component';
import {AboutComponent} from './about/about.component';
import {ContactComponent} from './contact/contact.component';
import {HomeComponent} from './home/home.component';
import {HttpErrorInterceptor} from './interceptor/httpError.interceptor';

import {TokenInterceptor} from './interceptor/token.interceptor';
import {TranslationsComponent} from './translations/translations.component';
import {NewTranslationComponent} from './translations/new-translation/new-translation.component';
import {TopPanelComponent} from './top-panel/top-panel.component';
import {CampaignsComponent} from './pages/campaigns/list/campaigns.component';
import {SidebarItemComponent} from './sidebar-item/sidebar-item.component';
import {SidebarFooterComponent} from './sidebar-footer/sidebar-footer.component';
import {DropdownComponent} from './_parts/atoms/dropdown/dropdown.component';
import {ListItemComponent} from './_parts/molecules/list-item/list-item.component';
import {SwitcherComponent} from './_parts/atoms/switcher/switcher.component';
import {BreadcrumbsComponent} from './_parts/molecules/breadcrumbs/breadcrumbs.component';
import {ButtonComponent} from './_parts/atoms/button/button.component';
import {NgCircleProgressModule} from 'ng-circle-progress';
import {SlovakNumberFormatter} from './_pipe/SlovakNumberFormatter';
import {ConfigurationComponent} from './pages/configuration/configuration.component';
import {StatusComponent} from './status/status.component';
import {CampaignEditComponent} from './pages/campaigns/edit/campaignEdit.component';
import {DragAndDropComponent} from './_parts/atoms/dragAndDrop/dragAndDrop.component';
import {AngularEditorModule} from '@kolkov/angular-editor';
import {CampaignDetailComponent} from "./pages/campaigns/detail/campaignDetail.component";

import {WidgetSettingsComponent} from './pages/campaigns/edit/widget-settings/widgetSettings.component';
import {CampaignsSettingsComponent} from './pages/campaigns/edit/campaign-settings/campaignsSettings.component';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {ProgressComponent} from './_parts/atoms/progress/progress.component';
import {DatepickerComponent} from './_parts/atoms/datepicker/datepicker.component';
import {MatTabsModule} from '@angular/material';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {CheckboxComponent} from './_parts/atoms/checkbox/checkbox.component';
import {RadioButtonComponent} from './_parts/atoms/radio-button/radio-button.component';
import {AlertComponent} from "./_parts/atoms/alert/alert.component";
import { ColorPickerModule } from 'ngx-color-picker';
import {LoadingComponent} from "./_parts/atoms/loading/loading.component";
import {InputNumberComponent} from "./_parts/atoms/input-number/input-number.component";
import { ActionsComponent } from './actions/actions.component';
import { StatisticsComponent } from './pages/campaigns/statistics/statistics.component';
import { RadioButtonGroupComponent } from './_parts/atoms/radio-button-group/radio-button-group.component';
import { InputGroupComponent } from './_parts/atoms/input-group/input-group.component';
import { WidgetEditComponent } from './pages/widget/widget-edit/widget-edit.component';
import { PreviewComponent } from './components/preview/preview.component';
import { ModalComponent } from './_parts/atoms/modal/modal.component';
import { SafePipe } from './_pipe/safe.pipe';
import { NotificationComponent } from './_parts/atoms/notification/notification.component';
import { SettingsComponent } from './components/settings/settings.component';
import { GeneralSettingsComponent } from "./components/general-settings/general-settings.component";

@NgModule({
    imports: [
        MatTabsModule,
        BrowserModule,
        ReactiveFormsModule,
        FormsModule,
        HttpClientModule,
        routing,
        NgCircleProgressModule.forRoot({
            space: -5
        }),
        InlineSVGModule.forRoot(),
        AngularEditorModule,
        BrowserAnimationsModule,
        NgbModule,
        ColorPickerModule
    ],
    entryComponents: [ModalComponent],
    declarations: [
        DatepickerComponent,
        ProgressComponent,
        SlovakNumberFormatter,
        AppComponent,
        TopPanelComponent,
        LoginComponent,
        DashboardComponent,
        AboutComponent,
        ContactComponent,
        HomeComponent,
        TranslationsComponent,
        NewTranslationComponent,
        CampaignsComponent,
        SideBarComponent,
        SidebarItemComponent,
        SidebarFooterComponent,
        ButtonComponent,
        DropdownComponent,
        ListItemComponent,
        ConfigurationComponent,
        SwitcherComponent,
        StatusComponent,
        CampaignEditComponent,
        BreadcrumbsComponent,
        WidgetSettingsComponent,
        CampaignsSettingsComponent,
        DragAndDropComponent,
        CampaignDetailComponent,
        CheckboxComponent,
        RadioButtonComponent,
        AlertComponent,
        LoadingComponent,
        InputNumberComponent,
        ActionsComponent,
        StatisticsComponent,
        ActionsComponent,
        RadioButtonGroupComponent,
        InputGroupComponent,
        WidgetEditComponent,
        PreviewComponent,
        ModalComponent,
        SafePipe,
        NotificationComponent,
        GeneralSettingsComponent,
        SettingsComponent
    ],
    providers: [
        {
            provide: HTTP_INTERCEPTORS,
            useClass: TokenInterceptor,
            multi: true
        },
        {
            provide: HTTP_INTERCEPTORS,
            useClass: HttpErrorInterceptor,
            multi: true,
        }
    ],
    bootstrap: [AppComponent]

})

export class AppModule {
}

