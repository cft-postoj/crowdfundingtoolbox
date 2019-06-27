import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {OverallComponent} from './pages/overall/overall.component';

const routes: Routes = [{
    path: '',
    component: OverallComponent
}];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class StatisticsRoutingModule {

}
