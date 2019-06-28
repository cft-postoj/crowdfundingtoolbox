import {UserDetail} from '../../portal-users/models/userDetail';

export class User {
    id: number;
    username: string;
    email: string;
    token: string;
    user_detail: UserDetail;
}
