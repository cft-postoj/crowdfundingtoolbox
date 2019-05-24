import {Address} from './address';

export class PortalUser {
    id: number = 0;
    firstName: string = '';
    lastName: string = '';
    email: string = '';
    isMonthlyDonor: boolean = false;
    address = new Address();
}