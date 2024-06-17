/**
    * @description      :
    * @author           : BYLL JAKE
    * @group            :
    * @created          : 15/04/2023 - 17:42
    *
    * MODIFICATION LOG
    * - Version         : 1.0.0
    * - Date            : 21/10/2023
    * - Author          : BYLL jake
    * - Modification    :
**/
export interface LoginResponse {
  data:any;
  authorisation: any;
  refreshToken: string;
  expiresAt: Date;
  user: any;
  roles: string[];
}
