import {UserDetail} from './userDetail';
import {DonorStatus} from './donorStatus';

export class PortalUser {
    id: number = 0;
    email: string = '';
    isMonthlyDonor: boolean = false;
    user_detail = new UserDetail();
    donor_status = [new DonorStatus()];
}
