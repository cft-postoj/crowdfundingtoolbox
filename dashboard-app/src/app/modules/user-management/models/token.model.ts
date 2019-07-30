export interface TokenModel {

    token: string;
    user_detail: {
        created_at: string
        deleted_at: string
        first_name: string
        id: number
        last_name: string
        updated_at: string
        username: string
    };
    user_role: string;
}
