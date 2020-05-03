import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {HelpersService} from '../../core/services/helpers.service';
import {Observable} from 'rxjs';
import {PortalUser} from '../models/portal-user';
import {environment} from '../../../../environments/environment';
import {DonorCategory} from '../models/donor-category';
import {DropdownItem} from '../../core/models';

@Injectable({
    providedIn: 'root'
})
export class DonorCategoryService {

    constructor(private http: HttpClient, private helpersService: HelpersService) {
    }

    public getByPortalUserId(id): Observable<PortalUser> {
        return this.http.get<PortalUser>(`${environment.backOfficeUrl}${environment.portalUsersUrl}/${id}${environment.donorCategories}`);
    }

    public getDonorCategories(): Observable<DonorCategory[]> {
        return this.http.get<DonorCategory[]>(`${environment.backOfficeUrl}${environment.donorCategories}`);
    }

    public assignDonorCategoryToPortalUser(id: number, newCategory: DropdownItem): Observable<any> {
        return this.http.post<any>(
            `${environment.backOfficeUrl}${environment.portalUsersUrl}${environment.donorCategories}${environment.create}`,
            {portalUserId: id, newCategoryId: newCategory});
    }

    public deletePortalUserDonorCategory(portalUserDonorCategory: DonorCategory) {
        return this.http.delete<any>(
            `${environment.backOfficeUrl}${environment.portalUsersUrl}${environment.donorCategories}/${portalUserDonorCategory.id}${environment.delete}`,
        );
    }
}
