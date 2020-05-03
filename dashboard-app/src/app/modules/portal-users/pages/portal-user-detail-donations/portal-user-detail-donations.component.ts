import {Component, OnInit} from '@angular/core';
import {PortalUserService} from '../../services/portal-user.service';
import {ActivatedRoute, Router} from '@angular/router';
import {DonorCategoryService} from '../../services/donor-category.service';
import {DropdownItem} from '../../../core/models';
import {DonorCategory} from '../../models/donor-category';
import {PortalUserDonorCategory} from '../../models/portal-user-donor-category';

@Component({
    selector: 'app-portal-user-detail-donations',
    templateUrl: './portal-user-detail-donations.component.html',
    styleUrls: ['./portal-user-detail-donations.component.scss']
})
export class PortalUserDetailDonationsComponent implements OnInit {

    public id: any;
    from = {year: 2010, month: 1, day: 1};
    to = {year: new Date().getFullYear(), month: new Date().getMonth() + 1, day: new Date().getDate()};
    public donationsDetail;
    public loading: boolean = true;
    private nowDate = new Date();
    showMoreFirst: boolean;
    showMoreLast: boolean;

    portalUserDonorCategoriesLoading = true;
    portalUserDonorCategories;
    showMoreDonorCategories = false;
    portalUserDonorCategoriesShow: PortalUserDonorCategory[];
    private categoriesLessSize: number = 1;
    addingNewCategory = false;
    donorCategoriesDropdownItems: DropdownItem[] = [];
    newCategory: any;

    alertOpen = false;
    alertMessage = '';
    alertType = 'success';
    assigning = false;

    constructor(private portalUserService: PortalUserService, private donorCategoryService: DonorCategoryService,
                private router: Router, private route: ActivatedRoute) {
    }

    ngOnInit() {
        this.route.parent.params.subscribe(
            params => {
                this.id = params['id'];
                this.getDonationsDetailInfo();
            }
        );

    }

    private getDonationsDetailInfo() {
        this.loading = true;
        this.portalUserService.getDonationsDetailInfo(this.id).subscribe(result => {
            this.donationsDetail = result;
            this.loading = false;
        });
        this.getPortalUserDonorCategories();
        this.donorCategoryService.getDonorCategories().subscribe(result => {
            this.donorCategoriesDropdownItems = result.map(item => {
                return {title: item.name, value: item.id}
            });
        });
    }

    getPortalUserDonorCategories() {
        this.portalUserDonorCategoriesLoading = true;
        this.donorCategoryService.getByPortalUserId(this.id).subscribe(result => {
            this.handleResultPortalUserDonorCategories(result);
        });
    }

    handleResultPortalUserDonorCategories(result) {
        this.portalUserDonorCategoriesLoading = false;
        this.portalUserDonorCategories = result;
        if (this.portalUserDonorCategories.length > 0 && !this.showMoreDonorCategories)
            this.portalUserDonorCategoriesShow = this.portalUserDonorCategories.slice(0, this.categoriesLessSize);
        else this.portalUserDonorCategoriesShow = this.portalUserDonorCategories;
    }

    public isNewDonor() {
        if (this.donationsDetail.first_donation == null) {
            return false;
        }
        const firstDate = new Date(this.donationsDetail.first_donation.payment.transaction_date);
        const nowDate = new Date();
        // 30 days in milliseconds
        const thirthyDays = 30 * 24 * 60 * 60 * 1000;
        return firstDate.getTime() + thirthyDays > nowDate.getTime();
    }

    public daysAgo() {
        if (this.donationsDetail.last == null) {
            return null;
        }
        const last = new Date(this.donationsDetail.last.payment.transaction_date);

        // 30 days in milliseconds
        const day = 24 * 60 * 60 * 1000;
        const daysAgo = Math.round((this.nowDate.getTime() - last.getTime()) / day);
        return '( ' + daysAgo + ' days ago)';
    }

    public showHidePortalUserDonorCategories() {
        this.showMoreDonorCategories = !this.showMoreDonorCategories;
        if (this.showMoreDonorCategories) {
            this.portalUserDonorCategoriesShow = this.portalUserDonorCategories;
        } else {
            if (this.portalUserDonorCategories.length > 0)
                this.portalUserDonorCategoriesShow = this.portalUserDonorCategories.slice(0, this.categoriesLessSize);
        }
    }

    assignDonorCategoryToPortalUser() {
        this.assigning = true;
        this.portalUserDonorCategoriesLoading = false
        this.donorCategoryService.assignDonorCategoryToPortalUser(this.id, this.newCategory).subscribe(result => {
                this.alertOpen = true;
                this.alertMessage = result.message;
                this.alertType = 'success';
                this.assigning = false;
                this.handleResultPortalUserDonorCategories(result.portalUserDonorCategories);
            },
            error => {
                this.alertOpen = true;
                this.alertMessage = error.message;
                this.alertType = 'danger';

                this.assigning = false;
            });

    }

    public deleteAssignment(portalUserDonorCategory) {
        this.donorCategoryService.deletePortalUserDonorCategory(portalUserDonorCategory).subscribe(result => {
                this.alertOpen = true;
                this.alertMessage = result.message;
                this.alertType = 'success';
                this.assigning = false;
                this.handleResultPortalUserDonorCategories(result.portalUserDonorCategories);
            },
            error => {
                this.alertOpen = true;
                this.alertMessage = error.message;
                this.alertType = 'danger';
                this.assigning = false;
            });
    }

}
