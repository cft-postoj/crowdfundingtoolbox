import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {CommonModule} from "@angular/common";
import {LoginComponent} from "./components/login";

const routes: Routes = [
    {
        path: '',
        component: LoginComponent
    },
];

@NgModule({
    imports: [CommonModule, RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class UserManagementRoutingModule {
}
