import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {InlineSVGModule} from 'ng-inline-svg';
import {AppComponent} from './app.component';

import {MatTabsModule} from '@angular/material';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {routing} from "./app.routing";
import {CoreModule} from "./modules/core/core.module";
import {UserManagementModule} from "./modules/user-management/user-management.module";
import {ModalComponent, NotificationComponent} from "./modules/core/parts/atoms";
import {
    CtaSettingsComponent,
    DashboardComponent, GeneralSettingsComponent, SettingsComponent,
    SideBarComponent,
    SidebarFooterComponent, SidebarItemComponent,
    TopPanelComponent
} from "./modules/core/components";
import {AboutComponent, ContactComponent} from "./components";
import {ConfigurationComponent} from "./modules/core/pages/configuration/configuration.component";
import {TranslationListComponent} from "./modules/translations/components";
import {TranslationCreateComponent} from "./modules/translations/components/translation-create/translation-create.component";
import {HttpErrorInterceptor, TokenInterceptor} from "./modules/user-management/interceptor";
import { registerLocaleData } from '@angular/common';
import localSk from '@angular/common/locales/sk';

@NgModule({
    imports: [
        BrowserModule,

        CoreModule,
        UserManagementModule,

        MatTabsModule,
        ReactiveFormsModule,
        HttpClientModule,
        BrowserAnimationsModule,
        InlineSVGModule.forRoot(),
        routing,
    ],
    entryComponents: [ModalComponent],
    declarations: [

        AppComponent,
        TopPanelComponent,
        DashboardComponent,
        AboutComponent,
        ContactComponent,
        TranslationListComponent,
        TranslationCreateComponent,
        SideBarComponent,
        SidebarItemComponent,
        SidebarFooterComponent,

        ConfigurationComponent,
        ModalComponent,

        NotificationComponent,
        GeneralSettingsComponent,
        SettingsComponent,
        NotificationComponent,

        CtaSettingsComponent,
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
    exports: [
        TopPanelComponent
    ],
    bootstrap: [AppComponent]

})

export class AppModule {
}

registerLocaleData(localSk, 'sk');
