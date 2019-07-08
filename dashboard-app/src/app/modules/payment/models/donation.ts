import {Payment} from './payment';
import {PortalUser} from '../../portal-users/models/portal-user';

export class Donation {
    amount: number;
    id: number;
    referral_widget_id: number;
    is_monhtly_donation: boolean;
    payments: Payment;
    payment_method: string;
    portal_user: PortalUser;
    status: string;
}
