import {UserDetail} from './userDetail';
import {DonorStatus} from './donorStatus';
import {Donation} from './donation';
import {User} from '../../user-management/models';

export class PortalUser {
    id: number = 0;
    email: string = '';
    username: string = '';
    isMonthlyDonor: boolean = false;
    user: User;
    donor_status = [new DonorStatus()];
    portal_user: any;
    donations: Donation[];
    user_detail: UserDetail;
}
