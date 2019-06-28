import {User} from '../../user-management/models';

export class DonorStats {
    donations_sum: number;
    first_donation_at: Date;
    last_donation_at: Date;
    last_donation_monthly: boolean;
    last_donation_value: number;
    user: User;
}
