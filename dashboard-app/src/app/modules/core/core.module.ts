import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RouterModule} from '@angular/router';
import {InlineSVGModule} from 'ng-inline-svg';
import {NgxSelectModule} from 'ngx-select-ex';
import { ColorPickerModule } from 'ngx-color-picker';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {AngularEditorModule} from '@kolkov/angular-editor';
import {NgCircleProgressModule} from 'ng-circle-progress';
import {BreadcrumbsComponent, GoogleFontSettingsComponent} from './parts/molecules';
import {
    AlertComponent,
    ButtonComponent, CheckboxComponent,
    DatepickerComponent, DragAndDropComponent,
    DropdownComponent, InputGroupComponent, InputNumberComponent, LoadingComponent,
    ProgressComponent, RadioButtonComponent, RadioButtonGroupComponent,
    SwitcherComponent
} from './parts/atoms';
import {ActionsComponent} from '../../components';
import {PreviewMonetizationComponent} from '../campaigns/components';
import {SafePipe} from './pipes/safe.pipe';
import {SlovakNumberFormatter} from './pipes/SlovakNumberFormatter';
import {WidgetSettingsComponent} from './components';
import { SelectDropDownModule } from 'ngx-select-dropdown';
import { TableHeaderComponent } from './parts/atoms/table-header/table-header.component';
import { InputTextComponent } from './parts/atoms/input-text/input-text.component';
import {ModalFullSizeComponent} from './components/modal-full-size/modal-full-size.component';
import { NavbarComponent } from './parts/atoms/navbar/navbar.component';
import {StatusComponent} from './parts/atoms/status/status.component';
import { ExportCsvComponent } from './components/export-csv/export-csv.component';
import { HelpComponent } from './components/help/help.component';
import {NgxDaterangepickerMd} from 'ngx-daterangepicker-material';
import { PreviousPageComponent } from './components/previous-page/previous-page.component';
import {PortalConnectionsSettingsComponent} from './components/portal-connections-settings/portal-connections-settings.component';
import { ResponsiveComponent } from './pages/responsive/responsive.component';
import { SafariDatePipe } from './pipes/safari-date.pipe';
import {PaginatorModule} from 'primeng/paginator';
import { UploadCsvComponent } from './components/upload-csv/upload-csv.component';
import {TranslateModule} from '@ngx-translate/core';
import {OrderListModule} from 'primeng/orderlist';
import {SelectModule} from 'ng2-select';
import {MonthlyPipe} from './pipes/monthly.pipe';

@NgModule({
    declarations: [
        BreadcrumbsComponent,
        DatepickerComponent,
        ProgressComponent,
        ButtonComponent,
        DropdownComponent,
        SwitcherComponent,
        DragAndDropComponent,
        CheckboxComponent,
        RadioButtonComponent,
        AlertComponent,
        LoadingComponent,
        InputNumberComponent,
        ActionsComponent,
        RadioButtonGroupComponent,
        InputGroupComponent,
        GoogleFontSettingsComponent,
        WidgetSettingsComponent,
        PreviewMonetizationComponent,
        ModalFullSizeComponent,
        StatusComponent,
        UploadCsvComponent,


        SafePipe,
        MonthlyPipe,
        SlovakNumberFormatter,
        TableHeaderComponent,
        InputTextComponent,
        NavbarComponent,
        ExportCsvComponent,
        HelpComponent,
        PreviousPageComponent,
        PortalConnectionsSettingsComponent,
        ResponsiveComponent,
        SafariDatePipe,
    ],
    imports: [
        CommonModule,
        RouterModule,
        InlineSVGModule.forRoot(),
        ColorPickerModule,
        NgxSelectModule,
        NgbModule,
        AngularEditorModule,
        FormsModule,
        SelectDropDownModule,
        NgxDaterangepickerMd.forRoot(),
        NgCircleProgressModule.forRoot({
            space: -5
        }),
        PaginatorModule,
        OrderListModule,
        TranslateModule,
        SelectModule
    ],
    exports: [

        FormsModule,
        ReactiveFormsModule,
        // components
        BreadcrumbsComponent,
        DatepickerComponent,
        ProgressComponent,
        ButtonComponent,
        DropdownComponent,
        SwitcherComponent,
        DragAndDropComponent,
        CheckboxComponent,
        RadioButtonComponent,
        AlertComponent,
        LoadingComponent,
        InputNumberComponent,
        ActionsComponent,
        RadioButtonGroupComponent,
        InputGroupComponent,
        GoogleFontSettingsComponent,
        WidgetSettingsComponent,
        PreviewMonetizationComponent,
        TableHeaderComponent,
        ModalFullSizeComponent,
        StatusComponent,
        UploadCsvComponent,

        // pipes
        SafePipe,
        SlovakNumberFormatter,
        SafariDatePipe,
        MonthlyPipe,
        // modules
        CommonModule,
        RouterModule,
        NgbModule,
        FormsModule,
        // custom modules
        ColorPickerModule,
        NgxSelectModule,
        AngularEditorModule,
        SelectDropDownModule,
        InputTextComponent,
        NavbarComponent,
        ExportCsvComponent,
        HelpComponent,
        PreviousPageComponent,
        PaginatorModule,
        OrderListModule,
        SelectModule,
        InlineSVGModule


    ]
})
export class CoreModule {
}
