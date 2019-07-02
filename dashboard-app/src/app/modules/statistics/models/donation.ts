import {Widget} from '../../campaigns/models';
import {PortalUser} from '../../portal-users/models/portal-user';

export class Donation {
    created_at: string;
    deleted_at: null;
    donation: number;
    id: number;
    is_monthly_donation: true;
    portal_user: PortalUser;
    portal_user_id: number;
    referral_widget_id: number;
    payment_method: string;
    updated_at: string;
    widget: Widget;
    widget_id: number;
}
