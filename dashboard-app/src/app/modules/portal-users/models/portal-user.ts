import {UserDetail} from './userDetail';
import {DonorStatus} from './donorStatus';
import {Donation} from './donation';

export class PortalUser {
    id: number = 0;
    email: string = '';
    username: string = '';
    isMonthlyDonor: boolean = false;
    user: any;
    user_detail = new PortalUser();
    donor_status = [new DonorStatus()];
    portal_user: any;
    donations: Donation[];
}
