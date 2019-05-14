import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {CoreModule} from "../core/core.module";
import {LoginComponent} from "./components/login";
import {RouterModule} from "@angular/router";
import {InlineSVGModule} from "ng-inline-svg";
import {NgxSelectModule} from "ngx-select-ex";
import {NgbModule} from "@ng-bootstrap/ng-bootstrap";
import {AngularEditorModule} from "@kolkov/angular-editor";
import {FormsModule} from "@angular/forms";
import {NgCircleProgressModule} from "ng-circle-progress";
import {UserManagementRoutingModule} from "./user-management-routing.module";

@NgModule({
    declarations: [
        LoginComponent
    ],
    imports: [
        CommonModule,
        CoreModule,
        UserManagementRoutingModule,
        RouterModule,
        InlineSVGModule.forRoot(),
        NgxSelectModule,
        NgbModule,
        AngularEditorModule,
        FormsModule,
        NgCircleProgressModule.forRoot({
            space: -5
        }),
    ],
    exports: [LoginComponent]
})
export class UserManagementModule {
}
